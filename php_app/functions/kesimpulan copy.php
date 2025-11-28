<?php

function kategoriSuhu($suhu) {
    if ($suhu <= 20) return "ideal"; //dingin
    if ($suhu <= 30) return "ideal"; //normal
    return "belum siap"; //panas
}

function kategoriKelembapan($hum) { 
    if ($hum >= 80 && $hum <= 100) return "belum jadi";
    if ($hum >= 51 && $hum <= 79) return "hampir jadi";
    if ($hum >= 40 && $hum <= 50) return "ideal";
}

function kategoriVolume($vol) {
    // asumsi full : 100 ml
    // kategori: sedikit (0-20), cukup (21-50), banyak (51-100)
    if ($vol <= 20) return "sedikit";
    if ($vol <= 50) return "hampir penuh";
    if ($vol <= 100) return "penuh";
}

// ... (Fungsi kategoriSuhu, kategoriKelembapan, kategoriVolume tetap sama) ...

function kesimpulan($suhu, $hum, $vol, $predict) {
    $s = kategoriSuhu($suhu);      // ideal (dingin), belum siap (panas)
    $h = kategoriKelembapan($hum); // ideal (40-50), hampir jadi (<79), belum jadi (>80 basah)
    $v = kategoriVolume($vol);     // sedikit, hampir penuh, penuh

    // --- KONDISI 1: SUHU IDEAL (STABIL) ---
    // Kondisi ini bagus untuk penyimpanan. Ampas tidak mengalami fermentasi panas berlebih.
    
    // 1.1 Volume Masih Sedikit
    if ($s == "ideal" && $h == "ideal" && $v == "sedikit")
        return "Status: AMAN (PENYIMPANAN). Kondisi ampas kopi sangat prima dan kering, namun volume masih sedikit. Belum perlu penjemputan. Estimasi angkut: $predict hari.";

    if ($s == "ideal" && $h == "hampir jadi" && $v == "sedikit")
        return "Status: NORMAL (PENYIMPANAN). Kelembapan sedikit bervariasi tapi suhu aman. Lanjutkan pengisian wadah. Estimasi angkut: $predict hari.";

    if ($s == "ideal" && $h == "belum jadi" && $v == "sedikit")
        return "Status: WASPADA (KELEMBAPAN). Wadah masih kosong, tapi ampas terdeteksi terlalu basah. Risiko jamur jika dibiarkan lama. Estimasi angkut: $predict hari.";


    // 1.2 Volume Hampir Penuh (Persiapan)
    if ($s == "ideal" && $h == "ideal" && $v == "hampir penuh")
        return "Status: PERSIAPAN ANGKUT. Wadah hampir penuh dengan kualitas ampas kopi yang sempurna (kering & sejuk). Siapkan jadwal truk. Estimasi angkut: $predict hari.";

    if ($s == "ideal" && $h == "hampir jadi" && $v == "hampir penuh")
        return "Status: PERSIAPAN ANGKUT. Kapasitas hampir habis. Kondisi ampas cukup stabil meski kelembapan perlu dipantau. Estimasi angkut: $predict hari.";

    if ($s == "ideal" && $h == "belum jadi" && $v == "hampir penuh")
        return "Status: PERLU PERHATIAN. Wadah hampir penuh tapi ampas terlalu basah/lembab. Disarankan segera angkut untuk menghindari pembusukan. Estimasi angkut: $predict hari.";


    // 1.3 Volume Penuh (SIAP ANGKUT vs KENDALA)
    // INI ADALAH GOLDEN SCENARIO (Sesuai request: Penuh + Ideal + Ideal)
    if ($s == "ideal" && $h == "ideal" && $v == "penuh")
        return "Status: SIAP ANGKUT (PRIORITAS). Wadah telah penuh dan kualitas ampas kopi SEMPURNA (Suhu & Kelembapan Ideal). Segera panggil truk! Estimasi angkut: $predict hari.";

    if ($s == "ideal" && $h == "hampir jadi" && $v == "penuh")
        return "Status: SIAP ANGKUT. Wadah penuh. Kualitas ampas baik meski kelembapan tidak di angka emas. Layak dikirim ke pengolahan. Estimasi angkut: $predict hari.";

    if ($s == "ideal" && $h == "belum jadi" && $v == "penuh")
        return "Status: ANGKUT SEGERA (RISIKO). Wadah penuh dengan kondisi ampas terlalu basah. Harus segera dikirim agar tidak menjadi limbah cair/busuk. Estimasi angkut: $predict hari.";



    // --- KONDISI 2: SUHU BELUM SIAP (PANAS/FERMENTASI AKTIF) ---
    // Suhu panas di dalam wadah tertutup bisa berarti fermentasi anaerob sedang terjadi (bau busuk/gas).
    
    // 2.1 Volume Sedikit
    if ($s == "belum siap" && $h == "ideal" && $v == "sedikit")
        return "Status: PANTAU SUHU. Volume sedikit tapi suhu terdeteksi tinggi. Cek apakah ada kontaminasi panas atau wadah terpapar matahari. Estimasi angkut: $predict hari.";

    if ($s == "belum siap" && $h == "hampir jadi" && $v == "sedikit")
        return "Status: TIDAK STABIL. Suhu tinggi terdeteksi di volume rendah. Lingkungan wadah mungkin kurang kondusif. Estimasi angkut: $predict hari.";

    if ($s == "belum siap" && $h == "belum jadi" && $v == "sedikit")
        return "Status: BAHAYA PEMBUSUKAN. Kombinasi panas dan basah di awal pengisian. Risiko bau menyengat tinggi. Perlu pengecekan manual. Estimasi angkut: $predict hari.";


    // 2.2 Volume Hampir Penuh
    if ($s == "belum siap" && $h == "ideal" && $v == "hampir penuh")
        return "Status: PERLU VENTILASI. Wadah hampir penuh dan mulai memanas. Pastikan sirkulasi udara wadah berjalan sebelum diangkut. Estimasi angkut: $predict hari.";

    if ($s == "belum siap" && $h == "hampir jadi" && $v == "hampir penuh")
        return "Status: WARNING. Suhu meningkat seiring wadah hampir penuh. Proses fermentasi mungkin terjadi prematur di dalam wadah. Estimasi angkut: $predict hari.";

    if ($s == "belum siap" && $h == "belum jadi" && $v == "hampir penuh")
        return "Status: KRITIS. Ampas panas dan basah. Potensi gas metana/bau busuk. Segera jadwalkan pengangkutan meski belum full 100%. Estimasi angkut: $predict hari.";


    // 2.3 Volume Penuh (Kondisi Tidak Ideal)
    if ($s == "belum siap" && $h == "ideal" && $v == "penuh")
        return "Status: ANGKUT (KONDISI PANAS). Wadah penuh. Suhu ampas tinggi (mungkin terpapar panas). Segera kirim ke pengolahan. Estimasi angkut: $predict hari.";

    if ($s == "belum siap" && $h == "hampir jadi" && $v == "penuh")
        return "Status: ANGKUT SEGERA. Wadah penuh dan suhu mulai tidak kondusif. Jangan didiamkan terlalu lama di dalam wadah. Estimasi angkut: $predict hari.";

    if ($s == "belum siap" && $h == "belum jadi" && $v == "penuh")
        return "Status: DARURAT ANGKUT. Wadah penuh, panas, dan basah. Ini kondisi terburuk untuk penyimpanan (risiko meledak/bau). Truk harus datang sekarang. Estimasi angkut: $predict hari.";


    // Default fallback
    return "Status: MENUNGGU DATA SENSOR. Pastikan sensor terhubung dengan baik. Prediksi: $predict hari.";
}

