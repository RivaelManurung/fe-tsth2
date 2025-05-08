<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    protected $authService;

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
}
