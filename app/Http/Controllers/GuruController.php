<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Guru::all();
        return response()->json(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nip' => 'required',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
        ]);
        if ($validasi->fails()) {
            return response()->json(['message' => 'Invalid field', 'errors' => $validasi->errors()], 403);
        }

         $guru = Guru::create([
            'NIP' => $request->nip,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
         ]);

         return response()->json(['message' => 'berhasil tambah data guru', 'data' => $guru], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $guru = Guru::find($id);
        if(!$guru) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        $guru->update($request->all());
        return response()->json(['message'=> 'berhasil update data','data'=> $guru], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $guru = Guru::find($id);
        if(!$guru) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        $guru->delete();
        return response()->json(['message'=> 'berhasil hapus data','data'=> $guru]);
    }
}
