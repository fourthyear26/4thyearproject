import time
from datetime import datetime
import os
import smtplib
from email.MIMEMultipart import MIMEMultipart
from email.MIMEText import MIMEText
from email.MIMEBase import MIMEBase
from email import encoders

fromaddr = "thethirdeyecarleton@gmail.com"
toaddr = "thethirdeyecarleton@gmail.com"

msg = MIMEMultipart()

msg['From'] = fromaddr
msg['To'] = toaddr
msg['Subject'] = "Movement Detected! Is there an intruder?"

body = "Attached is a snapshot at the time of event."

msg.attach(MIMEText(body, 'plain'))

timestamp = datetime.now()
filename = timestamp.strftime('%Y-%m-d_%H:%M:%S')+".jpg"
attachment = open("/home/pi/Videos/Email/snapshot.jpg", "rb")

part = MIMEBase('application', 'octet-stream')
part.set_payload((attachment).read())
encoders.encode_base64(part)
part.add_header('Content-Disposition', "attachment; filename= %s" % filename)

msg.attach(part)

server = smtplib.SMTP('smtp.gmail.com', 587)
server.starttls()
server.login(fromaddr, "Canada123")
text = msg.as_string()
server.sendmail(fromaddr, toaddr, text)
server.quit()

#os.system('sudo rm snapshot.jpg')


