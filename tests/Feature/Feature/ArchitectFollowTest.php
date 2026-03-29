<?php

use App\Models\User;

test('client can follow an architect', function () {
    $client = User::factory()->create(['role' => 'user']);
    $architect = User::factory()->create(['role' => 'architect']);

    $response = $this->actingAs($client)->post(route('features.follow', $architect->id));

    $response->assertRedirectToRoute('features.profil', $architect->id);
    $this->assertTrue($client->followingArchitects()->where('architect_id', $architect->id)->exists());
});

test('client can unfollow an architect', function () {
    $client = User::factory()->create(['role' => 'user']);
    $architect = User::factory()->create(['role' => 'architect']);

    $client->followingArchitects()->attach($architect->id);

    $response = $this->actingAs($client)->post(route('features.unfollow', $architect->id));

    $response->assertRedirectToRoute('features.profil', $architect->id);
    $this->assertFalse($client->followingArchitects()->where('architect_id', $architect->id)->exists());
});

test('architect cannot follow another architect', function () {
    $architect1 = User::factory()->create(['role' => 'architect']);
    $architect2 = User::factory()->create(['role' => 'architect']);

    $response = $this->actingAs($architect1)->post(route('features.follow', $architect2->id));

    $response->assertStatus(403);
});

test('unauthenticated user cannot follow', function () {
    $architect = User::factory()->create(['role' => 'architect']);

    $response = $this->post(route('features.follow', $architect->id));

    $response->assertRedirectToRoute('login');
});

test('unauthenticated user is redirected to login when opening follow link in browser', function () {
    $architect = User::factory()->create(['role' => 'architect']);

    $this->get(route('features.follow.link', $architect))
        ->assertRedirectToRoute('login');
});

test('client can follow via get link', function () {
    $client = User::factory()->create(['role' => 'user']);
    $architect = User::factory()->create(['role' => 'architect']);

    $this->actingAs($client)
        ->get(route('features.follow.link', $architect))
        ->assertRedirectToRoute('features.profil', $architect->id);

    expect($client->followingArchitects()->where('architect_id', $architect->id)->exists())->toBeTrue();
});

test('follower count is displayed correctly on architect profile', function () {
    $client1 = User::factory()->create(['role' => 'user']);
    $client2 = User::factory()->create(['role' => 'user']);
    $architect = User::factory()->create(['role' => 'architect']);
    $architect->architectProfile()->create([
        'specialization' => 'Test',
        'price_per_m2' => 100000,
    ]);

    $client1->followingArchitects()->attach($architect->id);
    $client2->followingArchitects()->attach($architect->id);

    $response = $this->get(route('features.profil', $architect->id));

    $response->assertViewHas('followersCount', 2);
});

test('isFollowing is false when client has not followed architect', function () {
    $client = User::factory()->create(['role' => 'user']);
    $architect = User::factory()->create(['role' => 'architect']);
    $architect->architectProfile()->create([
        'specialization' => 'Test',
        'price_per_m2' => 100000,
    ]);

    $response = $this->actingAs($client)->get(route('features.profil', $architect->id));

    $response->assertViewHas('isFollowing', false);
});

test('isFollowing is true when client has followed architect', function () {
    $client = User::factory()->create(['role' => 'user']);
    $architect = User::factory()->create(['role' => 'architect']);
    $architect->architectProfile()->create([
        'specialization' => 'Test',
        'price_per_m2' => 100000,
    ]);

    $client->followingArchitects()->attach($architect->id);

    $response = $this->actingAs($client)->get(route('features.profil', $architect->id));

    $response->assertViewHas('isFollowing', true);
});
