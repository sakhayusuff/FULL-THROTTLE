<?php
require 'koneksi.php';
$pesan = "";

if (isset($_POST['daftar'])) {
    // Sesuaikan dengan nama input di form lu
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $hp = mysqli_real_escape_string($koneksi, $_POST['nomor_hp']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // 1. CEK APAKAH EMAIL ATAU USERNAME SUDAH ADA
    // Kita cek username pakai variabel $nama karena di query nanti $nama jadi username
    $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email' OR username = '$nama'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        $pesan = "<p style='color: #d32f2f; text-align: center;'>Email atau Nama sudah terdaftar! Gunakan yang lain.</p>";
    } else {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        
        // 2. QUERY INSERT HARUS SESUAI KOLOM DATABASE FAISAL (nama, username, email, nomor_hp, password)
        // Pastikan lu sudah tambah kolom 'nomor_hp' manual di phpMyAdmin seperti instruksi sebelumnya
       $query = "INSERT INTO users (nama, username, email, nomor_hp, password) 
          VALUES ('$nama', '$nama', '$email', '$hp', '$password_hashed')";
        
        if (mysqli_query($koneksi, $query)) {
            $pesan = "<p style='color: #00e676; text-align: center;'>Pendaftaran berhasil! Silakan <a href='login.php' style='color:#ff5722;'>Login di sini</a>.</p>";
        } else {
            $pesan = "<p style='color: #d32f2f; text-align: center;'>Terjadi kesalahan: " . mysqli_error($koneksi) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - Go-Kart Racing Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="panel" style="max-width: 500px; margin: 50px auto;">
            <h2 class="panel-header" style="text-align: center;">🏁 RACER REGISTRATION</h2>
            <p class="panel-desc" style="text-align: center;">Daftarkan dirimu untuk memulai balapan</p>
            
            <?= $pesan; ?>

            <form action="" method="POST" class="license-form">
                <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required>
                <input type="number" name="nomor_hp" placeholder="Nomor HP" required>
                <input type="email" name="email" placeholder="Alamat Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="daftar">START ENGINE (DAFTAR)</button>
            </form>
            
            <p style="text-align: center; color: var(--text-color-muted); font-size: 14px; margin-top: 20px;">
                Sudah punya lisensi? <a href="login.php" style="color: var(--accent-orange); text-decoration: none;">Login ke Pit Lane</a>
            </p>
        </div>
    </div>
</body>
</html>