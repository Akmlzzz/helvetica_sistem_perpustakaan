<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perpustakaan - {{ ucfirst($type) }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0;
            color: #666;
        }

        .info {
            margin-bottom: 20px;
        }

        .info table {
            width: auto;
        }

        .info td {
            padding: 2px 10px 2px 0;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data th,
        table.data td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        table.data th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-center {
            text-align: center !important;
        }

        .text-right {
            text-align: right !important;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .signature {
            margin-top: 50px;
            display: inline-block;
            text-align: center;
            width: 200px;
        }

        .signature p {
            margin: 0;
        }

        .signature-name {
            margin-top: 60px !important;
            font-weight: bold;
            text-decoration: underline;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                padding: 0;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="header">
        <h1>LAPORAN SISTEM PERPUSTAKAAN DIGITAL</h1>
        <p>Jl. Contoh No. 123, Kota Contoh, Prov. Contoh</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td><strong>Jenis Laporan</strong></td>
                <td>: {{ ucfirst($type) }}</td>
            </tr>
            <tr>
                <td><strong>Periode</strong></td>
                <td>: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d
                    {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            @if($type == 'buku')
                <tr>
                    <th width="30" class="text-center">No</th>
                    <th>Judul & ISBN</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Penerbit</th>
                    <th width="50" class="text-center">Stok</th>
                    <th>Lokasi</th>
                </tr>
            @elseif($type == 'anggota')
                <tr>
                    <th width="30" class="text-center">No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Nama Lengkap</th>
                    <th>Telepon</th>
                    <th class="text-center">Tgl Regis</th>
                </tr>
            @elseif($type == 'peminjaman')
                <tr>
                    <th width="30" class="text-center">No</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th class="text-center">Pinjam</th>
                    <th class="text-center">Kembali</th>
                    <th class="text-center">Status</th>
                    <th class="text-right">Denda</th>
                </tr>
            @elseif($type == 'denda')
                <tr>
                    <th width="30" class="text-center">No</th>
                    <th>Peminjam</th>
                    <th class="text-center">ID Pinjam</th>
                    <th class="text-center">Tgl Kembali</th>
                    <th class="text-right">Jumlah Denda</th>
                    <th class="text-center">Status</th>
                </tr>
            @endif
        </thead>
        <tbody>
            @forelse($data as $row)
                @if($type == 'buku')
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <div style="font-weight: bold;">{{ $row->judul_buku }}</div>
                            <div style="font-size: 10px; color: #666;">ISBN: {{ $row->isbn ?? '-' }}</div>
                        </td>
                        <td>{{ $row->penulis }}</td>
                        <td>
                            @foreach($row->kategori as $kat)
                                <div style="font-size: 10px;">• {{ $kat->nama_kategori }}</div>
                            @endforeach
                        </td>
                        <td>{{ $row->penerbit }}</td>
                        <td class="text-center">{{ $row->stok }}</td>
                        <td>{{ $row->lokasi_rak }}</td>
                    </tr>
                @elseif($type == 'anggota')
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $row->nama_pengguna }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->anggota->nama_lengkap ?? '-' }}</td>
                        <td>{{ $row->anggota->nomor_telepon ?? '-' }}</td>
                        <td class="text-center">{{ $row->dibuat_pada->format('d/m/Y') }}</td>
                    </tr>
                @elseif($type == 'peminjaman')
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $row->pengguna->nama_pengguna }}</td>
                        <td>
                            @foreach($row->detail as $dtl)
                                <div>• {{ $dtl->buku->judul_buku ?? 'Buku Tidak Ditemukan' }}</div>
                            @endforeach
                        </td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($row->tgl_pinjam)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            {{ $row->tgl_kembali ? \Carbon\Carbon::parse($row->tgl_kembali)->format('d/m/Y') : '-' }}</td>
                        <td class="text-center">{{ ucfirst($row->status_transaksi) }}</td>
                        <td class="text-right">
                            {{ $row->denda ? 'Rp ' . number_format($row->denda->jumlah_denda, 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                @elseif($type == 'denda')
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $row->peminjaman->pengguna->nama_pengguna }}</td>
                        <td class="text-center">#{{ $row->id_peminjaman }}</td>
                        <td class="text-center">{{ $row->peminjaman->tgl_kembali }}</td>
                        <td class="text-right">Rp {{ number_format($row->jumlah_denda, 0, ',', '.') }}</td>
                        <td class="text-center">{{ ucfirst($row->status_pembayaran) }}</td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Admin Perpustakaan,</p>
            <p class="signature-name">( ____________________ )</p>
        </div>
    </div>

    <div class="no-print" style="margin-top: 50px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Ulang</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">Tutup</button>
    </div>
</body>

</html>