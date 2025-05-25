<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DosenCourse;

class  DosenCourseApiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required',
            'course_id' => 'required',
            'jurusan_id' => 'required',
            'thn_akademik' => 'required',
            'semester' => 'required',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'ruang' => 'required',
        ]);

        DosenCourse::updateOrInsert([
            'nip' => $validated['nip'],
            'thn_akademik' => $validated['thn_akademik'],
            'semester' => $validated['semester'],
            'tanggal' => $validated['tanggal'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'ruang' => $validated['ruang'],
        ], [
            'course_id' => $validated['course_id'],
            'jurusan_id' => $validated['jurusan_id'],
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        return redirect()->route('dosen-course.index')->with('success', 'Data berhasil disimpan (insert/update).');
    }

    public function create()
    {
        return view('dosen_courses.create'); 
    }

}