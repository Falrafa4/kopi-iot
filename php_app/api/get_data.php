<?php

include '../config/db.php';

$query = $conn->query("SELECT * FROM sensor ORDER BY id_sensor DESC LIMIT 1");
$json = $query->fetch_assoc();