<?php
include "config/db.php";

if (isset($_POST['pesan'])) {
    require_once "../../functions/pesanan.php";
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];
} else {
    // jika tidak ada data yang dikirim, redirect kembali ke halaman sebelumnya
    header("Location: ../");
    exit();
}

$id_user = $_SESSION['data']['id_user'];

// pesanan ampas kopi
if (insertPesanan($id_user, $id_produk, $jumlah)) {
    $_SESSION['message'] = 'Pesanan berhasil dibuat.';
    header('Location: ./');
} else {
    $_SESSION['error'] = 'Error creating order.';
    header('Location: ./');
}