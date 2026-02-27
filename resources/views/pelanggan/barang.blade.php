@extends('layouts.frontend')

@section('content')

<h3 class="mb-4">Koleksi Barang</h3>

<div class="row g-4">

@foreach($barang as $item)
<div class="col-md-4">

<div class="card shadow-sm rounded-4 h-100">

    {{-- Gambar --}}
    <div style="height:250px; overflow:hidden; border-top-left-radius:14px; border-top-right-radius:14px;">
        <img src="{{ asset('storage/'.$item->gambar) }}" 
             class="w-100 h-100" 
             style="object-fit:cover;">
    </div>

    <div class="card-body d-flex flex-column">

        <h5 class="fw-bold">{{ $item->nama_barang }}</h5>

        <p class="text-muted mb-1">
            Rp {{ number_format($item->harga_sewa_per_hari) }} / hari
        </p>

        <p class="text-muted">
            Stok: {{ $item->stok }}
        </p>

        <div class="mt-auto">
            <a href="/peminjaman/create" 
               class="btn btn-dark w-100 rounded-pill">
               Sewa Sekarang
            </a>
        </div>

    </div>

</div>

</div>
@endforeach

</div>

@endsection