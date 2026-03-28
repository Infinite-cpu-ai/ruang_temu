<?php

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists only followed architects for a client', function () {
    $client = User::factory()->client()->create();
    $architectFollowed = User::factory()->architect()->create(['name' => 'Arsitek Diikuti']);
    $architectNotFollowed = User::factory()->architect()->create(['name' => 'Arsitek Lain']);

    $client->followingArchitects()->attach($architectFollowed->id);

    $this->actingAs($client)
        ->get(route('chat.index'))
        ->assertSuccessful()
        ->assertSee('Arsitek Diikuti')
        ->assertDontSee('Arsitek Lain');
});

it('opens a thread with a followed architect', function () {
    $client = User::factory()->client()->create();
    $architect = User::factory()->architect()->create(['name' => 'Target Arsitek']);

    $client->followingArchitects()->attach($architect->id);

    $this->actingAs($client)
        ->get(route('chat.index', $architect->id))
        ->assertSuccessful()
        ->assertSee('Target Arsitek');
});

it('does not open a thread with an architect the client does not follow', function () {
    $client = User::factory()->client()->create();
    $architect = User::factory()->architect()->create(['name' => 'Bukan Diikuti']);

    $this->actingAs($client)
        ->get(route('chat.index', $architect->id))
        ->assertSuccessful()
        ->assertDontSee('Bukan Diikuti');
});

it('allows sending a message only to a followed architect', function () {
    $client = User::factory()->client()->create();
    $architect = User::factory()->architect()->create();

    $this->actingAs($client)
        ->postJson(route('chat.send'), [
            'receiver_id' => $architect->id,
            'message' => 'Halo.',
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['receiver_id']);

    $client->followingArchitects()->attach($architect->id);

    $this->actingAs($client)
        ->postJson(route('chat.send'), [
            'receiver_id' => $architect->id,
            'message' => 'Halo, konsultasi ruang tamu.',
        ])
        ->assertSuccessful()
        ->assertJsonPath('receiver_id', $architect->id)
        ->assertJsonPath('message', 'Halo, konsultasi ruang tamu.');

    expect(Message::query()->where('sender_id', $client->id)->where('receiver_id', $architect->id)->count())->toBe(1);
});

it('lets the receiver mark a message as delivered', function () {
    $client = User::factory()->client()->create();
    $architect = User::factory()->architect()->create();
    $client->followingArchitects()->attach($architect->id);

    $message = Message::create([
        'sender_id' => $client->id,
        'receiver_id' => $architect->id,
        'message' => 'Tes',
        'is_read' => false,
        'delivered_at' => null,
        'read_at' => null,
    ]);

    $this->actingAs($architect)
        ->postJson(route('chat.receipt.delivered'), [
            'message_id' => $message->id,
        ])
        ->assertNoContent();

    $message->refresh();
    expect($message->delivered_at)->not->toBeNull();
});

it('forbids marking delivered when not the receiver', function () {
    $client = User::factory()->client()->create();
    $architect = User::factory()->architect()->create();
    $other = User::factory()->architect()->create();
    $client->followingArchitects()->attach($architect->id);

    $message = Message::create([
        'sender_id' => $client->id,
        'receiver_id' => $architect->id,
        'message' => 'Tes',
        'is_read' => false,
        'delivered_at' => null,
        'read_at' => null,
    ]);

    $this->actingAs($other)
        ->postJson(route('chat.receipt.delivered'), [
            'message_id' => $message->id,
        ])
        ->assertForbidden();
});

it('marks incoming messages as read when the recipient opens the thread', function () {
    $client = User::factory()->client()->create();
    $architect = User::factory()->architect()->create();
    $client->followingArchitects()->attach($architect->id);

    $message = Message::create([
        'sender_id' => $architect->id,
        'receiver_id' => $client->id,
        'message' => 'Balasan arsitek',
        'is_read' => false,
        'delivered_at' => null,
        'read_at' => null,
    ]);

    $this->actingAs($client)
        ->get(route('chat.index', $architect->id))
        ->assertSuccessful();

    $message->refresh();
    expect($message->read_at)->not->toBeNull();
    expect($message->delivered_at)->not->toBeNull();
    expect($message->is_read)->toBeTrue();
});
