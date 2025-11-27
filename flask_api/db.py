# DB_CONFIG = {
#     "host": "localhost",
#     "database": "kopi_iot",
#     "user": "root",
#     "password": ""
# }

import mysql.connector
import os

def get_db():
    return mysql.connector.connect(
        host='localhost',
        user='root',
        password='',
        database='kopi_iot'
    )