<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
            ->with('architectProfile');

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

    public function profil($id)
    {
        $architect = User::where('role', 'architect')->with('architectProfile')->find($id);

        if (! $architect) {
            $architect = $this->dummyArchitectById((int) $id);
        }

        if (! $architect) {
            abort(404);
        }

        return view('features.profil', compact('architect'));
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
