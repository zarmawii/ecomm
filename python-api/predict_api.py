from flask import Flask, request, jsonify
from flask_cors import CORS
import numpy as np
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing import image
import os
import uuid

app = Flask(__name__)
CORS(app)

# Base directory (important for deployment)
BASE_DIR = os.path.dirname(os.path.abspath(__file__))

# Model path
MODEL_PATH = os.path.join(BASE_DIR, "fruit_veg_unknown_model.h5")

# Upload folder
UPLOAD_FOLDER = os.path.join(BASE_DIR, "uploads")
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

# Load model once
model = load_model(MODEL_PATH)

# Must match training class order
classes = ['fresh', 'rotten', 'unknown']

# Confidence threshold
CONFIDENCE_THRESHOLD = 60


def predict_image(img_path):
    img = image.load_img(img_path, target_size=(128, 128))
    img_array = image.img_to_array(img) / 255.0
    img_array = np.expand_dims(img_array, axis=0)

    prediction = model.predict(img_array, verbose=0)

    predicted_index = np.argmax(prediction)
    predicted_class = classes[predicted_index]
    confidence = float(np.max(prediction)) * 100

    # Low confidence → Out of bound
    if confidence < CONFIDENCE_THRESHOLD:
        return {"result": "Out of bound", "confidence": confidence}

    if predicted_class == "unknown":
        return {"result": "Out of bound", "confidence": confidence}

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

    # Create unique filename
    unique_filename = str(uuid.uuid4()) + ".jpg"
    file_path = os.path.join(UPLOAD_FOLDER, unique_filename)

    # Save uploaded image
    file.save(file_path)

    try:
        result = predict_image(file_path)
    except Exception as e:
        return jsonify({"error": str(e)}), 500
    finally:
        # Delete image after prediction
        if os.path.exists(file_path):
            os.remove(file_path)

    return jsonify(result)


@app.route("/", methods=["GET"])
def home():
    return jsonify({"message": "Fruit & Vegetable Freshness Prediction API"})


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5001)