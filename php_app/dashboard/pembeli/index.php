<!-- INI HALAMAN DASHBOARD USER -->
<?php
include "../../config/db.php";

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'pembeli') {
    header('Location: ../../auth/login/');
    exit();
}

// user sementara (prototype)
$id_user = $_SESSION['data']['id_user'];

$query = $conn->query("SELECT * FROM produk");
$produk_all = $query->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi IoT - Dashboard Pembeli</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">

    <!-- Style -->
    <link rel="stylesheet" href="/assets/style/global.css">
    <link rel="stylesheet" href="/assets/style/pembeli.css">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body>
    <!-- NAVBAR -->
    <?php include '../../includes/nav.php'; ?>
    <!-- NAVBAR END -->

    <!-- KONTEN -->
    <div class="content" id="content">
        <?php include '../../includes/pembeli_aside.php'; ?>
        <main>
            <!-- message -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert success">
                    <?= htmlspecialchars($_SESSION['message']) ?>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <!-- error -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert error">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            
            <section>
                <h1>Selamat Datang, <?= htmlspecialchars($_SESSION['data']['nama']) ?>!</h1>
                <hr class="line-break">
            </section>

            <section>
                <h2 class="mb-1">Daftar Produk Kami</h2>
                <div class="container" id="containerProduk">
                    <?php foreach ($produk_all as $produk) : ?>
                        <div class="card-toko" data-id="<?= htmlspecialchars($produk['id_produk']) ?>">
                            <div class="image-container">
                                <img src="../../assets/img/produk/<?= htmlspecialchars($produk['gambar']) ?>" alt="<?= htmlspecialchars($produk['nama_produk']) ?>">
                            </div>
                            <div class="desc">
                                <div class="top-desc">
                                    <h3><?= strtoupper($produk['nama_produk']) ?></h3>
                                    <p class="price-tag">Rp<?= number_format($produk['harga'], 0, ',', '.') ?></p>
                                </div>

                                <form action="/dashboard/pembeli/pesan.php" method="POST" class="form-pesan">
                                    <input type="hidden" name="id_produk" value="<?= htmlspecialchars($produk['id_produk']) ?>">

                                    <label class="lbl-jumlah">Jumlah Pesanan:</label>

                                    <div class="action-group">
                                        <div class="qty-selector">
                                            <button type="button" class="qty-btn minus" onclick="updateQty(this, -1)">
                                                <svg width="12" height="2" viewBox="0 0 12 2" fill="none">
                                                    <path d="M0 1H12" stroke="currentColor" stroke-width="2" />
                                                </svg>
                                            </button>

                                            <input type="number" id="jumlah-<?= htmlspecialchars($produk['id_produk']) ?>" name="jumlah" value="1" min="1" max="100" readonly>

                                            <button type="button" class="qty-btn plus" onclick="updateQty(this, 1)">
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                    <path d="M6 0V12M0 6H12" stroke="currentColor" stroke-width="2" />
                                                </svg>
                                            </button>
                                        </div>

                                        <button type="submit" class="btn-primary btn-block" name="pesan" onclick="return confirm('Apakah Anda yakin ingin memesan produk <?= htmlspecialchars($produk['nama_produk']) ?>')">
                                            Pesan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>
    </div>
    <!-- KONTEN END -->

    <script src="/assets/js/script.js"></script>
    <script>
        function updateQty(btn, change) {
            // Cari elemen input yang satu parent dengan tombol yang diklik
            const wrapper = btn.closest('.qty-selector');
            const input = wrapper.querySelector('input[type="number"]');

            // Ambil nilai saat ini
            let currentValue = parseInt(input.value) || 0;
            let min = parseInt(input.getAttribute('min')) || 1;
            let max = parseInt(input.getAttribute('max')) || 100;

            // Hitung nilai baru
            let newValue = currentValue + change;

            // Validasi agar tidak keluar batas min/max
            if (newValue >= min && newValue <= max) {
                input.value = newValue;
            }
        }
    </script>
</body>

</html>