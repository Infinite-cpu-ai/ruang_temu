<?php

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists active architects for a client even without prior messages', function () {
    $client = User::factory()->client()->create();
    $architectA = User::factory()->architect()->create(['name' => 'Arsitek Alpha']);
    $architectB = User::factory()->architect()->create(['name' => 'Arsitek Beta']);

    $this->actingAs($client)
        ->get(route('chat.index'))
        ->assertSuccessful()
        ->assertSee('Arsitek Alpha')
        ->assertSee('Arsitek Beta');
});

it('opens a thread with a chosen architect by id', function () {
    $client = User::factory()->client()->create();
    $architect = User::factory()->architect()->create(['name' => 'Target Arsitek']);

    $this->actingAs($client)
        ->get(route('chat.index', $architect->id))
        ->assertSuccessful()
        ->assertSee('Target Arsitek');
});

it('does not list or default to non-architect contacts for a client', function () {
    $client = User::factory()->client()->create();
    $otherClient = User::factory()->client()->create(['name' => 'user1']);
    $architect = User::factory()->architect()->create(['name' => 'Zebra Arsitek']);

    Message::query()->create([
        'sender_id' => $client->id,
        'receiver_id' => $otherClient->id,
        'message' => 'salah kirim',
        'is_read' => false,
        'delivered_at' => null,
        'read_at' => null,
    ]);

    $this->actingAs($client)
        ->get(route('chat.index'))
        ->assertSuccessful()
        ->assertDontSee('user1')
        ->assertSee('Zebra Arsitek');
});

it('allows sending a message to any architect user', function () {
    $client = User::factory()->client()->create();
    $architect = User::factory()->architect()->create();

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
