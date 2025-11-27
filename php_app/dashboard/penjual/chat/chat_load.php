<?php
// mengambil semua pesan chat dari database
include "../config/db.php";

$result = $conn->query("SELECT * FROM chat ORDER BY created_at ASC");

$rows = [];
while ($r = $result->fetch_assoc()) $rows[] = $r;

echo json_encode($rows);