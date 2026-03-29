<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects guests to login when opening checkout', function () {
    $architect = User::factory()->architect()->create();

    $this->get(route('checkout.index', $architect))
        ->assertRedirect(route('login'));
});

it('forbids checkout for non-clients', function () {
    $architect = User::factory()->architect()->create();
    $otherArchitect = User::factory()->architect()->create();

    $this->actingAs($otherArchitect)
        ->get(route('checkout.index', $architect))
        ->assertForbidden();
});

it('shows checkout for a client with a real architect', function () {
    $client = User::factory()->client()->create();
    $architect = User::factory()->architect()->create(['name' => 'Studio Tes']);

    $this->actingAs($client)
        ->get(route('checkout.index', $architect))
        ->assertSuccessful()
        ->assertSee('Studio Tes')
        ->assertSee('Rumah hunian')
        ->assertSee('Komersial / ruang usaha');
});

it('returns 404 when checkout target is not an architect', function () {
    $client = User::factory()->client()->create();
    $notArchitect = User::factory()->client()->create();

    $this->actingAs($client)
        ->get(route('checkout.index', $notArchitect))
        ->assertNotFound();
});

it('creates a project on checkout submit', function () {
    $client = User::factory()->client()->create();
    $architect = User::factory()->architect()->create();

    $this->actingAs($client)
        ->post(route('checkout.process'), [
            'architect_id' => $architect->id,
            'property_type' => 'hunian',
            'area_size' => 100,
            'price_per_m2' => 200000,
            '_token' => csrf_token(),
        ])
        ->assertSuccessful()
        ->assertSee('Pemesanan berhasil');

    $project = Project::query()->where('user_id', $client->id)->first();
    expect($project)->not->toBeNull();
    expect($project->property_type)->toBe('Rumah Hunian');
    expect((int) $project->area_size)->toBe(100);
    expect((float) $project->price_per_m2)->toBe(200000.0);
    expect((float) $project->total_price)->toBe(20000000.0);
});
