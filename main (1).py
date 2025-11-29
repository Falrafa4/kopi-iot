from machine import Pin, UART
import dht, network, utime, time
from hcsr04 import HCSR04
import urequests
import json

# ========================================
# KONFIGURASI WIFI 
# ========================================
ssid = "Redmi Note 9 Pro"
password = "12345678900"

wifi = network.WLAN(network.STA_IF)
wifi.active(True)
wifi.connect(ssid, password)

print("Menghubungkan WiFi...")
while not wifi.isconnected():
    print("Menghubungkan...")
    utime.sleep(1)

print("WiFi Terhubung:", wifi.ifconfig())

# ========================================
# KONFIGURASI SENSOR
# ========================================
sensor = dht.DHT11(Pin(14))
jarak = HCSR04(trigger_pin=26, echo_pin=27, echo_timeout_us=10000)
gps = UART(2, baudrate=9600, tx=17, rx=16)

# Tinggi tempat sampah (cm)
TINGGI_WADAH = 24

# ========================================
# LED INDIKATOR (PIN OUTPUT)
# ========================================
led_merah = Pin(19, Pin.OUT)
led_kuning = Pin(18, Pin.OUT)
led_hijau = Pin(5, Pin.OUT)

# Pastikan LED mati di awal
led_merah.off()
led_kuning.off()
led_hijau.off()

# ========================================
# URL API FLASK
# ========================================
FLASK_URL = "http://10.200.192.148:5000/sensor/upload"


# ========================================
# LOGIKA STATUS KELEMBAPAN
# ========================================
def cek_status_kelembapan(h):
    if 80 <= h <= 100:
        return "not ready", "merah"
    elif 51 <= h <= 79:
        return "almost ready", "kuning"
    elif 40 <= h <= 50:
        return "ready", "hijau"
    else:
        return "Diluar Batas", "none"


def update_led(warna):
    # Matikan semua LED dahulu
    led_merah.off()
    led_kuning.off()
    led_hijau.off()

    if warna == "merah":
        led_merah.on()
    elif warna == "kuning":
        led_kuning.on()
    elif warna == "hijau":
        led_hijau.on()


# ========================================
# LOOP UTAMA
# ========================================
print("Mulai membaca sensor & mengirim ke Flask...")

while True:
    try:
        # --------------------
        # BACA DHT11
        # --------------------
        sensor.measure()
        temperature = sensor.temperature()
        humidity = sensor.humidity()

        # Tentukan status berdasarkan kelembapan
        status, warna_led = cek_status_kelembapan(humidity)
        update_led(warna_led)

        print("Kelembapan:", humidity, "% | Status:", status)

        # --------------------
        # BACA HC-SR04
        # --------------------
        distance = jarak.distance_cm()  # jarak sensor ke sampah

        # Hitung tinggi sampah
        tinggi_isi = TINGGI_WADAH - distance
        if tinggi_isi < 0:
            tinggi_isi = 0
        elif tinggi_isi > TINGGI_WADAH:
            tinggi_isi = TINGGI_WADAH

        # Hitung persentase penuh
        persentase_penuh = (tinggi_isi / TINGGI_WADAH) * 100

        print("Jarak:", distance, "cm")
        print("Tinggi Sampah:", tinggi_isi, "cm")
        print("Penuh:", round(persentase_penuh, 2), "%")

        # --------------------
        # SIAPKAN DATA JSON
        # --------------------
        payload = {
            "suhu": temperature,
            "kelembapan": humidity,
            "volume": round(persentase_penuh, 2),   # <- persentase penuh
            "status": status,
            "selesai": 0
        }

        print("Kirim:", payload)

        # --------------------
        # KIRIM KE FLASK
        # --------------------
        try:
            resp = urequests.post(FLASK_URL, json=payload)
            print("Response Flask:", resp.text)
            resp.close()
        except Exception as e:
            print("Gagal kirim ke Flask:", e)

        print("================================")
        time.sleep(1)

    except Exception as e:
        print("Error:", e)
        time.sleep(1)

