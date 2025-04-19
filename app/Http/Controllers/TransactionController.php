<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use App\Services\TransactionTypeService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $service;
    protected $transactionService;

    public function __construct(TransactionTypeService $service, TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
        $this->service = $service;
    }

    public function tambah(Request $request)
    {
        $token = $request->session()->get('token');
        $transactionTypes = $this->service->all($token);
        return view('frontend.transaksi.create', compact('transactionTypes'));
    }

    public function index(Request $request)
    {
        $token = $request->session()->get('token');
        $transactions = $this->transactionService->getAllTransactions($token);
        return view('frontend.transaksi.index', compact('transactions'));
    }

    public function form(Request $request)
    {
        $token = $request->session()->get('token');
        $daftarBarang = $request->session()->get('daftar_barang', []);
        $transactionTypes = $this->service->all($token);
        return view('frontend.transaksi.barcode-check', compact('daftarBarang', 'transactionTypes'));
    }

    public function check(Request $request)
    {
        $kode = $request->kode;
        $token = $request->session()->get('token');

        $barang = $this->transactionService->checkAndAddBarang($kode, $token, $request->session());

        if ($barang) {
            $daftarBarang = $request->session()->get('daftar_barang', []);
            return response()->json([
                'success' => true,
                'html' => view('frontend.transaksi.table', compact('daftarBarang'))->render(),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Barang tidak ditemukan.']);
    }

    public function reset(Request $request)
    {
        $request->session()->forget('daftar_barang');
        return redirect()->back();
    }

    public function remove(Request $request)
    {
        $kode = $request->input('kode');
        $daftarBarang = session()->get('daftar_barang', []);

        if (isset($daftarBarang[$kode])) {
            unset($daftarBarang[$kode]);
            session()->put('daftar_barang', $daftarBarang);

            return response()->json(['success' => true, 'message' => 'Barang berhasil dihapus.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Barang tidak ditemukan.']);
        }
    }



    public function store(Request $request)
{
    $token = $request->session()->get('token');
    $tipe = $request->input('tipe');
    $daftarBarang = $request->session()->get('daftar_barang', []);

    if (empty($daftarBarang)) {
        return redirect()->back()->with('error', 'Tidak ada barang untuk transaksi.');
    }

    $response = $this->transactionService->storeTransaction($tipe, $daftarBarang, $token);

    if ($response->successful()) {
        $request->session()->forget('daftar_barang');
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan');
    }

    return redirect()->back()->with('error', 'Gagal menyimpan transaksi');
}
}
