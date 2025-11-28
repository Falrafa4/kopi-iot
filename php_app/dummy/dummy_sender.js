function kirimDummy(idSensor) {
    // Suhu: 15 - 35
    const suhu = (15 + Math.random() * (35 - 15)).toFixed(1);

    // Kelembapan: 40 - 100
    const kelembapan = (40 + Math.random() * (100 - 40)).toFixed(1);

    // Volume: 1 - 100 (bilangan bulat)
    const volume = Math.floor(1 + Math.random() * (100 - 1 + 1));

    // Prediksi Selesai: 1-15 (bilangan bulat)
    const prediksiSelesai = Math.floor(1 + Math.random() * (15 - 1 + 1));

    // Tentukan status jika perlu
    let status = "Not Ready";

    if (suhu <= 20 && suhu >= 30 && kelembapan >= 40 && kelembapan <= 50) {
        status = "Ready";
    }

    const form = new FormData();
    form.append("suhu", suhu);
    form.append("kelembapan", kelembapan);
    form.append("volume", volume);
    form.append("status", status);
    form.append("prediksi_selesai", prediksiSelesai);
    form.append("id_sensor", idSensor);

    fetch("/dummy/insert.php", {
        method: "POST",
        body: form
    })
        .then(r => r.text())
        .then(t => console.log("RESPON INSERT:", t))
        .catch(e => console.error(e));

    console.log(`Kirim data dummy - Suhu: ${suhu}, Kelembapan: ${kelembapan}, Volume: ${volume}, Prediksi Selesai: ${prediksiSelesai}, Status: ${status}`);
}

// kirim setiap 2 detik
setInterval(() => {
    kirimDummy(2);
    kirimDummy(3);
    kirimDummy(4);
}, 5000);
