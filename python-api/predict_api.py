from flask import Flask, request, jsonify
from flask_cors import CORS
import numpy as np
from PIL import Image
import tensorflow as tf
from io import BytesIO
import os

app = Flask(**name**)
CORS(app)

# Base directory

BASE_DIR = os.path.dirname(os.path.abspath(**file**))

# Load TFLite model

MODEL_PATH = os.path.join(BASE_DIR, "model.tflite")

interpreter = tf.lite.Interpreter(model_path=MODEL_PATH)
interpreter.allocate_tensors()

input_details = interpreter.get_input_details()
output_details = interpreter.get_output_details()

# Class labels

classes = ["fresh", "rotten", "unknown"]

CONFIDENCE_THRESHOLD = 60

def predict_image(img_bytes):

```
img = Image.open(BytesIO(img_bytes)).convert("RGB")
img = img.resize((128, 128))

img_array = np.array(img) / 255.0
img_array = np.expand_dims(img_array, axis=0).astype("float32")

interpreter.set_tensor(input_details[0]["index"], img_array)
interpreter.invoke()

output = interpreter.get_tensor(output_details[0]["index"])

predicted_index = np.argmax(output)
predicted_class = classes[predicted_index]
confidence = float(np.max(output)) * 100

if confidence < CONFIDENCE_THRESHOLD or predicted_class == "unknown":
    return {"result": "Out of bound", "confidence": round(confidence, 2)}

return {
    "result": predicted_class,
    "confidence": round(confidence, 2)
}
```

@app.route("/predict", methods=["POST"])
def predict():

```
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
```

@app.route("/", methods=["GET"])
def home():
return jsonify({"message": "Fruit & Vegetable Freshness API"})

if **name** == "**main**":
port = int(os.environ.get("PORT", 10000))
app.run(host="0.0.0.0", port=port)
