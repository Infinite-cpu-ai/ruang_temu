<?php

use App\Models\Project;
use App\Models\Review;
use App\Models\User;

test('client can add review from architect profile when completed project exists', function () {
    $client = User::factory()->create(['role' => 'user']);
    $architect = User::factory()->create(['role' => 'architect']);

    $project = Project::query()->create([
        'user_id' => $client->id,
        'architect_id' => $architect->id,
        'property_type' => 'Hunian',
        'area_size' => 120,
        'total_price' => 45000000,
        'status' => 'completed',
    ]);

    $response = $this->actingAs($client)->post(route('features.reviews.store', $architect->id), [
        'project_id' => $project->id,
        'rating' => 5,
        'comment' => 'Hasil desain sangat bagus dan sesuai brief.',
    ]);

    $response->assertRedirect(route('features.profil', $architect->id));

    $this->assertDatabaseHas('reviews', [
        'project_id' => $project->id,
        'client_id' => $client->id,
        'architect_id' => $architect->id,
        'rating' => 5,
    ]);
});

test('client can update own review from architect profile page', function () {
    $client = User::factory()->create(['role' => 'user']);
    $architect = User::factory()->create(['role' => 'architect']);

    $project = Project::query()->create([
        'user_id' => $client->id,
        'architect_id' => $architect->id,
        'property_type' => 'Komersial',
        'area_size' => 90,
        'total_price' => 32000000,
        'status' => 'completed',
    ]);

    $review = Review::query()->create([
        'project_id' => $project->id,
        'client_id' => $client->id,
        'architect_id' => $architect->id,
        'rating' => 4,
        'comment' => 'Bagus.',
    ]);

    $response = $this->actingAs($client)->put(route('features.reviews.update', ['architect' => $architect->id, 'review' => $review->id]), [
        'project_id' => $project->id,
        'rating' => 5,
        'comment' => 'Direvisi: sangat puas dengan hasil akhirnya.',
    ]);

    $response->assertRedirect(route('features.profil', $architect->id));

    $this->assertDatabaseHas('reviews', [
        'id' => $review->id,
        'rating' => 5,
        'comment' => 'Direvisi: sangat puas dengan hasil akhirnya.',
    ]);
});

test('client cannot add review for non completed project', function () {
    $client = User::factory()->create(['role' => 'user']);
    $architect = User::factory()->create(['role' => 'architect']);

    $project = Project::query()->create([
        'user_id' => $client->id,
        'architect_id' => $architect->id,
        'property_type' => 'Hunian',
        'area_size' => 120,
        'total_price' => 45000000,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($client)->post(route('features.reviews.store', $architect->id), [
        'project_id' => $project->id,
        'rating' => 5,
        'comment' => 'Coba review.',
    ]);

    $response->assertRedirect(route('features.profil', $architect->id));

    $this->assertDatabaseMissing('reviews', [
        'project_id' => $project->id,
        'client_id' => $client->id,
    ]);
});
