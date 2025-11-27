<?php

function kategoriSuhu($suhu) {
    if ($suhu <= 20) return "dingin";
    if ($suhu <= 30) return "normal";
    return "panas";
}

function kategoriKelembapan($hum) {
    if ($hum <= 40) return "rendah";
    if ($hum <= 70) return "normal";
    return "tinggi";
}

function kategoriVolume($vol) {
    if ($vol < 20) return "sedikit";
    if ($vol <= 50) return "cukup";
    return "banyak";
}

function kesimpulan($suhu, $hum, $vol, $predict) {
    $s = kategoriSuhu($suhu);
    $h = kategoriKelembapan($hum);
    $v = kategoriVolume($vol);

    if (empty($suhu) || empty($hum) || empty($vol) || empty($predict)) {
        return "Data sensor belum ada. Harap atur sensor terlebih dahulu.";
    }

    // ✔ Semua kombinasi SUHU x KELEMBAPAN x VOLUME (27 total)
    $rules = [

        // ========================
        // SUHU DINGIN
        // ========================
        "dingin-rendah-sedikit" => "Ampas kopi berada pada kondisi terlalu dingin dan sangat kering dengan volume yang masih sangat sedikit. Proses fermentasi berjalan sangat lambat. Prediksi dapat diambil: $predict hari.",

        "dingin-rendah-cukup" => "Ampas kopi terlalu dingin dan kering. Meskipun volumenya cukup, kelembapan rendah membuat proses berjalan lambat. Disarankan menambah kelembapan. Prediksi dapat diambil: $predict hari.",

        "dingin-rendah-banyak" => "Ampas kopi dalam kondisi dingin dan kelembapan rendah meskipun volumenya banyak. Proses cenderung tertahan di awal fermentasi. Perlu penyesuaian lingkungan. Prediksi dapat diambil: $predict hari.",

        "dingin-normal-sedikit" => "Suhu rendah dengan kelembapan normal tetapi volume sangat sedikit membuat proses kurang optimal. Disarankan menambah volume. Prediksi dapat diambil: $predict hari.",

        "dingin-normal-cukup" => "Ampas kopi berada pada suhu dingin dengan kelembapan yang cukup baik. Proses berjalan lambat namun stabil. Prediksi dapat diambil: $predict hari.",

        "dingin-normal-banyak" => "Suhu dingin dan kelembapan normal dengan volume banyak menghasilkan proses yang stabil namun lambat. Prediksi dapat diambil: $predict hari.",

        "dingin-tinggi-sedikit" => "Lingkungan dingin namun kelembapan terlalu tinggi dengan volume sedikit dapat menyebabkan penyerapan kelembapan berlebih. Perlu pengaturan ulang. Prediksi dapat diambil: $predict hari.",

        "dingin-tinggi-cukup" => "Ampas kopi berada pada suhu dingin dengan kelembapan tinggi. Proses fermentasi mungkin tidak stabil. Perlu menjaga kelembapan. Prediksi dapat diambil: $predict hari.",

        "dingin-tinggi-banyak" => "Suhu dingin dengan kelembapan tinggi dan volume banyak berpotensi menyebabkan penumpukan air. Pastikan ventilasi baik. Prediksi dapat diambil: $predict hari.",


        // ========================
        // SUHU NORMAL
        // ========================
        "normal-rendah-sedikit" => "Ampas kopi pada suhu normal namun kelembapan rendah dan volume sedikit membuat proses berjalan tidak maksimal. Disarankan menambah volume dan kelembapan. Prediksi dapat diambil: $predict hari.",

        "normal-rendah-cukup" => "Suhu stabil namun kelembapan rendah dapat memperlambat proses meskipun volume cukup. Perlu penyesuaian kelembapan. Prediksi dapat diambil: $predict hari.",

        "normal-rendah-banyak" => "Suhu ideal namun kelembapan rendah dengan volume besar dapat menurunkan kualitas fermentasi. Tambah kelembapan untuk hasil optimal. Prediksi dapat diambil: $predict hari.",

        "normal-normal-sedikit" => "Kondisi suhu dan kelembapan ideal, tetapi volume masih terlalu sedikit untuk proses optimal. Disarankan menambah volume. Prediksi dapat diambil: $predict hari.",

        "normal-normal-cukup" => "Ampas kopi berada pada kondisi ideal dan stabil. Volume cukup dan proses berjalan normal tanpa hambatan berarti. Prediksi dapat diambil: $predict hari.",

        "normal-normal-banyak" => "Ampas kopi berada pada kondisi sangat ideal dengan volume banyak, sehingga proses berjalan stabil dan efisien. Prediksi dapat diambil: $predict hari.",

        "normal-tinggi-sedikit" => "Kelembapan terlalu tinggi meskipun suhu normal. Volume yang sedikit membuat ampas menyerap kelembapan berlebih. Perlu diperhatikan. Prediksi dapat diambil: $predict hari.",

        "normal-tinggi-cukup" => "Suhu ideal namun kelembapan terlalu tinggi dapat menyebabkan fermentasi berjalan tidak stabil. Perlu ventilasi tambahan. Prediksi dapat diambil: $predict hari.",

        "normal-tinggi-banyak" => "Ampas kopi dalam kondisi lembap berlebih dengan volume besar. Risiko pertumbuhan jamur meningkat. Perhatikan kelembapan. Prediksi dapat diambil: $predict hari.",


        // ========================
        // SUHU PANAS
        // ========================
        "panas-rendah-sedikit" => "Suhu terlalu panas dengan kelembapan rendah serta volume sedikit dapat membuat ampas cepat mengering. Proses tidak berjalan baik. Prediksi dapat diambil: $predict hari.",

        "panas-rendah-cukup" => "Suhu panas dan kelembapan rendah membuat ampas mudah kering meskipun volumenya cukup. Perlu penyesuaian suhu. Prediksi dapat diambil: $predict hari.",

        "panas-rendah-banyak" => "Suhu panas berpotensi mengurangi kualitas meskipun volume cukup banyak. Tambah kelembapan untuk menjaga stabilitas. Prediksi dapat diambil: $predict hari.",

        "panas-normal-sedikit" => "Suhu panas namun kelembapan normal dengan volume sedikit dapat membuat bagian luar cepat kering. Perlu perhatian. Prediksi dapat diambil: $predict hari.",

        "panas-normal-cukup" => "Suhu panas membuat proses fermentasi tidak stabil meskipun kelembapan dan volume cukup baik. Pastikan suhu diturunkan. Prediksi dapat diambil: $predict hari.",

        "panas-normal-banyak" => "Suhu panas dengan volume besar dapat membuat fermentasi berlebihan. Perlu pengaturan ulang suhu. Prediksi dapat diambil: $predict hari.",

        "panas-tinggi-sedikit" => "Kondisi sangat tidak ideal: suhu panas dan kelembapan tinggi dengan volume sedikit berisiko menghasilkan ampas berjamur. Perlu penanganan segera. Prediksi dapat diambil: $predict hari.",

        "panas-tinggi-cukup" => "Ampas kopi dalam kondisi terlalu panas dan lembap, yang dapat mempercepat pembusukan. Segera sesuaikan lingkungan. Prediksi dapat diambil: $predict hari.",

        "panas-tinggi-banyak" => "Lingkungan sangat panas dan lembap dengan volume banyak berpotensi memicu fermentasi berlebihan dan pembusukan cepat. Kondisi sangat tidak direkomendasikan. Prediksi dapat diambil: $predict hari.",
    ];

    $key = "$s-$h-$v";

    return $rules[$key] ?? "Data tidak dapat ditentukan. Periksa kembali sensor.";
}
