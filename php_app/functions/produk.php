<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

function getAllProduk() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM produk");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function getProdukById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM produk WHERE id_produk = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function insertProduk($nama_produk, $harga, $stok, $gambar) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO produk (nama_produk, harga, stok, gambar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdis", $nama_produk, $harga, $stok, $gambar);
    return $stmt->execute();
}

function updateProduk($id, $nama_produk, $harga, $stok, $gambar) {
    global $conn;
    $stmt = $conn->prepare("UPDATE produk SET nama_produk = ?, harga = ?, stok = ?, gambar = ? WHERE id_produk = ?");
    $stmt->bind_param("sdisi", $nama_produk, $harga, $stok, $gambar, $id);
    return $stmt->execute();
}

function deleteProduk($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM produk WHERE id_produk = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}