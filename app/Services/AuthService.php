<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AuthService
{
    protected $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login(array $credentials): array
    {
        try {
            $response = $this->repository->login($credentials);
            $data = $response->json();

            if ($response->successful() && isset($data['response_code']) && $data['response_code'] == 200) {
                Session::put('token', $data['data']['token']);
                Session::put('user', $data['data']['user']);
                Session::put('permissions', $data['data']['permissions'] ?? []);
                Session::put('roles', $data['data']['roles'] ?? []);

                return ['success' => true, 'user' => $data['data']['user']];
            }

            return ['success' => false, 'message' => $data['message'] ?? 'Login gagal.'];
        } catch (\Exception $e) {
            Log::error('AuthService Login Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Terjadi kesalahan saat menghubungi server.'];
        }
    }

    public function logout(): bool
    {
        $token = Session::get('token');
        if ($token) {
            $response = $this->repository->logout($token);
            if ($response->successful()) {
                Session::flush();
                return true;
            }
        }
        return false;
    }
    public function getUserInfo(): ?array
    {
        Log::info('getUserInfo called', ['caller' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]]);
        if (Session::has('user_info')) {
            return Session::get('user_info');
        }

        $token = session('token');
        if (!$token) {
            Log::info('No token found, skipping getUserInfo');
            return null;
        }

        $response = $this->repository->getUserInfo($token);
        if ($response->successful()) {
            $userInfo = $response->json()['data'];
            Session::put('user_info', $userInfo);
            return $userInfo;
        }

        Log::warning('Failed to get user info', ['status' => $response->status()]);
        return null;
    }
}
