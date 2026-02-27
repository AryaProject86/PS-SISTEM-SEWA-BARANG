@extends('layouts.frontend')

@section('content')

<h3 class="mb-4">Transaksi Saya</h3>

<a href="/peminjaman/create" class="btn btn-dark mb-3 rounded">
    + Sewa Barang
</a>

<div class="card shadow-sm rounded-4">
<div class="card-body">

<table class="table align-middle">
<thead style="background:#D4A373; color:white;">
<tr>
<th>Barang</th>
<th>Tgl Sewa</th>
<th>Tgl Kembali</th>
<th>Total</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
@forelse($data as $d)

<tr>

<td>
    <div class="d-flex align-items-center">
        <img src="{{ asset('storage/'.$d->barang->gambar) }}"
             width="60"
             height="60"
             style="object-fit:cover; border-radius:8px; margin-right:10px;">
        {{ $d->barang->nama_barang }}
    </div>
</td>

<td>{{ \Carbon\Carbon::parse($d->tanggal_sewa)->format('d M Y') }}</td>

<td>
{{ $d->tanggal_kembali 
    ? \Carbon\Carbon::parse($d->tanggal_kembali)->format('d M Y') 
    : '-' }}
</td>

<td>
Rp {{ number_format($d->total_biaya) }}
</td>

<td>
@if($d->status == 'disewa')
    @if(\Carbon\Carbon::now()->gt($d->tanggal_kembali))
        <span class="badge bg-danger">Terlambat</span>
    @else
        <span class="badge bg-warning text-dark">Disewa</span>
    @endif
@else
    <span class="badge bg-success">Dikembalikan</span>
@endif
</td>

<td>

{{-- Jika masih disewa --}}
@if($d->status == 'disewa')

<form action="/pengembalian/{{ $d->id }}" method="POST" class="d-inline">
@csrf
<button class="btn btn-sm btn-warning rounded">
Ajukan Pengembalian
</button>
</form>

@endif

{{-- Lihat kuitansi --}}
<a href="/kuitansi/{{ $d->id }}" 
   class="btn btn-sm btn-primary rounded">
Kuitansi
</a>

</td>

</tr>

@empty
<tr>
<td colspan="6" class="text-center text-muted">
Belum ada transaksi.
</td>
</tr>
@endforelse

</tbody>
</table>

</div>
</div>

@endsection