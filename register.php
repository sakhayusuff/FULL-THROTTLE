<?php
require 'koneksi.php';
$pesan = "";

if (isset($_POST['daftar'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $hp = mysqli_real_escape_string($koneksi, $_POST['nomor_hp']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Cek apakah email sudah terdaftar
    $cek_email = mysqli_query($koneksi, "SELECT email FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($cek_email) > 0) {
        $pesan = "<p style='color: #d32f2f; text-align: center;'>Email sudah terdaftar! Gunakan email lain.</p>";
    } else {
        // Enkripsi password untuk keamanan
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        
        // Masukkan data ke database
        $query = "INSERT INTO users (nama_lengkap, nomor_hp, email, password) VALUES ('$nama', '$hp', '$email', '$password_hashed')";
        
        if (mysqli_query($koneksi, $query)) {
            $pesan = "<p style='color: #00e676; text-align: center;'>Pendaftaran berhasil! Silakan <a href='login.php' style='color:#ff5722;'>Login di sini</a>.</p>";
        } else {
            $pesan = "<p style='color: #d32f2f; text-align: center;'>Terjadi kesalahan sistem.</p>";
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