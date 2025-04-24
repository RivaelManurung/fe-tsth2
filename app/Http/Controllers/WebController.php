<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\WebResource;
use App\Services\WebService;
use Illuminate\Http\Request;

class WebController extends Controller
{
    protected $webService;

    public function __construct(WebService $webService)
    {
        $this->webService = $webService;
    }

    public function index(Request $request)
    {
        $token = $request->bearerToken();
        // dd($token);
        $webs = $this->webService->getAll($token);
        // dd($webs);
        return view('frontend.web.index',compact('webs'));
    }

    public function update(Request $request, $id)
    {
        $token = $request->bearerToken();
        $data = $request->only(['web_nama', 'web_logo', 'web_deskripsi']);
        $updated = $this->webService->update($token, $id, $data);

        return response()->gitjson([
            'message' => 'Data berhasil diperbarui.',
            'data' => new WebResource((object) $updated)
        ]);
    }
}
