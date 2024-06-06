import face_recognition as fr
import numpy as np
import cv2
import os
import mysql.connector
from datetime import datetime, timedelta

while True:
    try:
        # Conexión a la base de datos MySQL
        db = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",  # Sin contraseña
            database="asistencia"
        )
        cursor = db.cursor()

        # Ruta relativa al directorio que contiene todas las caras conocidas
        faces_path = os.path.join(os.path.dirname(__file__), "images")

        # Función para obtener los nombres de las caras y sus codificaciones
        def get_face_encodings():
            face_files = os.listdir(faces_path)
            face_encodings = []
            face_carnets = []
            for face_file in face_files:
                face_path = os.path.join(faces_path, face_file)
                face_image = fr.load_image_file(face_path)
                face_encodings.append(fr.face_encodings(face_image)[0])
                face_carnets.append(face_file.split(".")[0])  # Usar el nombre del archivo sin la extensión como carnet
            return face_encodings, face_carnets

        # Recuperar las codificaciones de las caras y los nombres
        face_encodings, face_carnets = get_face_encodings()

        # Referencia a la webcam
        video = cv2.VideoCapture('http://vv:vv2@192.168.16.201:8080/video') #IP Camera

        # Variable para escalar el tamaño de la imagen
        scl = 2

        # Función para obtener el aula y materia_id basados en el horario actual
        def obtener_horario_actual():
            dia_semana = datetime.now().weekday()
            hora_actual = datetime.now().time()
            cursor.execute("""
                SELECT aula_id, materia_id, tolerancia FROM horarios 
                WHERE dia_semana = %s AND hora_inicio <= %s AND hora_fin >= %s
                LIMIT 1
            """, (dia_semana, hora_actual, hora_actual))
            horario = cursor.fetchone()
            if horario:
                return horario[0], horario[1], horario[2]
            return None, None, None

        # Función para obtener el estado de asistencia (T = Tarde, I = Inasistencia, • = Asistencia)
        def obtener_estado_asistencia(aula_id, materia_id, tolerancia):
            dia_semana = datetime.now().weekday()
            hora_actual = datetime.now().time()
            cursor.execute("""
                SELECT hora_inicio FROM horarios 
                WHERE aula_id = %s AND materia_id = %s AND dia_semana = %s
            """, (aula_id, materia_id, dia_semana))
            horario = cursor.fetchone()
            if horario:
                hora_inicio = str(horario[0])
                print(hora_inicio)
                fecha_hora = datetime.strptime(hora_inicio, "%H:%M:%S")
                print(fecha_hora)
                hora_tolerancia = fecha_hora + timedelta(minutes=tolerancia)
                print("")
                print(hora_tolerancia.time())
                if hora_actual > hora_tolerancia.time():
                    return 'T'
                else:
                    return '•'
            return 'I'

        # Función para registrar la asistencia en la base de datos
        def registrar_asistencia(carnet, aula_id, materia_id, tolerancia):
            cursor.execute("SELECT id FROM estudiantes WHERE carnet = %s", (carnet,))
            estudiante = cursor.fetchone()
            if estudiante:
                estudiante_id = estudiante[0]
                fecha = datetime.now().date()
                cursor.execute("SELECT id FROM asistencia WHERE estudiante_id = %s AND fecha = %s AND aula_id = %s AND materia_id = %s", 
                            (estudiante_id, fecha, aula_id, materia_id))
                result = cursor.fetchall()  # Leer todos los resultados para evitar "Unread result found"
                if not result:
                    estado = obtener_estado_asistencia(aula_id, materia_id, tolerancia)
                    cursor.execute("INSERT INTO asistencia (estudiante_id, materia_id, aula_id, fecha, estado) VALUES (%s, %s, %s, %s, %s)", 
                                (estudiante_id, materia_id, aula_id, fecha, estado))
                    db.commit()
                    print(f"Asistencia registrada para carnet {carnet} con estado {estado}")

        # Captura continua de video de la webcam
        while True:
            aula_id, materia_id, tolerancia = obtener_horario_actual()
            if aula_id is None or materia_id is None or tolerancia is None:
                print("No hay clases programadas en este momento.")
                break

            success, image = video.read()
            if not success:
                break  # Si no se logra capturar la imagen, salir del bucle

            # Reducir el tamaño del frame actual
            resized_image = cv2.resize(image, (int(image.shape[1] / scl), int(image.shape[0] / scl)))
            rgb_image = cv2.cvtColor(resized_image, cv2.COLOR_BGR2RGB)
            face_locations = fr.face_locations(rgb_image)
            unknown_encodings = fr.face_encodings(rgb_image, face_locations)

            # Procesar cada cara detectada
            for face_encoding, face_location in zip(unknown_encodings, face_locations):
                result = fr.compare_faces(face_encodings, face_encoding, 0.4)
                if True in result:
                    carnet = face_carnets[result.index(True)]
                    registrar_asistencia(carnet, aula_id, materia_id, tolerancia)
                    print("Rostro detectado con carnet:", carnet)  # Imprimir el carnet del rostro detectado

    except Exception as e:
        print(f"Ocurrió un error: {e}")
        continue
    finally:
        video.release()
        cursor.close()
        db.close()
        print("Recursos liberados y programa terminado correctamente.")
