from flask import Flask, request, jsonify
from flask_cors import CORS
import numpy as np
from tensorflow.keras.layers import TFSMLayer
from io import BytesIO
from PIL import Image
import os

app = Flask(__name__)
CORS(app)

# Base directory (python-api folder)
BASE_DIR = os.path.dirname(os.path.abspath(__file__))

# Model folder is one level up (ecomm-l10/fruit_veg_model)
MODEL_PATH = os.path.join(BASE_DIR, "..", "fruit_veg_model")

# Load SavedModel using TFSMLayer (Keras 3 compatible)
model = TFSMLayer(MODEL_PATH, call_endpoint='serving_default')

# Class order (must match training)
classes = ['fresh', 'rotten', 'unknown']

# Confidence threshold
CONFIDENCE_THRESHOLD = 60


def predict_image(img_bytes):
    """
    Predict using in-memory image (no disk operations).
    """
    img = Image.open(BytesIO(img_bytes)).convert("RGB")
    img = img.resize((128, 128))

    img_array = np.array(img) / 255.0
    img_array = np.expand_dims(img_array, axis=0)

    # Predict (TFSMLayer returns dict)
    prediction = model(img_array)
    output = list(prediction.values())[0]

    predicted_index = np.argmax(output)
    predicted_class = classes[predicted_index]
    confidence = float(np.max(output)) * 100

    if confidence < CONFIDENCE_THRESHOLD or predicted_class == "unknown":
        return {"result": "Out of bound", "confidence": round(confidence, 2)}

    return {
        "result": predicted_class,
        "confidence": round(confidence, 2)
    }


@app.route("/predict", methods=["POST"])
def predict():
    if "image" not in request.files:
        return jsonify({"error": "No image uploaded"}), 400

    file = request.files["image"]

    if file.filename == "":
        return jsonify({"error": "Empty filename"}), 400

    try:
        img_bytes = file.read()
        result = predict_image(img_bytes)
    except Exception as e:
        return jsonify({"error": str(e)}), 500

    return jsonify(result)


@app.route("/", methods=["GET"])
def home():
    return jsonify({"message": "Fruit & Vegetable Freshness API"})


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5001)