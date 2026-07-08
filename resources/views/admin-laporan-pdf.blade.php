<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan PDF - PT Semeru Agung Mandiri</title>
    <style>
        /* Menggunakan font standar DomPDF dengan optimalisasi ketebalan */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #1a202c;
            line-height: 1.5;
            margin: 10px;
        }

        /* Kop Surat Modern Asimetris */
        .invoice-header {
            width: 100%;
            margin-bottom: 35px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .company-data {
            float: left;
            width: 50%;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #000000;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .company-tag {
            font-size: 9px;
            color: #e53e3e; /* Warna Merah Telkom / Seagma */
            font-weight: bold;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        .report-data {
            float: right;
            width: 50%;
            text-align: right;
        }

        .report-title {
            font-size: 13px;
            font-weight: bold;
            color: #2d3748;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .report-periode {
            font-size: 11px;
            font-weight: bold;
            color: #4a5568;
            margin-top: 4px;
        }

        .report-date {
            font-size: 10px;
            color: #718096;
            margin-top: 3px;
        }

        /* Pembersihan Float CSS */
        .clearfix {
            clear: both;
        }

        /* Tabel Minimalis Tanpa Border Kaku */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f8fafc;
            color: #4a5568;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8.5px;
            letter-spacing: 0.8px;
            padding: 10px 8px; /* Padding disesuaikan */
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
        }

        td {
            padding: 12px 8px; /* Padding disesuaikan */
            border-bottom: 1px solid #edf2f7;
            color: #2d3748;
            vertical-align: top;
        }

        /* Zebra Striping Halus */
        tr:nth-child(even) td {
            background-color: #fcfdfe;
        }

        /* Utilitas Tipografi */
        .text-center {
            text-align: center;
        }

        .font-mono {
            font-family: 'Courier', monospace;
            font-size: 10px;
            color: #718096;
        }

        /* Teks Status Berwarna Pastel Formal */
        .status {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 8.5px;
            letter-spacing: 0.5px;
            display: inline-block;
        }

        .status-menunggu {
            color: #dd6b20; /* Oranye */
        }
        .status-diproses {
            color: #3182ce; /* Biru Korporat */
        }
        .status-selesai {
            color: #38a169; /* Hijau Daun */
        }

        /* CSS untuk Foto Bukti */
        .foto-bukti {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #cbd5e0;
        }
    </style>
</head>

<body>

    <div class="invoice-header">
        <div class="company-data">
            <h1 class="company-name">PT SEMERU AGUNG MANDIRI</h1>
            <div class="company-tag">Mitra Resmi PT Telkom Indonesia</div>
        </div>
        <div class="report-data">
            <h2 class="report-title">Rekapitulasi Pengaduan</h2>
            <div class="report-periode">Periode: {{ $periode ?? 'Semua Waktu' }}</div>
            <div class="report-date">Cetak: {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('d M Y - H:i') }} WIB</div>
        </div>
        <div class="clearfix"></div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%" class="text-center">No</th>
                <th width="10%" class="text-center">Tgl. Masuk</th>
                <th width="16%">Pelanggan</th>
                <th width="28%">Deskripsi Masalah</th>
                <th width="16%">Teknisi Lapangan</th>
                <th width="10%" class="text-center">Status</th>
                <th width="16%" class="text-center">Bukti Foto</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tikets as $index => $tiket)
                <tr>
                    <td class="text-center font-mono" style="padding-top: 14px;">{{ $index + 1 }}</td>
                    
                    <td class="text-center font-mono" style="padding-top: 14px;">
                        {{ \Carbon\Carbon::parse($tiket->created_at)->format('d/m/Y') }}
                    </td>
                    
                    <td>
                        <div style="font-weight: bold; color: #1a202c; font-size: 11.5px;">
                            {{ $tiket->pelanggan ? Str::upper($tiket->pelanggan->name) : '-' }}
                        </div>
                        <div style="font-size: 9.5px; color: #a0aec0; margin-top: 2px;">ID: {{ $tiket->user_id }}</div>
                    </td>
                    
                    <td>
                        <div style="font-weight: bold; color: #2d3748;">{{ $tiket->judul }}</div>
                        <div style="font-size: 10px; color: #718096; margin-top: 3px; pr-4">
                            {{ Str::limit($tiket->deskripsi, 80) }}
                        </div>
                    </td>
                    
                    <td>
                        @if ($tiket->teknisi)
                            <div style="font-weight: 600; color: #2b6cb0;">
                                {{ $tiket->teknisi->name }}
                            </div>
                        @else
                            <div style="color: #a0aec0; font-style: italic; font-size: 10px;">Belum Ditunjuk</div>
                        @endif
                    </td>
                    
                    <td class="text-center status 
                        @if ($tiket->status == 'menunggu verifikasi') status-menunggu
                        @elseif($tiket->status == 'diproses') status-diproses
                        @else status-selesai @endif"
                        style="padding-top: 14px;">
                        {{ $tiket->status == 'menunggu verifikasi' ? 'menunggu' : $tiket->status }}
                    </td>

                    <td class="text-center">
                        @if ($tiket->foto_bukti)
                            <img src="{{ public_path('storage/' . $tiket->foto_bukti) }}" class="foto-bukti" alt="Bukti">
                        @else
                            <div style="font-size: 9px; color: #cbd5e0; margin-top: 10px; font-style: italic;">
                                - Tidak ada -
                            </div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px; font-style: italic; color: #718096;">
                        Tidak ada pengaduan pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>