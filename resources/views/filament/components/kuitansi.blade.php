<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kwitansi Sewa Barang</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            padding: 25px 40px;
            border: 1px solid black;
            max-width: 600px;
            margin: 30px auto;
        }

        .header, .footer {
            text-align: center;
        }
        .header h2 {
            color: #007bff;
            text-transform: uppercase;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .info {
            margin: 20px 0;
        }
        .info-table td {
            padding: 5px 10px;
            vertical-align: top;
        }
        .bold {
            font-weight: bold;
        }
        .section-title {
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .dashed {
            border-bottom: 1px dotted #000;
            display: inline-block;
            width: 100%;
            height: 18px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature p {
            border-top: 1px solid black;
            display: inline-block;
            padding-top: 5px;
            margin: 1;
        }
        .admin-name {
            font-weight: bold;
            margin-top: 5px;
        }
        .footer small {
            display: inline-block;
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
        }
        </style>
</head>
<body>
    <div class="header">
        <h2>KWITANSI PENYEWAAN BARANG</h2>
    </div>

    <table class="info-table" width="100%">
        <tr>
            <td class="bold">Nama Perusahaan :</td>
            <td>NS ADVENTURE</td>
            <td class="bold">Nomor Kuitansi :</td>
            <td>KWT-{{ $record->id }}</td>
        </tr>
        <tr>
            <td class="bold">Alamat :</td>
            <td>Jl. Raya maja koleang no 09</td>
            <td class="bold">Tanggal :</td>
            <td>{{ date('d-m-Y') }}</td>
        </tr>
    </table>

    <div class="section-title">CASH RECEIPT</div>

    <table class="info-table" width="100%">
        <tr>
            <td class="bold">Diterima dari :</td>
            <td class="dashed">{{ $record->pelanggan->name ?? '-' }}</td>
        </tr>
        <tr>
    <td class="bold">Senilai :</td>
    <td class="dashed">Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
</tr>
<tr>
    <td class="bold">Denda (Jika Ada) :</td>
    <td class="dashed">Rp {{ number_format($record->denda ?? 0, 0, ',', '.') }}</td>
</tr>
<tr>
    <td class="bold">Total Bayar :</td>
    <td class="dashed"><strong>Rp {{ number_format(($totalBayar ?? 0) + ($record->denda ?? 0), 0, ',', '.') }}</strong></td>
</tr>
<tr>
    <td class="bold">Jaminan :</td>
    <td class="dashed">{{ $record->jaminan ?? '-' }}</td>
</tr>

        <tr>
            <td class="bold" valign="top">Tujuan Pembayaran :</td>
            <td>
                <div class="dashed">Sewa {{ $record->barang->nama_barang }}</div>
                <div class="dashed">Dari {{ \Carbon\Carbon::parse($record->tanggal_sewa)->format('d-m-Y') }}
                                    sampai {{ \Carbon\Carbon::parse($record->tanggal_kembali)->format('d-m-Y') }}</div>
            </td>
        </tr>
        <tr>
    <td class="bold">Metode Pembayaran :</td>
    <td class="dashed">
        {{ strtoupper($record->metode_pembayaran) }}
    </td>
</tr>

<tr>
    <td class="bold">Status Pembayaran :</td>
    <td class="dashed">
        @if($record->status_pembayaran == 'lunas')
            <span style="color:green;">LUNAS</span>
        @else
            <span style="color:red;">BELUM BAYAR</span>
        @endif
    </td>
</tr>
    </table>

    <div class="signature">
        <p>Admin,</p>
          <p class="admin-name">Adventure</p>
</div>
    <div class="footer">
        <small>Terima kasih atas kepercayaan Anda menyewa barang di tempat kami.</small>
        <small>Untuk bantuan atau pertanyaan lebih lanjut, hubungi 081234567890.</small>

    </div>
</body>
</html>
