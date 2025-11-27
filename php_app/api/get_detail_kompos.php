<?php

include "../config/db.php";

$id_toko = $_GET['id'] ?? null;

$query = $conn->prepare("SELECT * FROM sensor WHERE id_toko = ?");
$query->bind_param("i", $id_toko);
$query->execute();
$result = $query->get_result();
$kompos_detail = $result->fetch_assoc();

if (!$kompos_detail) {
    echo json_encode(["error" => "Data tidak ditemukan"]);
    exit;
}
echo json_encode($kompos_detail);