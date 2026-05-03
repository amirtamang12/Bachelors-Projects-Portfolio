import cv2
import numpy as np
import datetime
import os
import matplotlib.pyplot as plt

# If the "detectedImg" folder doesn't already exist, create one.
if not os.path.exists("detectedImg"):
    os.makedirs("detectedImg")

# load YOLO model
net = cv2.dnn.readNet("yolov3.weights", "yolov3.cfg")

# load class names (list of object categories that YOLO can detect)
classes = []
with open("coco.names", "r") as f:
    classes = [line.strip() for line in f.readlines()]

# YOLO model names if it doesn't exist
output_layers = net.getUnconnectedOutLayersNames()
colors = np.random.uniform(0, 255, size=(len(classes), 3))

# open video capture
cap = cv2.VideoCapture("video/nv232.MOV")

# set the desired frame rate (adjust as needed) 
desired_frame_rate = 30
cap.set(cv2.CAP_PROP_FPS, desired_frame_rate)

# create a background subtractor
fgbg = cv2.createBackgroundSubtractorMOG2(history=100, varThreshold=40) 

# initialize variables to store the best image
best_confidence = 0
best_frame = None
paused = False
show_best_image = False

# Set the centre of the frame as the area to check object placements in.
middle_region = (0.4, 0.6)  # adjust as needed

while True:
    # read a frame from the video
    ret, frame = cap.read()
    if not ret:
        break

    if not paused:
        # reduce processing demand by scaling the frame.
        frame = cv2.resize(frame, None, fx=0.4, fy=0.4)
        height, width, channels = frame.shape

        # apply background subtraction to detect motion
        fgmask = fgbg.apply(frame)

        # perform object detection using YOLO on the frame
        blob = cv2.dnn.blobFromImage(
            frame, 0.00392, (416, 416), (0, 0, 0), True, crop=False
        )

        net.setInput(blob)
        outs = net.forward(output_layers)

        # object detection code
        class_ids = []
        confidences = []
        boxes = []

        for out in outs:
            for detection in out:
                scores = detection[5:]
                class_id = np.argmax(scores)
                confidence = scores[class_id]
                if confidence > 0.5:

                    # object detected
                    center_x = int(detection[0] * width)
                    center_y = int(detection[1] * height)
                    w = int(detection[2] * width)
                    h = int(detection[3] * height)

                    # rectangle coordinates
                    x = int(center_x - w / 2)
                    y = int(center_y - h / 2)

                    # check if there's movement in the detection area
                    if np.mean(fgmask[y: y + h, x: x + w]) > 10:
                        boxes.append([x, y, w, h])
                        confidences.append(float(confidence))
                        class_ids.append(class_id)

        # find the detection with the highest confidence
        if confidences:
            max_confidence_idx = np.argmax(confidences)
            best_confidence = confidences[max_confidence_idx]
            best_frame = frame.copy()

            # verify that the identified object's center is in the region in the middle.
            x, y, w, h = boxes[max_confidence_idx]
            center_x = x + w // 2
            center_y = y + h // 2
            if middle_region[0] < center_x / width < middle_region[1]:

                # object is in the center; keep the frame.
                timestamp = datetime.datetime.now().strftime("%Y-%m-%d_%H-%M-%S")
                filename = os.path.join(
                    "detectedImg", f"object_detected_{timestamp}.jpg")
                cv2.imwrite(filename, best_frame)

    # To get rid of overlapping bounding boxes, using non-maximum suppression.
    indexes = cv2.dnn.NMSBoxes(boxes, confidences, 0.5, 0.4)

    font = cv2.FONT_HERSHEY_PLAIN
    for i in range(len(boxes)):
        if i in indexes:
            x, y, w, h = boxes[i]
            label = str(classes[class_ids[i]])
            color = colors[i]
            cv2.rectangle(frame, (x, y), (x + w, y + h), color, 2)
            cv2.putText(frame, label, (x, y + 30), font, 1, color, 3)

    # Display the video stream
    cv2.imshow("Video", frame)

    # display the image that was captured in a separate Matplotlib window.
    if show_best_image and best_frame is not None:
        plt.imshow(cv2.cvtColor(best_frame, cv2.COLOR_BGR2RGB))
        plt.title("Best Detection")
        plt.show()
        show_best_image = False

    # user controls: 'p' for pause/resume, 'q' to quit, 's' to show the best image
    key = cv2.waitKey(1) & 0xFF
    if key == ord("p"):
        paused = not paused
    elif key == ord("q"):
        break
    elif key == ord("s"):
        show_best_image = True

# close all open windows after releasing the video capture.
cap.release()
cv2.destroyAllWindows()
