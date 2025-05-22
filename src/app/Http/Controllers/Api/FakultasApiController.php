<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use Illuminate\Http\Request;

class FakultasApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_fakultas' => 'required|string|max:255',
        ]);

        $fakultas = Fakultas::create([
            'nama_fakultas' => $request->nama_fakultas,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $fakultas,
        ]);
    }

    public function index()
    {
        $data = Fakultas::all();
        return response()->json($data);
    }
}
