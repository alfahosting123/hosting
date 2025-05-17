<?php
session_start();
include '../database/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis = $_POST['nis'];
    $token = $_POST['token'];
    $password_baru = $_POST['password_baru'];

    // Cari siswa berdasarkan NIS
    $result = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis = '$nis'");
    
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // Cek token cocok
        if ($data['token'] === $token) {
            // Update password baru
            $update = mysqli_query($koneksi, "UPDATE siswa SET password = '$password_baru' WHERE nis = '$nis'");

            if ($update) {
                $notif = "Password berhasil diubah. Silakan login.";
                header("Location: login.php?notif=" . urlencode($notif));
                exit();
            } else {
                $error = "Gagal mengubah password. Silakan coba lagi.";
            }
        } else {
            $error = "Token salah. Minta token baru ke admin.";
        }
    } else {
        $error = "NIS tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<h2>Reset Password Siswa</h2>

<?php if (isset($error)): ?>
    <div class="error-message"><?= $error ?></div>
<?php endif; ?>

<form action="lupa_password.php" method="post">
    <label for="nis">NIS:</label>
    <input type="text" id="nis" name="nis" required>

    <label for="token">Token dari Admin:</label>
    <input type="text" id="token" name="token" required>

    <label for="password_baru">Password Baru:</label>
    <input type="password" id="password_baru" name="password_baru" required>

    <button type="submit">Ganti Password</button>
</form>

</body>
</html>
