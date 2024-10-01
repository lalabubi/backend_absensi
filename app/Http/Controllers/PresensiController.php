<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function presensi()
    {
        $siswa_id = Auth::user()->siswa_id;
        $tanggal = Carbon::now()->format('d-m-Y');
        $currentTime = Carbon::now('Asia/Jakarta');

        // Mengonversi tanggal ke format Y-m-d untuk disimpan ke database
        $tanggalFormatted = Carbon::createFromFormat('d-m-Y', $tanggal)->format('Y-m-d');

        // Cek apakah siswa sudah absen pada hari itu
        $absen = Presensi::where('siswa_id', $siswa_id)
            ->where('tanggal', $tanggalFormatted)
            ->first();

        if ($absen) {
        // Jika sudah absen dan ingin absen pulang
            if ($absen->waktu_datang !== null) {
                if ($absen->waktu_pulang) {
                    return response()->json(['message' => 'Anda sudah absen pulang hari ini.'], 422);
                } else {
                    // Cek jika waktu sekarang sudah waktunya pulang
                    $waktu_pulang = Carbon::parse('15:00:00', 'Asia/Jakarta'); // contoh waktu pulang jam 16:00
                    if ($currentTime->greaterThanOrEqualTo($waktu_pulang)) {
                        $absen->update(['waktu_pulang' => $currentTime]);
                        return response()->json(['message' => 'Berhasil Absen Pulang', 'data' => $absen], 201);
                    } else {
                        return response()->json(['message' => 'Belum waktunya pulang.'], 422);
                    }
                }
            } else {
                return response()->json(['message' => 'Anda sudah absen datang hari ini.'], 422);
            }
        } else {
            // Tentukan tenggat waktu untuk absen datang
            $batasWaktu = Carbon::parse('07:00:00', 'Asia/Jakarta');

            // Tentukan keterangan default
            $keterangan = 'hadir';

            // Cek apakah siswa terlambat
            if ($currentTime->greaterThanOrEqualTo($batasWaktu)) {
                $keterangan = 'telat';
            }

            // Jika belum absen, buat data absen baru
            $absen = Presensi::create([
                'siswa_id' => $siswa_id,
                'tanggal' => $tanggalFormatted,
                'keterangan' => $keterangan,
                'waktu_datang' => $currentTime,
            ]);

            return response()->json(['message' => 'Berhasil Absen Datang', 'data' => $absen], 200);
        }
    }
}
