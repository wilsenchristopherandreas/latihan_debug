<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use App\Models\Matakuliah;
use App\Models\Absensi;
use App\Models\Mahasiswa;

class AbsensiController extends Controller
{
    /**
     * Menampilkan daftar kehadiran mahasiswa.
     */
    public function index(Request $request)
    {
        // Mengambil seluruh mata kuliah dan mahasiswa
        $matkuls = Matakuliah::orderBy('nama_matakuliah')->get();

        $mahasiswas = Mahasiswa::orderBy('NIM')->get();

        // Menentukan tanggal dan mata kuliah yang dipilih
        $selectedTanggal = $request->input(
            'tanggal_absensi',
            now()->toDateString()
        );

        $selectedMatkulId = $request->input(
            'matakuliah_id',
            $matkuls->first()?->id
        );

        // Menyiapkan data absensi
        $absensis = collect();

        if ($selectedMatkulId && $selectedTanggal) {
            $absensis = Absensi::where('matakuliah_id', $selectedMatkulId)
                ->where('tanggal_absensi', $selectedTanggal)
                ->get()
                ->keyBy('mahasiswa_id');
        }

        return view('absensi.index', compact(
            'matkuls',
            'mahasiswas',
            'absensis',
            'selectedTanggal',
            'selectedMatkulId'
        ));
    }


    /**
     * Menampilkan form pengisian absensi.
     */
    public function create(Request $request)
    {
        // Mengambil data mata kuliah dan mahasiswa
        $matkuls = Matakuliah::orderBy('nama_matakuliah')->get();

        $mahasiswas = Mahasiswa::orderBy('NIM')->get();

        // Menentukan tanggal dan mata kuliah pilihan
        $selectedTanggal = $request->input(
            'tanggal_absensi',
            now()->toDateString()
        );

        $selectedMatkulId = $request->input(
            'matakuliah_id',
            $matkuls->first()?->id
        );

        // Mengambil absensi yang sudah tersimpan
        $absensis = collect();

        if ($selectedMatkulId && $selectedTanggal) {
            $absensis = Absensi::where('matakuliah_id', $selectedMatkulId)
                ->where('tanggal_absensi', $selectedTanggal)
                ->get()
                ->keyBy('mahasiswa_id');
        }

        return view('absensi.create', compact(
            'matkuls',
            'mahasiswas',
            'absensis',
            'selectedTanggal',
            'selectedMatkulId'
        ));
    }


    /**
     * Menyimpan atau memperbarui data absensi.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'tanggal_absensi' => 'required|date',
            'matakuliah_id' => 'required|exists:matakuliah,id',
            'status' => 'required|array|min:1',
            'status.*' => 'required|in:H,A,I,S',
        ]);

        $statuses = $validated['status'];

        // Memastikan seluruh ID mahasiswa yang dikirim valid
        $mahasiswaIds = array_keys($statuses);

        $validMahasiswaIds = Mahasiswa::whereIn('id', $mahasiswaIds)
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();

        if (count($validMahasiswaIds) !== count($mahasiswaIds)) {
            throw ValidationException::withMessages([
                'status' => 'Terdapat ID mahasiswa yang tidak valid.',
            ]);
        }

        // Menyimpan seluruh data secara aman dalam transaksi database
        DB::transaction(function () use ($validated, $statuses) {

            foreach ($statuses as $mahasiswaId => $statusAbsen) {

                Absensi::updateOrCreate(
                    [
                        'mahasiswa_id' => $mahasiswaId,
                        'matakuliah_id' => $validated['matakuliah_id'],
                        'tanggal_absensi' => $validated['tanggal_absensi'],
                    ],
                    [
                        'status_absen' => $statusAbsen,
                    ]
                );
            }
        });

        // Kembali ke halaman daftar absensi
        return redirect()
            ->route('absensi.index', [
                'tanggal_absensi' => $validated['tanggal_absensi'],
                'matakuliah_id' => $validated['matakuliah_id'],
            ])
            ->with('success', 'Data kehadiran berhasil disimpan.');
    }
}