// function kesimpulan($suhu, $hum, $vol, $predict) {
//     $s = kategoriSuhu($suhu);
//     $h = kategoriKelembapan($hum);
//     $v = kategoriVolume($vol);

//     //
//     // 18 RULE KOMBINASI LENGKAP
//     //

//     // --- SUHU IDEAL ---
//     if ($s == "ideal" && $h == "ideal" && $v == "sedikit")
//         return "Ampas kopi berada pada suhu ideal dan kelembapan ideal sehingga proses berjalan lambat. Volume juga masih sangat sedikit. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "ideal" && $h == "ideal" && $v == "hampir penuh")
//         return "Suhu dan kelembapan ideal membuat proses lambat, namun volume hampir penuh. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "ideal" && $h == "ideal" && $v == "penuh")
//         return "Kondisi cukup kering dan ideal, namun volume sudah penuh sehingga proses tetap berjalan stabil meski lambat. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "ideal" && $h == "hampir jadi" && $v == "sedikit")
//         return "Suhu ideal namun kelembapan ideal. Volume masih sedikit sehingga proses berjalan lambat. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "ideal" && $h == "hampir jadi" && $v == "hampir penuh")
//         return "Suhu ideal dan kelembapan ideal dengan volume sedang. Proses berlangsung normal namun sedikit lambat. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "ideal" && $h == "hampir jadi" && $v == "penuh")
//         return "Suhu ideal tetapi kelembapan ideal dan volume banyak membuat proses lebih stabil meski tidak terlalu cepat. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "ideal" && $h == "belum jadi" && $v == "sedikit")
//         return "Suhu ideal namun kelembapan tinggi membuat kondisi berpotensi lembap dan lambat. Volume masih sedikit. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "ideal" && $h == "belum jadi" && $v == "hampir penuh")
//         return "Kelembapan tinggi dan suhu ideal membuat kondisi terlalu lembap meski volume sedang. Perlu pemantauan. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "ideal" && $h == "belum jadi" && $v == "penuh")
//         return "Volume banyak namun kondisi terlalu lembap dan ideal. Risiko jamur meningkat. Prediksi dapat diambil oleh truk: $predict hari.";


