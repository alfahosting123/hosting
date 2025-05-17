<?php
session_start();
include '../database/koneksi.php';

// Cek apakah ada notifikasi berhasil login di URL
if (isset($_GET['notif']) && $_GET['notif'] == 'login_berhasil') {
    $notifMessage = 'Login berhasil! Selamat datang.';
    $notifClass = 'notif-berhasil';
} else {
    $notifMessage = '';
    $notifClass = '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis = $_POST['nis'];
    $password = $_POST['password'];
    $token = $_POST['token'];

    // Cari siswa berdasarkan NIS saja
    $result = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis = '$nis'");
    
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // Cek password dan token manual
        if ($data['password'] === $password && $data['token'] === $token) {
            $_SESSION['siswa'] = $data;
            header('Location: dashboard.php?notif=login_berhasil');
            exit();
        } else {
            $errorMessage = 'Password atau token salah.';
        }
    } else {
        $errorMessage = 'NIS tidak terdaftar.';
    }
}
// Setting header agar tidak cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }

        .notif-berhasil {
            background-color: #d4edda; /* Hijau muda */
            color: #155724; /* Warna hijau gelap */
            padding: 10px;
            border: 1px solid #c3e6cb;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
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

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="text"] {
            margin-bottom: 10px;
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

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<?php if (!empty($notifMessage)): ?>
    <div class="<?= $notifClass ?>">
        <?= $notifMessage ?>
    </div>
<?php endif; ?>

<?php if (isset($errorMessage)): ?>
    <div class="error-message">
        <?= $errorMessage ?>
    </div>
<?php endif; ?>

<h2>Login Siswa</h2>

<form action="login.php" method="post">
    <label for="nis">NIS:</label>
    <input type="text" id="nis" name="nis" required><br><br>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="token">Token:</label>
    <input type="text" id="token" name="token" required><br><br>
    
    <button type="submit">Login</button>
</form>
<p style="text-align: center; margin-top: 10px;">
    <a href="lupa_password.php">Lupa Password?</a>
</p>

</body>
</html>
