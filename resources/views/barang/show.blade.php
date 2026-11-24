@extends('layouts.app')

@section('title', 'Detail Barang')

@section('content')
<div class="kartu">
    <h2>Detail Barang</h2>

    <table class="detail">
        <tr><td>Kode</td><td>{{ $barang['kode'] }}</td></tr>
        <tr><td>Nama Barang</td><td>{{ $barang['nama'] }}</td></tr>
        <tr><td>Kategori</td><td>{{ $barang['kategori'] }}</td></tr>
        <tr><td>Lokasi</td><td>{{ $barang['lokasi'] }}</td></tr>
        <tr><td>Jumlah</td><td>{{ $barang['jumlah'] }}</td></tr>
        <tr><td>Kondisi</td><td>{{ $barang['kondisi'] }}</td></tr>
        <tr><td>Keterangan</td><td>{{ $barang['keterangan'] !== '' ? $barang['keterangan'] : '-' }}</td></tr>
        <tr><td>Dibuat</td><td>{{ $barang['dibuat'] }}</td></tr>
        <tr><td>Terakhir diubah</td><td>{{ $barang['diubah'] }}</td></tr>
    </table>

    <div class="aksi" style="margin-top:18px">
        <a href="{{ route('barang.index') }}" class="btn btn-abu">Kembali</a>
        <a href="{{ route('barang.edit', $barang['kode']) }}" class="btn btn-kuning">Edit</a>
        <form method="POST" action="{{ route('barang.destroy', $barang['kode']) }}"
              onsubmit="return confirm('Yakin ingin menghapus barang {{ $barang['nama'] }}?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-merah">Hapus</button>
        </form>
    </div>
</div>
@endsection