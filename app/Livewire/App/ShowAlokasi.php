<?php

namespace App\Livewire\App;

use App\Models\Alokasi;
use App\Models\RiwayatAlokasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowAlokasi extends Component
{
    public $dataAlokasi, $riwayat_alokasi = [], $totalSaldo = 0, $daftarAlokasi = [], $hanyaAlokasiUtama;
    public $alokasi_id = "", $jumlah;

    public function mount($nama)
    {
        $this->dataAlokasi = Alokasi::where('nama', $nama)->where('user_id', Auth::user()->id)->first();

        if (!$this->dataAlokasi) {
            abort(404);
        }

        $this->riwayat_alokasi = RiwayatAlokasi::where('alokasi_id', $this->dataAlokasi->id)->get();

        $this->totalSaldo = collect($this->riwayat_alokasi)->sum(function ($riwayat) {
            return $riwayat->tipe === 'masuk' ? $riwayat->jumlah : -$riwayat->jumlah;
        });

        $this->daftarAlokasi = Alokasi::where('nama', '!=', $this->dataAlokasi->nama)->where('user_id', Auth::user()->id)->get();
        $this->hanyaAlokasiUtama = Alokasi::where('user_id', Auth::user()->id)->count() == 1 && $this->dataAlokasi->nama === 'Alokasi Utama';

        $this->alokasi_id = null;
    }

    public function openPindahSaldoModal()
    {
        $this->alokasi_id = null;
        $this->jumlah = null;
    }

    public function pindahSaldo() {
        $this->validate([
            'alokasi_id' => 'required',
            'jumlah' => 'required',
        ], [
            'alokasi_id.required' => 'Alokasi tujuan harus dipilih.',
            'jumlah.required' => 'Jumlah harus diisi.',
        ]);

        try {
            $alokasiTujuan = Alokasi::find($this->alokasi_id);

            if (!$alokasiTujuan) {
                session()->flash('error', 'Alokasi tujuan tidak ditemukan.');
                return;
            }

            if ($this->jumlah <= 0 || $this->jumlah > $this->totalSaldo) {
                session()->flash('error', 'Jumlah tidak valid.');
                return;
            }

            RiwayatAlokasi::create([
                'alokasi_id' => $this->dataAlokasi->id,
                'tipe' => 'keluar',
                'jumlah' => $this->jumlah,
                'keterangan' => "Pindah ke {$alokasiTujuan->nama}",
                'tanggal' => now(),
            ]);

            RiwayatAlokasi::create([
                'alokasi_id' => $alokasiTujuan->id,
                'tipe' => 'masuk',
                'jumlah' => $this->jumlah,
                'keterangan' => "Diterima dari {$this->dataAlokasi->nama}",
                'tanggal' => now(),
            ]);

            session()->flash('success', "Saldo berhasil dipindahkan ke {$alokasiTujuan->nama}.");
            $this->reset_form();
            $this->mount($this->dataAlokasi->nama);
        } catch (\Throwable $th) {
            session()->flash('error', 'Terjadi kesalahan saat memindahkan saldo. Silakan coba lagi.');
        }
    }


    public function render()
    {
        return view('livewire.app.show-alokasi');
    }

    public function reset_form()
    {
        $this->alokasi_id = null;
        $this->jumlah = null;
    }
}
