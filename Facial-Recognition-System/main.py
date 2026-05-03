import cv2
import face_recognition
import numpy as np
import csv
import os
import pyttsx3 as textSpeach
from datetime import datetime
import tkinter as tk


engine = textSpeach.init()

# initializing Tkinter window
window = tk.Tk()

# created labels for student information and attendance status
student_info_label = tk.Label(window, text="Student Information")
attendance_label = tk.Label(window, text="Attendance Status")

# created text boxes to display student information and attendance status
student_info_text = tk.Text(window, height=10, width=30)
attendance_text = tk.Text(window, height=10, width=30)

# grid layout for labels and text boxes
student_info_label.grid(row=0, column=0)
attendance_label.grid(row=0, column=1)
student_info_text.grid(row=1, column=0)
attendance_text.grid(row=1, column=1)

# function to update student information and attendance status
def update_student_info(name):
    # update student information text box
    student_info_text.delete("1.0", tk.END)
    student_info_text.insert(tk.END, name)

    # update attendance status text box
    attendance_text.delete("1.0", tk.END)
    attendance_text.insert(tk.END, "Present")

# function to resize image
def resize(img, size):
    width = int(img.shape[1] * size)
    height = int(img.shape[0] * size)
    dimention = (width, height)
    return cv2.resize(img, dimention, interpolation=cv2.INTER_AREA)

# calling image dataset 
path = 'images'
student_img = []
student_Name = []
myList = os.listdir(path)

for cl in myList:
    curImg = cv2.imread(f'{path}/{cl}')
    student_img.append(curImg)
    student_Name.append(os.path.splitext(cl)[0])

# function for encoding images
def findEncoding(image):
    encoding_img = []
    for img in image:
        if img is None:
            continue
        img = resize(img, 0.50)
        img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        encoding = face_recognition.face_encodings(img)[0]
        encoding_img.append(encoding)
    return encoding_img

# function for marking attendance
def MarkAttendance(name):
    with open('attedence.csv', 'r+') as f:
        myDatalist = f.readlines()
        nameList = []
        for line in myDatalist:
            entry = line.split(',')
            nameList.append(entry[0])

        now = datetime.now()
        datestr = now.strftime('%Y-%m-%d')
        timestr = now.strftime('%H:%M')

        if len(myDatalist) == 0:  # checking if the file is empty
            f.write("Name, Date, Time\n")
        
        if name not in nameList:
            f.writelines(f'\n{name},{datestr}, {timestr}\n')
            statement = str('Welcome to class ' + name)
            engine.say(statement)
            engine.runAndWait()

            # called update_student_info to update GUI
        update_student_info(name)

encode_list = findEncoding(student_img)

vid = cv2.VideoCapture(0)

while True:
    success, frame = vid.read()

    if not success:
        break

    small_frame = cv2.resize(frame, (0, 0), None, 0.25, 0.25)

    faces_in_frame = face_recognition.face_locations(small_frame)
    encode_inframe = face_recognition.face_encodings(small_frame, faces_in_frame)

    for encodeFace, faceloc in zip(encode_inframe, faces_in_frame):
        matches = face_recognition.compare_faces(encode_list, encodeFace)
        faces_distance = face_recognition.face_distance(encode_list, encodeFace)
        print(faces_distance)
        matchIndex = np.argmin(faces_distance)

        if matches[matchIndex]:
            name = student_Name[matchIndex].upper()
            y1, x2, y2, x1 = faceloc
            y1, x2, y2, x1 = y1 * 4, x2 * 4, y2 * 4, x1 * 4
            cv2.rectangle(frame, (x1, y1), (x2, y2), (0, 255, 0), 3)
            cv2.rectangle(frame, (x1, y2 - 25), (x2, y2), (0, 255, 0), cv2.FILLED)
            cv2.putText(frame, name, (x1 + 6, y2 - 6), cv2.FONT_HERSHEY_COMPLEX, 1, (255, 255, 255), 2)
            MarkAttendance(name)

    cv2.imshow('video', frame)
    if cv2.waitKey(1) & 0xFF == ord('c'):
        break

vid.release()
window.mainloop()
cv2.destroyAllWindows()
