<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Register - Zola Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #212529;
            line-height: 1.4;
        }
        .page {
            padding: 40px;
            page-break-after: always;
        }
        .page:last-child {
            page-break-after: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4263eb;
        }
        .header h1 {
            font-size: 20px;
            font-weight: bold;
            color: #4263eb;
            margin-bottom: 2px;
        }
        .tutor-title {
            background: #4263eb;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: bold;
        }
        .summary-box {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .summary-grid {
            display: table;
            width: 100%;
        }
        .summary-item {
            display: table-cell;
            width: 33%;
            padding: 5px;
        }
        .summary-label {
            font-size: 9px;
            color: #868e96;
            text-transform: uppercase;
            font-weight: bold;
        }
        .summary-value {
            font-size: 13px;
            font-weight: bold;
            color: #212529;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead th {
            background: #f1f3f5;
            color: #495057;
            padding: 8px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            border-bottom: 2px solid #dee2e6;
        }
        tbody td {
            padding: 8px;
            border-bottom: 1px solid #e9ecef;
            font-size: 10px;
        }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .badge {
            background: #e7f5ff;
            color: #1c7ed6;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 9px;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #adb5bd;
        }
    </style>
</head>
<body>
    @foreach($tutorData as $data)
        <div class="page">
            <div class="header">
                <h1>ZOLA REGISTER</h1>
                <p>Laporan Register Bulanan — {{ now()->format('F Y') }}</p>
                <p style="font-size: 8px; margin-top: 5px;">Filter: {{ implode(' | ', $filterInfo) ?: 'Semua Data' }}</p>
            </div>

            <div class="tutor-title">
                TUTOR: {{ strtoupper($data['tutor']->name) }}
            </div>

            <div class="summary-box">
                <div class="summary-grid">
                    <div class="summary-item">
                        <span class="summary-label">Total Murid</span><br>
                        <span class="summary-value">{{ $data['totalStudents'] }} Siswa</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Total Kelas</span><br>
                        <span class="summary-value">{{ $data['registers']->count() }} Sesi</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Rincian Mengajar</span><br>
                        <span class="summary-value" style="font-size: 10px;">
                            @forelse($data['classCounts'] as $prog => $count)
                                {{ $prog }} {{ $count }}x{{ !$loop->last ? ',' : '' }}
                            @empty
                                Tidak ada aktivitas
                            @endforelse
                        </span>
                    </div>
                </div>
            </div>

            @if($data['registers']->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th style="width: 30px;" class="text-center">No</th>
                            <th style="width: 80px;">Tanggal</th>
                            <th style="width: 60px;">Kelas</th>
                            <th>Program</th>
                            <th style="width: 90px;">Jam</th>
                            <th style="width: 40px;" class="text-center">Siswa</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['registers'] as $index => $reg)
                            <tr>
                                <td class="text-center text-gray-500">{{ $index + 1 }}</td>
                                <td>{{ $reg->register_date->format('d/m/Y') }}</td>
                                <td><span class="badge">{{ $reg->classCode->code }}</span></td>
                                <td>{{ $reg->classCode->program }}</td>
                                <td>{{ $reg->time_range }}</td>
                                <td class="text-center text-bold">{{ $reg->student_count }}</td>
                                <td style="font-style: italic; color: #495057;">{{ $reg->notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 50px; color: #adb5bd; border: 1px dashed #dee2e6; border-radius: 8px;">
                    Tidak ada data register untuk tutor ini pada periode yang dipilih.
                </div>
            @endif
        </div>
    @endforeach

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }} — &copy; Zola Register System
    </div>
</body>
</html>
