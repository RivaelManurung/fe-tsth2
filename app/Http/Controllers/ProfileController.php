<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    protected $auth_service;

    public function __construct(AuthService $auth_service)
    {
        $this->auth_service = $auth_service;
    }

    public function index()
    {
        $token = session('token');

        if (!$token) return null;

        $user = $this->auth_service->getUserInfo();
        return view('frontend.profile.user_profile', compact('user'));
    }

    public function changePassword()
    {
        $token = session('token');

        if (!$token) return null;

        $user = $this->auth_service->getUserInfo();

        return view('frontend.profile.ganti_password', compact('user'));
    }

    public function updateEmail(Request $request)
{
    // Ambil email baru dari input form
    $newEmail = $request->input('new_email');

    // Kirim request ke API untuk update email
    $response = Http::withToken(session('token'))->put(config('api.base_url') . '/user/update-email', [
        'email' => $newEmail,
    ]);

    if ($response->successful()) {
        // Kirimkan email verifikasi jika update email berhasil
        return back()->with('success', 'Email berhasil diperbarui. Kami telah mengirimkan email verifikasi ke alamat baru.');
    }

    return back()->withErrors(['message' => 'Gagal memperbarui email.']);
}
}
