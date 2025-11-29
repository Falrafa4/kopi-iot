<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

function getAllPesanan() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM pesanan JOIN users ON pesanan.id_user = users.id_user JOIN produk ON pesanan.id_produk = produk.id_produk");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function getAllPesananById($id_user) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM pesanan JOIN produk ON pesanan.id_produk = produk.id_produk WHERE pesanan.id_user = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getPesananById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM pesanan WHERE id_pesanan = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function insertPesanan($id_user, $id_produk, $jumlah) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO pesanan (id_user, id_produk, qty) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $id_user, $id_produk, $jumlah);
    return $stmt->execute();
}

function updateStatusPesanan($id_pesanan, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE pesanan SET status = ? WHERE id_pesanan = ?");
    $stmt->bind_param("si", $status, $id_pesanan);
    return $stmt->execute();
}

function changeToSelesai($id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE pesanan SET status = 'selesai' WHERE id_pesanan = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function deletePesanan($id_pesanan) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM pesanan WHERE id_pesanan = ?");
    $stmt->bind_param("i", $id_pesanan);
    return $stmt->execute();
}