<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

function getAllKeuntungan()
{
    global $conn;
    $stmt = $conn->query("SELECT * FROM keuntungan");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function getKeuntunganById($id)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM keuntungan WHERE id_keuntungan = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function insertKeuntungan($keuntungan_key, $keuntungan_value, $satuan, $keterangan = null)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO keuntungan (keuntungan_key, keuntungan_value, satuan, keterangan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $keuntungan_key, $keuntungan_value, $satuan, $keterangan);
    return $stmt->execute();
}

function updateKeuntungan($id, $keuntungan_key, $keuntungan_value, $satuan, $keterangan)
{
    // waktu indonesia barat
    date_default_timezone_set('Asia/Jakarta');
    $waktu_update = date('Y-m-d H:i:s');
    global $conn;
    $stmt = $conn->prepare("UPDATE keuntungan SET keuntungan_key = ?, keuntungan_value = ?, satuan = ?, keterangan = ?, waktu_update = ? WHERE id_keuntungan = ?");
    $stmt->bind_param("sdsssi", $keuntungan_key, $keuntungan_value, $satuan, $keterangan, $waktu_update, $id);
    return $stmt->execute();
}

function deleteKeuntungan($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM keuntungan WHERE id_keuntungan = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
