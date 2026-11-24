@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="kartu">
    <h2>Edit Barang: {{ $barang['kode'] }}</h2>

    <form method="POST" action="{{ route('barang.update', $barang['kode']) }}">
        @csrf
        @method('PUT')
        @include('barang._form')

        <p style="margin-top:18px">
            <button type="submit" class="btn btn-kuning">Perbarui</button>
            <a href="{{ route('barang.index') }}" class="btn btn-abu">Batal</a>
        </p>
    </form>
</div>
@endsection