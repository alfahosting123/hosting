<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['siswa'])) {
    header('Location: login.php');
    exit();
}

// Perbaikan disini:
$nis = $_SESSION['siswa']['nis']; // Ambil nis dari session dengan benar

$result = mysqli_query($koneksi, "SELECT * FROM tagihan WHERE nis = '$nis'");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Tagihan</title>
    <link rel="stylesheet" href="../css/cektag.css">
    <style>
        .notif-sukses {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .dibayar {
            color: green;
            font-weight: bold;
        }
        .belum-dibayar {
            color: red;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: center;
        }
        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>

<?php if (isset($_GET['sukses']) && $_GET['sukses'] == 1): ?>
    <div class="notif-sukses">
        Pembayaran berhasil! Menunggu konfirmasi admin.
    </div>
<?php endif; ?>

    <h2>Tagihan Anda</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Tagihan</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        if (mysqli_num_rows($result) > 0) {
            while ($tagihan = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($tagihan['nama_tagihan']) . "</td>";
                echo "<td>Rp " . number_format($tagihan['jumlah'], 0, ',', '.') . "</td>";
                if ($tagihan['status'] == 'Sudah Dibayar') {
                    echo "<td class='dibayar'>Sudah Dibayar</td>";
                    echo "<td>-</td>";
                } else {
                    echo "<td class='belum-dibayar'>Belum Dibayar</td>";
                    echo "<td><a href='bayar_tagihan.php?id_tagihan=" . $tagihan['id_tagihan'] . "'>Bayar Sekarang</a></td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada tagihan ditemukan.</td></tr>";
        }
        ?>
    </table>

    <br>
    <a href="dashboard.php">Kembali ke Dashboard</a>

</body>
</html>
