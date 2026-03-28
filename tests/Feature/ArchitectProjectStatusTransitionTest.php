<?php

use App\Models\Project;
use App\Models\User;

test('architect cannot jump status from pending directly to completed', function () {
    $architect = User::factory()->create(['role' => 'architect']);
    $client = User::factory()->create(['role' => 'user']);

    $project = Project::query()->create([
        'user_id' => $client->id,
        'architect_id' => $architect->id,
        'property_type' => 'Hunian',
        'area_size' => 100,
        'total_price' => 25000000,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($architect)->patch(route('architect.projects.update-status', $project), [
        'status' => 'completed',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');

    expect($project->fresh()->status)->toBe('pending');
});

test('architect can update status through valid flow to completed', function () {
    $architect = User::factory()->create(['role' => 'architect']);
    $client = User::factory()->create(['role' => 'user']);

    $project = Project::query()->create([
        'user_id' => $client->id,
        'architect_id' => $architect->id,
        'property_type' => 'Komersial',
        'area_size' => 80,
        'total_price' => 30000000,
        'status' => 'pending',
    ]);

    $this->actingAs($architect)->patch(route('architect.projects.update-status', $project), ['status' => 'paid'])
        ->assertRedirect();

    expect($project->fresh()->status)->toBe('paid');

    $this->actingAs($architect)->patch(route('architect.projects.update-status', $project), ['status' => 'on_progress'])
        ->assertRedirect();

    expect($project->fresh()->status)->toBe('on_progress');

    $this->actingAs($architect)->patch(route('architect.projects.update-status', $project), ['status' => 'completed'])
        ->assertRedirect();

    expect($project->fresh()->status)->toBe('completed');
});
