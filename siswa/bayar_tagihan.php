<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['siswa'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id_tagihan'])) {
    die('ID Tagihan tidak ditemukan.');
}

$id_tagihan = intval($_GET['id_tagihan']);
$query = mysqli_query($koneksi, "SELECT * FROM tagihan WHERE id_tagihan = '$id_tagihan'");
$tagihan = mysqli_fetch_assoc($query);

if (!$tagihan) {
    die('Tagihan tidak ditemukan.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $metode = htmlspecialchars($_POST['metode']);
    $status = 'Menunggu Konfirmasi';

    if ($metode == 'Indomaret' || $metode == 'Alfamart') {
        // Generate kode pembayaran lebih rapi
        $kode_pembayaran = strtoupper(substr($metode, 0, 1)) . date('Ymd') . '-' . sprintf("%04d", $id_tagihan);

        mysqli_query($koneksi, "UPDATE tagihan SET metode_bayar='$metode', kode_pembayaran='$kode_pembayaran', status='$status' WHERE id_tagihan='$id_tagihan'");
        
        echo "<script>
            localStorage.setItem('kodePembayaran', '$kode_pembayaran');
            localStorage.setItem('metodeBayar', '$metode');
            window.location='bayar_tagihan.php?id_tagihan=$id_tagihan&showpopup=true';
        </script>";
    } else {
        $bukti = $_FILES['bukti']['name'];
        $tmp = $_FILES['bukti']['tmp_name'];

        if (!empty($bukti)) {
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $file_extension = strtolower(pathinfo($bukti, PATHINFO_EXTENSION));

            if (!in_array($file_extension, $allowed_extensions)) {
                echo "<script>alert('Hanya file gambar yang diperbolehkan!');</script>";
            } else {
                $bukti_path = '../uploads/' . time() . '_' . $bukti;
                if (move_uploaded_file($tmp, $bukti_path)) {
                    mysqli_query($koneksi, "UPDATE tagihan SET metode_bayar='$metode', bukti_transfer='$bukti_path', status='$status' WHERE id_tagihan='$id_tagihan'");
                    echo "<script>alert('Pembayaran berhasil dikirim. Menunggu konfirmasi admin.'); window.location='cek_tagihan.php';</script>";
                } else {
                    echo "<script>alert('Terjadi kesalahan saat meng-upload file.');</script>";
                }
            }
        } else {
            echo "<script>alert('Silakan upload bukti pembayaran!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bayar Tagihan</title>
    <link rel="stylesheet" href="../css/Cuy.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        select, input[type="file"], button {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .info {
            margin-top: 15px;
            padding: 10px;
            background: #e9ecef;
            border-left: 4px solid #007bff;
        }
        .btn-submit {
            background-color: #007bff;
            color: white;
            border: none;
            font-size: 16px;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        a.back {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
        /* Animasi loading */
        #loading {
            display: none;
            position: fixed;
            z-index: 9999;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.8) url('../assets/loading.gif') no-repeat center center;
            background-size: 100px 100px;
        }
        /* Popup kode pembayaran */
        #popup-kode {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
        }
        #popup-kode .content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 400px;
            margin: 100px auto;
            text-align: center;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.8);}
            to { opacity: 1; transform: scale(1);}
        }
    </style>
</head>
<body>

<div id="loading"></div>

<div id="popup-kode">
    <div class="content">
        <h3>Kode Pembayaran</h3>
        <p id="kode-pembayaran" style="font-size:24px; font-weight:bold;">---</p>
        <p id="instruksi-pembayaran"></p>
        <button onclick="downloadBukti()" style="margin-top:10px; padding:10px 20px; background:#27ae60; color:white; border:none; border-radius:5px;">Download Bukti</button><br>
        <button onclick="tutupPopup()" style="margin-top:10px; padding:10px 20px; background:#3498db; color:white; border:none; border-radius:5px;">Tutup</button>
    </div>
</div>

<div class="container">
    <h2>Bayar Tagihan</h2>

    <form method="post" enctype="multipart/form-data">
        <label for="metode">Pilih Metode Pembayaran</label>
        <select name="metode" id="metode" onchange="toggleBukti()" required>
            <option value="">-- Pilih Metode --</option>
            <option value="Bank BCA">Bank BCA</option>
            <option value="Bank BRI">Bank BRI</option>
            <option value="Bank BNI">Bank BNI</option>
            <option value="Bank BSI">Bank BSI</option>
            <option value="DANA">DANA</option>
            <option value="OVO">OVO</option>
            <option value="GoPay">GoPay</option>
            <option value="ShopeePay">ShopeePay</option>
            <option value="Alfamart">Alfamart</option>
            <option value="Indomaret">Indomaret</option>
        </select>

        <div id="info" class="info" style="display:none;"></div>

        <div id="upload-bukti">
            <label for="bukti">Upload Bukti Transfer</label>
            <input type="file" name="bukti" id="bukti" accept="image/*">
        </div>

        <button type="submit" class="btn-submit">Kirim Pembayaran</button>
    </form>

    <a href="cek_tagihan.php" class="back">Kembali ke Cek Tagihan</a>
</div>

<script>
function toggleBukti() {
    var metode = document.getElementById('metode').value;
    var uploadBukti = document.getElementById('upload-bukti');
    var info = document.getElementById('info');

    if (metode === "") {
        uploadBukti.style.display = "block";
        info.style.display = "none";
    } else if (metode == "Indomaret" || metode == "Alfamart") {
        uploadBukti.style.display = "none";
        info.style.display = "block";
        info.innerHTML = "<b>Instruksi:</b> Setelah klik Kirim, Anda akan mendapatkan <b>Kode Pembayaran</b> untuk membayar di " + metode + ".";
    } else {
        uploadBukti.style.display = "block";
        info.style.display = "block";
        info.innerHTML = "<b>Instruksi:</b> Transfer ke rekening atau e-wallet pilihan, lalu upload bukti transfer di bawah.";
    }
}

// Popup show kalau ada ?showpopup=true
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('showpopup') === 'true') {
        var kode = localStorage.getItem('kodePembayaran');
        var metode = localStorage.getItem('metodeBayar');
        if (kode && metode) {
            document.getElementById('kode-pembayaran').innerText = kode;
            document.getElementById('instruksi-pembayaran').innerText = "Bayar di " + metode + " dengan kode ini.";
            document.getElementById('popup-kode').style.display = 'block';
        }
    }
}

function tutupPopup() {
    document.getElementById('popup-kode').style.display = 'none';
}

// Download bukti bayar sebagai gambar (screenshot popup)
function downloadBukti() {
    var element = document.getElementById('popup-kode');
    html2canvas(element).then(function(canvas) {
        var link = document.createElement('a');
        link.download = 'Bukti_Pembayaran.png';
        link.href = canvas.toDataURL();
        link.click();
    });
}
</script>

<!-- Load library html2canvas untuk screenshot download -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

</body>
</html>
