<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'lab_key', 'started_at', 'last_seen_at', 'solved_at', 'solve_count'])]
class LabProgress extends Model
{
    protected $table = 'lab_progress';

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'last_seen_at' => 'datetime',
            'solved_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function elapsedSeconds(): ?int
    {
        if ($this->started_at === null) {
            return null;
        }

        return $this->started_at->diffInSeconds($this->solved_at ?? now());
    }
}
