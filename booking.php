<?php
session_start();
require 'koneksi.php'; //

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$pesan_booking = "";
if (isset($_POST['book_now'])) {
    $nama = $_SESSION['nama_lengkap'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $sesi = $_POST['jumlah_sesi'];
    $tipe_hari = $_POST['tipe_hari']; // Didapat dari JS otomatis
    $total_harga = ($tipe_hari == "Weekend") ? ($sesi * 60000) : ($sesi * 50000);

    $pesan_booking = "
    <div class='success-msg'>
        🏁 <b>BOOKING BERHASIL!</b><br>
        Pembalap: $nama<br>
        Jadwal: $tanggal ($tipe_hari) jam $waktu<br>
        Total: Rp " . number_format($total_harga, 0, ',', '.') . " ($sesi Sesi)
    </div>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Booking - Full Throttle</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> </head>
<body>

<div class="container">
    <div class="hero" style="padding-bottom: 20px;">
        <h2 class="main-subtitle">RACE RESERVATION</h2>
        <h1 class="main-title">BOOK YOUR SESSION</h1>
    </div>

    <div class="panel" style="max-width: 600px; margin: 0 auto;">
        <?= $pesan_booking; ?>

        <form action="" method="POST" class="smart-booking-form">
            <div class="price-display">
                <div class="price-tag">
                    <span id="label-hari">Pilih Tanggal...</span>
                    <h2 id="display-harga">Rp -</h2>
                </div>
                <p id="info-sesi">Silakan tentukan jadwal balap Anda</p>
            </div>

            <input type="hidden" name="tipe_hari" id="tipe_hari_input">

            <div class="input-grid">
                <div class="field">
                    <label>TANGGAL BALAP</label>
                    <input type="date" name="tanggal" id="tanggal_input" required class="booking-input">
                </div>
                <div class="field">
                    <label>JAM START</label>
                    <input type="time" name="waktu" required class="booking-input">
                </div>
                <div class="field">
                    <label>JUMLAH SESI (5 Menit/Sesi)</label>
                    <input type="number" name="jumlah_sesi" id="sesi_input" min="1" value="1" required class="booking-input">
                </div>
            </div>

            <button type="submit" name="book_now" class="pro-book-btn">
                <span class="btn-text">CONFIRM BOOKING</span>
                <span class="btn-icon">🏎️</span>
            </button>
        </form>
    </div>
</div>

<script>
    const tanggalInput = document.getElementById('tanggal_input');
    const sesiInput = document.getElementById('sesi_input');
    const displayHarga = document.getElementById('display-harga');
    const labelHari = document.getElementById('label-hari');
    const tipeHariInput = document.getElementById('tipe_hari_input');

    function updateHarga() {
        const dateVal = new Date(tanggalInput.value);
        const sesi = sesiInput.value || 1;
        
        if (!isNaN(dateVal)) {
            const day = dateVal.getDay(); // 0 = Minggu, 6 = Sabtu
            const isWeekend = (day === 0 || day === 6);
            const hargaSatuan = isWeekend ? 60000 : 50000;
            const total = hargaSatuan * sesi;
            const tipe = isWeekend ? "Weekend" : "Weekday";

            labelHari.innerText = `Paket ${tipe}`;
            labelHari.style.color = isWeekend ? "#d32f2f" : "#00e676";
            displayHarga.innerText = `Rp ${total.toLocaleString('id-ID')}`;
            tipeHariInput.value = tipe;
        }
    }

    tanggalInput.addEventListener('change', updateHarga);
    sesiInput.addEventListener('input', updateHarga);
</script>

</body>
</html>