import os
import time
from datetime import datetime
import cv2
from ConfigParser import SafeConfigParser
import warnings
from picamera import PiCamera
from picamera.array import PiRGBArray
import numpy as np
import thread
global filepath
global emailBreak
global lastSave
warnings.filterwarnings("ignore")
kernel = np.ones((9,9),np.uint8)
config = SafeConfigParser()
config.read('config.ini')
pixelTolerance = config.getint('main', 'pixelTolerance')
objTolerance = config.getint('main', 'objectTolerance')
filepath = config.get('main', 'picturesFilepath')
frameWidth = config.getint('main', 'frameWidth')
frameHeight = config.getint('main', 'frameHeight')
fps = config.getint('main', 'frameRate')
testWidth = config.getint('main', 'testWidth')
testHeight = config.getint('main', 'testHeight')
widthRatio = frameWidth/testWidth
heightRatio = frameHeight/testHeight
numAreaa = config.getint('main', 'numRejectAreas')
rejectAreas = config.get('main', 'rejectAreas')
emailBreak = config.getint('main', 'breakBetweenEmails')
lastSave = datetime.now()
emailLock = thread.allocate_lock()
def checkMotion(motionText, lastSave, now, secSinceEmail, ts, currFrame):
        if motionText == 'Motion':
                filename = filepath + "/motionFrame_"+ts+".jpg"
                cv2.imwrite(filename, currFrame)
                if secSinceEmail >= emailBreak:
                        print('WARNING :: Posiible Intruder! Email sent.')
                        filename2 = filepath + "/Email/snapshot.jpg"
                        cv2.imwrite(filename2, currFrame)
                        os.system("python /home/pi/sendEmail.py")
                        lastSave = now
        globals()['lastSave'] = lastSave
        emailLock.release()
camera = PiCamera()
camera.vflip = True
camera.resolution = tuple([frameWidth,frameHeight])
camera.framerate = fps
rawVideo = PiRGBArray(camera, size=tuple([frameWidth,frameHeight]))
refFrame = None
count = 0
warmUp = 25
for frames in camera.capture_continuous(rawVideo, format='bgr', use_video_port=True):
	currFrame = frames.array
	now = datetime.now()
	ts = now.strftime('%Y-%m-d_%H:%M:%S')
	rejectFrame = currFrame.copy()
	for i in range(0, numAreas):
		x1 = rejectAreas[i][0][0]
		y1 = rejectAreas[i][0][1]
		x2 = rejectAreas[i][1][0]
		y2 = rejectAreas[i][1][1]
		cv2.rectangle(rejectFrame, (x1, y1), (x2, y2), (0, 0, 255), -1)
	testFrame = cv2.addWeighted(rejectFrame, 1, currFrame, 0, 0)
	currFrame = cv2.addWeighted(rejectFrame, 0.5, currFrame, 0.5, 0)
	testFrame = cv2.resize(testFrame, (testWidth,testHeight))
	testFrame = cv2.cvtColor(testFrame, cv2.COLOR_BGR2GRAY)
	testFrame = cv2.GaussianBlur(testFrame, (25,25), 0)
	if refFrame is None:
		print('INFO :: Initializing motion detection')
		refFrame = testFrame.copy().astype('float')
		rawVideo.truncate(0)
		continue
	cv2.accumulateWeighted(testFrame, refFrame, 0.12)
	if count < warmUp:
		count += 1
		rawVideo.truncate(0)
		continue
	diffFrame = cv2.absdiff(testFrame, cv2.convertScaleAbs(refFrame))
	_, toleranceFrame = cv2.threshold(diffFrame, pixelTolerance, 255, cv2.THRESH_BINARY)
	toleranceFrame = cv2.morphologyEx(toleranceFrame, cv2.MORPH_OPEN, kernel)
	motionObjects, _ = cv2.findContours(toleranceFrame.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
	motionText = ''
	for obj in motionObjects:
		if cv2.contourArea(obj) > objTolerance:
			motionText = 'Motion'
			x, y, w, h = cv2.boundingRect(obj)
			x1 = int(x*widthRatio)
			y1 = int(y*heightRatio)
			x2 = int((x + w)*widthRatio)
			y2 = int((y + h)*heightRatio)
			cv2.rectangle(currFrame, (x1, y1), (x2, y2), (155, 155, 0), 3)
	if not emailLock.locked():
                emailLock.acquire()
                thread.start_new_thread(checkMotion, (motionText, lastSave, now, ((now - lastSave).seconds), ts, currFrame))
	timestamp = now.strftime('%a %b %d, %Y - %H:%M:%S')
	cv2.putText(currFrame, timestamp, (15, frameHeight - 15), 4, .5, (0, 115, 230), 1)
	header = 'Press ESC or q to exit'
	cv2.putText(currFrame, header, (15, 15), 4, .5, (0, 115, 230), 1)
	cv2.putText(currFrame, motionText, (frameWidth - 200, 50), 4, 1.5, (0, 115, 230), 2)
	cv2.imshow('Video Feed', currFrame)
	cv2.moveWindow('Video Feed', 50, 50)
	keyInput = cv2.waitKey(1) & 0xFF
	if (keyInput == ord('q')) or (keyInput == 27):
		cv2.destroyAllWindows()
		break
	rawVideo.truncate(0)