<!-- HALAMAN PENJUAL -->
<?php
include '../../config/db.php';
include '../../functions/toko.php';
include '../../functions/kesimpulan.php';

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'penjual') {
    header('Location: ../../login/');
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
    <link rel="stylesheet" href="../../assets/style/global.css">
    <link rel="stylesheet" href="../../assets/style/penjual.css">

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
                    <p class="badge-status <?= $json['status'] == 'Ready' ? 'status-success' : 'status-danger' ?>"><?= $json['status'] == 'Ready' ? 'Siap Diambil' : 'Belum Siap' ?></p>
                    <p class="status-text"><?= kesimpulan($json['suhu'], $json['kelembapan'], $json['volume'], $json['prediksi_selesai']) ?></p>
                    <?php
                    $prediksi_selesai = $json['prediksi_selesai'];
                    $prediksi_tanggal = date("d M Y", strtotime("+$prediksi_selesai days"));

                    if (empty($prediksi_selesai) || is_null($prediksi_selesai)) {
                        $prediksi_tanggal = "-";
                    }
                    ?>
                    <p><strong>Prediksi Siap Diambil:</strong> <?= htmlspecialchars($prediksi_tanggal) ?></p>
                    <div class="modal-toggler">
                        <p>Lihat Detail</p>
                    </div>

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
                                    <p><?= $json['volume'] == '' ? '-' : htmlspecialchars($json['volume']) ?> g</p>
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
                    $estimated_profit = $json['volume'] * 2000; // Ganti dengan logika perhitungan
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
        <div id="penjualan" class="tab-content" style="display: none;">
            <h2>Daftar Pesanan</h2>
            <!-- daftar pesanan -->
            <div class="daftar-pesanan">
                <?php
                $query = $conn->prepare("SELECT *
                                        FROM pesanan p 
                                        JOIN users u ON p.id_user = u.id_user 
                                        WHERE p.id_toko = ? 
                                        ORDER BY p.waktu_pesanan DESC");
                $query->bind_param("i", $id_toko);
                $query->execute();
                $result = $query->get_result();

                $no = 1;
                while ($row = $result->fetch_assoc()) :
                ?>
                    <div class="pesanan">
                        <h3><?= htmlspecialchars($row['nama']) ?></h3>
                        <div class="pesanan-info">
                            <p><span class="status <?= strtolower(str_replace(' ', '-', $row['status'])) ?>"><?= htmlspecialchars($row['status']) ?></span></p>
                            <p><?= date("d-m-Y H:i", strtotime($row['waktu_pesanan'])) ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="chat-pembeli">
                <?php
                $query = $conn->prepare("SELECT u.id_user, u.nama, c.pesan, c.created_at
                                    FROM chat c
                                    JOIN users u ON c.id_pengirim = u.id_user OR c.id_penerima = u.id_user
                                    WHERE (c.id_pengirim = ? OR c.id_penerima = ?) AND u.role = 'pembeli'
                                    ORDER BY c.created_at DESC LIMIT 1");
                $query->bind_param("ii", $id_toko, $id_toko);
                $query->execute();
                $result = $query->get_result();

                while ($row = $result->fetch_assoc()) :
                ?>
                    <a href="/penjual/chat/?id=<?= htmlspecialchars($row['id_user']) ?>" class="chat-card">

                        <div class="chat-icon-container">
                            <svg viewBox="0 0 86 87" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M58.6364 31.6363C58.6364 35.8315 56.989 39.855 54.0566 42.8214C51.1242 45.7879 47.147 47.4545 43 47.4545C38.853 47.4545 34.8758 45.7879 31.9434 42.8214C29.011 39.855 27.3636 35.8315 27.3636 31.6363C27.3636 27.4411 29.011 23.4176 31.9434 20.4512C34.8758 17.4847 38.853 15.8181 43 15.8181C47.147 15.8181 51.1242 17.4847 54.0566 20.4512C56.989 23.4176 58.6364 27.4411 58.6364 31.6363ZM50.8182 31.6363C50.8182 33.7339 49.9945 35.7456 48.5283 37.2289C47.0621 38.7121 45.0735 39.5454 43 39.5454C40.9265 39.5454 38.9379 38.7121 37.4717 37.2289C36.0055 35.7456 35.1818 33.7339 35.1818 31.6363C35.1818 29.5387 36.0055 27.527 37.4717 26.0437C38.9379 24.5605 40.9265 23.7272 43 23.7272C45.0735 23.7272 47.0621 24.5605 48.5283 26.0437C49.9945 27.527 50.8182 29.5387 50.8182 31.6363Z" fill="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M43 0C19.2523 0 0 19.4761 0 43.5C0 67.5239 19.2523 87 43 87C66.7477 87 86 67.5239 86 43.5C86 19.4761 66.7477 0 43 0ZM7.81818 43.5C7.81818 51.765 10.6054 59.3735 15.2767 65.4161C18.5582 61.0587 22.7906 57.5273 27.6437 55.0976C32.4968 52.6679 37.8392 51.4055 43.2541 51.4091C48.5993 51.4028 53.8754 52.6314 58.6799 55.0013C63.4844 57.3712 67.6905 60.8197 70.9774 65.0839C74.3644 60.59 76.6449 55.3447 77.6302 49.7822C78.6155 44.2196 78.2773 38.4996 76.6436 33.0955C75.0098 27.6914 72.1275 22.7586 68.2351 18.7051C64.3427 14.6517 59.5521 11.5942 54.2597 9.78556C48.9673 7.97694 43.3252 7.46923 37.8004 8.30444C32.2755 9.13964 27.0266 11.2938 22.4881 14.5885C17.9496 17.8833 14.2518 22.224 11.7008 27.2515C9.1498 32.2791 7.81889 37.8488 7.81818 43.5ZM43 79.0909C34.9235 79.1041 27.0906 76.2933 20.8276 71.1344C23.3483 67.4828 26.7038 64.5014 30.6085 62.4441C34.5132 60.3867 38.8515 59.3143 43.2541 59.3182C47.6017 59.3143 51.8874 60.36 55.7553 62.3684C59.6232 64.3767 62.9615 67.2897 65.4929 70.8655C59.1816 76.1922 51.2194 79.1039 43 79.0909Z" fill="white" />
                            </svg>
                        </div>

                        <div class="chat-details">
                            <div class="chat-header">
                                <h3 class="chat-name"><?= htmlspecialchars($row['nama']) ?></h3>
                            </div>

                            <div class="chat-body">
                                <p class="chat-message"><?= htmlspecialchars($row['pesan']) ?></p>
                                <span class="chat-time"><?= date('H.i', strtotime($row['created_at'])) ?></span>
                            </div>
                        </div>

                        <?php if (true): ?>
                            <div class="chat-badge">1</div>
                        <?php endif; ?>

                    </a>
                <?php endwhile; ?>
            </div>
        </div>
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
        const modalToggler = document.querySelector(".modal-toggler");
        const modal = document.getElementById("modal");
        const closeModalBtn = document.getElementById("closeModalBtn");
        modalToggler.addEventListener("click", () => {
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