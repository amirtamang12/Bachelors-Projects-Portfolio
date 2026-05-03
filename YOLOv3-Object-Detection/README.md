# 🤖 YOLOv3 Real-Time Object Detection

![Python](https://img.shields.io/badge/Python-3.8%2B-blue)
![OpenCV](https://img.shields.io/badge/OpenCV-Supported-green)
![Machine Learning](https://img.shields.io/badge/Machine%20Learning-YOLOv3-orange)

A high-performance computer vision script that utilizes pre-trained YOLOv3 (You Only Look Once) models to detect, classify, and track objects in real-time video streams and static inputs.

## 📖 Overview

This project demonstrates the implementation of deep learning-based object detection. Unlike traditional classifiers, YOLOv3 looks at the entire image during training and test time, making it exceptionally fast and accurate. The script processes video input, identifies multiple objects within the frame, and draws bounding boxes with confidence scores.

## ✨ Features

*   **Real-Time Processing:** Capable of analyzing live video streams or pre-recorded `.mp4` files.
*   **Multi-Object Classification:** Detects and classifies up to 80 different object categories (based on the COCO dataset).
*   **Confidence Thresholding:** Filters out weak predictions to ensure high-accuracy bounding boxes.
*   **Non-Maximum Suppression (NMS):** Eliminates redundant overlapping bounding boxes for clean visual output.

## 🛠️ Technologies Used

*   **Python:** Core scripting language.
*   **OpenCV (`cv2`):** Used for reading video frames, image manipulation, and rendering the bounding boxes.
*   **YOLOv3 Architecture:** Deep learning model weights and configuration files.
*   **NumPy:** For high-performance array and matrix mathematics.

## 🚀 Installation & Setup

1.  **Clone the repository and navigate to the folder:**
    ```bash
    git clone [https://github.com/amirtamang12/Bachelors-Projects-Portfolio.git](https://github.com/amirtamang12/Bachelors-Projects-Portfolio.git)
    cd Bachelors-Projects-Portfolio/YOLOv3-Object-Detection
    ```

2.  **Install dependencies:**
    ```bash
    pip install opencv-python numpy
    ```

3.  **Download YOLOv3 Weights:**
    *Note: The `.weights` file is too large for standard GitHub hosting. You must download it manually.*
    *   Download `yolov3.weights` from the official Darknet website: [https://pjreddie.com/media/files/yolov3.weights](https://pjreddie.com/media/files/yolov3.weights)
    *   Place the downloaded file into the `models/` directory alongside the `.cfg` file.

## 💻 Usage

To run the object detection script on a sample video:
```bash
python detect.py --input sample_video.mp4
