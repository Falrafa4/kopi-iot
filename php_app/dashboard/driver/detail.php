<!-- INI HALAMAN DETAIL TOKO -->
<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ./");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . "/config/db.php";

// user sementara (prototype)
$id_user = 2;

// get id toko dari parameter URL
$id_toko = $_GET['id'] ?? null;

// get toko detail
$query = $conn->prepare("SELECT * FROM toko WHERE id_toko = ?");
$query->bind_param("i", $id_toko);
$query->execute();
$result = $query->get_result();
$toko_detail = $result->fetch_assoc();

// get kompos detail
$query_kompos = $conn->prepare("SELECT * FROM sensor WHERE id_toko = ? ORDER BY id_sensor DESC LIMIT 1");
$query_kompos->bind_param("i", $id_toko);
$query_kompos->execute();
$result_kompos = $query_kompos->get_result();
$kompos_detail = $result_kompos->fetch_assoc();

// print_r($toko_detail);
// print_r($kompos_detail);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Toko - <?= htmlspecialchars($toko_detail['nama_toko']) ?></title>
    
    <link rel="stylesheet" href="../../assets/style/global.css">
    <link rel="stylesheet" href="../../assets/style/dashboard.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <!-- NAVBAR -->
    <?php include '../../includes/nav.php'; ?>
    <!-- NAVBAR END -->
    
    <main class="detail-page-wrapper">
        <div class="back-container">
            <a href="index.php" class="back-link">
                <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        <section class="detail-hero">
            <div class="detail-image">
                <img src="../../assets/img/<?= htmlspecialchars($toko_detail['gambar_toko']) ?>" alt="<?= htmlspecialchars($toko_detail['nama_toko']) ?>">
            </div>

            <div class="detail-info card-clean">
                <div class="header-info">
                    <h1><?= strtoupper($toko_detail['nama_toko']) ?></h1>
                    
                    <span class="badge-status <?= ($toko_detail['status_toko'] == 'Aktif') ? 'status-active' : 'status-inactive' ?>">
                        <?= ucfirst($toko_detail['status_toko']) ?>
                    </span>
                </div>

                <div class="address-info">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <p><?= htmlspecialchars($toko_detail['alamat']) ?></p>
                </div>

                <hr class="divider-soft">

                <div class="description">
                    <h3>Tentang Toko</h3>
                    <p><?= nl2br(htmlspecialchars($toko_detail['deskripsi_toko'])) ?></p>
                </div>

                <div class="kompos-status-box">
                    <h3>Status Kompos</h3>
                    
                    <?php if (!empty($kompos_detail) && !is_null($kompos_detail)) : ?>
                        <div class="sensor-grid">
                            <div class="sensor-item">
                                <span class="label">Berat</span>
                                <span class="value"><?= htmlspecialchars($kompos_detail['volume']) ?> Kg</span>
                            </div>
                            <div class="sensor-item">
                                <span class="label">Kelembaban</span>
                                <span class="value"><?= htmlspecialchars($kompos_detail['kelembapan']) ?>%</span>
                            </div>
                            <div class="sensor-item">
                                <span class="label">Status</span>
                                <?php 
                                    $statusClass = 'status-not-ready';
                                    if(strtolower($kompos_detail['status']) == 'ready') {
                                        $statusClass = 'status-ready';
                                    }
                                ?>
                                <span class="value <?= $statusClass ?>"><?= htmlspecialchars($kompos_detail['status']) ?></span>
                            </div>
                        </div>

                        <!-- <div class="action-buttons">
                            <?php if (strtolower($kompos_detail['status']) == 'Ready') : ?>
                                <button class="btn-primary">Beli Sekarang</button>
                                <button class="btn-secondary">Chat Penjual</button>
                            <?php else : ?>
                                <button class="btn-primary-disabled" disabled>Beli Sekarang</button>
                                <button class="btn-secondary">Chat Penjual</button>
                            <?php endif; ?>
                        </div> -->

                    <?php else : ?>
                        <div class="empty-state">
                            <p><em>Data sensor kompos belum tersedia saat ini.</em></p>
                        </div>
                        <!-- <div class="action-buttons">
                            <button class="btn-primary-disabled" disabled>Beli Sekarang</button>
                            <button class="btn-secondary-disabled" disabled>Chat Penjual</button>
                        </div> -->
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="location-section">
            <h2 class="section-title">Lokasi Pengambilan</h2>
            <div class="map-container card-clean">
                <?php if (!empty($kompos_detail) && !is_null($kompos_detail)) : ?>
                    <iframe
                        width="100%"
                        height="450"
                        style="border:0;"
                        loading="lazy"
                        allowfullscreen
                        src="https://www.google.com/maps?q=<?= htmlspecialchars($kompos_detail['lat']) ?>,<?= htmlspecialchars($kompos_detail['lng']) ?>&z=15&output=embed">
                    </iframe>
                <?php else : ?>
                    <div class="map-placeholder">
                        <p>Lokasi peta belum tersedia.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <?php include '../../includes/footer.php'; ?>
    <!-- FOOTER END -->
    
    <script src="assets/js/script.js"></script>
</body>
</html>