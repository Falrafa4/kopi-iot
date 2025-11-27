from flask import Flask, jsonify, request
import mysql.connector
from db import get_db
from ai_predictor import predict_finish_time

app = Flask(__name__)

# fungsi untuk menyimpan data ke database
def save_to_db(data):
    db = get_db()
    cur = db.cursor()

    # menyimpan log/histori data sensor
    sql_add = """
    INSERT INTO sensor_log (id_sensor, suhu, kelembapan, volume, selesai, prediksi_selesai)
    VALUES (%s, %s, %s, %s, %s, %s)
    """

    # update data sensor dengan id_sensor = 1
    sql_update = """
    UPDATE sensor SET suhu=%s, kelembapan=%s, volume=%s, selesai=%s, lat=%s, lng=%s, prediksi_selesai=%s
    WHERE id_sensor=1
    """

    cur.execute(sql_update, (
        data['id_toko'],
        data['suhu'],
        data['kelembapan'],
        data['volume'],
        data['selesai'],
        data['gps_lat'],
        data['gps_lon'],
        data['prediksi']
    ))

    cur.execute(sql_add, (
        1,
        data['suhu'],
        data['kelembapan'],
        data['volume'],
        data['selesai'],
        data['gps_lat'],
        data['gps_lon'],
        data['prediksi']
    ))

    db.commit()
    cur.close()
    db.close()

# endpoint untuk menerima data sensor
@app.route('/sensor/upload', methods=['POST'])
def upload():
    data = request.json

    prediksi = predict_finish_time(
        data["suhu"],
        data["kelembapan"],
        data["volume"]
    )

    data['prediksi'] = prediksi

    save_to_db(data)

    return jsonify({"status": "OK", "prediksi": prediksi})

@app.route('/data/latest')
def latest_data():
    db = get_db()
    cur = db.cursor(dictionary=True)
    cur.execute("SELECT * FROM sensor ORDER BY id_sensor DESC LIMIT 1")
    row = cur.fetchone()
    cur.close()
    db.close()
    if row:
        return jsonify(row)
    else:
        return jsonify({"error": "No data found"}), 404

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)