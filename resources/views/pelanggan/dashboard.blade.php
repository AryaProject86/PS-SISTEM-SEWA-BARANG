@extends('layouts.frontend')

@section('content')

<h3 class="mb-4">Dashboard Pelanggan</h3>

<div class="row g-4">

<div class="col-md-4">
<div class="card card-custom shadow" style="background:#6D8B74;">
<div class="card-body">
<h6>Total Transaksi</h6>
<h2>{{ $total }}</h2>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card card-custom shadow" style="background:#D4A373;">
<div class="card-body">
<h6>Sedang Disewa</h6>
<h2>{{ $disewa }}</h2>
</div>
</div>
</div>

</div>

@endsection