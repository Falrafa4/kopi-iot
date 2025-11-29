<?php

// --- FUNGSI KATEGORI TETAP SAMA ---

function kategoriSuhu($suhu) {
    if ($suhu <= 20) return "ideal"; 
    if ($suhu <= 30) return "ideal";
    return "panas"; // Saya ubah labelnya biar lebih jelas konteksnya
}

function kategoriKelembapan($hum) { 
    if ($hum >= 40 && $hum <= 50) return "ideal";
    if ($hum <= 79) return "hampir jadi"; // Terlalu kering atau agak basah dikit
    if ($hum >= 80) return "basah"; // Terlalu basah (>80)
}

// Fungsi Volume dipisah, hanya untuk Display di Dashboard, tidak masuk logika kesimpulan
function kategoriVolume($vol) {
    if ($vol <= 20) return "sedikit";
    if ($vol <= 50) return "hampir penuh";
    if ($vol <= 100) return "penuh";
}

// --- LOGIKA BARU (HANYA SUHU & KELEMBAPAN) ---

function kesimpulan($suhu, $hum, $predict) {
    $s = kategoriSuhu($suhu);
    $h = kategoriKelembapan($hum);
    
    // Kita hanya punya 2 (Suhu) x 3 (Kelembapan) = 6 KEMUNGKINAN

    // 1. KONDISI TERBAIK (GOLDEN STANDARD)
    if ($s == "ideal" && $h == "ideal") {
        return "SIAP OLAH. Kualitas ampas kopi sempurna! Suhu dingin stabil dan kelembapan sangat pas. Sangat direkomendasikan untuk segera diolah. Harap menunggu driver untuk penjemputan.";
    }

    // 2. KONDISI BAIK (STANDARD)
    if ($s == "ideal" && $h == "hampir jadi") {
        return "SIAP OLAH. Kondisi suhu aman. Kelembapan sedikit meleset dari target ideal namun masih sangat layak untuk diproses lanjut. Harap menunggu driver untuk penjemputan.";
    }

    // 3. KONDISI DINGIN TAPI BASAH
    if ($s == "ideal" && $h == "basah") {
        return "BELUM SIAP (TERLALU BASAH). Suhu aman, tetapi kadar air terlalu tinggi. Berisiko jamur jika tidak dikeringkan dulu. Tidak disarankan langsung masuk pengolahan utama. (Estimasi siap diolah: $predict hari)";
    }

    // 4. KONDISI PANAS TAPI KERING
    if ($s == "panas" && $h == "ideal") {
        return "WARNING (SUHU TINGGI). Kelembapan bagus, tapi suhu terdeteksi panas. Kemungkinan terjadi fermentasi liar atau wadah terpapar panas eksternal. Perlu pendinginan. (Estimasi siap diolah: $predict hari)";
    }

    // 5. KONDISI PANAS DAN KURANG PAS
    if ($s == "panas" && $h == "hampir jadi") {
        return "KURANG STABIL. Suhu panas dan kelembapan tidak ideal. Kualitas ampas kopi menurun. Perlu pemeriksaan ventilasi wadah. (Estimasi siap diolah: $predict hari)";
    }

    // 6. KONDISI KRITIS (PANAS & BASAH)
    if ($s == "panas" && $h == "basah") {
        return "BAHAYA (RISIKO PEMBUSUKAN). Kombinasi suhu panas dan sangat basah memicu pembusukan anaerob (bau busuk). Kualitas buruk untuk diolah. (Estimasi siap diolah: $predict hari)";
    }

    return "Menunggu pembacaan sensor...";
}
?>