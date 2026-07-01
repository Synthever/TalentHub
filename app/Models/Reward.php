<?php

namespace App\Models;

use Database\Factories\RewardFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama', 'deskripsi', 'poin_dibutuhkan', 'stok', 'gambar', 'aktif'])]
class Reward extends Model
{
    /** @use HasFactory<RewardFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }

    public function claims(): HasMany
    {
        return $this->hasMany(RewardClaim::class);
    }
}
