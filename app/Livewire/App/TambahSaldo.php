<?php

namespace App\Livewire\App;

use App\Models\Alokasi;
use App\Models\RiwayatAlokasi;
use App\Models\UangMasuk;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TambahSaldo extends Component
{
    public $jumlah, $tanggal, $keterangan, $user_id;

    public function mount() {
        $this->user_id = Auth::user()->id;

        $this->tanggal = now()->format('Y-m-d');
    }

    public function store()
    {
        $this->validate([
            'jumlah' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required',
        ], [
            'jumlah.required' => 'Jumlah harus diisi.',
            'tanggal.required' => 'Tanggal harus diisi.',
            'keterangan.required' => 'Keterangan harus diisi.',
        ]);

        try {
            UangMasuk::create([
                'user_id' => $this->user_id,
                'jumlah' => $this->jumlah,
                'tanggal' => $this->tanggal,
                'keterangan' => $this->keterangan,
            ]);

            $alokasiList = Alokasi::where('user_id', $this->user_id)->get();

            $alokasiUtama = $alokasiList->firstWhere('nama', 'Alokasi Utama');
            $alokasiLain = $alokasiList->where('nama', '!=', 'Alokasi Utama');

            $totalPersentase = $alokasiLain->sum('persentase');

            foreach ($alokasiLain as $alokasi) {
                $jumlahDialokasikan = $this->jumlah * ($alokasi->persentase / 100);

                RiwayatAlokasi::create([
                    'alokasi_id' => $alokasi->id,
                    'tipe' => 'masuk',
                    'jumlah' => $jumlahDialokasikan,
                    'keterangan' => $this->keterangan,
                    'tanggal' => $this->tanggal,
                ]);
            }

            if ($alokasiUtama && $totalPersentase < 100) {
                $jumlahUtama = $this->jumlah * ((100 - $totalPersentase) / 100);

                RiwayatAlokasi::create([
                    'alokasi_id' => $alokasiUtama->id,
                    'tipe' => 'masuk',
                    'jumlah' => $jumlahUtama,
                    'keterangan' => $this->keterangan,
                    'tanggal' => $this->tanggal,
                ]);
            }

            session()->flash('success', 'Saldo berhasil ditambahkan dan dialokasikan sesuai persentase.');
            $this->reset_form();
            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            session()->flash('error', 'Terjadi kesalahan saat menambahkan saldo.');
        }
    }

    public function render()
    {
        return view('livewire.app.tambah-saldo');
    }

    public function reset_form() {
        $this->jumlah = '';
        $this->tanggal = '';
        $this->keterangan = '';
    }
}
