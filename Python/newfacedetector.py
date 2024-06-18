import face_recognition as fr
import numpy as np
import cv2
import os
import pymysql
from datetime import datetime, timedelta
import threading
import time

# Conexión a la base de datos MySQL
db = pymysql.connect(
    host="localhost",
    user="root",
    password="",
    database="aulainteligente"
)

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
rtsp_url = 1

# Variable para escalar el tamaño de la imagen
scl = 2

# Función para obtener el horario actual
def get_current_schedule():
    cursor = db.cursor(pymysql.cursors.DictCursor)
    now = datetime.now()
    dia = now.weekday()  # MySQL tiene los días de la semana de 0 a 6
    hora_actual = now.time()

    query = """
    SELECT h.id, h.materia, h.grupo, h.horaInicio, t.minutos AS tolerancia
    FROM Horarios h
    JOIN Tolerancia t ON h.materia = t.materia
    WHERE h.dia = %s AND h.horaInicio <= %s AND h.horaFin >= %s
    """
    cursor.execute(query, (dia, hora_actual, hora_actual))
    return cursor.fetchone()

# Función para verificar el registro del estudiante
def verify_student_registration(carnet):
    cursor = db.cursor()
    query = "SELECT id FROM Alumnos WHERE carnet = %s"
    cursor.execute(query, (carnet,))
    return cursor.fetchone()

# Función para verificar la inscripción del estudiante en la materia y grupo
def verify_student_enrollment(student_id, materia, grupo):
    cursor = db.cursor()
    query = """
    SELECT id FROM MateriasInscritas
    WHERE alumno = %s AND materia = %s AND grupo = %s
    """
    cursor.execute(query, (student_id, materia, grupo))
    return cursor.fetchone()

# Función para registrar la asistencia inicial con estado 'I'
def register_initial_attendance(materia, grupo):
    cursor = db.cursor()
    now = datetime.now()
    today = now.date()
    query = """
    INSERT INTO Asistencias (fechaHora, materia, alumno, grupo, estado)
    SELECT %s, %s, mi.alumno, %s, 'I'
    FROM MateriasInscritas mi
    LEFT JOIN Asistencias a ON mi.alumno = a.alumno AND mi.materia = a.materia AND DATE(a.fechaHora) = %s
    WHERE mi.materia = %s AND mi.grupo = %s AND a.id IS NULL
    """
    cursor.execute(query, (now, materia, grupo, today, materia, grupo))
    db.commit()

# Función para actualizar el estado de asistencia del estudiante
def update_attendance_state(student_id, materia, grupo, estado):
    cursor = db.cursor()
    now = datetime.now()
    query = """
    UPDATE Asistencias
    SET estado = %s, fechaHora = %s
    WHERE alumno = %s AND materia = %s AND grupo = %s AND estado = 'I'
    """
    cursor.execute(query, (estado, now, student_id, materia, grupo))
    db.commit()

# Función para registrar la asistencia del estudiante
def register_attendance(carnet):
    schedule = get_current_schedule()
    if not schedule:
        print("No hay clases en este momento.")
        return

    materia = schedule['materia']
    grupo = schedule['grupo']
    tolerancia = schedule['tolerancia']

    # Registrar la asistencia inicial de todos los estudiantes con estado 'I'
    register_initial_attendance(materia, grupo)
    print(f"Asistencia inicial registrada para todos los estudiantes en la materia {materia} y grupo {grupo} con estado 'I'.")

    student = verify_student_registration(carnet)
    if not student:
        print("Estudiante no registrado.")
        return

    student_id = student[0]

    enrollment = verify_student_enrollment(student_id, materia, grupo)
    if not enrollment:
        print("Estudiante no está inscrito en la materia o grupo correspondiente.")
        return

    now = datetime.now()
    hora_inicio = schedule['horaInicio']
    if isinstance(hora_inicio, timedelta):
        hora_inicio = (datetime.min + hora_inicio).time()
    start_time = datetime.combine(now.date(), hora_inicio)
    late_time = start_time + timedelta(minutes=tolerancia)
    
    if now > late_time:
        estado = 'T'
    else:
        estado = '•'

    update_attendance_state(student_id, materia, grupo, estado)
    print(f"Asistencia registrada para el estudiante {carnet} con estado {estado}.")

# Función para capturar video
def capture_video():
    global video_frame, rtsp_url, video
    while True:
        if video is None or not video.isOpened():
            video = cv2.VideoCapture(rtsp_url)
            time.sleep(2)  # Esperar un poco antes de reintentar la conexión
            continue

        success, frame = video.read()
        if not success:
            print("Error al capturar el video, reintentando...")
            video.release()
            video = None
            continue

        video_frame = frame
        cv2.waitKey(1)

# Función para procesar imágenes y detectar rostros
def process_image():
    global video_frame
    while True:
        schedule = get_current_schedule()
        if not schedule:
            print("No hay clases programadas en este momento.")
            break

        if video_frame is not None:
            resized_image = cv2.resize(video_frame, (int(video_frame.shape[1] / scl), int(video_frame.shape[0] / scl)))
            rgb_image = cv2.cvtColor(resized_image, cv2.COLOR_BGR2RGB)
            face_locations = fr.face_locations(rgb_image)
            unknown_encodings = fr.face_encodings(rgb_image, face_locations)

            for face_encoding, face_location in zip(unknown_encodings, face_locations):
                result = fr.compare_faces(face_encodings, face_encoding, 0.4)
                if True in result:
                    carnet = face_carnets[result.index(True)]
                    register_attendance(carnet)
                    print("Rostro detectado con carnet:", carnet)

# Variables globales
video_frame = None
video = None

# Crear hilos para capturar video y procesar imágenes
video_thread = threading.Thread(target=capture_video)
process_thread = threading.Thread(target=process_image)

# Iniciar hilos
video_thread.start()
process_thread.start()

# Esperar a que los hilos terminen
video_thread.join()
process_thread.join()

# Liberar recursos
if video is not None:
    video.release()
db.close()
print("Recursos liberados y programa terminado correctamente.")
