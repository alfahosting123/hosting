<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
            min-height: 100vh;
            margin: 0;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
            animation: fadeInDown 1s ease;
        }

        a {
            display: inline-block;
            margin: 10px;
            padding: 12px 20px;
            background-color: #ffffff;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transition: 0.3s ease;
            animation: fadeInUp 1s ease;
            font-size: 18px; /* Ukuran font yang sesuai */
            width: 100%;
            max-width: 320px; /* Batas lebar maksimal tombol */
        }

        a:hover {
            background-color: #4CAF50;
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .notif {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 12px;
            margin: 20px auto;
            width: 90%;
            max-width: 400px;
            text-align: center;
            border: 1px solid #badbcc;
            border-radius: 8px;
            font-size: 16px;
            animation: fadeSlide 1s ease;
        }

        @keyframes fadeSlide {
            0% {opacity: 0; transform: translateY(-20px);}
            100% {opacity: 1; transform: translateY(0);}
        }

        /* Media Query untuk ukuran layar lebih kecil (misalnya Android) */
        @media (max-width: 600px) {
            a {
                padding: 15px 30px; /* Lebih besar agar lebih mudah di klik */
                font-size: 20px; /* Ukuran font lebih besar di perangkat mobile */
            }

            h2 {
                font-size: 22px; /* Ukuran heading lebih besar di mobile */
            }
        }
    </style>
</head>
<body>
    <h2>Selamat datang, Admin!</h2>

    <a href="tambah_siswa.php">Tambah Siswa</a><br>
    <a href="tambah_tagihan.php">Tambah Tagihan</a><br>
    <a href="konfirmasi_pembayaran.php">Konfirmasi Pembayaran</a><br>
    <a href="konfirmasi_tindakan.php">Blokir/Unblokir Siswa</a><br>
    <a href="cek_siswa.php">Cek Data Siswa</a><br><br>
    <a href="tambah_token.php">Buat Token</a><br><br>
    <a href="hapus_tagihan.php">Hapus Tagihan Siswa</a><br><br>
    <a href="logout.php">Logout</a>
</body>
</html>
