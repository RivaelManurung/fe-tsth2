<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Services\WebService;
use App\Services\AuthService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Batasi View Composer ke view spesifik
        View::composer(['*'], function ($view) {
            // Ambil token dari sesi
            $token = Session::get('token');
            if (!$token) {
                Log::info('No token found in View Composer, skipping data fetch');
                return $view->with(['user' => null, 'web' => null, 'permissions' => []]);
            }

            // Ambil user info dari sesi atau AuthService
            $authService = app(AuthService::class);
            $user = Session::get('user_info') ?? $authService->getUserInfo();
            if ($user) {
                Session::put('user_info', $user);
                Log::info('User info fetched or retrieved from session', ['user_id' => $user['id'] ?? null]);
            } else {
                Log::warning('Failed to fetch user info in View Composer');
            }

            // Ambil web info dari sesi atau WebService
            $webService = app(WebService::class);
            $web = Session::get('web_info') ?? $webService->getById($token, 1);
            if ($web) {
                Session::put('web_info', $web);
                Log::info('Web info fetched or retrieved from session', ['web_id' => 1]);
            } else {
                Log::warning('Failed to fetch web info in View Composer');
            }

            // Generate permission flags
            $permissions = $user['permissions'] ?? [];
            $keys = [
                'manage_permissions',
                'create_user',
                'update_user',
                'view_user',
                'delete_user',
                'create_role',
                'update_role',
                'view_role',
                'delete_role',
                'create_barang',
                'update_barang',
                'view_barang',
                'delete_barang',
                'create_gudang',
                'update_gudang',
                'view_gudang',
                'delete_gudang',
                'create_satuan',
                'update_satuan',
                'view_satuan',
                'delete_satuan',
                'create_jenis_barang',
                'update_jenis_barang',
                'view_jenis_barang',
                'delete_jenis_barang',
                'create_transaction_type',
                'update_transaction_type',
                'view_transaction_type',
                'delete_transaction_type',
                'create_transaction',
                'view_transaction',
                'create_category_barang',
                'update_category_barang',
                'view_category_barang',
                'delete_category_barang',
            ];
            $flags = generatePermissionsFlags($permissions, $keys);

            // Kirim data ke view
            $view->with([
                'user' => $user,
                'web' => $web,
                'permissions' => $permissions,
            ] + $flags);
        });

        // Optimasi Blade directive @can
        Blade::if('can', function ($permission) {
            // Gunakan user info dari sesi jika tersedia
            $user = Session::get('user_info');
            if (!$user) {
                $user = app(AuthService::class)->getUserInfo();
                if ($user) {
                    Session::put('user_info', $user);
                }
            }
            return in_array($permission, $user['permissions'] ?? []);
        });
    }
}
