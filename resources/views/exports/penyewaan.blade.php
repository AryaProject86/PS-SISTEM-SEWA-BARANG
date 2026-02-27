<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penyewaan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #eee;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h2>LAPORAN PENYEWAAN BARANG</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pelanggan</th>
                <th>Barang</th>
                <th>Tanggal Sewa</th>
                <th>Tanggal Kembali</th>
                <th>Total Biaya</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->pelanggan->nama ?? '-' }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_sewa)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}</td>
                    <td>Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</td>
                    <td>
                        @if ($item->status === 'disewa')
                            Disewa
                        @elseif ($item->status === 'dikembalikan')
                            Dikembalikan
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
    </div>
</body>
</html>
