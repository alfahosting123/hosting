<?php
session_start();
include '../database/koneksi.php';

// Hapus siswa jika ada parameter hapus
if (isset($_GET['hapus'])) {
    $nis_hapus = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM siswa WHERE nis='$nis_hapus'");
    header('Location: cek_siswa.php?notif=hapus_berhasil');
    exit();
}

// Ambil semua siswa
$result = mysqli_query($koneksi, "SELECT nis, nama FROM siswa ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Siswa Terdaftar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
        }
        a:hover {
            background-color: #0056b3;
        }
        .btn-hapus {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-hapus:hover {
            background-color: #c82333;
        }
        .notif {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Daftar Siswa Terdaftar</h2>

<?php if (isset($_GET['notif']) && $_GET['notif'] == 'hapus_berhasil'): ?>
    <div class="notif">Siswa berhasil dihapus!</div>
<?php endif; ?>

<table>
    <tr>
        <th>NIS</th>
        <th>Nama Siswa</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= htmlspecialchars($row['nis']) ?></td>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td>
            <a href="cek_siswa.php?hapus=<?= htmlspecialchars($row['nis']) ?>" 
               class="btn-hapus" 
               onclick="return confirm('Yakin ingin menghapus siswa ini?')">
               Hapus
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<a href="login.php">Kembali ke Login</a>

</body>
</html>
