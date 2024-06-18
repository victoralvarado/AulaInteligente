# Importando las bibliotecas necesarias
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing.image import img_to_array
import numpy as np
import cv2
import imutils

# Tipos de emociones del detector classes = ['angry', 'disgust', 'fear', 'happy', 'neutral', 'sad', 'surprise']
classes = ["enojado", "disgustado", "temeroso", "feliz", "neutral", "triste", "sorprendido"]
# Cargamos el modelo de detección de rostros
prototxtPath = r"face_detector\deploy.prototxt"
weightsPath = r"face_detector\res10_300x300_ssd_iter_140000.caffemodel"
faceNet = cv2.dnn.readNet(prototxtPath, weightsPath)

# Carga el detector de clasificación de emociones
emotionModel = load_model("modelFEC.h5")

# Se crea la captura de video
cam = cv2.VideoCapture('rtsp://admin:Passw0rd777!@169.254.67.37/Streaming/Channels/101', cv2.CAP_DSHOW)

# Función para predecir emociones en rostros detectados
def predict_emotion(frame, faceNet, emotionModel):
    blob = cv2.dnn.blobFromImage(frame, 1.0, (224, 224), (104.0, 177.0, 123.0))
    faceNet.setInput(blob)
    detections = faceNet.forward()
    faces = []
    locs = []
    preds = []

    for i in range(0, detections.shape[2]):
        confidence = detections[0, 0, i, 2]
        if confidence > 0.4:
            box = detections[0, 0, i, 3:7] * np.array([frame.shape[1], frame.shape[0], frame.shape[1], frame.shape[0]])
            (Xi, Yi, Xf, Yf) = box.astype("int")

            face = frame[Yi:Yf, Xi:Xf]
            face = cv2.cvtColor(face, cv2.COLOR_BGR2GRAY)
            face = cv2.resize(face, (48, 48))
            face = img_to_array(face)
            face = np.expand_dims(face, axis=0)

            faces.append(face)
            locs.append((Xi, Yi, Xf, Yf))
            pred = emotionModel.predict(face)
            preds.append(pred[0])

    return (locs, preds)

while True:
    ret, frame = cam.read()
    frame = imutils.resize(frame, width=640)
    (locs, preds) = predict_emotion(frame, faceNet, emotionModel)

    for (box, pred) in zip(locs, preds):
        (Xi, Yi, Xf, Yf) = box
        label = "{}: {:.0f}%".format(classes[np.argmax(pred)], max(pred) * 100)
        cv2.rectangle(frame, (Xi, Yi - 40), (Xf, Yi), (255, 0, 0), -1)
        cv2.putText(frame, label, (Xi + 5, Yi - 15), cv2.FONT_HERSHEY_SIMPLEX, 0.8, (0, 255, 0), 2)
        cv2.rectangle(frame, (Xi, Yi), (Xf, Yf), (255, 0, 0), 3)

    cv2.imshow("Frame", frame)
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

cv2.destroyAllWindows()
cam.release()
