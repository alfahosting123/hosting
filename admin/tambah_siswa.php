<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Token kosong dulu
    $token = '';

    $query = "INSERT INTO siswa (nis, nama, alamat, telepon, email, username, password, token) 
              VALUES ('$nis', '$nama', '$alamat', '$telepon', '$email', '$username', '$password', '$token')";
    mysqli_query($koneksi, $query);

    echo "<script>alert('Siswa berhasil ditambahkan!'); window.location.href='dashboard.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Siswa</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2>Tambah Siswa</h2>

<form method="post">
    <input type="text" name="nis" placeholder="NIS" required><br><br>
    <input type="text" name="nama" placeholder="Nama" required><br><br>
    <input type="text" name="alamat" placeholder="Alamat" required><br><br>
    <input type="text" name="telepon" placeholder="Telepon" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Tambah</button>
</form>

</body>
</html>
