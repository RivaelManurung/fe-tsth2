<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // if(config('app.env') === 'local') {
        //     \Illuminate\Support\Facades\URL::forceScheme('https');
        // }
        View::composer('*', function ($view) {
            $permissions = session('permissions', []);
            // dd($permissions);
            $keys = [
                'manage_permissions',
                'create_user', 'update_user', 'view_user', 'delete_user',
                'create_role', 'update_role', 'view_role', 'delete_role',
                'create_barang', 'update_barang', 'view_barang', 'delete_barang',
                'create_gudang', 'update_gudang', 'view_gudang', 'delete_gudang',
                'create_satuan', 'update_satuan', 'view_satuan', 'delete_satuan',
                'create_jenis_barang', 'update_jenis_barang', 'view_jenis_barang', 'delete_jenis_barang',
                'create_transaction_type', 'update_transaction_type', 'view_transaction_type', 'delete_transaction_type',
                'create_transaction', 'view_transaction',
                'create_category_barang', 'update_category_barang', 'view_category_barang', 'delete_category_barang',
            ];

            $flags = generatePermissionsFlags($permissions, $keys);
            $view->with($flags);
        });

        Blade::if('can', function ($permission) {
            $permissions = session('permissions', []);
            return in_array($permission, $permissions);
        });
    }
}
