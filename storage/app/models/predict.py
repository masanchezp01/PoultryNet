import sys
import json
import tensorflow as tf
import numpy as np
from PIL import Image
import os

# Cargar modelo y config
model_path = "poultry_coccidiosis_model.tflite"
labels_path = "poultry_labels.txt"

# Cargar modelo
interpreter = tf.lite.Interpreter(model_path=model_path)
interpreter.allocate_tensors()

# Cargar etiquetas
with open(labels_path, "r", encoding="utf-8") as f:
    labels = [line.strip() for line in f.readlines()]

# Obtener detalles de entrada/salida
input_details = interpreter.get_input_details()
output_details = interpreter.get_output_details()

def preprocess_image(image_path):
    """Preprocesar imagen igual que en el entrenamiento"""
    image = Image.open(image_path).convert('RGB')
    image = image.resize((224, 224))
    image_array = np.array(image).astype(np.float32)
    # Normalizar: (image / 127.5) - 1.0
    image_array = (image_array / 127.5) - 1.0
    return np.expand_dims(image_array, axis=0)

def predict(image_path):
    """Realizar predicción"""
    # Preprocesar imagen
    processed_image = preprocess_image(image_path)

    # Realizar predicción
    interpreter.set_tensor(input_details[0]['index'], processed_image)
    interpreter.invoke()

    predictions = interpreter.get_tensor(output_details[0]['index'])[0]

    # Formatear resultados
    results = []
    max_confidence = 0
    predicted_class = ""

    for i, confidence in enumerate(predictions):
        results.append({
            'class': labels[i],
            'confidence': float(confidence)
        })

        if confidence > max_confidence:
            max_confidence = confidence
            predicted_class = labels[i]

    return {
        'predictions': results,
        'predicted_class': predicted_class,
        'max_confidence': float(max_confidence)
    }

if __name__ == "__main__":
    # Leer argumentos
    image_path = sys.argv[1]
    output_path = sys.argv[2]

    # Realizar predicción
    result = predict(image_path)

    # Guardar resultado
    with open(output_path, 'w') as f:
        json.dump(result, f)
