<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$tokenGenerated = ''; // Untuk menyimpan token yang sudah digenerate

// Fungsi untuk menghasilkan token acak 6 karakter
function generateToken($length = 6) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis = $_POST['nis'];
    $token = generateToken(); // Generate token 6 karakter
    $sql = "UPDATE siswa SET token = '$token' WHERE nis = '$nis'";

    if (mysqli_query($koneksi, $sql)) {
        $tokenGenerated = $token; // Token berhasil dibuat
        $notifMessage = "Token berhasil diberikan ke siswa dengan NIS $nis.";
        $notifClass = "notif-berhasil";
    } else {
        $notifMessage = "Gagal memberikan token.";
        $notifClass = "notif-gagal";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Token</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }

        .notif-berhasil {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .notif-gagal {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border: 1px solid #f5c6cb;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .token-generated {
            background-color: #f0f0f0;
            color: #333;
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<?php if (isset($notifMessage)): ?>
    <div class="<?= $notifClass ?>">
        <?= $notifMessage ?>
    </div>
<?php endif; ?>

<h2>Tambah Token untuk Siswa</h2>
<form action="tambah_token.php" method="POST">
    <label for="nis">NIS Siswa:</label>
    <input type="text" name="nis" id="nis" required>
    <button type="submit">Berikan Token</button>
</form>

<?php if (!empty($tokenGenerated)): ?>
    <div class="token-generated">
        <strong>Token yang dihasilkan:</strong> <?= $tokenGenerated ?>
        <p>Token ini dapat diberikan kepada siswa untuk login.</p>
        <p>token ini hanya berlaku selama 10 menit</p>
    </div>
<?php endif; ?>

</body>
</html>
