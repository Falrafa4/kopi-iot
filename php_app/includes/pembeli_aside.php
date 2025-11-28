<?php
$namaFolder = basename(dirname($_SERVER['SCRIPT_NAME'])); //mengambil nama url terakhir

$path2 = dirname($_SERVER['SCRIPT_NAME']);
$explode = explode('/', trim($path2, '/'));
$namaFolder2 = $explode[count($explode) - 2];
?>
<aside class="pembeli-aside" id="pembeliAside">
    <h1>KOPI IoT</h1>
    <ul class="sidebar">
        <li><a href="/dashboard/pembeli/" class="<?= ($namaFolder === 'pembeli') ? 'active' : '' ?>">Daftar Produk</a></li>
        <li><a href="/dashboard/pembeli/manage_users/" class="<?= ($namaFolder === 'manage_users') ? 'active' : '' ?>">Pesanan Anda</a></li>
        <li><a href="/dashboard/pembeli/pengaturan/" class="<?= ($namaFolder === 'pengaturan') ? 'active' : '' ?>">Pengaturan</a></li>
    </ul>
</aside>