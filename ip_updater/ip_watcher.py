from ftplib import FTP
from requests import get
import threading
def ipupdate():
    #get ip from API
    ip = get('https://api.ipify.org').text
    print('My public IP address is: {}'.format(ip))
    #write ip to file
    filename = 'my_current_external_ip.txt'
    text_file = open(filename, "w")
    text_file.write(ip)
    text_file.close()
    #establish FTP connection and send file to FTP server
    ftp = FTP('ftpaddr')
    ftp.set_debuglevel(1)
    ftp.login('usrname','pass')

    ftp.storbinary('STOR '+filename, open(filename,'rb'))
    ftp.retrlines('LIST')

    ftp.quit()
    #threading.Timer(10.0, ipupdate).start() #lets you repeat updating
ipupdate()
