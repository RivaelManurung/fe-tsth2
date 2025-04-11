<?php

namespace App\Http\Controllers;

use App\Http\Resources\BarangResource;
use App\Http\Resources\JenisBarangResource;
use App\Http\Resources\SatuanResource;
use App\Services\BarangCategoryService;
use App\Services\BarangService;
use App\Services\JenisBarangService;
use App\Services\SatuanService;
use App\Services\KategoriBarangService;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    protected $barang_service;
    protected $jenis_barang_service;
    protected $kategori_barang_service;
    protected $satuan_service;
    protected $baseUrl;

    public function __construct(
        BarangService $barang_service,
        JenisBarangService $jenis_barang_service,
        BarangCategoryService $barang_category_service,
        SatuanService $satuan_service
    ) {
        $this->barang_service = $barang_service;
        $this->jenis_barang_service = $jenis_barang_service;
        $this->kategori_barang_service = $barang_category_service;
        $this->satuan_service = $satuan_service;
    }
    public function index()
    {
        try {
            $token = session('token');

            $barangs = $this->barang_service->getAllBarang();
            logger()->info('Barang Index Fetch:', $barangs);
            $jenis_barangs = JenisBarangResource::collection(collect($this->jenis_barang_service->all($token)));
            $satuans = SatuanResource::collection(collect($this->satuan_service->all($token)));
            $kategori_barangs = $this->kategori_barang_service->all($token);

            return view('frontend.barang.index', compact('barangs', 'jenis_barangs', 'kategori_barangs', 'satuans'));
        } catch (\Throwable $th) {
            return back()->with('error', 'Gagal memuat data barang: ' . $th->getMessage());
        }
    }


    public function store(Request $request)
    {
        try {
            $this->barang_service->createBarang($request->all());
            return redirect()->back()->with('success', 'Barang berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menambahkan barang: ' . $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $barang = $this->barang_service->getBarangById($id);
            return response()->json($barang);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }
    }

    // public function update(Request $request, $id)
    // {
    //     try {
    //         $this->barang_service->updateBarang($id, $request->all());
    //         return redirect()->back()->with('success', 'Barang berhasil diperbarui.');
    //     } catch (\Throwable $th) {
    //         return redirect()->back()->with('error', 'Gagal memperbarui barang: ' . $th->getMessage());
    //     }
    // }

    public function update(Request $request, $id)
    {
        try {
            // Filter input (handle jika tidak ada file gambar)
            $data = $request->except(['_token', '_method']);
            if (!$request->hasFile('barang_gambar')) {
                unset($data['barang_gambar']);
            }

            $this->barang_service->updateBarang($id, $data);
            return redirect()->back()->with('success', 'Barang berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal memperbarui barang: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->barang_service->deleteBarang($id);
            return redirect()->back()->with('success', 'Barang berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus barang: ' . $th->getMessage());
        }
    }
    public function refreshQRCodes()
    {
        try {
            $response = $this->barang_service->regenerateQRCodeAll();

            if (isset($response['success']) || isset($response['message'])) {
                return redirect()->back()->with('success', 'QR Code berhasil diperbarui.');
            } else {
                return redirect()->back()->with('error', 'Gagal memperbarui QR Code.');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }



}
