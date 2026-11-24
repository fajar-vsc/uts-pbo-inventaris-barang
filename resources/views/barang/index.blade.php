@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('content')
<div class="kartu">
    <h2>Daftar Barang</h2>

    <div class="baris-atas">
        <a href="{{ route('barang.create') }}" class="btn btn-hijau">+ Tambah Barang</a>

        <form method="GET" action="{{ route('barang.index') }}" class="cari">
            <input type="text" name="q" value="{{ $kataKunci }}" placeholder="Cari kode, nama, kategori, lokasi">
            <button type="submit" class="btn btn-biru">Cari</button>
            @if ($kataKunci !== '')
                <a href="{{ route('barang.index') }}" class="btn btn-abu">Reset</a>
            @endif
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Jumlah</th>
                <th>Kondisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($daftarBarang as $barang)
                <tr>
                    <td>{{ $barang['kode'] }}</td>
                    <td>{{ $barang['nama'] }}</td>
                    <td>{{ $barang['kategori'] }}</td>
                    <td>{{ $barang['lokasi'] }}</td>
                    <td>{{ $barang['jumlah'] }}</td>
                    <td>
                        @php
                            $kelas = match ($barang['kondisi']) {
                                'Baik' => 'badge-baik',
                                'Rusak ringan' => 'badge-ringan',
                                default => 'badge-berat',
                            };
                        @endphp
                        <span class="badge {{ $kelas }}">{{ $barang['kondisi'] }}</span>
                    </td>
                    <td>
                        <div class="aksi">
                            <a href="{{ route('barang.show', $barang['kode']) }}" class="btn btn-biru">Detail</a>
                            <a href="{{ route('barang.edit', $barang['kode']) }}" class="btn btn-kuning">Edit</a>
                            <form method="POST" action="{{ route('barang.destroy', $barang['kode']) }}"
                                  onsubmit="return confirm('Yakin ingin menghapus barang {{ $barang['nama'] }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-merah">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="kosong">
                        @if ($kataKunci !== '')
                            Tidak ada barang yang cocok dengan pencarian "{{ $kataKunci }}".
                        @else
                            Belum ada data barang. Silakan tambah barang terlebih dahulu.
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection