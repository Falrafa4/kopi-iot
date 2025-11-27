import requests

url = "http://127.0.0.1:5000/sensor"

dummy = {
    "suhu": 34,
    "kelembapan": 70.0,
    "jarak": 15,
    "lat": -7.36,
    "lng": 112.72
}
# dummy = {
#     "suhu": 28.5,
#     "kelembapan": 65.0,
#     "jarak": 12.5,
#     "lat": -7.36,
#     "lng": 112.72
# }

response = requests.post(url, json=dummy)

print("Status code:", response.status_code)
print("Raw text:", response.text)

try:
    print("JSON:", response.json())
except:
    print("Response bukan JSON.")
