<?php
session_start();
include '../database/koneksi.php';
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Ambil data tagihan
$result = mysqli_query($koneksi, "SELECT * FROM tagihan");

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM tagihan WHERE id_tagihan = $id");
    header('Location: hapus_tagihan.php?sukses=1');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hapus Tagihan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: linear-gradient(135deg, #c3ecb2, #7ddfca);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background: white;
            border-radius: 10px;
            overflow: hidden;
            animation: fadeIn 1s ease;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #00b894;
            color: white;
        }
        tr:hover {
            background: #f1f2f6;
        }
        a.hapus-btn {
            padding: 8px 15px;
            background: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        a.hapus-btn:hover {
            background: #c0392b;
        }
        .notif-sukses {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin: 20px auto;
            width: 90%;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            animation: slideIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px);}
            to { opacity: 1; transform: translateY(0);}
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-100px);}
            to { opacity: 1; transform: translateX(0);}
        }
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            z-index: 1000;
            animation: fadeInPopup 0.5s ease;
        }
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }
        @keyframes fadeInPopup {
            from { opacity: 0; transform: translateY(-10px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>

<?php if (isset($_GET['sukses'])): ?>
    <div class="notif-sukses">Tagihan berhasil dihapus!</div>
<?php endif; ?>

<h2>Daftar Tagihan</h2>

<table>
    <tr>
        <th>No</th>
        <th>Nama Tagihan</th>
        <th>Jumlah</th>
        <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . htmlspecialchars($row['nama_tagihan'] ?? '') . "</td>";
        echo "<td>Rp " . number_format($row['jumlah'] ?? 0, 0, ',', '.') . "</td>";
        echo "<td><a class='hapus-btn' href='#' onclick='confirmDelete(" . htmlspecialchars($row['id_tagihan'] ?? 0) . ")'>Hapus</a></td>";
        echo "</tr>";
    }
    ?>
</table>

<!-- Popup konfirmasi -->
<div id="popup" class="popup">
    <h3>Konfirmasi Penghapusan</h3>
    <p>Apakah Anda yakin ingin menghapus tagihan ini?</p>
    <button onclick="deleteTagihan()" id="confirmDeleteBtn">Hapus</button>
    <button onclick="closePopup()">Batal</button>
</div>
<div id="popupOverlay" class="popup-overlay"></div>

<script>
    let tagihanId = null;

    // Tampilkan popup konfirmasi
    function confirmDelete(id) {
        tagihanId = id;
        document.getElementById('popup').style.display = 'block';
        document.getElementById('popupOverlay').style.display = 'block';
    }

    // Tutup popup
    function closePopup() {
        document.getElementById('popup').style.display = 'none';
        document.getElementById('popupOverlay').style.display = 'none';
    }

    // Hapus tagihan
    function deleteTagihan() {
        if (tagihanId) {
            window.location.href = "hapus_tagihan.php?hapus=" + tagihanId;
        }
    }
</script>
<a href="dashboard.php" style="display: inline-block; padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; transition: background 0.3s ease;">Kembali ke Dashboard</a>
</body>
</html>
