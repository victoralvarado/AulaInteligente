import face_recognition as fr
import numpy as np
import cv2
import os
import threading

# Ruta relativa al directorio que contiene todas las caras conocidas
faces_path = os.path.join(os.path.dirname(__file__), "images")

# Función para obtener los nombres de las caras y sus codificaciones
def get_face_encodings():
    face_names = os.listdir(faces_path)
    face_encodings = []

    for i, name in enumerate(face_names):
        face = fr.load_image_file(os.path.join(faces_path, name))
        face_encodings.append(fr.face_encodings(face)[0])
        face_names[i] = name.split(".")[0]  # Remover la extensión del archivo para usar solo el nombre
    
    return face_encodings, face_names

# Recuperar las codificaciones de las caras y los nombres
face_encodings, face_names = get_face_encodings()

# Variables compartidas
frame = None
lock = threading.Lock()

# Función para capturar video en un hilo
def capture_video():
    global frame
    video = cv2.VideoCapture('rtsp://admin:Passw0rd777!@169.254.67.37/Streaming/Channels/1')

    if not video.isOpened():
        print("No se pudo abrir la cámara")
        return

    video.set(cv2.CAP_PROP_BUFFERSIZE, 5)
    video.set(cv2.CAP_PROP_FPS, 15)

    while True:
        success, image = video.read()
        if not success:
            print("No se pudo capturar la imagen de la cámara")
            break

        with lock:
            frame = image.copy()

    video.release()

# Función para procesar el video en otro hilo
def process_video():
    global frame
    scl = 2

    while True:
        with lock:
            if frame is None:
                continue
            resized_image = cv2.resize(frame, (int(frame.shape[1] / scl), int(frame.shape[0] / scl)))
            rgb_image = cv2.cvtColor(resized_image, cv2.COLOR_BGR2RGB)

        face_locations = fr.face_locations(rgb_image)
        unknown_encodings = fr.face_encodings(rgb_image, face_locations)

        for face_encoding, face_location in zip(unknown_encodings, face_locations):
            result = fr.compare_faces(face_encodings, face_encoding, 0.4)

            if True in result:
                name = face_names[result.index(True)]
                top, right, bottom, left = face_location
                with lock:
                    cv2.rectangle(frame, (left * scl, top * scl), (right * scl, bottom * scl), (0, 0, 255), 2)
                    font = cv2.FONT_HERSHEY_DUPLEX
                    cv2.putText(frame, name, (left * scl, bottom * scl + 20), font, 0.8, (255, 255, 255), 1)

        with lock:
            if frame is not None:
                cv2.imshow("frame", frame)
                if cv2.waitKey(1) & 0xFF == ord('q'):
                    break

    cv2.destroyAllWindows()

# Crear e iniciar los hilos
capture_thread = threading.Thread(target=capture_video)
process_thread = threading.Thread(target=process_video)

capture_thread.start()
process_thread.start()

capture_thread.join()
process_thread.join()