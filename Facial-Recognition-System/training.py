import os
import cv2
import tensorflow as tf
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Conv2D, MaxPooling2D, Flatten, Dense
from tensorflow.keras.preprocessing.image import ImageDataGenerator
import numpy as np

# input and output folders
input_folder = 'images'  # input folder path
output_folder = 'Script/Dataset'

# create the output folder if it doesn't exist
os.makedirs(output_folder, exist_ok=True)

# load the images
image_files = os.listdir(input_folder)
images = []

# resize function
def resize_image(image, desired_size):
    if image.shape[:2] != desired_size:
        image = cv2.resize(image, desired_size)
    return image

for file in image_files:
    image_path = os.path.join(input_folder, file)
    image = cv2.imread(image_path)
    if image is not None:
        image = resize_image(image, (150, 150))  # Resize the image to a consistent shape
        images.append(image)
    else:
        print(f"Error loading image: {image_path}")


# augmentation parameters
num_augmented_images = 1000  # Number of augmented images to generate for each original image

# augmentation generator
augmentation = ImageDataGenerator(
    rotation_range=45,
    shear_range=16,
    horizontal_flip=True,
    vertical_flip=True,
)

# loop to generate augmented images
augmented_images = []

for i, image in enumerate(images):
    if image is not None:
        image = cv2.resize(image, (150, 150))  # Resize the image to a consistent shape
        image = np.expand_dims(image, axis=0)  # Add an extra dimension for batch size
        j = 0
        for augmented_image in augmentation.flow(image, batch_size=1, save_to_dir=output_folder, save_prefix=f"augmented_{i}", save_format="jpg"):
            augmented_images.append(augmented_image[0])
            j += 1
            if j >= num_augmented_images:
                break
    else:
        print(f"Skipping augmentation for image {i+1} due to loading error.")

# reshape the original images to match the shape of augmented images
images = np.array(images)
images = images.reshape((-1, 150, 150, 3))

# reshape augmented images to match the shape of original images
augmented_images = np.array(augmented_images)
augmented_images = augmented_images.reshape((-1, 150, 150, 3))

# combine original and augmented images
all_images = np.concatenate((images, augmented_images), axis=0)

# labels
labels = np.zeros(len(images))  # Assuming the original images are of class 0
labels = np.concatenate((labels, np.ones(len(augmented_images))), axis=0)  # Augmented images are of class 1

# converting images and labels to numpy arrays
all_images = np.array(all_images)
labels = np.array(labels)

# normalizing the image pixel values to [0, 1]
all_images = all_images.astype('float32') / 255.0

# spliting the data into training and testing sets
from sklearn.model_selection import train_test_split

train_images, test_images, train_labels, test_labels = train_test_split(all_images, labels, test_size=0.2, random_state=42)

# model architecture
model = Sequential([
    Conv2D(32, (3, 3), activation='relu', input_shape=(150, 150, 3)),
    MaxPooling2D((2, 2)),
    Conv2D(64, (3, 3), activation='relu'),
    MaxPooling2D((2, 2)),
    Conv2D(128, (3, 3), activation='relu'),
    MaxPooling2D((2, 2)),
    Flatten(),
    Dense(64, activation='relu'),
    Dense(1, activation='sigmoid')
])

# compiling the model
model.compile(optimizer='adam', loss='binary_crossentropy', metrics=['accuracy'])

# training the model
model.fit(train_images, train_labels, epochs=10, batch_size=32)

# evaluating the model on the test data
loss, accuracy = model.evaluate(test_images, test_labels)
print(f"Test loss: {loss}")
print(f"Test accuracy: {accuracy}")