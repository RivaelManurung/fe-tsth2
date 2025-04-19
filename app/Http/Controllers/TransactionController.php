<?php

namespace App\Http\Controllers;

use App\Services\TransactionService as ServicesTransactionService;
use App\Services\TransactionTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    protected $service;
    protected $transactionService;

    public function __construct(TransactionTypeService $service, ServicesTransactionService $transactionService)
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
        $transactions = $this->transactionService->getAllTransactions($token); // Gunakan $this->transactionService

        return view('frontend.transaksi.index', compact('transactions'));
    }

    public function checkBarcode(Request $request, $kode)
    {
        $token = $request->session()->get('token');
        $response = $this->transactionService->checkBarcode($token, $kode);

        // teruskan status & body persis dari BE
        return response($response->body(), $response->status())
               ->header('Content-Type', 'application/json');
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
        $response = Http::withToken($token)
            ->get("http://127.0.0.1:8090/api/transactions/check-barcode/" . $kode);

        if ($response->successful() && $response->json('success')) {
            $barang = $response->json('data');
            $daftarBarang = $request->session()->get('daftar_barang', []);

            // Tambahkan stok_tersedia dan gambar ke data barang
            $barang['stok_tersedia'] = $barang['stok_tersedia'];
            $barang['gambar'] = $barang['gambar'];

            if (isset($daftarBarang[$barang['barang_kode']])) {
                $daftarBarang[$barang['barang_kode']]['jumlah'] += 1;
            } else {
                $daftarBarang[$barang['barang_kode']] = [
                    'nama' => $barang['barang_nama'],
                    'kode' => $barang['barang_kode'],
                    'jumlah' => 1,
                    'stok_tersedia' => $barang['stok_tersedia'],
                    'gambar' => $barang['gambar'],
                ];
            }

            $request->session()->put('daftar_barang', $daftarBarang);

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

        // Hapus barang dari sesi atau database
        $daftarBarang = session()->get('daftar_barang', []);

        if (isset($daftarBarang[$kode])) {
            unset($daftarBarang[$kode]);
            session()->put('daftar_barang', $daftarBarang);

            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan.'
            ]);
        }
    }



}
