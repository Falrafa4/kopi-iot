<?php
$namaFolder = basename(dirname($_SERVER['SCRIPT_NAME'])); //mengambil nama url terakhir

$path2 = dirname($_SERVER['SCRIPT_NAME']);
$explode = explode('/', trim($path2, '/'));
$namaFolder2 = $explode[count($explode) - 2];
?>
<aside class="admin-aside" id="adminAside">
    <h1>KOPI IoT</h1>
    <ul class="sidebar">
        <li><a href="/dashboard/admin/" class="<?= ($namaFolder === 'admin') ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="/dashboard/admin/manage_users/" class="<?= ($namaFolder === 'manage_users') ? 'active' : '' ?>">Manage Users</a></li>
        <li><a href="/dashboard/admin/manage_toko/" class="<?= ($namaFolder === 'manage_toko') ? 'active' : '' ?>">Manage Toko</a></li>
        <li><a href="/dashboard/admin/manage_sensor/" class="<?= ($namaFolder === 'manage_sensor') ? 'active' : '' ?>">Manage Sensor</a></li>
        <li><a href="/dashboard/admin/reports/" class="<?= ($namaFolder === 'reports') ? 'active' : '' ?>">Reports</a></li>
    </ul>
</aside>