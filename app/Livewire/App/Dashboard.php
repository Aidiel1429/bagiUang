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
        $alokasi = Alokasi::withSum('riwayat as total_jumlah', 'jumlah')
            ->where('user_id', $this->user_id)
            ->get();

        $riwayat = RiwayatAlokasi::orderBy('tanggal', 'desc')
            ->with(['alokasi' => function ($query) {
                $query->select('id', 'nama', 'icon');
            }])
            ->take(5)
            ->get();

        // Hitung total masuk
        $totalMasuk = RiwayatAlokasi::whereHas('alokasi', function ($query) {
                $query->where('user_id', $this->user_id);
            })
            ->where('tipe', 'masuk')
            ->sum('jumlah');

        // Hitung total keluar
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
