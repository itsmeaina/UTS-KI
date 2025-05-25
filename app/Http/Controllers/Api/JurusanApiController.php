<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;

class JurusanApiController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::with('fakultas')->get();
        return view('jurusan.index', compact('jurusan'));
    }

}
