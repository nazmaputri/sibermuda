<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Anda Telah Aktif</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }
        h1 {
            color: #08072a;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #ffffff;
            color: #ffffff; /* Warna teks default: putih */
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #08072a;
            transition: all 0.3s ease; /* Efek transisi agar lebih halus */
        }
        .btn:hover {
            background-color: #08072a;
            color: #ffffff; /* Warna teks saat hover: hitam */
            border: 1px solid #08072a;
        }
        .note {
            font-size: 14px;
            color: #ffffff;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat, {{ $mentorName }}!</h1>
        <p>Akun Anda telah diaktifkan oleh Admin dan kini Anda resmi menjadi mentor di <strong>Sibermuda</strong>!</p>
        <p>Silakan login untuk mengakses akun Anda dan mulai membuat kursus pertama Anda.</p>
        <a href="https://www.sibermuda.id/login" class="btn">Login Sekarang</a>
        <br>
        <hr>
        <p><em><strong>Catatan Penting:</strong></em></p>
        <p>- Kursus yang Anda buat tidak akan dipublikasikan oleh Admin jika belum memiliki materi dan kuis.</p>
        <hr>
        <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi tim support kami.</p>
        <p class="note">Salam, <br><strong>Sibermuda Team</strong></p>
    </div>
</body>
</html>
