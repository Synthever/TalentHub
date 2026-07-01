<?php

namespace App\Models;

use Database\Factories\UserSkillFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable(['user_id', 'skill_id', 'level', 'bukti', 'status', 'catatan_admin', 'poin', 'verified_at'])]
class UserSkill extends Model
{
    /** @use HasFactory<UserSkillFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function points(): MorphMany
    {
        return $this->morphMany(Point::class, 'pointable');
    }
}
