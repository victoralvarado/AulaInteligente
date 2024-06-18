import face_recognition as fr  # Para reconocer rostros
import numpy as np  # Para manejar listas y arrays
import cv2  # Para capturar video de la webcam
import os  # Para manejar directorios, rutas y nombres de archivos

# Ruta relativa al directorio que contiene todas las caras conocidas
faces_path = os.path.join(os.path.dirname(__file__), "images")

# Función para obtener los nombres de las caras y sus codificaciones
def get_face_encodings():
    face_names = os.listdir(faces_path)
    face_encodings = []
    for i, name in enumerate(face_names):
        face = fr.load_image_file(f"{faces_path}\\{name}")
        face_encodings.append(fr.face_encodings(face)[0])
        face_names[i] = name.split(".")[0]  # Remover la extensión del archivo
    return face_encodings, face_names

# Recuperar las codificaciones de las caras y los nombres
face_encodings, face_names = get_face_encodings()

# Referencia a la webcam
video = cv2.VideoCapture('rtsp://admin:Passw0rd777!@169.254.67.37/Streaming/Channels/101')

# Variable para escalar el tamaño de la imagen
scl = 2

# Captura continua de video de la webcam
try:
    while True:
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
                name = face_names[result.index(True)]
                print("Rostro detectado:", name)  # Imprimir el nombre del rostro detectado
                
                # Dibujar un rectángulo alrededor del rostro detectado
                top, right, bottom, left = [v * scl for v in face_location]
                cv2.rectangle(image, (left, top), (right, bottom), (0, 0, 255), 2)
                cv2.putText(image, name, (left, top - 10), cv2.FONT_HERSHEY_SIMPLEX, 0.9, (0, 0, 255), 2)

        # Mostrar la imagen con los rectángulos en una ventana
        cv2.imshow('Video', image)

        # Salir del bucle si se presiona la tecla 'q'
        if cv2.waitKey(1) & 0xFF == ord('q'):
            break

except KeyboardInterrupt:
    print("Programa interrumpido por el usuario")

finally:
    video.release()
    cv2.destroyAllWindows()
    print("Recursos liberados y programa terminado correctamente.")