//     // --- SUHU PANAS ---
//     if ($s == "belum siap" && $h == "ideal" && $v == "sedikit")
//         return "Suhu terlalu panas namun kelembapan ideal. Volume sangat sedikit membuat proses tidak stabil. Perlu penanganan. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "belum siap" && $h == "ideal" && $v == "hampir penuh")
//         return "Suhu panas dan kelembapan ideal dengan volume sedang membuat proses berjalan cepat namun berisiko mengering. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "belum siap" && $h == "ideal" && $v == "penuh")
//         return "Suhu panas dan volume banyak membuat reaksi fermentasi cepat, namun kelembapan ideal perlu diperhatikan. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "belum siap" && $h == "hampir jadi" && $v == "sedikit")
//         return "Suhu tinggi namun kelembapan ideal. Volume sedikit membuat proses cepat tapi tidak stabil. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "belum siap" && $h == "hampir jadi" && $v == "hampir penuh")
//         return "Suhu panas dengan kelembapan ideal dan volume sedang membuat proses berjalan sangat cepat. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "belum siap" && $h == "hampir jadi" && $v == "penuh")
//         return "Proses berjalan cepat karena suhu tinggi dan volume banyak. Kondisi stabil namun tetap perlu pantauan. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "belum siap" && $h == "belum jadi" && $v == "sedikit")
//         return "Kondisi terlalu panas dan terlalu lembap dengan volume kecil. Risiko kerusakan meningkat. Perlu penanganan segera. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "belum siap" && $h == "belum jadi" && $v == "hampir penuh")
//         return "Suhu dan kelembapan tinggi membuat proses berjalan terlalu cepat dan tidak stabil. Perlu pemantauan. Prediksi dapat diambil oleh truk: $predict hari.";

//     if ($s == "belum siap" && $h == "belum jadi" && $v == "penuh")
//         return "Suhu dan kelembapan tinggi pada volume besar membuat kondisi kritis dan rentan rusak. Penanganan segera diperlukan. Prediksi dapat diambil oleh truk: $predict hari.";


//     // Default (harusnya tidak pernah kepanggil)
//     return "Ampas kopi dalam kondisi normal. Prediksi dapat diambil oleh truk: $predict hari.";
// }   

