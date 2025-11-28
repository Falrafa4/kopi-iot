<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

function getAllPesanan() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM pesanan JOIN users ON pesanan.id_user = users.id_user JOIN produk ON pesanan.id_produk = produk.id_produk");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function getPesananById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM pesanan WHERE id_pesanan = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function insertPesanan($nama_pesanan, $harga, $stok, $gambar) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO pesanan (nama_pesanan, harga, stok, gambar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdis", $nama_pesanan, $harga, $stok, $gambar);
    return $stmt->execute();
}

function updatePesanan($id, $nama_pesanan, $harga, $stok, $gambar) {
    global $conn;
    $stmt = $conn->prepare("UPDATE pesanan SET nama_pesanan = ?, harga = ?, stok = ?, gambar = ? WHERE id_pesanan = ?");
    $stmt->bind_param("sdisi", $nama_pesanan, $harga, $stok, $gambar, $id);
    return $stmt->execute();
}

function deletePesanan($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM pesanan WHERE id_pesanan = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}