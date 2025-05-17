<?php
include '../database/koneksi.php'; // pastikan path koneksi sesuai

if (isset($_POST['nis'])) {
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis = '$nis'");
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        echo "NIS $nis sudah terdaftar.";
    } else {
        echo "NIS $nis belum terdaftar.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek NIS Terdaftar</title>
</head>
<body>
    <h2>Cek NIS Terdaftar</h2>
    <form method="POST">
        <label for="nis">Masukkan NIS:</label><br>
        <input type="text" id="nis" name="nis" required><br><br>
        <button type="submit">Cek</button>
    </form>
</body>
</html>
