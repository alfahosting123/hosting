<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$query = mysqli_query($koneksi, "SELECT * FROM tagihan WHERE status = 'Menunggu Konfirmasi'");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pembayaran</title>
    <link rel="stylesheet" href="../css/Cuy.css">
</head>
<body>
    <h2>Konfirmasi Pembayaran Siswa</h2>

    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID Tagihan</th>
                <th>Siswa</th>
                <th>Metode Pembayaran</th>
                <th>Bukti Pembayaran</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($data = mysqli_fetch_assoc($query)) {
                echo "<tr>
                    <td>{$no}</td>
                    <td>{$data['id_tagihan']}</td>
                    <td>{$data['id_siswa']}</td>
                    <td>{$data['metode_bayar']}</td>
                    <td><img src='../uploads/{$data['bukti_transfer']}' width='100px'></td>
                    <td>{$data['status']}</td>
                    <td>
                        <a href='konfirmasi_tindakan.php?id_tagihan={$data['id_tagihan']}&action=approve'>Approve</a> |
                        <a href='konfirmasi_tindakan.php?id_tagihan={$data['id_tagihan']}&action=reject'>Reject</a>
                    </td>
                </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
    <a href="dashboard.php">logout bang</a>
</body>
</html>
