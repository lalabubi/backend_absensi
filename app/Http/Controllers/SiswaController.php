<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa=Siswa::all();
        return response()->json(['data' => $siswa]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nisn' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'kelas' => 'required',       
        ]);
        if ($validasi->fails()) {
            return response()->json(['message' => 'Invalid field', 'errors' => $validasi->errors()]);
        }
        $siswa = Siswa::create([
            'nisn' => $request->nisn,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'kelas' => $request->kelas       
            ]);
            return response()->json(['data' => $siswa]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $siswa = Siswa::find($id);
        if (!$siswa) return response()->json(['message'  => "Siswa tidak ditemukan"], 404);
        return response()->json(['data' => $siswa], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id);
        if (!$siswa) return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        $siswa->update($request->all());
        return response()->json(['message' => 'Berhasil update data siswa'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $siswa = Siswa::find($id);
        if (!$siswa) return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
        $siswa->delete();
        return response()->json(['message' => 'Data siswa berhasil dihapus'], 200);
    }
}
