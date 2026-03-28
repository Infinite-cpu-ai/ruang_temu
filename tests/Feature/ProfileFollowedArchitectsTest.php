<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('hides the followed architects block when the client follows nobody', function () {
    $client = User::factory()->client()->create();

    $this->actingAs($client)
        ->get(route('profile.edit'))
        ->assertSuccessful()
        ->assertDontSee('Arsitek yang Anda ikuti');
});

it('shows followed architects on the client profile page', function () {
    $client = User::factory()->client()->create();
    $architect = User::factory()->architect()->create(['name' => 'Studio Diikuti']);

    $client->followingArchitects()->attach($architect->id);

    $this->actingAs($client)
        ->get(route('profile.edit'))
        ->assertSuccessful()
        ->assertSee('Arsitek yang Anda ikuti')
        ->assertSee('Studio Diikuti');
});
