<?php
session_start();
include '../database/koneksi.php';
if (!isset($_SESSION['siswa'])) {
    header('Location: login.php');
    exit();
}

// Cegah cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Cek apakah user sudah login
if (!isset($_SESSION['siswa'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/Cuy.css">
    <title>Dashboard Siswa</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
            font-size: 32px;
            animation: fadeInDown 1s ease;
        }

        a {
            display: inline-block;
            margin: 20px;
            padding: 18px 40px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-size: 20px;
            transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
            transform: scale(1.15);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
        }

        a:active {
            transform: scale(1);
        }

        /* Animations */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dashboard-container {
            animation: fadeInUp 1s ease-out;
        }

    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Selamat datang, Siswa!</h2>
        <a href="cek_tagihan.php">Cek Tagihan</a><br>
        <a href="cek_data_diri.php">Cek Data Diri</a><br>
        <a href="logout.php">Logout</a>
    </div>

    <a href="http://0.0.0.0:8080/index.html">Kembali ke Tempat</a>
</body>
</html>
