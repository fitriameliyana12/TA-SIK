<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Antrian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .ticket {
            border: 2px solid #000;
            padding: 20px;
            width: 300px;
            margin: 0 auto;
            text-align: center;
        }
        .ticket-header {
            font-size: 18px;
            font-weight: bold;
        }
        .ticket-body {
            margin-top: 20px;
            font-size: 14px;
        }
        .ticket-footer {
            margin-top: 20px;
            font-size: 12px;
            color: gray;
        }
        .highlight {
            font-weight: bold;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="ticket">
        <div class="ticket-header">
            <p>Klinik Fisioterapi Gerhana</p>
            <p>Ahsana Regency No.A3,</p>
            <p>Jl. Tropodo, Meri, Mojokerto</p>
        </div>
        
        <div class="ticket-body">
            <p><span class="highlight">Nama Pasien:</span> {{ $antrian->pasien->nama }}</p>
            <p><span class="highlight">Jam Terapi:</span> {{ $antrian->jam_terapi }}</p>
            <p><span class="highlight">Tanggal Terapi:</span> {{ $antrian->tanggal_terapi }}</p>
        </div>

        <div class="ticket-footer">
            <p>Harap datang 10 menit sebelum jam terapi dimulai.</p>
        </div>
    </div>

</body>
</html>
