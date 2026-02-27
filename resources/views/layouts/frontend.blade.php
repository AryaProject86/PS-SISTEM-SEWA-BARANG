<!DOCTYPE html>
<html>
<head>
<title>Sistem Sewa Barang</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background-color:#F5E6D3;
    margin:0;
    font-family:'Segoe UI', sans-serif;
}

/* ===== TOPBAR FULL ===== */
.topbar{
    position:fixed;
    top:0;
    left:0;
    right:0;
    height:70px;
    background:#D4A373;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 30px;
    color:white;
    z-index:1000;
}

/* ===== SIDEBAR ===== */
.sidebar{
    width:240px;
    height:100vh;
    position:fixed;
    top:70px;
    left:0;
    background:#4E342E;
    padding-top:30px;
}

.sidebar a{
    color:white;
    display:block;
    padding:14px 25px;
    text-decoration:none;
    transition:0.3s;
}

/* hover coklat lebih gelap */
.sidebar a:hover{
    background:#5D4037;
}

/* ACTIVE TANPA HIJAU */
.sidebar a.active{
    background:#6D4C41;
    border-left:5px solid #D4A373;
    padding-left:20px;
}

/* ===== CONTENT ===== */
.content{
    margin-left:240px;
    margin-top:70px;
    min-height:100vh;
}

.page-content{
    padding:30px;
}

.card-custom{
    border:none;
    border-radius:12px;
}
</style>
</head>

<body>

<!-- NAVBAR ATAS -->
<div class="topbar">
    <div style="font-weight:600; font-size:20px;">
        SEWA BARANG
    </div>

    <div class="d-flex align-items-center gap-3">
        <span>Halo, {{ auth()->user()->name }}</span>

        <form action="/logout" method="POST" class="m-0">
            @csrf
            <button class="btn btn-sm btn-light">Logout</button>
        </form>
    </div>
</div>

<!-- SIDEBAR -->
<div class="sidebar">

    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
    <a href="/barang" class="{{ request()->is('barang') ? 'active' : '' }}">Barang</a>
    <a href="/peminjaman" class="{{ request()->is('peminjaman') ? 'active' : '' }}">Transaksi Sewa</a>
    <a href="/pengembalian" class="{{ request()->is('pengembalian') ? 'active' : '' }}">Pengembalian</a>

</div>

<!-- CONTENT -->
<div class="content">
    <div class="page-content">
        @yield('content')
    </div>
</div>

</body>
</html>