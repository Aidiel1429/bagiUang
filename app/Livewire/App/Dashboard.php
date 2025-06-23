<?php

namespace App\Livewire\App;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Alokasi;
use App\Models\RiwayatAlokasi;
use Illuminate\Support\Facades\Auth;

#[Title('Dashboard - BagiUang')]
class Dashboard extends Component
{
    public $user_id;

    public function mount() {
        $this->user_id = Auth::user()->id;
    }

    public function render()
    {
        $alokasi = Alokasi::where('user_id', $this->user_id)
            ->with('riwayat') // ambil semua riwayat
            ->get()
            ->map(function($alokasi) {
                $alokasi->total_jumlah = $alokasi->riwayat->sum(function($item) {
                    return $item->tipe === 'masuk' 
                        ? $item->jumlah 
                        : -$item->jumlah;
                });
                return $alokasi;
            });

        $riwayat = RiwayatAlokasi::whereHas('alokasi', function ($query) {
                $query->where('user_id', $this->user_id);
            })
            ->orderBy('tanggal', 'desc')           
            ->orderBy('created_at', 'desc')        
            ->with(['alokasi' => function ($query) {
                $query->select('id', 'nama', 'icon');
            }])
            ->take(5)
            ->get();

        $totalMasuk = RiwayatAlokasi::whereHas('alokasi', function ($query) {
                $query->where('user_id', $this->user_id);
            })
            ->where('tipe', 'masuk')
            ->sum('jumlah');

        $totalKeluar = RiwayatAlokasi::whereHas('alokasi', function ($query) {
                $query->where('user_id', $this->user_id);
            })
            ->where('tipe', 'keluar')
            ->sum('jumlah');

        $totalSaldo = $totalMasuk - $totalKeluar;

        return view('livewire.app.dashboard', [
            'alokasi' => $alokasi,
            'riwayat' => $riwayat,
            'totalSaldo' => $totalSaldo,
        ]);
    }


}
