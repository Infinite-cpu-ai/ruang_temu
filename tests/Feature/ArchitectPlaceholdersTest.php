<?php

use App\Models\ArchitectProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows profile and portfolio placeholder images when architect has no photos', function () {
    $architect = User::factory()->create(['role' => 'architect']);
    ArchitectProfile::query()->create([
        'user_id' => $architect->id,
        'specialization' => 'Hunian',
        'portfolio_images' => [],
        'profile_image' => null,
    ]);

    $response = $this->get(route('features.profil', $architect->id));

    $response->assertSuccessful();
    expect($response->getContent())->toContain('images/profiles/profile_placeholder.png');
    expect($response->getContent())->toContain('images/portofolios/portofolio_placeholder.png');
});
