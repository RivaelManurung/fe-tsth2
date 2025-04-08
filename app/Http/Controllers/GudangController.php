<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GudangService;

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

        $gudangs = $this->service->all($token);
        return view('frontend.gudangs.index', compact('gudangs'));
    }

    public function store(Request $request)
    {
        $token = session('token');
        $this->service->create($request->only('name'), $token);
        return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {
        $token = session('token');
        $this->service->edit($id, $request->only('name'), $token);
        return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $token = session('token');
        $this->service->destroy($id, $token);
        return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil dihapus.');
    }
}
