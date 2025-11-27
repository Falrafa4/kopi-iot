<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

function getIdTokoByIdUser($id_user) {
    global $conn;
    $stmt = $conn->prepare("SELECT id_toko FROM toko WHERE id_penjual = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result ? $result['id_toko'] : null;
}

function hasTokoByIdUser($id_user) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM toko WHERE id_penjual = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'] > 0;
}

function getAllToko() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM toko");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function getTokoById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM toko WHERE id_toko = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function insertToko($nama_toko, $dekripsi_toko, $alamat, $gambar_toko, $lat, $lng, $id_penjual) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO toko (nama_toko, deskripsi_toko, alamat, gambar_toko, lat, lng, id_penjual) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssddi", $nama_toko, $dekripsi_toko, $alamat, $gambar_toko, $lat, $lng, $id_penjual);
    return $stmt->execute();
}

function searchTokoByName($name) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM toko WHERE nama_toko LIKE ?");
    $likeName = "%" . $name . "%";
    $stmt->bind_param("s", $likeName);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}