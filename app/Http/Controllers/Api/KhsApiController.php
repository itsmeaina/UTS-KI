<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Khs;

class KhsApiController extends Controller
{
    public function index()
    {
        return response()->json(Khs::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required',
            'course_id' => 'required',
            'nilai' => 'required|numeric',
        ]);

        $khs = Khs::create($validated);

        return response()->json([
            'message' => 'Data berhasil ditambahkan.',
            'data' => $khs
        ], 201);
    }
}
