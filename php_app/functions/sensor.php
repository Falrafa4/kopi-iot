<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

function getSensorById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM sensor WHERE id_sensor = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function insertSensor($id_toko, $suhu = null, $kelembapan = null, $volume = null, $selesai = 0, $lat, $lng, $prediksi_selesai = null) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO sensor (id_toko, suhu, kelembapan, volume, selesai, lat, lng, prediksi_selesai) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("idddiddi", $id_toko, $suhu, $kelembapan, $volume, $selesai, $lat, $lng, $prediksi_selesai);
    return $stmt->execute();
}