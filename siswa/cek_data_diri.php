<?php
session_start();
include '../database/koneksi.php';

// Cegah cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Cek apakah user sudah login
if (!isset($_SESSION['siswa'])) {
    header('Location: login.php');
    exit();
}

// Cek apakah user sudah login
if (!isset($_SESSION['siswa'])) {
    header('Location: login.php');
    exit();
}

// Ambil NIS dengan benar
$nis = is_array($_SESSION['siswa']) ? $_SESSION['siswa']['nis'] : $_SESSION['siswa'];

// Query data siswa
$query = mysqli_query($koneksi, "SELECT nama, nis, alamat, telepon, email FROM siswa WHERE nis = '$nis'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data siswa tidak ditemukan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Data Diri</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .data-container {
            background: white;
            padding: 30px 50px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            animation: fadeIn 1s ease;
            text-align: left;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="data-container">
        <h2>Data Diri Siswa</h2>
        <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama']); ?></p>
        <p><strong>NIS:</strong> <?= htmlspecialchars($data['nis']); ?></p>
        <p><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat']); ?></p>
        <p><strong>Telepon:</strong> <?= htmlspecialchars($data['telepon']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($data['email']); ?></p>
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>
</body>
</html>
