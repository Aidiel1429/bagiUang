<?php

namespace App\Livewire\App\Akun;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;

class EditProfil extends Component
{
    public $nama, $email, $user_id;


    public function mount()
    {
        $this->nama = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->user_id = Auth::user()->id;
    }

    public function update() {
        try {
            $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            ], [
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            ]);

            $user = User::find($this->user_id);
            if (!$user) {
                session()->flash('error', 'Pengguna tidak ditemukan.');
                return;
            }

            $user->name = $this->nama;
            $user->email = $this->email;

            if ($user->save()) {
                session()->flash('success', 'Profil berhasil diperbarui.');
            } else {
                session()->flash('error', 'Profil gagal diperbarui.');
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.');
        }
    }
    
    public function render()
    {
        return view('livewire.app.akun.edit-profil');
    }
}
