<?php

namespace App\Http\Controllers;

use App\Services\BarangService;
use App\Services\SatuanService;
use App\Services\TransactionService;
use App\Services\TransactionTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    protected $service;
    protected $barang_service;
    protected $transactionService;
    protected $satuanService;

    public function __construct(
        BarangService $barang_service,
        TransactionTypeService $service,
        TransactionService $transactionService,
        SatuanService $satuanService
    ) {
        $this->transactionService = $transactionService;
        $this->service = $service;
        $this->barang_service = $barang_service;
        $this->satuanService = $satuanService;
    }

    public function index(Request $request)
    {
        $token = session('token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $transactions = $this->transactionService->getAllTransactions($token);
        $transactionTypes = $this->service->all($token);
        $satuanList = $this->satuanService->all($token);

        return view('frontend.transaksi.index', compact('transactions', 'transactionTypes', 'satuanList'));
    }

    public function create(Request $request)
    {
        $token = session('token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $transactionTypes = $this->service->all($token);
        $satuanList = $this->satuanService->all($token);

        return view('frontend.transaksi.create', compact('transactionTypes', 'satuanList'));
    }

    public function store(Request $request)
    {
        $token = session('token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        try {
            $validated = $request->validate([
                'transaction_type_id' => 'required|integer|exists:transaction_types,id',
                'description' => 'nullable|string|max:255',
                'items' => 'required|array|min:1',
                'items.*.kode' => 'required|string',
                'items.*.jumlah' => 'required|integer|min:1',
                'items.*.description' => 'nullable|string|max:500',
                'items.*.nama' => 'nullable|string|max:255',
                'items.*.satuan_id' => 'required|integer|exists:satuan,id',
            ]);

            $response = $this->transactionService->store($validated, $token);

            if (!$response['success']) {
                throw new \Exception($response['message']);
            }

            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dibuat.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for transaction store', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Failed to store transaction', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $token = session('token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $result = $this->transactionService->find($id, $token);

        if (!$result['success']) {
            return redirect()->route('transactions.index')->with('error', $result['message']);
        }

        $transaction = $result['data'];
        return view('frontend.transaksi.show', compact('transaction'));
    }

    public function edit($id)
    {
        $token = session('token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $result = $this->transactionService->find($id, $token);

        if (!$result['success']) {
            return redirect()->route('transactions.index')->with('error', $result['message']);
        }

        $transactions = $this->transactionService->getAllTransactions($token);
        $transactionTypes = $this->service->all($token);
        $satuanList = $this->satuanService->all($token);

        return view('frontend.transaksi.index', compact('transactions', 'transactionTypes', 'satuanList'));
    }

    public function update(Request $request, $id)
    {
        $token = session('token');
        if (!$token) {
            Log::error('No token found in session');
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        try {
            Log::info('Transaction update attempt', [
                'transaction_id' => $id,
                'request_data' => $request->all()
            ]);

            $validated = $request->validate([
                'transaction_type_id' => 'required|integer|exists:transaction_types,id',
                'transaction_date' => 'required|date',
                'description' => 'nullable|string|max:255',
                'user_id' => 'required|integer|exists:users,id',
                'items' => 'required|array|min:1',
                'items.*.kode' => 'required|string',
                'items.*.jumlah' => 'required|integer|min:1',
                'items.*.nama' => 'nullable|string|max:255',
                'items.*.satuan_id' => 'required|integer|exists:satuans,id',
                'items.*.description' => 'nullable|string|max:500',
            ]);

            $response = $this->transactionService->update($id, $validated, $token);

            if (!$response['success']) {
                Log::error('Transaction update failed', ['message' => $response['message']]);
                return redirect()->back()->with('error', $response['message'])->withInput();
            }

            Log::info('Transaction updated successfully', ['transaction_id' => $id]);
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for transaction update', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Transaction update failed', [
                'transaction_id' => $id,
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage())->withInput();
        }
    }

    // Commented out unused methods
    /*
    public function addItem(Request $request, $id)
    {
        // ... (previous addItem code)
    }

    public function removeItem(Request $request, $id)
    {
        // ... (previous removeItem code)
    }

    public function resetItems(Request $request, $id)
    {
        // ... (previous resetItems code)
    }
    */

    public function searchBarang(Request $request)
    {
        $token = session('token');
        if (!$token) {
            return response()->json(['error' => 'Silakan login terlebih dahulu.'], 401);
        }

        $keyword = $request->get('keyword');
        $barangs = $this->barang_service->getAllBarang($token);

        $filteredBarang = collect($barangs)->filter(function ($barang) use ($keyword) {
            return str_contains(strtolower($barang['barang_kode'] ?? ''), strtolower($keyword)) ||
                str_contains(strtolower($barang['barang_nama'] ?? ''), strtolower($keyword));
        });

        return response()->json($filteredBarang->values());
    }
}