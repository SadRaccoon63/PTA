import mysql.connector
import adafruit_fingerprint
import serial
import time

# Sambung ke sensor fingerprint melalui port UART
uart = serial.Serial("/dev/serial0", baudrate=57600, timeout=1)
fingerprint = adafruit_fingerprint.Adafruit_Fingerprint(uart)

# Fungsi sambungan database
def connect_db():
    try:
        db = mysql.connector.connect(
            host="localhost",
            user="root",
            password="P@ssw0rd",
            database="attendance_db"
        )
        cursor = db.cursor()
        print("Sambungan ke MySQL berjaya!")
        return db, cursor
    except mysql.connector.Error as err:
        print(f"Gagal menyambung ke MySQL: {err}")
        exit()

# Fungsi untuk mendaftar cap jari
def enroll_fingerprint(db, cursor, location, name, dorm):
    print("Mendaftar Cap Jari Untuk: ", name, dorm)
    
    # Semak jika lokasi cap jari telah digunakan
    cursor.execute("SELECT * FROM students WHERE fingerprint_id = %s", (location,))
    if cursor.fetchone():
        print("Lokasi cap jari ini telah digunakan. Sila pilih lokasi lain.")
        return False
    
    print("Letakkan Jari Anda")
    while fingerprint.get_image() != adafruit_fingerprint.OK:
        pass
    if fingerprint.image_2_tz(1) != adafruit_fingerprint.OK:
        print("Gagal Menganalisis Imej Pertama.")
        return False
    
    print("Angkat Jari Anda")
    while fingerprint.get_image() != adafruit_fingerprint.NOFINGER:
        pass
    
    print("Letakkan Semula Jari Anda")
    while fingerprint.get_image() != adafruit_fingerprint.OK:
        pass
    if fingerprint.image_2_tz(2) != adafruit_fingerprint.OK:
        print("Gagal Menganalisis Imej Kedua.")
        return False
    
    if fingerprint.create_model() != adafruit_fingerprint.OK:
        print("Gagal Mencipta Model.")
        return False
    
    if fingerprint.store_model(location) != adafruit_fingerprint.OK:
        print("Gagal menyimpan model cap jari.")
        return False
    
    try:
        sql = "INSERT INTO students (fingerprint_id, name, dorm) VALUES (%s, %s, %s)"
        values = (location, name, dorm)
        cursor.execute(sql, values)
        db.commit()
        print("Maklumat pelajar berjaya disimpan ke dalam database.")
    except mysql.connector.Error as err:
        print(f"Ralat database: {err}")
        return False

    print(f"Cap jari berjaya disimpan di lokasi {location}.")
    return True

# Fungsi untuk merekod kehadiran
def record_attendance(db, cursor):
    print("Letakkan jari anda pada sensor untuk merekod kehadiran...")
    while fingerprint.get_image() != adafruit_fingerprint.OK:
        pass
    if fingerprint.image_2_tz(1) != adafruit_fingerprint.OK:
        print("Gagal memproses cap jari.")
        return

    if fingerprint.finger_search() != adafruit_fingerprint.OK:
        print("Cap jari tidak dikenali.")
        return

    fingerprint_id = fingerprint.finger_id

    # Semak jika fingerprint_id wujud dalam jadual students
    cursor.execute("SELECT * FROM students WHERE fingerprint_id = %s", (fingerprint_id,))
    student = cursor.fetchone()
    if not student:
        print("Cap jari tidak didaftarkan. Sila daftar pelajar dahulu.")
        return

    try:
        timestamp = time.strftime('%Y-%m-%d %H:%M:%S')
        sql = "INSERT INTO attendance (fingerprint_id, timestamp) VALUES (%s, %s)"
        values = (fingerprint_id, timestamp)
        cursor.execute(sql, values)
        db.commit()
        print("Kehadiran berjaya direkod.")
    except mysql.connector.Error as err:
        print(f"Ralat database: {err}")

# Menu utama
def main():
    db, cursor = connect_db()
    while True:
        print("\nSistem Kehadiran Fingerprint")
        print("1. Daftar Cap Jari Pelajar")
        print("2. Rekod Kehadiran")
        print("3. Keluar")
        choice = input("Pilihan: ")

        if choice == "1":
            name = input("Masukkan nama pelajar: ")
            dorm = input("Masukkan dorm pelajar: ")
            location = int(input("Masukkan lokasi penyimpanan cap jari (1-127): "))
            if enroll_fingerprint(db, cursor, location, name, dorm):
                print("Pendaftaran cap jari berjaya.")
            else:
                print("Pendaftaran cap jari gagal.")
        elif choice == "2":
            record_attendance(db, cursor)
        elif choice == "3":
            print("Keluar sistem.")
            break
        else:
            print("Pilihan tidak sah. Sila cuba lagi.")

if __name__ == "__main__":
    main()