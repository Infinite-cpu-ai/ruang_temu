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
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $projectType = $request->string('project_type')->toString();
        $location = $request->string('location')->toString();
        $style = $request->string('style')->toString();

        $architectsQuery = User::query()
            ->where('role', 'architect')
            ->where('is_active', true)
            ->where('is_premium', true)
            ->with(['architectProfile.specializations'])
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
            $architectsQuery->whereHas('architectProfile', function ($q) use ($budget, $minPrice, $maxPrice) {
                if ($budget === 'under_100') {
                    $q->where('price_per_m2', '<', 100000);
                } elseif ($budget === '100_300') {
                    $q->whereBetween('price_per_m2', [100000, 300000]);
                } elseif ($budget === 'above_300') {
                    $q->where('price_per_m2', '>', 300000);
                } elseif ($budget === 'custom') {
                    if ($minPrice !== null && $minPrice !== '') {
                        $q->where('price_per_m2', '>=', $minPrice);
                    }
                    if ($maxPrice !== null && $maxPrice !== '') {
                        $q->where('price_per_m2', '<=', $maxPrice);
                    }
                }
            });
        }

        if ($projectType !== '') {
            // Check if it's within the specific project type array OR within the modern relations
            $architectsQuery->whereHas('architectProfile', function ($q) use ($projectType) {
                $q->whereJsonContains('project_types', $projectType)
                  ->orWhereHas('specializations', function ($sq) use ($projectType) {
                      $sq->where('name', $projectType);
                  });
            });
        }

        $architects = $architectsQuery->get();

        // No more fallback to dummy data according to the request "tidak di hardcode"
        // But if architects is empty, we just pass the empty collection to frontend.

        // Get unique options dynamically from active architects' profiles
        $locations = \App\Models\ArchitectProfile::whereHas('user', fn($q) => $q->where('role', 'architect')->where('is_active', true)->where('is_premium', true))
            ->whereNotNull('location')->where('location', '!=', '')
            ->distinct()->pluck('location');
            
        $styles = \App\Models\ArchitectProfile::whereHas('user', fn($q) => $q->where('role', 'architect')->where('is_active', true)->where('is_premium', true))
            ->whereNotNull('style')->where('style', '!=', '')
            ->distinct()->pluck('style');
            
        // For specializations, fetch from relationships or raw DB
        $dbSpecializations = \App\Models\Specialization::pluck('name');
        $profileProjectTypes = []; // Can be extracted if needed, but DB spec is better
        
        $projectTypes = $dbSpecializations->count() > 0 ? $dbSpecializations : collect([
            'Residential', 'Commercial', 'Minimalist', 'Interior', 'Landscape', 'Master Planning'
        ]); // fallback options if totally empty table

        return view('features.cari', compact('architects', 'locations', 'styles', 'projectTypes'));
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

    public function followFromLink(Request $request, User $architect): RedirectResponse
    {
        if ($architect->role !== 'architect') {
            abort(404);
        }

        if (! $request->user()) {
            return redirect()->guest(route('login'));
        }

        if ($request->user()->role !== 'user') {
            abort(403, 'Hanya klien yang dapat mengikuti arsitek.');
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
