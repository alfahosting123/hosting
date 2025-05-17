<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Ambil semua siswa untuk pilihan
$siswa = mysqli_query($koneksi, "SELECT id_siswa, nis, nama FROM siswa");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_siswa']) && !empty($_POST['id_siswa'])) {
        $id_siswa = $_POST['id_siswa'];
        $nama_tagihan = $_POST['nama_tagihan'];
        $jumlah = $_POST['jumlah'];

        // Insert dengan tambahan field metode_bayar dan bukti_transfer
        $query = "INSERT INTO tagihan (id_siswa, nis, nama_tagihan, jumlah, metode_bayar, bukti_transfer, status) 
                  VALUES (
                      '$id_siswa',
                      (SELECT nis FROM siswa WHERE id_siswa = '$id_siswa'),
                      '$nama_tagihan',
                      '$jumlah',
                      '-',       -- metode_bayar default '-'
                      '-',       -- bukti_transfer default '-'
                      'Belum Dibayar'
                  )";
        mysqli_query($koneksi, $query);

        echo "<script>alert('Tagihan berhasil ditambahkan!'); window.location.href='dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Pilih siswa terlebih dahulu!'); window.history.back();</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Tagihan</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f7;
            padding: 20px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 400px;
            margin: 50px auto;
            animation: fadeIn 1s ease;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background: #3498db;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #2980b9;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>

<h2 align="center">Tambah Tagihan</h2>

<form method="post">
    <label for="id_siswa">Pilih Siswa</label>
    <select name="id_siswa" required>
        <option value="">-- Pilih Siswa --</option>
        <?php while($data = mysqli_fetch_assoc($siswa)): ?>
            <option value="<?= htmlspecialchars($data['id_siswa']) ?>">
                <?= htmlspecialchars($data['nis'] . ' - ' . $data['nama']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label for="nama_tagihan">Nama Tagihan</label>
    <input type="text" name="nama_tagihan" required>

    <label for="jumlah">Jumlah (Rp)</label>
    <input type="number" name="jumlah" required>

    <button type="submit">Tambah Tagihan</button>
</form>

</body>
</html>
