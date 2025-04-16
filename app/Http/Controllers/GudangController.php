<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GudangService;
use Exception;

class GudangController extends Controller
{
    protected $service;

    public function __construct(GudangService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $token = session('token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        try {
            $gudangs = $this->service->all($token);
            $operators = $this->service->getOperators($token);

            return view('frontend.gudangs.index', compact('gudangs', 'operators'));
        } catch (Exception $e) {
            return redirect()->route('gudangs.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    // public function store(Request $request)
    // {
    //     $token = session('token');

    //     if (!$token) {
    //         return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    //     }

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'user_id' => 'required|exists:users,id',
    //     ]);

    //     try {
    //         $data = $request->only(['name', 'description', 'user_id']);
    //         $this->service->create($data, $token);

    //         return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil ditambahkan.');
    //     } catch (\Exception $e) {
    //         // Cek apakah error berkaitan dengan user_id yang sudah di-assign ke gudang lain
    //         if (strpos($e->getMessage(), 'User ini sudah diassign ke gudang lain.') !== false) {
    //             return back()->withErrors([
    //                 'user_id' => 'User ini sudah diassign ke gudang lain.'
    //             ]);
    //         }

    //         return redirect()->route('gudangs.index')
    //             ->withErrors($e->getMessage()); // Ensure errors are passed correctly

    //     }
    // }


    public function store(Request $request)
    {
        $token = session('token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            // Menyimpan data gudang menggunakan service
            $data = $request->only('name', 'description', 'user_id');
            $this->service->create($data, $token);

            return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Menangkap dan menampilkan error yang lebih spesifik
            $errorMessage = $e->getMessage();  // Mendapatkan pesan error dari API

            // Parsing JSON error message jika ada
            $errorData = json_decode($errorMessage, true);
            if ($errorData && isset($errorData['user_id'])) {
                // Menampilkan error spesifik untuk user_id
                return back()->withErrors([
                    'user_id' => $errorData['user_id'][0] ?? 'Terjadi kesalahan. Coba lagi.'
                ]);
            }

            // Jika tidak ada error terkait user_id, tampilkan error umum
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $errorMessage]);
        }
    }


    public function update(Request $request, $id)
    {
        $token = session('token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id', // Pastikan user_id valid
        ]);

        try {
            // Mengambil data request dan mengirim ke service
            $data = $request->only('name', 'description', 'user_id');

            // Mengirim data ke service untuk update
            $this->service->edit($id, $data, $token);

            // Redirect dengan pesan sukses
            return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil diperbarui.');
        } catch (Exception $e) {
            // Tangani error dan kembalikan pesan error
            return redirect()->route('gudangs.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $token = session('token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        try {
            $this->service->destroy($id, $token);
            return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('gudangs.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
