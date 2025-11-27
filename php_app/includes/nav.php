<nav id="navbar">
    <a href="/">
        <img src="/assets/img/logo-secondary.png" alt="KOPI IoT Logo" />
    </a>
    <ul>
        <?php 
        $namaFolder = basename(dirname($_SERVER['SCRIPT_NAME'])); //mengambil nama url terakhir
        ?>
        <li><a href="/" class="<?= ($namaFolder == "") ? 'active' : '' ?>">Home</a></li>
        <li><a href="/pages/fitur/" class="<?= ($namaFolder == "fitur") ? 'active' : '' ?>">Fitur</a></li>
        <li><a href="/pages/about/" class="<?= ($namaFolder == "about") ? 'active' : '' ?>">About</a></li>
        <?php
        if (isset($_SESSION['data'])) {
        ?>
            <li><a href="/dashboard/<?= htmlspecialchars($_SESSION['data']['role']); ?>/" class="<?= ($namaFolder == $_SESSION['data']['role']) ? 'active' : '' ?>"><?= htmlspecialchars(ucfirst($_SESSION['data']['role'])); ?></a></li>
            <li><a href="/auth/logout.php" class="<?= ($namaFolder == "logout.php") ? 'active' : '' ?>">Logout</a></li>
        <?php
        } else {
        ?>
        <li><a href="/auth/login">Login</a></li>
        <?php } ?>
    </ul>
</nav>