# Importando todos los módulos necesarios
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

    # Bucle para recuperar todas las codificaciones de las caras y almacenarlas en una lista
    for i, name in enumerate(face_names):
        face = fr.load_image_file(f"{faces_path}\\{name}")
        face_encodings.append(fr.face_encodings(face)[0])
        face_names[i] = name.split(".")[0]  # Remover la extensión del archivo para usar solo el nombre
    
    return face_encodings, face_names

# Recuperar las codificaciones de las caras y los nombres
face_encodings, face_names = get_face_encodings()

# Referencia a la webcam: 0  principal, 1  secundaria ...
video = cv2.VideoCapture(1)

# Variable para escalar el tamaño de la imagen
scl = 2

# Captura continua de video de la webcam
try:
    while True:
        success, image = video.read()
        if not success:
            break  # Si no se logra capturar la imagen, salir del bucle

        # Reducir el tamaño del frame actual para que el programa corra más rápido
        resized_image = cv2.resize(image, (int(image.shape[1] / scl), int(image.shape[0] / scl)))

        # Convertir la imagen de BGR (usado por OpenCV) a RGB (usado por face_recognition)
        rgb_image = cv2.cvtColor(resized_image, cv2.COLOR_BGR2RGB)

        # Obtener las ubicaciones de las caras y las codificaciones en el frame actual
        face_locations = fr.face_locations(rgb_image)
        unknown_encodings = fr.face_encodings(rgb_image, face_locations)

        # Iterar sobre cada codificación y ubicación de cara
        for face_encoding, face_location in zip(unknown_encodings, face_locations):
            # Comparar las caras conocidas con las desconocidas
            result = fr.compare_faces(face_encodings, face_encoding, 0.4)

            # Obtener el nombre correcto si se encontró una coincidencia
            if True in result:
                name = face_names[result.index(True)]
                top, right, bottom, left = face_location
                # Dibujar un rectángulo alrededor de la cara
                cv2.rectangle(image, (left * scl, top * scl), (right * scl, bottom * scl), (0, 0, 255), 2)
                # Establecer el tipo de fuente y mostrar el nombre de la persona reconocida
                font = cv2.FONT_HERSHEY_DUPLEX
                cv2.putText(image, name, (left * scl, bottom * scl + 20), font, 0.8, (255, 255, 255), 1)

        # Mostrar la imagen resultante en pantalla
        cv2.imshow("frame", image)
        if cv2.waitKey(1) & 0xFF == ord('q'):  # Esperar por la tecla 'q' para salir
            break

except KeyboardInterrupt:
    print("Programa interrumpido por el usuario")

finally:
    # Liberar la webcam y cerrar todas las ventanas
    video.release()
    cv2.destroyAllWindows()
    print("Recursos liberados y programa terminado correctamente.")
