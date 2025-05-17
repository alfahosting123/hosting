<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id_tagihan']) && isset($_GET['action'])) {
    $id_tagihan = intval($_GET['id_tagihan']);
    $action = $_GET['action'];

    if ($action == 'approve') {
        $status = 'Sudah Dibayar';
    } elseif ($action == 'reject') {
        $status = 'Ditolak';
    } else {
        die('Aksi tidak valid');
    }

    // Update status pembayaran
    $query = mysqli_query($koneksi, "UPDATE tagihan SET status = '$status' WHERE id_tagihan = '$id_tagihan'");

    if ($query) {
        echo "<script>alert('Pembayaran telah diperbarui menjadi $status');window.location='konfirmasi_pembayaran.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan dalam konfirmasi pembayaran');window.location='konfirmasi_pembayaran.php';</script>";
    }
} else {
    die('ID Tagihan atau Aksi tidak ditemukan.');
}
?>

<a href="logout.php">logout bang</a>