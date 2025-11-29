<!-- HALAMAN PENJUAL -->
<?php
include '../../config/db.php';
include '../../functions/toko.php';
include '../../functions/kesimpulan.php';

$volume_wadah = 9; //dalam ml/cm3

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'penjual') {
    header('Location: ../../auth/login/');
    exit();
}

$id_toko = getIdTokoByIdUser($_SESSION['data']['id_user']); // Ganti dengan ID toko yang sesuai
$query = $conn->prepare("SELECT * FROM sensor JOIN toko ON sensor.id_toko = toko.id_toko WHERE sensor.id_toko = ?");
$query->bind_param("i", $id_toko);
$query->execute();
$result = $query->get_result();
$json = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi IoT - Dashboard Penjual</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">

    <!-- Style -->
    <link rel="stylesheet" href="/assets/style/global.css">
    <link rel="stylesheet" href="/assets/style/penjual.css">

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&display=swap" rel="stylesheet">
</head>

<body>
    <!-- NAVBAR -->
    <?php include '../../includes/nav.php'; ?>
    <!-- NAVBAR END -->

    <main>
        <!-- NAVBAR V2 -->
        <!-- <div class="menu-nav" id="menu-nav">
            <ul>
                <li><a href="#" class="active" data-tab="status">Status</a></li>
                <li><a href="#" data-tab="penjualan">Penjualan</a></li>
            </ul>
        </div> -->
        <!-- NAVBAR V2 END -->

        <!-- STATUS CONTENT -->
        <div id="status" class="tab-content" style="display: block;">
            <h1>Selamat Datang, <?= $_SESSION['data']['nama'] ?>!</h1>
            <hr class="line-break">
            <h2 class="mb-1">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                <?= htmlspecialchars($json['nama_toko']) ?>
            </h2>
            <h3>Siap untuk mengumpulkan ampas kopi?</h3>

            <div class="summary-container">
                <div class="summary">
                    <h2>Status Ampas Kopi</h2>
                    <hr>
                    <?php
                    // menentukan status ampas kopi
                    if ($json['status'] == 'ready') {
                        $class_status = 'status-success';
                        $status_text = 'Siap Diambil';
                    } elseif ($json['status'] == 'almost ready') {
                        $class_status = 'status-warning';
                        $status_text = 'Hampir Siap';
                    } else {
                        $class_status = 'status-danger';
                        $status_text = 'Belum Siap';
                    }
                    ?>
                    <p class="badge-status <?= $class_status ?>"><?= htmlspecialchars($status_text) ?></p>
                    <p class="status-text"><?= kesimpulan($json['suhu'], $json['kelembapan'], $json['prediksi_selesai']) ?></p>
                    <?php
                    $prediksi_selesai = $json['prediksi_selesai'];
                    $prediksi_tanggal = date("d M Y", strtotime("+$prediksi_selesai days"));

                    if (empty($prediksi_selesai) || is_null($prediksi_selesai)) {
                        $prediksi_tanggal = "-";
                    }

                    if ($json['status'] == 'ready') {
                        $prediksi_tanggal = "Segera diambil oleh driver truk.";
                    }
                    ?>
                    <p><strong>Prediksi Siap Diambil:</strong> <?= htmlspecialchars($prediksi_tanggal) ?></p>
                    <div class="modal-toggler" id="modalToggler">
                        <p>Lihat Detail</p>
                    </div>

                    <!-- MODAL  -->
                    <div id="modal">
                        <div class="modal-content">
                            <div class="modal-heading">
                                <h2>Detail Status Ampas Kopi</h2>
                                <span class="close-button" id="closeModalBtn">&times;</span>
                            </div>
                            <div class="sensor-container">
                                <div class="sensor-box">
                                    <h3>Kelembaban</h3>
                                    <p><?= $json['kelembapan'] == '' ? '-' : htmlspecialchars($json['kelembapan']) ?> %</p>
                                </div>
                                <div class="sensor-box">
                                    <h3>Suhu</h3>
                                    <p><?= $json['suhu'] == '' ? '-' : htmlspecialchars($json['suhu']) ?> °C</p>
                                </div>
                                <div class="sensor-box">
                                    <h3>Volume</h3>
                                    <p><?= $json['volume'] == '' ? '-' : htmlspecialchars($json['volume']) ?> %</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($json['status'] == 'Ready') : ?>
                    <div class="info">
                        <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#000000"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                        <p>Ampas kopi sudah siap diambil oleh driver truk. Menunggu driver untuk mengambil ampas kopi.</p>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="summary">
                    <h2>Perkiraan Keuntungan</h2>
                    <hr>
                    <p class="keuntungan-text">Berdasarkan data volume pada ampas kopi, perkiraan keuntungan Anda untuk penyetoran ampas kopi adalah:</p>
                    <?php
                    // Dummy calculation for estimated profit
                    $estimated_profit = $volume_wadah * ($json['volume'] / 100) * 300; // Ganti dengan logika perhitungan
                    ?>
                    <p class="profit">Rp <?= number_format($estimated_profit, 0, ',', '.') ?></p>
                </div>
            </div>

            <section class="map">
                <h2 class="mb-1">Lokasi Tempat Sampah Ampas Kopi</h2>
                <?php if (!empty($json['lat']) && !empty($json['lng']) && !is_null($json['lat']) && !is_null($json['lng'])) : ?>
                    <iframe
                        height="450"
                        style="border:0; width: 100%;"
                        loading="lazy"
                        allowfullscreen
                        src="https://www.google.com/maps?q=<?= htmlspecialchars($json['lat']) ?>,<?= htmlspecialchars($json['lng']) ?>&z=15&output=embed">
                    </iframe>
                <?php else : ?>
                    <p>Lokasi tempat sampah belum tersedia.</p>
                <?php endif; ?>
            </section>
        </div>
        <!-- STATUS CONTENT END -->

        <!-- PENJUALAN CONTENT -->
        
        <!-- PENJUALAN CONTENT END -->
    </main>

    <script src="/assets/js/script.js"></script>
    <script>
        document.querySelectorAll("#menu-nav a").forEach(link => {
            console.log(link);
            link.addEventListener("click", function(e) {
                e.preventDefault();

                // RESET ACTIVE NAV
                document.querySelectorAll("#menu-nav a").forEach(a => a.classList.remove("active"));
                this.classList.add("active");

                // SWITCH TAB
                const tab = this.dataset.tab;
                document.querySelectorAll(".tab-content").forEach(c => c.style.display = "none");
                document.getElementById(tab).style.display = "block";
            });
        });

        // MODAL TOGGLER
        const modalToggler = document.getElementById("modalToggler");
        const modal = document.getElementById("modal");
        const closeModalBtn = document.getElementById("closeModalBtn");
        modalToggler.addEventListener("click", () => {
            console.log("clicked");
            modal.style.visibility = "visible";
            modal.style.opacity = "1";
            document.querySelector("#modal .modal-content").style.transform = "translateY(0)";
        });
        
        closeModalBtn.addEventListener("click", () => {
            document.querySelector("#modal .modal-content").style.transform = "translateY(-20px)";
            modal.style.visibility = "hidden";
            modal.style.opacity = "0";
        });
    </script>

</body>

</html>