<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Daftar extends Component
{
    public $name, $email, $password, $password_confirmation;

    public function render()
    {
        return view('livewire.auth.daftar');
    }

    public function daftar()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $data = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password)
            ]);

            if ($data) {
                session()->flash('success', 'Pendaftaran berhasil. Silahkan masuk.');
                $this->reset_form();
                return redirect()->route('login');
            } else {
                session()->flash('error', 'Pendaftaran gagal. Silahkan coba lagi.');
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'Terjadi kesalahan. Silahkan coba lagi.');
        }
    }

    public function reset_form() {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
    }
}
