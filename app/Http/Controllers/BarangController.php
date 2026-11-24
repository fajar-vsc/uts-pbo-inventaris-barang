<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangController extends Controller
{
    /** Kunci penyimpanan data di session. */
    private const SESSION_KEY = 'inventaris_barang';

    /** Pilihan kondisi barang. */
    private const DAFTAR_KONDISI = ['Baik', 'Rusak ringan', 'Rusak berat'];

    /**
     * Menampilkan daftar barang dari session.
     */
    public function index(Request $request): View
    {
        $daftarBarang = $this->semuaBarang();

        // Fitur pencarian sederhana berdasarkan kode / nama / kategori / lokasi
        $kataKunci = trim((string) $request->query('q', ''));
        if ($kataKunci !== '') {
            $daftarBarang = array_filter($daftarBarang, function ($barang) use ($kataKunci) {
                $teks = $barang['kode'] . ' ' . $barang['nama'] . ' ' . $barang['kategori'] . ' ' . $barang['lokasi'];
                return stripos($teks, $kataKunci) !== false;
            });
        }

        ksort($daftarBarang);

        return view('barang.index', [
            'daftarBarang' => array_values($daftarBarang),
            'kataKunci'    => $kataKunci,
        ]);
    }

    /**
     * Menampilkan form tambah barang.
     */
    public function create(): View
    {
        return view('barang.create', [
            'daftarKondisi' => self::DAFTAR_KONDISI,
        ]);
    }

    /**
     * Menyimpan barang baru ke session.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->aturan(true), $this->pesan());

        $semua = $this->semuaBarang();

        // Kode barang harus unik
        if (isset($semua[$data['kode']])) {
            return back()
                ->withInput()
                ->withErrors(['kode' => 'Kode barang sudah dipakai, gunakan kode lain.']);
        }

        $sekarang = now()->format('d-m-Y H:i');
        $semua[$data['kode']] = [
            'kode'       => $data['kode'],
            'nama'       => $data['nama'],
            'kategori'   => $data['kategori'],
            'lokasi'     => $data['lokasi'],
            'jumlah'     => (int) $data['jumlah'],
            'kondisi'    => $data['kondisi'],
            'keterangan' => $data['keterangan'] ?? '',
            'dibuat'     => $sekarang,
            'diubah'     => $sekarang,
        ];

        $this->simpan($semua);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang "' . $data['nama'] . '" berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu barang berdasarkan kode.
     */
    public function show(string $kode): View|RedirectResponse
    {
        $barang = $this->cariBarang($kode);

        if ($barang === null) {
            return $this->tidakDitemukan($kode);
        }

        return view('barang.show', ['barang' => $barang]);
    }

    /**
     * Menampilkan form edit barang.
     */
    public function edit(string $kode): View|RedirectResponse
    {
        $barang = $this->cariBarang($kode);

        if ($barang === null) {
            return $this->tidakDitemukan($kode);
        }

        return view('barang.edit', [
            'barang'        => $barang,
            'daftarKondisi' => self::DAFTAR_KONDISI,
        ]);
    }

    /**
     * Memperbarui data barang di session.
     */
    public function update(Request $request, string $kode): RedirectResponse
    {
        $barang = $this->cariBarang($kode);

        if ($barang === null) {
            return $this->tidakDitemukan($kode);
        }

        // Kode tidak diubah, jadi tidak divalidasi ulang
        $data = $request->validate($this->aturan(false), $this->pesan());

        $semua = $this->semuaBarang();
        $semua[$kode] = array_merge($barang, [
            'nama'       => $data['nama'],
            'kategori'   => $data['kategori'],
            'lokasi'     => $data['lokasi'],
            'jumlah'     => (int) $data['jumlah'],
            'kondisi'    => $data['kondisi'],
            'keterangan' => $data['keterangan'] ?? '',
            'diubah'     => now()->format('d-m-Y H:i'),
        ]);

        $this->simpan($semua);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang dengan kode ' . $kode . ' berhasil diperbarui.');
    }

    /**
     * Menghapus barang dari session.
     */
    public function destroy(string $kode): RedirectResponse
    {
        $barang = $this->cariBarang($kode);

        if ($barang === null) {
            return $this->tidakDitemukan($kode);
        }

        $semua = $this->semuaBarang();
        unset($semua[$kode]);
        $this->simpan($semua);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang "' . $barang['nama'] . '" berhasil dihapus.');
    }

    // ---------------------------------------------------------------
    // Helper / Fungsi Bantu
    // ---------------------------------------------------------------

    /** Ambil semua data barang dari session. */
    private function semuaBarang(): array
    {
        return session(self::SESSION_KEY, []);
    }

    /** Simpan seluruh barang ke session. */
    private function simpan(array $semua): void
    {
        session([self::SESSION_KEY => $semua]);
    }

    /** Cari satu barang berdasarkan kodenya. */
    private function cariBarang(string $kode): ?array
    {
        return $this->semuaBarang()[$kode] ?? null;
    }

    /** Respons saat barang tidak ditemukan. */
    private function tidakDitemukan(string $kode): RedirectResponse
    {
        return redirect()
            ->route('barang.index')
            ->with('error', 'Barang dengan kode "' . $kode . '" tidak ditemukan.');
    }

    /** Aturan validasi input form. */
    private function aturan(bool $denganKode): array
    {
        $aturan = [
            'nama'       => ['required', 'string', 'max:100'],
            'kategori'   => ['required', 'string', 'max:50'],
            'lokasi'     => ['required', 'string', 'max:100'],
            'jumlah'     => ['required', 'integer', 'min:0', 'max:100000'],
            'kondisi'    => ['required', 'in:' . implode(',', self::DAFTAR_KONDISI)],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ];

        if ($denganKode) {
            $aturan['kode'] = ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9_-]+$/'];
        }

        return $aturan;
    }

    /** Pesan error validasi berbahasa Indonesia. */
    private function pesan(): array
    {
        return [
            'required'   => 'Kolom :attribute wajib diisi.',
            'integer'    => 'Kolom :attribute harus berupa angka.',
            'min'        => 'Kolom :attribute tidak boleh kurang dari :min.',
            'max'        => 'Kolom :attribute maksimal :max karakter.',
            'in'         => 'Pilihan :attribute tidak valid.',
            'kode.regex' => 'Kode hanya boleh berupa huruf, angka, minus (-), dan garis bawah (_).',
        ];
    }
}