import tensorflow as tf
from tensorflow.keras.layers import TFSMLayer

# Load SavedModel using TFSMLayer (Keras 3 compatible)
model = TFSMLayer("fruit_veg_model", call_endpoint="serving_default")

# Create a simple wrapper model
inputs = tf.keras.Input(shape=(128,128,3))
outputs = model(inputs)

wrapped_model = tf.keras.Model(inputs, outputs)

# Convert to TFLite
converter = tf.lite.TFLiteConverter.from_keras_model(wrapped_model)
tflite_model = converter.convert()

# Save file
with open("model.tflite", "wb") as f:
    f.write(tflite_model)

print("✅ Model converted successfully to model.tflite")