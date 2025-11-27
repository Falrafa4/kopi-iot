<?php

include "config/db.php";

$query = $conn->query("SELECT * FROM toko");
$toko_all = $query->fetch_all(MYSQLI_ASSOC);