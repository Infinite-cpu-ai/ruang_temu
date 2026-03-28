<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArchitectReviewRequest;
use App\Models\Project;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FeatureController extends Controller
{
    public function cari(Request $request)
    {
        $budget = $request->string('budget')->toString();
        $projectType = $request->string('project_type')->toString();
        $location = $request->string('location')->toString();
        $style = $request->string('style')->toString();

        $architectsQuery = User::query()
            ->where('role', 'architect')
            ->with('architectProfile')
            ->withAvg('reviewsAsArchitect as reviews_avg_rating', 'rating');

        if ($location !== '') {
            $architectsQuery->whereHas('architectProfile', function ($q) use ($location) {
                $q->where('location', $location);
            });
        }

        if ($style !== '') {
            $architectsQuery->whereHas('architectProfile', function ($q) use ($style) {
                $q->where('style', $style);
            });
        }

        if ($budget !== '') {
            $architectsQuery->whereHas('architectProfile', function ($q) use ($budget) {
                if ($budget === 'under_100') {
                    $q->where('price_per_m2', '<', 100000);
                } elseif ($budget === '100_300') {
                    $q->whereBetween('price_per_m2', [100000, 300000]);
                } elseif ($budget === 'above_300') {
                    $q->where('price_per_m2', '>', 300000);
                }
            });
        }

        $architects = $architectsQuery->get();

        if ($projectType !== '') {
            $architects = $architects->filter(function ($architect) use ($projectType) {
                $types = (array) data_get($architect, 'architectProfile.project_types', []);
                $specialization = (string) data_get($architect, 'architectProfile.specialization', '');

                if ($types !== [] && in_array($projectType, $types, true)) {
                    return true;
                }

                return str_contains(mb_strtolower($specialization), mb_strtolower($projectType));
            })->values();
        }

        if ($architects->isEmpty()) {
            $architects = $this->dummyArchitects();

            $architects = $architects->filter(function ($architect) use ($budget, $projectType, $location, $style) {
                $price = (float) data_get($architect, 'architectProfile.price_per_m2', 0);
                $archLocation = (string) data_get($architect, 'architectProfile.location', '');
                $archStyle = (string) data_get($architect, 'architectProfile.style', '');
                $types = (array) data_get($architect, 'architectProfile.project_types', []);

                if ($location !== '' && $archLocation !== $location) {
                    return false;
                }

                if ($style !== '' && $archStyle !== $style) {
                    return false;
                }

                if ($budget === 'under_100' && $price >= 100000) {
                    return false;
                }

                if ($budget === '100_300' && ($price < 100000 || $price > 300000)) {
                    return false;
                }

                if ($budget === 'above_300' && $price <= 300000) {
                    return false;
                }

                if ($projectType !== '' && ! in_array($projectType, $types, true)) {
                    return false;
                }

                return true;
            })->values();
        }

        return view('features.cari', compact('architects'));
    }

    public function profil(Request $request, $id)
    {
        $architect = User::where('role', 'architect')
            ->with(['architectProfile', 'reviewsAsArchitect.client'])
            ->find($id);

        if (! $architect) {
            $architect = $this->dummyArchitectById((int) $id);
        }

        if (! $architect) {
            abort(404);
        }

        $reviews = collect();
        $eligibleProjects = collect();
        $ratingAverage = 0.0;
        $followersCount = 0;
        $isFollowing = false;

        if ($architect instanceof User) {
            $reviews = $architect->reviewsAsArchitect()
                ->with(['client'])
                ->latest()
                ->get();

            $ratingAverage = (float) $reviews->avg('rating');
            $followersCount = $architect->followers()->count();

            if ($request->user() && $request->user()->role === 'user') {
                $eligibleProjects = Project::query()
                    ->where('user_id', $request->user()->id)
                    ->where('architect_id', $architect->id)
                    ->where('status', 'completed')
                    ->whereDoesntHave('review')
                    ->latest()
                    ->get();

                $isFollowing = $request->user()->followingArchitects()
                    ->where('architect_id', $architect->id)
                    ->exists();
            }
        }

        return view('features.profil', compact('architect', 'reviews', 'eligibleProjects', 'ratingAverage', 'followersCount', 'isFollowing'));
    }

    public function storeReview(StoreArchitectReviewRequest $request, User $architect): RedirectResponse
    {
        if ($architect->role !== 'architect') {
            abort(404);
        }

        if ($request->user()?->role !== 'user') {
            abort(403);
        }

        $project = Project::query()
            ->where('id', $request->integer('project_id'))
            ->where('user_id', $request->user()->id)
            ->where('architect_id', $architect->id)
            ->where('status', 'completed')
            ->first();

        if (! $project) {
            return redirect()
                ->route('features.profil', $architect->id)
                ->with('error', 'Review hanya bisa ditulis untuk proyek yang sudah selesai dan sudah dibayar.');
        }

        if (Review::query()->where('project_id', $project->id)->exists()) {
            return redirect()
                ->route('features.profil', $architect->id)
                ->with('error', 'Proyek ini sudah memiliki review.');
        }

        Review::create([
            'project_id' => $project->id,
            'client_id' => $request->user()->id,
            'architect_id' => $architect->id,
            'rating' => $request->integer('rating'),
            'comment' => $request->string('comment')->toString(),
        ]);

        return redirect()
            ->route('features.profil', $architect->id)
            ->with('success', 'Review berhasil ditambahkan.');
    }

    public function updateReview(StoreArchitectReviewRequest $request, User $architect, Review $review): RedirectResponse
    {
        if ($architect->role !== 'architect') {
            abort(404);
        }

        if ($request->user()?->role !== 'user') {
            abort(403);
        }

        if ($review->client_id !== $request->user()->id || $review->architect_id !== $architect->id) {
            abort(403);
        }

        $review->update([
            'rating' => $request->integer('rating'),
            'comment' => $request->string('comment')->toString(),
        ]);

        return redirect()
            ->route('features.profil', $architect->id)
            ->with('success', 'Review berhasil diperbarui.');
    }

    public function follow(Request $request, User $architect): RedirectResponse
    {
        if ($architect->role !== 'architect') {
            abort(404);
        }

        if ($request->user()?->role !== 'user') {
            abort(403);
        }

        if ($request->user()->id === $architect->id) {
            abort(403, 'Tidak bisa mengikuti diri sendiri');
        }

        if (! $request->user()->followingArchitects()->where('architect_id', $architect->id)->exists()) {
            $request->user()->followingArchitects()->attach($architect->id);
        }

        return redirect()
            ->route('features.profil', $architect->id)
            ->with('success', 'Berhasil mengikuti arsitek ini.');
    }

    public function unfollow(Request $request, User $architect): RedirectResponse
    {
        if ($architect->role !== 'architect') {
            abort(404);
        }

        if ($request->user()?->role !== 'user') {
            abort(403);
        }

        $request->user()->followingArchitects()->detach($architect->id);

        return redirect()
            ->route('features.profil', $architect->id)
            ->with('success', 'Berhasil berhenti mengikuti arsitek ini.');
    }

    public function pricing()
    {
        return view('features.pricing');
    }

    private function dummyArchitects(): Collection
    {
        $rows = [
            [
                'id' => 1,
                'name' => 'Aruna Studio',
                'architectProfile' => [
                    'specialization' => 'Hunian Modern Minimalis',
                    'project_types' => ['Hunian'],
                    'price_per_m2' => 150000,
                    'rating' => 4.8,
                    'location' => 'Jakarta Selatan',
                    'style' => 'Minimalis',
                    'portfolio_images' => [],
                ],
            ],
            [
                'id' => 2,
                'name' => 'Bumi Atelier',
                'architectProfile' => [
                    'specialization' => 'Komersial & Restaurant',
                    'project_types' => ['Komersial'],
                    'price_per_m2' => 320000,
                    'rating' => 4.7,
                    'location' => 'Bandung',
                    'style' => 'Industrial',
                    'portfolio_images' => [],
                ],
            ],
            [
                'id' => 3,
                'name' => 'Karsa Arch',
                'architectProfile' => [
                    'specialization' => 'Hunian Tropis',
                    'project_types' => ['Hunian'],
                    'price_per_m2' => 95000,
                    'rating' => 4.6,
                    'location' => 'Yogyakarta',
                    'style' => 'Tropical',
                    'portfolio_images' => [],
                ],
            ],
            [
                'id' => 4,
                'name' => 'Nusa Forma',
                'architectProfile' => [
                    'specialization' => 'Hunian Klasik Modern',
                    'project_types' => ['Hunian'],
                    'price_per_m2' => 280000,
                    'rating' => 4.9,
                    'location' => 'Surabaya',
                    'style' => 'Klasik',
                    'portfolio_images' => [],
                ],
            ],
            [
                'id' => 5,
                'name' => 'Ruang Rupa',
                'architectProfile' => [
                    'specialization' => 'Commercial Space',
                    'project_types' => ['Komersial'],
                    'price_per_m2' => 210000,
                    'rating' => 4.5,
                    'location' => 'Jakarta Selatan',
                    'style' => 'Modern',
                    'portfolio_images' => [],
                ],
            ],
            [
                'id' => 6,
                'name' => 'Sagara Design',
                'architectProfile' => [
                    'specialization' => 'Restaurant & Cafe Concept',
                    'project_types' => ['Komersial'],
                    'price_per_m2' => 360000,
                    'rating' => 4.8,
                    'location' => 'Bali',
                    'style' => 'Tropical',
                    'portfolio_images' => [],
                ],
            ],
        ];

        return collect($rows)->map(fn ($row) => (object) $row);
    }

    private function dummyArchitectById(int $id): ?object
    {
        $architect = $this->dummyArchitects()->firstWhere('id', $id);

        if (! $architect) {
            return null;
        }

        if (is_array($architect->architectProfile ?? null)) {
            $architect->architectProfile = (object) $architect->architectProfile;
        }

        return $architect;
    }
}
