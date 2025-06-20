<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatAlokasi extends Model
{
    protected $table = 'riwayat_alokasi';

    protected $fillable = ['alokasi_id', 'tipe', 'jumlah', 'keterangan', 'tanggal'];

    public function alokasi(): BelongsTo
    {
        return $this->belongsTo(Alokasi::class);
    }
}
