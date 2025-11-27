<?php

if (isset($_GET['id'])) {
    $id_toko = $_GET['id'];
} else {
    // jika tidak ada id di URL, redirect ke halaman utama
    header("Location: ./");
    exit();
}

include "config/db.php";

// user sementara (prototype)
$id_user = 2;

// pesanan ampas kopi
$query = $conn->prepare("INSERT INTO pesanan (id_user, id_toko, status) VALUES (?, ?, 'Pending')");
$query->bind_param("ii", $id_user, $id_toko);
$query->execute();

if ($query->affected_rows > 0) {
    // jika berhasil, redirect ke halaman konfirmasi atau halaman lain yang sesuai
    header("Location: /konfirmasi/");
    exit();
} else {
    // jika gagal, tampilkan pesan error atau lakukan penanganan lain
    echo "Gagal membuat pesanan.";
}