@extends('layouts.frontend')

@section('content')

<h3>Pengembalian Barang</h3>

<table class="table">
<tr>
<th>Barang</th>
<th>Aksi</th>
</tr>

@foreach($data as $d)
<tr>
<td>{{ $d->barang->nama_barang }}</td>
<td>
<form method="POST" action="/pengembalian/{{ $d->id }}">
@csrf
<button class="btn btn-danger btn-sm">Kembalikan</button>
</form>
</td>
</tr>
@endforeach

</table>

@endsection