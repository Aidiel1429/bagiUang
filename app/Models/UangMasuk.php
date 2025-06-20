<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UangMasuk extends Model
{
    //
    protected $table = 'uang_masuk';

    protected $fillable = ['user_id', 'jumlah', 'keterangan', 'tanggal'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
