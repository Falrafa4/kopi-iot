<?php
include "../../../config/db.php";

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'admin') {
    header('Location: ../../../auth/login/');
    exit();
}

// --- QUERY DATA UNTUK REPORT ---

// A. Menghitung Total Keuntungan
$sql_profit = "SELECT SUM(keuntungan_value) * 9072 as total FROM keuntungan WHERE keuntungan_key = 'Admin'";
$result_profit = $conn->query($sql_profit);
$row_profit = $result_profit->fetch_assoc();
$total_profit = $row_profit['total'] ?? 0;

// B. Menghitung Status Kompos (Siap Panen)
// Mengambil data dari tabel 'sensor' dimana status = 'ready'
$sql_ready = "SELECT COUNT(*) as total_ready FROM sensor WHERE status = 'ready'";
$result_ready = $conn->query($sql_ready);
$row_ready = $result_ready->fetch_assoc();
$total_ready = $row_ready['total_ready'] ?? 0;

// C. Menghitung Pesanan Selesai
$sql_orders = "SELECT COUNT(*) as total_selesai FROM pesanan WHERE status = 'Selesai'";
$result_orders = $conn->query($sql_orders);
$row_orders = $result_orders->fetch_assoc();
$total_orders = $row_orders['total_selesai'] ?? 0;

// D. Mengambil Data Tabel Detail (Contoh: Monitoring Toko & Sensor)
// Kita join tabel sensor dan toko untuk tahu toko mana yang komposnya siap
$sql_tabel = "
    SELECT t.nama_toko, s.nama_sensor, s.suhu, s.kelembapan, s.status, s.prediksi_selesai 
    FROM sensor s
    JOIN toko t ON s.id_toko = t.id_toko
    ORDER BY s.waktu_update DESC
    LIMIT 10
";
$result_tabel = $conn->query($sql_tabel);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Admin - KOPI IoT</title>

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
        main h1 {
            color: var(--primary-color);
            font-weight: 300;
            margin-bottom: 30px;
            font-size: 2.5rem;
        }

        h2.section-title {
            color: var(--text-dark);
            font-size: 1.2rem;
            margin-bottom: 15px;
            border-left: 5px solid var(--primary-color);
            padding-left: 10px;
        }

        /* Cards Statistik */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            background: var(--white);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-top: 4px solid var(--primary-color);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin: 0;
            font-size: 0.9rem;
            color: #8d6e63;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card .value {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin: 10px 0;
        }

        .card .desc {
            font-size: 0.8rem;
            color: #999;
        }

        /* Style Khusus Card Keuntungan (Biar menonjol) */
        .card.profit {
            border-top-color: var(--gold);
        }

        .card.profit .value {
            color: #d89614;
        }

        /* Tabel Data */
        .table-container {
            background: var(--white);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #fff8e1;
            /* Kuning sangat muda */
            color: var(--primary-color);
            font-weight: 600;
        }

        tr:hover {
            background-color: #fafafa;
        }

        /* Status Badges */
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .badge-ready {
            background-color: #c8e6c9;
            color: #2e7d32;
        }

        /* Hijau */
        .badge-process {
            background-color: #fff9c4;
            color: #f9a825;
        }

        /* Kuning */
        .badge-not {
            background-color: #ffcdd2;
            color: #c62828;
        }

        /* Merah */

        /* Tombol Print */
        .btn-print {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            cursor: pointer;
            float: right;
            margin-top: -60px;
            /* Hack dikit biar sejajar judul */
        }

        .btn-print:hover {
            background-color: #3e2723;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <?php include '../../../includes/nav.php'; ?>
    <!-- NAVBAR END -->

    <div class="content" id="content">
        <?php include '../../../includes/admin_aside.php'; ?>
        <main>
            <section>
                <h1>Laporan Sistem</h1>
                <button class="btn-print" onclick="window.print()">Cetak Laporan</button>
        
                <div class="stats-container">
                    <div class="card profit">
                        <h3>Perkiraan Pendapatan</h3>
                        <div class="value">Rp <?= number_format($total_profit, 0, ',', '.') ?></div>
                        <div class="desc">Akumulasi seluruh waktu</div>
                    </div>
        
                    <div class="card">
                        <h3>Ampas Siap Diolah</h3>
                        <div class="value"><?= $total_ready ?> <span style="font-size:1rem">Unit</span></div>
                        <div class="desc">Siap diolah lebih lanjut</div>
                    </div>
        
                    <div class="card">
                        <h3>Pesanan Selesai</h3>
                        <div class="value"><?= $total_orders ?></div>
                        <div class="desc">Transaksi berhasil diproses</div>
                    </div>
                </div>
        
                <h2 class="section-title">Monitoring Kondisi Kompos Terkini</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Toko</th>
                                <th>Sensor</th>
                                <th>Suhu (°C)</th>
                                <th>Kelembapan (%)</th>
                                <th>Status</th>
                                <th>Prediksi Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result_tabel->num_rows > 0): ?>
                                <?php while ($row = $result_tabel->fetch_assoc()): ?>
                                    <?php
                                    // Logic warna badge status
                                    $status_class = 'badge-not';
                                    if ($row['status'] == 'ready') $status_class = 'badge-ready';
                                    elseif ($row['status'] == 'almost ready') $status_class = 'badge-process';
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['nama_toko']) ?></td>
                                        <td><?= htmlspecialchars($row['nama_sensor']) ?></td>
                                        <td><?= $row['suhu'] ?>°C</td>
                                        <td><?= $row['kelembapan'] ?>%</td>
                                        <td><span class="badge <?= $status_class ?>"><?= ucfirst($row['status']) ?></span></td>
                                        <td><?= $row['prediksi_selesai'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align:center">Belum ada data sensor.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script src="/assets/js/script.js"></script>
</body>

</html>