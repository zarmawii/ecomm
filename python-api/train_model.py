import tensorflow as tf
from tensorflow.keras.preprocessing.image import ImageDataGenerator
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Conv2D, MaxPooling2D, Flatten, Dense, Dropout
import os

# =======================
# Dataset paths
# =======================
train_dir = r"D:\project\dataset\train"
test_dir  = r"D:\project\dataset\test"

# =======================
# Data augmentation for training
# =======================
train_datagen = ImageDataGenerator(
    rescale=1./255,
    rotation_range=20,
    width_shift_range=0.1,
    height_shift_range=0.1,
    horizontal_flip=True
)

test_datagen = ImageDataGenerator(rescale=1./255)

# =======================
# Load data
# =======================
train_generator = train_datagen.flow_from_directory(
    train_dir,
    target_size=(128,128),
    batch_size=16,
    class_mode='categorical'
)

test_generator = test_datagen.flow_from_directory(
    test_dir,
    target_size=(128,128),
    batch_size=16,
    class_mode='categorical'
)

# =======================
# CNN model
# =======================
model = Sequential([
    Conv2D(32, (3,3), activation='relu', input_shape=(128,128,3)),
    MaxPooling2D(2,2),
    Conv2D(64, (3,3), activation='relu'),
    MaxPooling2D(2,2),
    Flatten(),
    Dense(128, activation='relu'),
    Dropout(0.5),
    Dense(train_generator.num_classes, activation='softmax')  # 3 classes: fresh, rotten, unknown
])

# =======================
# Compile model
# =======================
model.compile(
    optimizer='adam',
    loss='categorical_crossentropy',
    metrics=['accuracy']
)

# =======================
# Train model
# =======================
history = model.fit(
    train_generator,
    validation_data=test_generator,
    epochs=20
)

# =======================
# Save trained model
# =======================
model.save(r"D:\project\fruit_veg_unknown_model.h5")
print("Training complete, model saved as fruit_veg_unknown_model.h5")