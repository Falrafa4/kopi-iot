<?php

function kategoriSuhu($suhu) {
    if ($suhu <= 20) return "ideal"; //dingin
    if ($suhu <= 30) return "ideal"; //normal
    return "belum siap"; //panan
}

function kategoriKelembapan($hum) { 
    if ($hum >= 40 && $hum <= 50) return "ideal";
    if ($hum <= 79) return "hampir jadi";
    if ($hum >= 80) return "belum jadi";
}

function kategoriVolume($vol) {
    // asumsi full : 100 ml
    // kategori: sedikit (0-20), cukup (21-50), banyak (51-100)
    if ($vol <= 20) return "sedikit";
    if ($vol <= 50) return "hampir penuh";
    if ($vol <= 100) return "penuh";
}

function kesimpulan($suhu, $hum, $vol, $predict) {
    $s = kategoriSuhu($suhu);
    $h = kategoriKelembapan($hum);
    $v = kategoriVolume($vol);

    //
    // 18 RULE KOMBINASI LENGKAP
    //

    // --- SUHU IDEAL ---
    if ($s == "ideal" && $h == "ideal" && $v == "sedikit")
        return "Ampas kopi berada pada suhu ideal dan kelembapan ideal sehingga proses berjalan lambat. Volume juga masih sangat sedikit. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "ideal" && $h == "ideal" && $v == "hampir penuh")
        return "Suhu dan kelembapan ideal membuat proses lambat, namun volume hampir penuh. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "ideal" && $h == "ideal" && $v == "penuh")
        return "Kondisi cukup kering dan ideal, namun volume sudah penuh sehingga proses tetap berjalan stabil meski lambat. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "ideal" && $h == "hampir jadi" && $v == "sedikit")
        return "Suhu ideal namun kelembapan ideal. Volume masih sedikit sehingga proses berjalan lambat. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "ideal" && $h == "hampir jadi" && $v == "hampir penuh")
        return "Suhu ideal dan kelembapan ideal dengan volume sedang. Proses berlangsung normal namun sedikit lambat. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "ideal" && $h == "hampir jadi" && $v == "penuh")
        return "Suhu ideal tetapi kelembapan ideal dan volume banyak membuat proses lebih stabil meski tidak terlalu cepat. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "ideal" && $h == "belum jadi" && $v == "sedikit")
        return "Suhu ideal namun kelembapan tinggi membuat kondisi berpotensi lembap dan lambat. Volume masih sedikit. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "ideal" && $h == "belum jadi" && $v == "hampir penuh")
        return "Kelembapan tinggi dan suhu ideal membuat kondisi terlalu lembap meski volume sedang. Perlu pemantauan. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "ideal" && $h == "belum jadi" && $v == "penuh")
        return "Volume banyak namun kondisi terlalu lembap dan ideal. Risiko jamur meningkat. Prediksi dapat diambil oleh truk: $predict hari.";


    // --- SUHU PANAS ---
    if ($s == "belum siap" && $h == "ideal" && $v == "sedikit")
        return "Suhu terlalu panas namun kelembapan ideal. Volume sangat sedikit membuat proses tidak stabil. Perlu penanganan. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "belum siap" && $h == "ideal" && $v == "hampir penuh")
        return "Suhu panas dan kelembapan ideal dengan volume sedang membuat proses berjalan cepat namun berisiko mengering. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "belum siap" && $h == "ideal" && $v == "penuh")
        return "Suhu panas dan volume banyak membuat reaksi fermentasi cepat, namun kelembapan ideal perlu diperhatikan. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "belum siap" && $h == "hampir jadi" && $v == "sedikit")
        return "Suhu tinggi namun kelembapan ideal. Volume sedikit membuat proses cepat tapi tidak stabil. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "belum siap" && $h == "hampir jadi" && $v == "hampir penuh")
        return "Suhu panas dengan kelembapan ideal dan volume sedang membuat proses berjalan sangat cepat. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "belum siap" && $h == "hampir jadi" && $v == "penuh")
        return "Proses berjalan cepat karena suhu tinggi dan volume banyak. Kondisi stabil namun tetap perlu pantauan. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "belum siap" && $h == "belum jadi" && $v == "sedikit")
        return "Kondisi terlalu panas dan terlalu lembap dengan volume kecil. Risiko kerusakan meningkat. Perlu penanganan segera. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "belum siap" && $h == "belum jadi" && $v == "hampir penuh")
        return "Suhu dan kelembapan tinggi membuat proses berjalan terlalu cepat dan tidak stabil. Perlu pemantauan. Prediksi dapat diambil oleh truk: $predict hari.";

    if ($s == "belum siap" && $h == "belum jadi" && $v == "penuh")
        return "Suhu dan kelembapan tinggi pada volume besar membuat kondisi kritis dan rentan rusak. Penanganan segera diperlukan. Prediksi dapat diambil oleh truk: $predict hari.";


    // Default (harusnya tidak pernah kepanggil)
    return "Ampas kopi dalam kondisi normal. Prediksi dapat diambil oleh truk: $predict hari.";
}   

