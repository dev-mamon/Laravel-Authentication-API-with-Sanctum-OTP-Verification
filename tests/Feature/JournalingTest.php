<?php

use App\Models\Journaling;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

it('allows mass assignment for year and week only', function () {
    $journal = Journaling::create(['year' => 2025, 'week' => 10]);

    expect($journal->year)->toBe(2025)
        ->and($journal->week)->toBe(10);
});

it('has a users many-to-many relationship with expected pivot columns', function () {
    $journal = Journaling::create(['year' => 2025, 'week' => 1]);
    $user = User::factory()->create();

    // attach with pivot data
    $journal->users()->attach($user->id, [
        'is_submitted' => true,
        'content' => 'My first week journal',
    ]);

    $attached = $journal->users()->first();

    expect($attached)->not->toBeNull()
        ->and($attached->pivot)->not->toBeNull()
        ->and((bool) $attached->pivot->is_submitted)->toBeTrue()
        ->and($attached->pivot->content)->toBe('My first week journal');
});

it('syncs pivot timestamps on attach and detach', function () {
    $journal = Journaling::create(['year' => 2025, 'week' => 2]);
    $user = User::factory()->create();

    $journal->users()->attach($user->id, [
        'is_submitted' => false,
        'content' => 'draft',
    ]);

    $pivot = $journal->users()->first()->pivot;

    expect($pivot->created_at)->not->toBeNull()
        ->and($pivot->updated_at)->not->toBeNull();

    // update pivot to bump updated_at
    $journal->users()->updateExistingPivot($user->id, ['content' => 'updated']);
    $pivotRefreshed = $journal->users()->first()->pivot;

    expect($pivotRefreshed->updated_at)->not->toEqual($pivot->updated_at);

    // detach to ensure no exception occurs
    $journal->users()->detach($user->id);
    expect($journal->users()->count())->toBe(0);
});

it('scopes querying by year and week correctly', function () {
    $j2025w1 = Journaling::create(['year' => 2025, 'week' => 1]);
    $j2025w2 = Journaling::create(['year' => 2025, 'week' => 2]);
    $j2026w1 = Journaling::create(['year' => 2026, 'week' => 1]);

    $found = Journaling::where('year', 2025)->where('week', 2)->first();

    expect($found->id)->toBe($j2025w2->id)
        ->and($found->is($j2025w1))->toBeFalse()
        ->and($found->is($j2026w1))->toBeFalse();
});

it('eager loads users relationship', function () {
    $journal = Journaling::create(['year' => 2025, 'week' => 3]);
    $users = User::factory()->count(2)->create();

    $journal->users()->attach($users->pluck('id')->all(), [
        'is_submitted' => false,
        'content' => 'multi',
    ]);

    $loaded = Journaling::with('users')->find($journal->id);

    expect($loaded->relationLoaded('users'))->toBeTrue()
        ->and($loaded->users)->toHaveCount(2)
        ->and($loaded->users->first()->pivot->content)->toBe('multi');
});
