@php $editing = isset($barang); @endphp

<label for="kode">Kode Barang</label>
<input type="text" id="kode" name="kode" value="{{ old('kode', $barang['kode'] ?? '') }}"
       placeholder="Contoh: BRG-001" {{ $editing ? 'readonly' : 'required' }}>
@error('kode') <div class="error">{{ $message }}</div> @enderror

<label for="nama">Nama Barang</label>
<input type="text" id="nama" name="nama" value="{{ old('nama', $barang['nama'] ?? '') }}" required>
@error('nama') <div class="error">{{ $message }}</div> @enderror

<label for="kategori">Kategori</label>
<input type="text" id="kategori" name="kategori" value="{{ old('kategori', $barang['kategori'] ?? '') }}"
       placeholder="Contoh: Elektronik" required>
@error('kategori') <div class="error">{{ $message }}</div> @enderror

<label for="lokasi">Lokasi</label>
<input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $barang['lokasi'] ?? '') }}"
       placeholder="Contoh: Lab 2" required>
@error('lokasi') <div class="error">{{ $message }}</div> @enderror

<label for="jumlah">Jumlah</label>
<input type="number" id="jumlah" name="jumlah" min="0" value="{{ old('jumlah', $barang['jumlah'] ?? '') }}" required>
@error('jumlah') <div class="error">{{ $message }}</div> @enderror

<label for="kondisi">Kondisi</label>
<select id="kondisi" name="kondisi" required>
    <option value="">-- Pilih kondisi --</option>
    @foreach ($daftarKondisi as $kondisi)
        <option value="{{ $kondisi }}" {{ old('kondisi', $barang['kondisi'] ?? '') === $kondisi ? 'selected' : '' }}>
            {{ $kondisi }}
        </option>
    @endforeach
</select>
@error('kondisi') <div class="error">{{ $message }}</div> @enderror

<label for="keterangan">Keterangan (opsional)</label>
<textarea id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $barang['keterangan'] ?? '') }}</textarea>
@error('keterangan') <div class="error">{{ $message }}</div> @enderror