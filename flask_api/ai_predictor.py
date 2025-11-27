from google import genai
import os

API_KEY = os.getenv("GEMINI_API_KEY")

client = genai.Client(api_key=API_KEY)
model = "gemini-2.0-flash"

def predict_finish_time(suhu, kelembapan, volume):
    prompt = f"""
    Anda adalah seorang ahli AI yang membantu memprediksi waktu penyelesaian pembuatan pupuk dari ampas kopi berdasarkan data sensor.

    Data sensor yang diberikan adalah:
    - Suhu: {suhu} °C
    - Kelembapan: {kelembapan} %
    - Volume/berat ampas kopi: {volume} gr

    Berdasarkan data tersebut, prediksikan dalam hari berapa lama lagi proses pembuatan pupuk akan selesai dan siap dijual. Berikan jawaban Anda dalam format hanya angka hari saja tanpa penjelasan tambahan.
    """

    response = client.models.get(model=model)
    completion = client.models.generate_content(
        model = response.name,
        contents = prompt,
    )

    return completion.text.strip()