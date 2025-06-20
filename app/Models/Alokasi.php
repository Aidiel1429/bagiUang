<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alokasi extends Model
{
    protected $table = 'alokasi';

    protected $fillable = ['user_id', 'nama', 'persentase', 'icon'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function riwayat(): HasMany
    {
        return $this->hasMany(RiwayatAlokasi::class);
    }
}
