<?php
// Menampilkan semua error PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Memeriksa jika data form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $pesan = isset($_POST['pesan']) ? $_POST['pesan'] : '';

    // Mengecek apakah form terisi dengan benar
    if (empty($nama) || empty($email) || empty($pesan)) {
        echo "<script>document.getElementById('formResponse').innerHTML = 'Semua field harus diisi!';</script>";
    } else {
        // Tentukan email tujuan
        $to = "apigratis6969@gmail.com"; // Ganti dengan email yang dituju
        $subject = "Laporan atau Pertanyaan dari $nama";
        
        // Membuat pesan email
        $message = "
        <html>
        <head>
          <title>Laporan atau Pertanyaan</title>
        </head>
        <body>
          <p><strong>Nama:</strong> $nama</p>
          <p><strong>Email:</strong> $email</p>
          <p><strong>Pesan:</strong></p>
          <p>$pesan</p>
        </body>
        </html>
        ";

        // Set headers untuk format HTML
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: $email" . "\r\n";

        // Kirim email
        if (mail($to, $subject, $message, $headers)) {
            echo "<script>document.getElementById('formResponse').innerHTML = 'Pesan berhasil dikirim!';</script>";
        } else {
            echo "<script>document.getElementById('formResponse').innerHTML = 'Gagal mengirim pesan. Silakan coba lagi.';</script>";
        }
    }
} else {
    echo "<script>document.getElementById('formResponse').innerHTML = 'Form tidak terkirim dengan benar.';</script>";
}
?>
