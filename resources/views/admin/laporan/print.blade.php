<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perpustakaan - {{ ucfirst($type) }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 10px 20px; /* Reduced from 20px */
            color: #333;
        }

        .header {
            margin-bottom: 5px; /* Reduced from 15px */
        }

        .header h1 {
            margin: 0 0 3px 0; /* Tightened */
            font-size: 18px;
            font-weight: 700;
            color: #0d3b2e; /* dark green from image */
            text-transform: uppercase;
        }

        .header p {
            margin: 0 0 3px 0; /* Tightened */
            color: #666;
            font-size: 10px;
        }

        .header .subtitle {
            font-weight: bold;
            color: #333;
            margin-top: 3px;
        }

        .divider-thick {
            border-top: 3px solid #0d3b2e;
            margin: 10px 0; /* Adjusted margins */
        }

        .summary-box {
            display: table;
            width: 100%;
            border: 1px solid #e0e0e0;
            margin-bottom: 10px; /* Reduced */
            background-color: #fcfcfc;
        }

        .summary-row {
            display: table-row;
        }

        .summary-col {
            display: table-cell;
            padding: 8px 12px; /* Reduced padding */
            border-right: 1px solid #e0e0e0;
            vertical-align: top;
            width: 33.33%;
        }

        .summary-col:last-child {
            border-right: none;
        }

        .summary-label {
            font-size: 9px;
            color: #888;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .summary-value {
            font-size: 12px; /* Slightly reduced */
            font-weight: 600;
            color: #222;
        }

        .stats-box {
            display: table;
            width: 100%;
            border: 1px solid #e0e0e0;
            margin-bottom: 10px; /* Reduced */
            background-color: #fff;
        }
        
        .stat-col {
            display: table-cell;
            text-align: center;
            padding: 12px 10px; /* Reduced padding */
            border-right: 1px solid #e0e0e0;
            width: 25%;
        }

        .stat-col:last-child {
            border-right: none;
        }

        .stat-value {
            font-size: 20px; /* Reduced from 24px */
            font-weight: bold;
            margin-bottom: 3px;
        }

        .stat-value.total { color: #0d3b2e; }
        .stat-value.terlambat { color: #d32f2f; }
        .stat-value.dikembalikan { color: #388e3c; }
        .stat-value.dipinjam { color: #0d3b2e; }

        .stat-label {
            font-size: 9px;
            color: #888;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px; /* Reduced */
            margin-bottom: 10px; /* Added */
        }

        table.data th {
            background-color: #0d3b2e;
            color: #fff;
            padding: 8px 10px; /* Reduced padding */
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            text-align: left;
        }

        table.data td {
            padding: 6px 10px; /* Reduced padding */
            border-bottom: 1px solid #eee;
            color: #444;
            vertical-align: top;
        }

        table.data tr:nth-child(even) td {
            background-color: #fafafa;
        }

        table.data tr:last-child td {
            border-bottom: 1px solid #e0e0e0;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px; /* Adjusted padding */
            border-radius: 20px;
            font-size: 9px; /* Reduced */
            font-weight: 600;
            text-align: center;
        }

        .badge-dipinjam {
            background-color: #e8f0fe;
            color: #1967d2;
            border: 1px solid #d2e3fc;
        }

        .badge-dikembalikan {
            background-color: #e6f4ea;
            color: #1e8e3e;
            border: 1px solid #ceead6;
        }

        .badge-terlambat {
            background-color: #fce8e6;
            color: #d93025;
            border: 1px solid #fad2cf;
        }

        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }

        .footer-note {
            font-size: 9px;
            color: #888;
            margin-top: 5px; /* Reduced */
            border-top: 1px solid #eee;
            padding-top: 5px;
        }

        .signature-area {
            width: 100%;
            margin-top: 20px; /* Reduced */
            page-break-inside: avoid;
        }

        .signature-box {
            float: right;
            width: 250px;
            text-align: right; /* Changed to match image layout */
        }

        .signature-title {
            font-size: 11px;
            color: #555;
            margin-bottom: 40px; /* Reduced space for signature */
        }

        .signature-line {
            border-bottom: 1px solid #333;
            margin: 0;
            width: 100%;
            display: inline-block;
        }
        
        .signature-name {
            display: inline-block;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .book-item {
            margin-bottom: 2px;
            line-height: 1.3;
        }

        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN SISTEM PERPUSTAKAAN DIGITAL</h1>
        <p>Dokumen Resmi — Dicetak Otomatis oleh Sistem</p>
        <p class="subtitle">Jenis: {{ ucfirst($type) }} | Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
    </div>

    <div class="divider-thick"></div>

    <div class="summary-box">
        <div class="summary-row">
            <div class="summary-col">
                <div class="summary-label">JENIS LAPORAN</div>
                <div class="summary-value">{{ ucfirst($type) }}</div>
            </div>
            <div class="summary-col">
                <div class="summary-label">PERIODE</div>
                <div class="summary-value">{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</div>
            </div>
            <div class="summary-col">
                <div class="summary-label">TOTAL DATA</div>
                <div class="summary-value">{{ count($data) }} record</div>
            </div>
            <div class="summary-col">
                <div class="summary-label">DICETAK PADA</div>
                <div class="summary-value">{{ \Carbon\Carbon::now()->format('d M Y, H:i') }} WIB</div>
            </div>
        </div>
    </div>

    @if($type === 'peminjaman' && isset($totalPeminjaman))
    <div class="stats-box">
        <div class="summary-row">
            <div class="stat-col">
                <div class="stat-value total">{{ $totalPeminjaman }}</div>
                <div class="stat-label">TOTAL TRANSAKSI</div>
            </div>
            <div class="stat-col">
                <div class="stat-value terlambat">{{ $totalTerlambat }}</div>
                <div class="stat-label">TERLAMBAT</div>
            </div>
            <div class="stat-col">
                <div class="stat-value dikembalikan">{{ $totalDikembalikan }}</div>
                <div class="stat-label">DIKEMBALIKAN</div>
            </div>
            <div class="stat-col">
                <div class="stat-value dipinjam">{{ $totalDipinjam }}</div>
                <div class="stat-label">MASIH DIPINJAM</div>
            </div>
        </div>
    </div>
    @endif

    <table class="data">
        <thead>
            @if($type == 'buku')
                <tr>
                    <th width="30" class="text-center">NO</th>
                    <th>JUDUL & ISBN</th>
                    <th>PENULIS</th>
                    <th>KATEGORI</th>
                    <th>PENERBIT</th>
                    <th width="50" class="text-center">STOK</th>
                    <th>LOKASI</th>
                </tr>
            @elseif($type == 'anggota')
                <tr>
                    <th width="30" class="text-center">NO</th>
                    <th>USERNAME</th>
                    <th>EMAIL</th>
                    <th>NAMA LENGKAP</th>
                    <th>TELEPON</th>
                    <th class="text-center">TGL REGIS</th>
                </tr>
            @elseif($type == 'peminjaman')
                <tr>
                    <th width="30" class="text-center">NO</th>
                    <th>PEMINJAM</th>
                    <th>BUKU</th>
                    <th class="text-center">TGL PINJAM</th>
                    <th class="text-center">TGL KEMBALI</th>
                    <th class="text-center">STATUS</th>
                    <th class="text-right">DENDA</th>
                </tr>
            @elseif($type == 'denda')
                <tr>
                    <th width="30" class="text-center">NO</th>
                    <th>PEMINJAM</th>
                    <th class="text-center">ID PINJAM</th>
                    <th class="text-center">TGL KEMBALI</th>
                    <th class="text-right">JUMLAH DENDA</th>
                    <th class="text-center">STATUS</th>
                </tr>
            @endif
        </thead>
        <tbody>
            @forelse($data as $row)
                @if($type == 'buku')
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <div style="font-weight: 600;">{{ $row->judul_buku }}</div>
                            <div style="font-size: 9px; color: #888;">ISBN: {{ $row->isbn ?? '-' }}</div>
                        </td>
                        <td>{{ $row->penulis }}</td>
                        <td>
                            @foreach($row->kategori as $kat)
                                <div style="font-size: 9px;">• {{ $kat->nama_kategori }}</div>
                            @endforeach
                        </td>
                        <td>{{ $row->penerbit }}</td>
                        <td class="text-center">{{ $row->stok }}</td>
                        <td>{{ $row->lokasi_rak }}</td>
                    </tr>
                @elseif($type == 'anggota')
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td style="font-weight: 500;">{{ $row->nama_pengguna }}</td>
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
                            @if($row->detail && $row->detail->count() > 0)
                                @foreach($row->detail as $dtl)
                                    <div class="book-item">• {{ $dtl->buku->judul_buku ?? 'Buku Tidak Ditemukan' }}</div>
                                @endforeach
                            @elseif($row->buku)
                                <div class="book-item">• {{ $row->buku->judul_buku }}</div>
                            @else
                                <div class="book-item" style="font-style: italic; color: #999;">Buku Tidak Ditemukan</div>
                            @endif
                        </td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($row->tgl_pinjam)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            {{ $row->tgl_kembali ? \Carbon\Carbon::parse($row->tgl_kembali)->format('d/m/Y') : '-' }}</td>
                        <td class="text-center">
                            @if($row->status_transaksi == 'dipinjam')
                                <span class="badge badge-dipinjam">Dipinjam</span>
                            @elseif($row->status_transaksi == 'dikembalikan')
                                <span class="badge badge-dikembalikan">Dikembalikan</span>
                            @elseif($row->status_transaksi == 'terlambat')
                                <span class="badge badge-terlambat">Terlambat</span>
                            @else
                                <span class="badge badge-dipinjam">{{ ucfirst($row->status_transaksi) }}</span>
                            @endif
                        </td>
                        <td class="text-right" style="{{ $row->denda ? 'color: #d32f2f; font-weight: 600;' : 'color: #aaa;' }}">
                            {{ $row->denda ? 'Rp ' . number_format($row->denda->jumlah_denda, 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                @elseif($type == 'denda')
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $row->peminjaman->pengguna->nama_pengguna }}</td>
                        <td class="text-center">#{{ $row->id_peminjaman }}</td>
                        <td class="text-center">{{ $row->peminjaman->tgl_kembali ? \Carbon\Carbon::parse($row->peminjaman->tgl_kembali)->format('d/m/Y') : '-' }}</td>
                        <td class="text-right" style="color: #d32f2f; font-weight: 600;">Rp {{ number_format($row->jumlah_denda, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($row->status_pembayaran == 'lunas')
                                <span class="badge badge-dikembalikan">Lunas</span>
                            @else
                                <span class="badge badge-terlambat">Belum Bayar</span>
                            @endif
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px;">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-note">
        Dokumen digenerate otomatis oleh Sistem Perpustakaan Digital pada {{ \Carbon\Carbon::now()->format('d M Y') }} pukul {{ \Carbon\Carbon::now()->format('H:i') }} WIB
    </div>

    <div class="signature-area clearfix">
        <div class="signature-box">
            <div class="signature-title">Admin Perpustakaan,</div>
            <div class="signature-name">( <div class="signature-line" style="width: 150px; margin: 0 10px;"></div> )</div>
        </div>
    </div>
</body>

</html>
