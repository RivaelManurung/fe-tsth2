<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Gudang;
use App\Models\JenisBarang;
use App\Models\Satuan;
use App\Models\TransactionType;
use App\Models\User;
use App\Services\BarangCategoryService;
use App\Services\BarangService;
use App\Services\GudangService;
use App\Services\JenisBarangService;
use App\Services\RoleService;
use App\Services\SatuanService;
use App\Services\TransactionService;
use App\Services\TransactionTypeService;
use App\Services\UserService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $barang_service;
    protected $jenis_barang_service;
    protected $kategori_barang_service;
    protected $satuan_service;
    protected $user_service;
    protected $gudang_service;
    protected $transaksi_service;
    protected $role_service;
    protected $transactionType_service;

    public function __construct(
        BarangService $barang_service,
        JenisBarangService $jenis_barang_service,
        BarangCategoryService $barang_category_service,
        SatuanService $satuan_service,
        UserService $user_service,
        GudangService $gudang_service,
        TransactionService $transaksi_service,
        RoleService $role_service,
        TransactionTypeService $transactionType_service

    ) {
        $this->barang_service = $barang_service;
        $this->jenis_barang_service = $jenis_barang_service;
        $this->kategori_barang_service = $barang_category_service;
        $this->satuan_service = $satuan_service;
        $this->user_service = $user_service;
        $this->gudang_service = $gudang_service;
        $this->transaksi_service = $transaksi_service;
        $this->role_service = $role_service;
        $this->transactionType_service = $transactionType_service;
    }
    public function index()
    {
        $barangs = $this->barang_service->countBarang();
        $jenisbarangs = $this->jenis_barang_service->count();
        $satuans = $this->satuan_service->satuancount();
        $users = $this->user_service->count();
        $gudangs = $this->gudang_service->count();
        $transaksis = $this->transaksi_service->countTransaksi();
        $roles = $this->role_service->count();
        $barang_category = $this->kategori_barang_service->count();
        $transactionType = $this->transactionType_service->count();

        $token = session('token');
        $allTransactions = $this->transaksi_service->getAllTransactions($token);
        $transactionTypes = $this->transactionType_service->all($token);

        $summaryByType = [];
        foreach ($transactionTypes as $type) {
            $summaryByType[$type['name']] = [];
        }

        foreach ($allTransactions as $trx) {
            $date = substr($trx['created_at'], 0, 10); // pakai created_at
            $typeName = $trx['transaction_type']['name'] ?? 'Unknown';

            if (!isset($summaryByType[$typeName][$date])) {
                $summaryByType[$typeName][$date] = 0;
            }

            $summaryByType[$typeName][$date]++;
        }

        $allDates = collect($allTransactions)->pluck('created_at')->map(fn($d) => substr($d, 0, 10))->unique()->sort()->values();
        return view('frontend.dashboard', compact(
            'transactionType',
            'barangs',
            'barang_category',
            'jenisbarangs',
            'satuans',
            'users',
            'gudangs',
            'transaksis',
            'roles',
            'summaryByType',
            'allDates'
        ));    }

}
