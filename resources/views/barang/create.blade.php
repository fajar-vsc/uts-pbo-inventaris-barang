@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')
<div class="kartu">
    <h2>Tambah Barang</h2>

    <form method="POST" action="{{ route('barang.store') }}">
        @csrf
        @include('barang._form')

        <p style="margin-top:18px">
            <button type="submit" class="btn btn-hijau">Simpan</button>
            <a href="{{ route('barang.index') }}" class="btn btn-abu">Batal</a>
        </p>
    </form>
</div>
@endsection