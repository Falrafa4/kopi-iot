<!-- INI HALAMAN DASHBOARD ADMIN -->
<?php
include "../../config/db.php";

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'admin') {
    header('Location: ../../auth/login/');
    exit();
}

$count_toko_query = "SELECT COUNT(*) AS total_toko FROM toko";
$result_toko = $conn->query($count_toko_query);
$total_toko = $result_toko->fetch_assoc()['total_toko'];

$count_users_query = "SELECT COUNT(*) AS total_users FROM users WHERE role IN ('penjual', 'pembeli', 'driver')";
$result_users = $conn->query($count_users_query);
$total_users = $result_users->fetch_assoc()['total_users'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi IoT - Dashboard Admin</title>
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">

    <!-- Style -->
    <link rel="stylesheet" href="/assets/style/global.css">
    <link rel="stylesheet" href="/assets/style/admin.css">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        /* ========================================= */
        /* SECTION ADMIN DASHBOARD HOME START        */
        /* ========================================= */

        /* 1. Metric Cards Grid */
        .metrics-grid {
            display: grid;
            /* 4 kolom di desktop */
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .metric-card {
            background-color: #fff;
            padding: 1.5rem 2rem;
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            border-left: 5px solid;
            /* Garis vertikal sebagai aksen */
        }

        .metric-card h3 {
            font-size: 1.2rem;
            color: #5c5c5c;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .metric-card .value {
            display: block;
            font-family: 'Gilda Display', serif;
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .metric-card .description {
            font-size: 0.85rem;
            color: #5c5c5c;
            margin-top: 0.5rem;
        }

        /* Warna Aksen Card */
        .metric-card.primary {
            border-left-color: var(--primary-color);
        }

        .metric-card.warning {
            border-left-color: #eab308;
        }

        /* Kuning */
        .metric-card.success {
            border-left-color: #27ae60;
        }

        /* Hijau */
        .metric-card.info {
            border-left-color: #3498db;
        }

        /* Biru */


        /* 2. Charts and Maps Grid (2 Kolom) */
        .charts-maps-grid {
            display: grid;
            /* Layout fleksibel: 2 kolom untuk grafik dan log */
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .card-box {
            background-color: #fff;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(104, 69, 3, 0.05);
        }

        .card-box h3 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .card-box.full-width {
            grid-column: 1 / -1;
        }

        /* 3. Activity List */
        .activity-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .activity-list li {
            padding: 0.8rem 1rem;
            border-radius: 8px;
            background-color: var(--secondary-color);
            border-left: 4px solid #ccc;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            color: #5c5c5c;
            transition: background-color 0.2s;
        }

        .activity-list li:hover {
            background-color: #f5f5f5;
        }

        .activity-list .badge {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 4px;
            color: #fff;
            flex-shrink: 0;
        }

        .badge.success {
            background-color: #27ae60;
        }

        .badge.error {
            background-color: #c0392b;
        }

        .badge.info {
            background-color: #3498db;
        }


        /* Responsive Fixes */
        @media (max-width: 768px) {
            .charts-maps-grid {
                grid-template-columns: 1fr;
                /* Tumpuk vertikal di HP */
            }
        }

        /* ========================================= */
        /* SECTION ADMIN DASHBOARD HOME END          */
        /* ========================================= */
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <?php include '../../includes/nav.php'; ?>
    <!-- NAVBAR END -->

    <!-- KONTEN -->
    <div class="content" id="content">
        <?php include '../../includes/admin_aside.php'; ?>
        <main>
            <section>
                <h1>Selamat Datang, <?= htmlspecialchars($_SESSION['data']['nama']) ?>!</h1>
                <hr class="line-break">
            </section>

            <section class="admin-metrics mb-4">
                <h2>Status Sistem</h2>
                <div class="metrics-grid">
                    <div class="metric-card primary">
                        <h3>Total Toko Aktif</h3>
                        <span class="value"><?= htmlspecialchars($total_toko) ?></span>
                        <p class="description">Penyedia ampas terdaftar</p>
                    </div>
                    <div class="metric-card warning">
                        <h3>Pengguna Aktif</h3>
                        <span class="value"><?= htmlspecialchars($total_users) ?></span>
                        <p class="description">Total pengguna aktif KOPI IoT (Penjual, pembeli, driver)</p>
                    </div>
                </div>
            </section>

            <!-- <section class="admin-charts-maps">
                <h2 class="mb-3">Logistik & Pemantauan</h2>
                <div class="charts-maps-grid">

                    <div class="card-box full-width">
                        <h3>Peta Lokasi Sampah Kritis</h3>
                        <iframe
                            height="400"
                            style="border:0; width: 100%; border-radius: 12px;"
                            loading="lazy"
                            allowfullscreen
                            src="https://www.google.com/maps?q=-7.4461,112.7183&z=15&output=embed">
                        </iframe>
                    </div>

                    <div class="card-box">
                        <h3>Tren Pengiriman (6 Bulan)</h3>
                        <div class="chart-placeholder" style="height: 300px; background-color: #f7f7f7; border-radius: 8px;">
                            <p style="padding: 20px; text-align: center; color: #888;">Area Grafik Batang / Garis</p>
                        </div>
                    </div>

                    <div class="card-box">
                        <h3>Aktivitas Terbaru</h3>
                        <ul class="activity-list">
                            <li><span class="badge success">LOG</span> Driver C menyelesaikan pengiriman.</li>
                            <li><span class="badge error">KRITIS</span> Toko B status sensor: Penuh.</li>
                            <li><span class="badge info">BARU</span> User Penjual baru mendaftar.</li>
                        </ul>
                    </div>

                </div>
            </section> -->
        </main>
    </div>
    <!-- KONTEN END -->

    <script src="../../assets/js/script.js"></script>
    <script src="/dummy/dummy_sender.js"></script>
</body>

</html>