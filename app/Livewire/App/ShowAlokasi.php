<?php

namespace App\Livewire\App;

use App\Models\Alokasi;
use App\Models\RiwayatAlokasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowAlokasi extends Component
{
    public $dataAlokasi, $riwayat_alokasi = [], $totalSaldo = 0, $daftarAlokasi = [], $hanyaAlokasiUtama;
    public $alokasi_id, $jumlah, $tanggal, $keterangan, $search;

    public function mount($nama)
    {
        $this->dataAlokasi = Alokasi::where('nama', $nama)->where('user_id', Auth::user()->id)->first();

        if (!$this->dataAlokasi) {
            abort(404);
        }

        $riwayat = RiwayatAlokasi::where('alokasi_id', $this->dataAlokasi->id)->get();

        $this->totalSaldo = collect($riwayat)->sum(function ($r) {
            return $r->tipe === 'masuk' ? $r->jumlah : -$r->jumlah;
        });

        $this->daftarAlokasi = Alokasi::where('nama', '!=', $this->dataAlokasi->nama)->where('user_id', Auth::user()->id)->get();
        $this->hanyaAlokasiUtama = Alokasi::where('user_id', Auth::user()->id)->count() == 1 && $this->dataAlokasi->nama === 'Alokasi Utama';

        $this->tanggal = now()->format('Y-m-d');
    }


    public function openPindahSaldoModal()
    {
        $this->alokasi_id = null;
        $this->jumlah = null;
    }

    public function pindahSaldo()
    {
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
                session()->flash('error', 'Jumlah saldo tidak valid. Pastikan jumlah saldo yang dipindahkan lebih besar dari 0 dan tidak melebihi saldo saat ini.');
                return;
            }

            RiwayatAlokasi::create([
                'alokasi_id' => $this->dataAlokasi->id,
                'tipe' => 'keluar',
                'jumlah' => $this->jumlah,
                'keterangan' => "Pindah ke alokasi {$alokasiTujuan->nama}",
                'tanggal' => now(),
            ]);

            RiwayatAlokasi::create([
                'alokasi_id' => $alokasiTujuan->id,
                'tipe' => 'masuk',
                'jumlah' => $this->jumlah,
                'keterangan' => "Diterima dari alokasi {$this->dataAlokasi->nama}",
                'tanggal' => now(),
            ]);

            session()->flash('success', "Saldo berhasil dipindahkan ke {$alokasiTujuan->nama}.");
            $this->reset_form();
            $this->mount($this->dataAlokasi->nama);
        } catch (\Throwable $th) {
            session()->flash('error', 'Terjadi kesalahan saat memindahkan saldo. Silakan coba lagi.');
        }
    }

    public function transferBayar()
    {
        $this->validate([
            'jumlah' => 'required|numeric|min:1|max:' . $this->totalSaldo,
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ], [
            'jumlah.required' => 'Jumlah harus diisi.',
            'jumlah.numeric' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah tidak boleh kurang dari 1.',
            'jumlah.max' => 'Jumlah tidak boleh melebihi saldo saat ini.',
            'tanggal.required' => 'Tanggal harus diisi.',
            'keterangan.required' => 'Keterangan harus diisi.',
        ]);

        try {
            $data = RiwayatAlokasi::create([
                'alokasi_id' => $this->dataAlokasi->id,
                'tipe' => 'keluar',
                'jumlah' => $this->jumlah,
                'keterangan' => $this->keterangan,
                'tanggal' => $this->tanggal,
            ]);

            if ($data) {
                session()->flash('success', "Berhasil melakukan pembayaran.");
                $this->reset_form();
                $this->mount($this->dataAlokasi->nama);
            } else {
                session()->flash('error', 'Gagal melakukan pembayaran. Silakan coba lagi.');
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'Terjadi kesalahan saat melakukan pembayaran: ' . $th->getMessage());
        }
    }

    public function tambahSaldo()
    {
        $this->validate([
            'jumlah' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ], [
            'jumlah.required' => 'Jumlah harus diisi.',
            'jumlah.numeric' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah tidak boleh kurang dari 1.',
            'tanggal.required' => 'Tanggal harus diisi.',
            'keterangan.required' => 'Keterangan harus diisi.',
        ]);

        try {
            $data = RiwayatAlokasi::create([
                'alokasi_id' => $this->dataAlokasi->id,
                'tipe' => 'masuk',
                'jumlah' => $this->jumlah,
                'keterangan' => $this->keterangan,
                'tanggal' => $this->tanggal,
            ]);

            if ($data) {
                session()->flash('success', "Saldo berhasil ditambahkan.");
                $this->reset_form();
                $this->mount($this->dataAlokasi->nama);
            } else {
                session()->flash('error', 'Gagal menambahkan saldo. Silakan coba lagi.');
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'Terjadi kesalahan saat menambahkan saldo: ');
        }
    }

    public function delete()
    {
        try {
            $data = Alokasi::find($this->dataAlokasi->id);

            if (!$data) {
                session()->flash('error', 'Alokasi tidak ditemukan!');
                return;
            }

            // Hitung total saldo dari alokasi yang mau dihapus
            $riwayat = RiwayatAlokasi::where('alokasi_id', $data->id)->get();
            $saldo = collect($riwayat)->sum(function ($r) {
                return $r->tipe === 'masuk' ? $r->jumlah : -$r->jumlah;
            });

            // Jika saldo > 0, pindahkan ke Alokasi Utama
            if ($saldo > 0) {
                $alokasiUtama = Alokasi::where('user_id', Auth::user()->id)
                    ->where('nama', 'Alokasi Utama')
                    ->first();

                if ($alokasiUtama) {
                    RiwayatAlokasi::create([
                        'alokasi_id' => $alokasiUtama->id,
                        'tipe'       => 'masuk',
                        'jumlah'     => $saldo,
                        'keterangan' => "Saldo dari Alokasi {$data->nama} yang dihapus",
                        'tanggal'    => now(),
                    ]);
                }
            }

            // Hapus alokasi
            $data->delete();

            session()->flash('success', "Alokasi {$data->nama} berhasil dihapus.");
            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            session()->flash('error', 'Terjadi kesalahan saat menghapus alokasi: ' . $th->getMessage());
        }
    }



    public function render()
    {
        $riwayatQuery = RiwayatAlokasi::where('alokasi_id', $this->dataAlokasi->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $riwayatQuery->where('keterangan', 'like', '%' . $this->search . '%')->orWhere('jumlah', 'like', '%' . $this->search . '%')->orWhere('tanggal', 'like', '%' . $this->search . '%')->orWhereHas('alokasi', function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            });
        }

        $this->riwayat_alokasi = $riwayatQuery->get();

        return view('livewire.app.show-alokasi');
    }

    public function reset_form()
    {
        $this->alokasi_id = null;
        $this->jumlah = null;
    }
}
