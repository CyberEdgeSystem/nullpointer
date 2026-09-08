<?php

use App\Models\LabProgress;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Product::query()->create([
        'name' => 'Released Gift',
        'description' => 'Visible catalogue product.',
        'category' => 'Gifts',
        'price' => 10,
        'released' => true,
    ]);

    Product::query()->create([
        'name' => 'Unreleased Gift',
        'description' => 'This product must normally remain hidden.',
        'category' => 'Gifts',
        'price' => 20,
        'released' => false,
    ]);
});

test('labs remain available to guests', function () {
    $this->get(route('labs.sql-injection'))
        ->assertOk()
        ->assertDontSee('data-test="lab-progress"', false);
});

test('authenticated users get lab progress when opening a lab', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('labs.sql-injection'))
        ->assertOk()
        ->assertSee('data-test="lab-progress"', false);

    expect(LabProgress::query()
        ->where('user_id', $user->id)
        ->where('lab_key', 'product_filter')
        ->exists())->toBeTrue();
});

test('solving a lab records solved progress for authenticated users', function () {
    $user = User::factory()->create();
    $payload = "Gifts' OR 1=1 -- ";

    $this->actingAs($user)
        ->get(route('labs.sql-injection', ['category' => $payload]))
        ->assertOk()
        ->assertSee('data-test="ctf-flag"', false);

    $progress = LabProgress::query()
        ->where('user_id', $user->id)
        ->where('lab_key', 'product_filter')
        ->first();

    expect($progress)->not->toBeNull()
        ->and($progress->solved_at)->not->toBeNull()
        ->and($progress->solve_count)->toBe(1);
});

test('the dashboard shows authenticated user progress', function () {
    $user = User::factory()->create();

    LabProgress::query()->create([
        'user_id' => $user->id,
        'lab_key' => 'product_filter',
        'started_at' => now()->subMinutes(5),
        'last_seen_at' => now(),
        'solved_at' => now(),
        'solve_count' => 1,
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Прогрес лабораторних')
        ->assertSee('Лаба 1: Фільтр товарів')
        ->assertSee('1 / 10');
});

test('authenticated users can reset a lab completion status', function () {
    $user = User::factory()->create();

    LabProgress::query()->create([
        'user_id' => $user->id,
        'lab_key' => 'product_filter',
        'started_at' => now()->subMinutes(5),
        'last_seen_at' => now(),
        'solved_at' => now(),
        'solve_count' => 1,
    ]);

    $this->actingAs($user)
        ->post(route('dashboard.lab.reset', ['labKey' => 'product_filter']))
        ->assertRedirect(route('dashboard'));

    $progress = LabProgress::query()
        ->where('user_id', $user->id)
        ->where('lab_key', 'product_filter')
        ->first();

    expect($progress)->not->toBeNull()
        ->and($progress->solved_at)->toBeNull()
        ->and($progress->solve_count)->toBe(0)
        ->and($progress->started_at)->toBeNull();
});
