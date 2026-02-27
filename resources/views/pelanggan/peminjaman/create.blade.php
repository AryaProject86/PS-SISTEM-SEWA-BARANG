@extends('layouts.frontend')

@section('content')

<h3>Sewa Barang</h3>

<form method="POST" action="/peminjaman">
@csrf

<div class="mb-3">
<label>Barang</label>
<select name="barang_id" class="form-control">
@foreach($barang as $item)
<option value="{{ $item->id }}">
{{ $item->nama_barang }}
</option>
@endforeach
</select>
</div>

<div class="mb-3">
<label>Tanggal Sewa</label>
<input type="date" name="tanggal_sewa" class="form-control">
</div>

<div class="mb-3">
<label>Tanggal Pengembalian</label>
<input type="date" name="tanggal_pengembalian" class="form-control">
</div>

<div class="mb-3">
<label>Jaminan</label>
<input type="text" name="jaminan" class="form-control">
</div>

<button class="btn btn-dark">Sewa</button>

</form>

@endsection