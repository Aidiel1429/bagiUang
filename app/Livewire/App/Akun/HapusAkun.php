<?php

namespace App\Livewire\App\Akun;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HapusAkun extends Component
{
    public $konfirmasi;

    public function hapusAkun()
    {
        $this->validate([
            'konfirmasi' => 'required|in:HAPUS',
        ], [
            'konfirmasi.required' => 'Ketik "HAPUS" untuk mengonfirmasi penghapusan akun.',
            'konfirmasi.in' => 'Ketik kata "HAPUS" dengan benar untuk melanjutkan.'
        ]);

        try {
            $user = User::find(Auth::user()->id);
            if (!$user) {
                session()->flash('error', 'Pengguna tidak ditemukan.');
            }

            foreach ($user->alokasi as $alokasi) {
                $alokasi->riwayat()->delete();
            }

            $user->alokasi()->delete();
            $user->saldoMasuk()->delete();

            if ($user->delete()) {
                session()->flash('success', 'Akun dan semua data terkait berhasil dihapus!');
                return redirect('/login');
                $this->konfirmasi = null;
            } else {
                session()->flash('error', 'Gagal menghapus akun. Silakan coba lagi.');
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'Terjadi kesalahan saat menghapus akun. Silakan coba lagi.');
        }
    }


    public function render()
    {
        return view('livewire.app.akun.hapus-akun');
    }
}
