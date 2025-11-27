<!-- GENERATE QR CODE -->
<?php
include '../config/db.php';

$id_user = 2; // Ganti dengan ID user yang sesuai
$query = $conn->prepare("SELECT * FROM pesanan
JOIN toko ON pesanan.id_toko = toko.id_toko
JOIN sensor ON toko.id_toko = sensor.id_toko
WHERE pesanan.id_user = ? AND pesanan.status = 'Pending' ORDER BY pesanan.id_pesanan DESC LIMIT 1");

$query->bind_param("i", $id_user);
$query->execute();
$result = $query->get_result();
$pesanan = $result->fetch_assoc();

if (!$pesanan) {
    // jika tidak ada pesanan, redirect ke halaman utama atau tampilkan pesan error
    header("Location: ../");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOPI IoT - Konfirmasi Pesanan</title>
    <link rel="stylesheet" href="assets/style/global.css">
    <link rel="stylesheet" href="assets/style/dashboard.css">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&display=swap" rel="stylesheet">
</head>

<body>
    <!-- NAVBAR -->
    <?php include '../includes/nav.php'; ?>
    <!-- NAVBAR END -->

    <main class="konfirmasi">
        <h1><?= htmlspecialchars($pesanan['nama_toko']) ?></h1>
        <div class="alamat-toko">
            <!-- icon -->
            <p>
                <svg width="15" height="30" viewBox="0 0 35 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.2083 23.3542C15.5784 23.3542 14.0151 22.7067 12.8626 21.5541C11.71 20.4015 11.0625 18.8383 11.0625 17.2083C11.0625 15.5784 11.71 14.0151 12.8626 12.8626C14.0151 11.71 15.5784 11.0625 17.2083 11.0625C18.8383 11.0625 20.4015 11.71 21.5541 12.8626C22.7067 14.0151 23.3542 15.5784 23.3542 17.2083C23.3542 18.0154 23.1952 18.8146 22.8863 19.5602C22.5775 20.3059 22.1248 20.9834 21.5541 21.5541C20.9834 22.1248 20.3059 22.5775 19.5602 22.8863C18.8146 23.1952 18.0154 23.3542 17.2083 23.3542ZM17.2083 0C12.6444 0 8.26739 1.81302 5.0402 5.0402C1.81302 8.26739 0 12.6444 0 17.2083C0 30.1146 17.2083 49.1667 17.2083 49.1667C17.2083 49.1667 34.4167 30.1146 34.4167 17.2083C34.4167 12.6444 32.6036 8.26739 29.3765 5.0402C26.1493 1.81302 21.7723 0 17.2083 0Z" fill="#684503" />
                </svg>
                <?= htmlspecialchars($pesanan['alamat']) ?>
            </p>
        </div>

        <!-- qr code -->
        <img src="/assets/img/qr-dummy.png" alt="QR Dummy">

        <h2>Terima kasih telah membeli pupuk di Kopi Iot!</h2>
        <p>Silakan tunjukkan QR code ini kepada penjual untuk konfirmasi pembelian Anda.</p>

        <div class="btn-group">
            <a href="#" class="btn-primary">
                <svg width="15" height="30" viewBox="0 0 35 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="icon" d="M17.2083 23.3542C15.5784 23.3542 14.0151 22.7067 12.8626 21.5541C11.71 20.4015 11.0625 18.8383 11.0625 17.2083C11.0625 15.5784 11.71 14.0151 12.8626 12.8626C14.0151 11.71 15.5784 11.0625 17.2083 11.0625C18.8383 11.0625 20.4015 11.71 21.5541 12.8626C22.7067 14.0151 23.3542 15.5784 23.3542 17.2083C23.3542 18.0154 23.1952 18.8146 22.8863 19.5602C22.5775 20.3059 22.1248 20.9834 21.5541 21.5541C20.9834 22.1248 20.3059 22.5775 19.5602 22.8863C18.8146 23.1952 18.0154 23.3542 17.2083 23.3542ZM17.2083 0C12.6444 0 8.26739 1.81302 5.0402 5.0402C1.81302 8.26739 0 12.6444 0 17.2083C0 30.1146 17.2083 49.1667 17.2083 49.1667C17.2083 49.1667 34.4167 30.1146 34.4167 17.2083C34.4167 12.6444 32.6036 8.26739 29.3765 5.0402C26.1493 1.81302 21.7723 0 17.2083 0Z" fill="#FFFAF1" />
                </svg>
                Buka di Maps
            </a>
            <a href="/" class="btn-secondary">
                Kembali ke Beranda
            </a>
        </div>
    </main>

    <!-- FOOTER -->
    <?php include '../includes/footer.php'; ?>
    <!-- FOOTER END -->
</body>

</html>