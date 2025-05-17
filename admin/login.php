<?php
session_start();
include '../database/koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $cek = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    $data = mysqli_fetch_assoc($cek);

    if ($data) {
        $_SESSION['admin'] = $data['id_admin'];
        header("Location: dashboard.php");
    } else {
        echo "Login gagal. Periksa username/password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
    <title>Login Admin</title>
</head>
<body>
    <form method="POST">
        <h2>Login Admin</h2>
        <input type="text" name="username" placeholder="Username Admin" required>
        <input type="password" name="password" placeholder="Password Admin" required>
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>
