<?php
// Koneksi ke database
include '../database/koneksi.php'; 

// Baca input dari JavaScript
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['nama'], $data['status'], $data['tanggal'])) {
    $nama = mysqli_real_escape_string($koneksi, $data['nama']);
    $status = mysqli_real_escape_string($koneksi, $data['status']);
    $tanggal = mysqli_real_escape_string($koneksi, $data['tanggal']);

    // Simpan ke tabel absensi
    $query = "INSERT INTO absensi (nama, status, tanggal) VALUES ('$nama', '$status', '$tanggal')";

    if (mysqli_query($koneksi, $query)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => mysqli_error($koneksi)]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Data tidak lengkap"]);
}
?>
