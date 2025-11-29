<!-- INI HALAMAN DASHBOARD DRIVER -->
<?php
include "../../config/db.php";
include "../../functions/keuntungan.php";

if (!isset($_SESSION['data']) || $_SESSION['data']['role'] != 'driver') {
    header('Location: ../../login/');
    exit();
}

// keuntungan driver
$keuntungan_driver = getKeuntunganByName('Driver');

// user sementara (prototype)
$id_user = $_SESSION['data']['id_user'];

// Fetch semua toko
$query = $conn->query("SELECT * FROM toko");
$toko_all = $query->fetch_all(MYSQLI_ASSOC);

// Fetch notifikasi
$query_notif = $conn->query("SELECT toko.id_toko, toko.nama_toko, sensor.status, sensor.prediksi_selesai
FROM sensor
JOIN toko ON sensor.id_toko = toko.id_toko
ORDER BY
    CASE status
        WHEN 'ready' THEN 1
        WHEN 'almost ready' THEN 2
        WHEN 'not ready' THEN 3
        ELSE 4
    END,
    CASE 
        WHEN status = 'not ready' THEN prediksi_selesai
        ELSE waktu_update
    END ASC;");
$notifikasi = $query_notif->fetch_all(MYSQLI_ASSOC);

// fetch data pengambilan driver
$query_driver = $conn->prepare("SELECT * FROM driver WHERE id_user = ?");
$query_driver->bind_param("i", $id_user);
$query_driver->execute();
$result_driver = $query_driver->get_result();
$driver = $result_driver->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi IoT - Dashboard Driver</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">

    <!-- Style -->
    <link rel="stylesheet" href="/assets/style/global.css">
    <link rel="stylesheet" href="/assets/style/driver.css">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        #home {
            scroll-margin-top: 15rem;
            /* tinggi navbar */
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <?php include '../../includes/nav.php'; ?>
    <!-- NAVBAR END -->

    <!-- KONTEN -->
    <main>
        <!-- NAVBAR V2 -->
        <div class="menu-nav" id="menu-nav">
            <ul>
                <li><a href="#" class="active" data-tab="home">Home</a></li>
                <li><a href="#" data-tab="profile">Profile</a></li>
            </ul>
        </div>
        <!-- NAVBAR V2 END -->

        <div id="home" class="tab-content">
            <section>
                <h1>Selamat Datang, <?= htmlspecialchars($_SESSION['data']['nama']) ?>!</h1>
                <hr class="line-break">
            </section>

            <section class="sampah-notif" id="mapSampah">
                <!-- <h2 class="mb-1">Lokasi Tempat Sampah Ampas Kopi</h2> -->
                <div class="container-sampah-notif">
                    <div class="notification">
                        <h2 class="mb-1">Notifikasi Terbaru</h2>
                        <p>Siap ambil ampas kopi?</p>
                        <ul>
                            <?php
                            if (empty($notifikasi)) {
                                echo "<li>Tidak ada notifikasi baru.</li>";
                            }

                            foreach ($notifikasi as $notif) :
                                if ($notif['status'] == 'almost ready'):
                                    $class = 'warning';
                                    $message = "Ampas kopi di <strong>" . htmlspecialchars($notif['nama_toko']) . "</strong> hampir siap.";
                                elseif ($notif['status'] == 'ready'):
                                    $class = 'success';
                                    $message = "Ampas kopi di <strong>" . htmlspecialchars($notif['nama_toko']) . "</strong> sudah penuh. Segera diambil.";
                                else:
                                    $class = 'danger';
                                    $message = "Ampas kopi di <strong>" . htmlspecialchars($notif['nama_toko']) . "</strong> belum siap diambil. Prediksi penuh dalam waktu dekat: " . htmlspecialchars($notif['prediksi_selesai']) . " hari.";
                                endif;
                            ?>
                                <li class='notif-card <?= $class ?>' data-id="<?= htmlspecialchars($notif['id_toko']) ?>"><?= $message ?></li>
                            <?php
                            endforeach;
                            ?>
                        </ul>
                    </div>
                    <?php
                    foreach ($notifikasi as $notif) :
                    ?>

                    <?php endforeach; ?>
                    <div class="map-sampah" id="map-sampah">
                        <div class="placeholder" id="map-placeholder">
                            <p>Map Akan muncul di sini</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="pengambilan">
                <h2 class="mb-1">Jumlah Ampas Yang Telah Diambil</h2>
                <p><?= $driver['total_volume'] ?> mL</p>
            </section>

            <section>
                <h2 class="mb-1">Daftar Toko Penyedia Ampas Kopi</h2>
                <div class="container" id="containerToko">
                    <?php foreach ($toko_all as $toko) : ?>
                        <div href="detail.php?id=<?= htmlspecialchars($toko['id_toko']) ?>" class="card-toko" data-id="<?= htmlspecialchars($toko['id_toko']) ?>">
                            <div class="image-container">
                                <img src="../../assets/img/toko/<?= htmlspecialchars($toko['gambar_toko']) ?>" alt="Kafe 1">
                            </div>
                            <div class="desc">
                                <h3><?= strtoupper($toko['nama_toko']) ?></h3>
                                <p><?= htmlspecialchars($toko['alamat']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="keteranganToko">
                </div>
            </section>
        </div>

        <div id="profile" class="tab-content">
            <h1>Profile Driver</h1>
            <hr class="line-break">

            <div class="profile-card">
                <h2 class="driver-name"><?= htmlspecialchars($_SESSION['data']['nama']) ?></h2>
                <p><strong>Username:</strong> <?= htmlspecialchars($_SESSION['data']['username']) ?></p>
                <p><strong>Role:</strong> <?= htmlspecialchars($_SESSION['data']['role']) ?></p>
                <p class="badge-status status-active" style="width: fit-content;">Status: Aktif</p>
            </div>

            <h2 class="mt-4">Kinerja & Pendapatan</h2>
            <div class="performance-metrics">
                <div class="metric-card today primary">
                    <h3>Pendapatan Hari Ini</h3>
                    <span class="metric-value">Rp <?= number_format($keuntungan_driver['keuntungan_value'] * $driver['total_volume'], 0, ',', '.') ?></span>
                    <p class="metric-detail">Dari <?= $driver['total_volume'] ?> mL Ampas Kopi</p>
                </div>

                <div class="metric-card monthly warning">
                    <h3>Total Volume Bulan Ini</h3>
                    <span class="metric-value"><?= $driver['total_volume'] ?> mL</span>
                    <p class="metric-detail">Sama dengan Rp <?= number_format($keuntungan_driver['keuntungan_value'] * $driver['total_volume'], 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
    </main>
    <!-- KONTEN END -->

    <!-- FOOTER -->
    <?php include '../../includes/footer.php'; ?>
    <!-- FOOTER END -->

    <!-- <script src="../../assets/js/script.js"></script> -->
    <script>
        document.querySelectorAll("#menu-nav a").forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault();

                // RESET ACTIVE NAV
                document.querySelectorAll("#menu-nav a").forEach(a => a.classList.remove("active"));
                this.classList.add("active");

                // SWITCH TAB
                const tab = this.dataset.tab;
                document.querySelectorAll(".tab-content").forEach(c => c.style.display = "none");
                document.getElementById(tab).style.display = "block";

                // UPDATE URL HASH TANPA SCROLL
                history.replaceState(null, null, "#" + tab);
                window.scrollTo(0, 0); // 🔥 cegah scroll otomatis
            });
        });

        window.addEventListener("DOMContentLoaded", () => {
            const hash = location.hash.replace("#", "");

            if (hash) {
                const link = document.querySelector(`#menu-nav a[data-tab="${hash}"]`);
                if (link) link.click();
            } else {
                document.querySelector("#menu-nav a").click();
            }
        });


        const searchInput = document.getElementById("search");
        const container = document.querySelector(".container");

        // searchInput.addEventListener("keyup", function() {
        //     const containerToko = document.getElementById("containerToko");
        //     // get lokasi container toko
        //     window.scrollTo(0, containerToko.offsetTop - 200);
        //     let keyword = this.value;

        //     fetch(`../../api/search_toko.php?keyword=${keyword}`)
        //         .then(res => res.json())
        //         .then(data => {
        //             container.innerHTML = ""; // reset

        //             if (data.length === 0) {
        //                 container.innerHTML = "<p>Toko tidak ditemukan</p>";
        //                 return;
        //             }

        //             data.forEach(toko => {
        //                 container.innerHTML += `
        //                     <div class="card-toko" data-id="${toko.id_toko}">
        //                         <div class="image-container">
        //                             <img src="../../assets/img/${toko.gambar_toko}" alt="${toko.nama_toko}">
        //                         </div>
        //                         <div class="desc">
        //                             <h3>${toko.nama_toko.toUpperCase()}</h3>
        //                             <p>${toko.alamat}</p>
        //                         </div>
        //                     </div>
        //                 `;
        //             });

        //             // panggil ulang event click pada card
        //             attachCardClick();
        //         });
        // });

        function attachNotifClick() {
            const cards = document.querySelectorAll('.notif-card');

            cards.forEach(card => {
                card.addEventListener('click', () => {
                    const tokoId = card.getAttribute('data-id');

                    // Hapus class active dari semua card
                    cards.forEach(c => c.classList.remove('active'));

                    // Tambahkan class active ke card yang diklik
                    card.classList.add('active');

                    fetch(`../../api/get_map_toko.php?id=${tokoId}`)
                        .then(response => response.json())
                        .then(data => {
                            const mapPlaceholder = document.getElementById('map-placeholder');

                            // Default: hanya lokasi toko
                            let mapSrc = `https://www.google.com/maps?q=${data.lat},${data.lng}&z=15&output=embed`;

                            // Masukkan iframe terlebih dahulu
                            mapPlaceholder.innerHTML = `
                        <iframe
                            id="mapFrame"
                            width="600"
                            height="450"
                            style="border:0;"
                            loading="lazy"
                            allowfullscreen
                            src="${mapSrc}">
                        </iframe>
                    `;

                            // Setelah iframe dibuat → ambil lokasi user
                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition(pos => {
                                    const userLat = pos.coords.latitude;
                                    const userLng = pos.coords.longitude;

                                    // Update iframe dengan 2 marker:
                                    // merah = toko, biru = user
                                    const frame = document.getElementById("mapFrame");
                                    frame.src =
                                        `https://www.google.com/maps?q=${data.lat},${data.lng}&z=15&output=embed` +
                                        `&markers=color:red|${data.lat},${data.lng}` +
                                        `&markers=color:blue|${userLat},${userLng}`;
                                }, err => {
                                    console.log("User tolak GPS:", err.message);
                                    // Kalau ditolak → tetap tampil lokasi toko saja
                                });
                            }
                        });
                });
            });
        }


        function attachCardClick() {
            document.querySelectorAll('.card-toko').forEach(card => {
                card.addEventListener('click', () => {
                    const tokoId = card.getAttribute('data-id');

                    fetch(`../../api/get_detail_toko.php?id=${tokoId}`)
                        .then(response => response.json())
                        // ... kode sebelumnya ...
                        .then(data => {
                            const output = document.getElementById('keteranganToko');

                            // Hapus style inline manual, gunakan class CSS
                            output.removeAttribute('style');

                            // Isi konten
                            output.innerHTML = `
                                <h1 class='mb-2'>Detail Toko</h1>
                                <div class="container-detail-toko">
                                    <iframe
                                        id="mapFrame"
                                        style="border:0; width: 50%;"
                                        loading="lazy"
                                        allowfullscreen
                                        src="https://www.google.com/maps?q=${data.lat},${data.lng}&z=15&output=embed">
                                    </iframe>
                                    <div class="desc-toko">
                                        <img src="../../assets/img/toko/${data.gambar_toko}" alt="${data.nama_toko}">
                                        <h2>${data.nama_toko}</h2>
                                        <p>${data.deskripsi_toko}</p>
                                        <a href="detail.php?id=${tokoId}" class="see-more">Lihat Selengkapnya</a>
                                    </div>
                                </div>
                            `;

                            // Tambahkan class active untuk memicu animasi CSS
                            // Kita pakai timeout sedikit agar transisi terbaca browser
                            setTimeout(() => {
                                output.classList.add('active');
                            }, 100);

                            output.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        });
                    // ... kode setelahnya ...

                });
            });
        }

        attachNotifClick();
        attachCardClick();
    </script>
</body>

</html>