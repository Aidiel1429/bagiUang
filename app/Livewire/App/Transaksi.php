<?php

namespace App\Livewire\App;

use App\Models\Alokasi;
use App\Models\RiwayatAlokasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Transaksi extends Component
{
    public $totalMasuk, $totalKeluar, $sisaSaldo;
    public $range = '', $tanggalAwal = '', $tanggalAkhir = '', $minAmount, $maxAmount, $alokasiId, $tipe;
    public $temp_range, $temp_tanggalAwal, $temp_tanggalAkhir, $temp_minAmount, $temp_maxAmount, $temp_alokasiId, $temp_tipe;
    public $listAlokasi = [];
    public $search = '';

    public function mount()
    {
        $this->totalMasuk = RiwayatAlokasi::whereHas('alokasi', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })
            ->where('tipe', 'masuk')
            ->sum('jumlah');

        $this->totalKeluar = RiwayatAlokasi::whereHas('alokasi', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })
            ->where('tipe', 'keluar')
            ->sum('jumlah');

        $this->sisaSaldo = $this->totalMasuk - $this->totalKeluar;

        $this->temp_tanggalAkhir = now()->format('Y-m-d');
        $this->temp_tanggalAwal = now()->subDays(3)->format('Y-m-d');

        $this->listAlokasi = Alokasi::where('user_id', Auth::user()->id)->get();
    }

    public function render()
    {
        $riwayatQuery = RiwayatAlokasi::whereHas('alokasi', function ($query) {
            $query->where('user_id', Auth::user()->id);
        });

        if ($this->range == '7_hari') {
            $riwayatQuery->whereDate('tanggal', '>=', now()->subDays(7));
        } elseif ($this->range == 'bulan_ini') {
            $riwayatQuery->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year);
        } elseif ($this->range == 'custom' && $this->tanggalAwal && $this->tanggalAkhir) {
            $riwayatQuery->whereBetween('tanggal', [$this->tanggalAwal, $this->tanggalAkhir]);
        }

        if ($this->minAmount) {
            $riwayatQuery->where('jumlah', '>=', $this->minAmount);
        }
        if ($this->maxAmount) {
            $riwayatQuery->where('jumlah', '<=', $this->maxAmount);
        }

        if ($this->alokasiId) {
            $riwayatQuery->where('alokasi_id', $this->alokasiId);
        }

        if ($this->tipe) {
            $riwayatQuery->where('tipe', $this->tipe);
        }

        if (!empty($this->search)) {
            $riwayatQuery->where(function ($q) {
                $q->where('keterangan', 'like', '%' . $this->search . '%')
                ->orWhere('jumlah', 'like', '%' . $this->search . '%')
                ->orWhereHas('alokasi', function ($query) {
                    $query->where('nama', 'like', '%' . $this->search . '%');
                });
            });
        }

        $riwayat = $riwayatQuery
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.app.transaksi', compact('riwayat'));
    }

    public function applyFilter()
    {
        $this->range = $this->temp_range;
        $this->tanggalAwal = $this->temp_tanggalAwal;
        $this->tanggalAkhir = $this->temp_tanggalAkhir;
        $this->minAmount = $this->temp_minAmount;
        $this->maxAmount = $this->temp_maxAmount;
        $this->alokasiId = $this->temp_alokasiId;
        $this->tipe = $this->temp_tipe;
    }

    public function resetFilter()
    {
        $this->range = '';
        $this->tanggalAwal = null;
        $this->tanggalAkhir = null;
        $this->minAmount = null;
        $this->maxAmount = null;
        $this->alokasiId = null;
        $this->tipe = null;
        $this->temp_range = '';
        $this->temp_tanggalAwal = now()->subDays(3)->format('Y-m-d');
        $this->temp_tanggalAkhir = now()->format('Y-m-d');
        $this->temp_minAmount = null;
        $this->temp_maxAmount = null;
        $this->temp_alokasiId = null;
        $this->temp_tipe = null;
    }
}
