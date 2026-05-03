# 👤 Facial Recognition System

![Python](https://img.shields.io/badge/Python-3.8%2B-blue)
![OpenCV](https://img.shields.io/badge/OpenCV-Supported-green)
![License](https://img.shields.io/badge/License-MIT-lightgrey)

A robust and efficient Facial Recognition System built with Python. This project utilizes computer vision to detect, recognize, and log faces in real-time using a webcam or video input. 

## 📖 Overview

This project was developed to automate the process of face detection and recognition. It can be easily adapted for various use cases, such as an automated attendance system, security access control, or user identification. The system extracts facial features, compares them against a known database of faces, and outputs the recognized identity.

## ✨ Features

*   **Real-Time Detection:** Detects faces in real-time using live webcam feeds.
*   **High Accuracy:** Utilizes advanced computer vision libraries for reliable face encoding and matching.
*   **Automated Logging (Optional):** Can be configured to automatically record the name and timestamp of recognized individuals into a CSV file (perfect for attendance tracking).
*   **Scalable Database:** Easily add new users to the system by adding their images to the designated faces directory.

## 🛠️ Technologies Used

*   **Python:** The core programming language.
*   **OpenCV (`cv2`):** Used for real-time computer vision, image processing, and video capture.
*   **face_recognition / Dlib:** (Update this based on what you actually used) Used for extracting facial encodings and performing the actual recognition mathematics.
*   **NumPy:** For handling large, multi-dimensional arrays and matrices.
*   **Pandas:** For data manipulation and exporting attendance logs.

## 🚀 Installation & Setup

Follow these instructions to get the project up and running on your local machine.

### Prerequisites

*   Python 3.8 or higher installed.
*   A working webcam.
*   (If using Dlib) CMake and a C++ compiler installed on your system.

### Steps

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/amirtamang12/facial-recognition-system.git](https://github.com/amirtamang12/facial-recognition-system.git)
    cd facial-recognition-system
    ```

2.  **Create a virtual environment (Recommended):**
    ```bash
    python -m venv venv
    source venv/bin/activate  # On Windows use `venv\Scripts\activate`
    ```

3.  **Install the required dependencies:**
    ```bash
    pip install -r requirements.txt
    ```

4.  **Add known faces:**
    *   Create a folder named `known_faces` (or whatever your code requires) in the root directory.
    *   Add clear, well-lit images of the people you want the system to recognize. 
    *   Name the image files with the person's name (e.g., `Amir_Tamang.jpg`).

## 💻 Usage

To start the facial recognition system, run the main Python script:

```bash
python main.py
