import smtplib,email
from email.Message import Message
SMTP_SERVER='localhost'
SMTP_FROM='monitor@domain.com'
SMTP_USER=''
SMTP_PASSWD=''
SMTP_PORT='25'


default_mail_subject="Database connection monitor notification"
default_mail_content="""
Hi guys,

Routine English hyperlink process has finished

Best regards
LexisNexis China
"""
def connectToSMTP():
        """
        Connect to smtp server
        Return a smtp instance which encapsulates a SMTP connection
        """
        #server=smtplib.SMTP(SMTP_SERVER,SMTP_PORT)
        server=smtplib.SMTP(SMTP_SERVER)
        server.ehlo()
        #server.login(SMTP_USER,SMTP_PASSWD)
        return server

def sendMessage(server,to,subject,content):
        msg=Message()
        msg['Mime-Version']='1.0'
        msg['From']=SMTP_FROM
        msg['To']=to
        msg['Subject']=subject
        msg['Date']=email.Utils.formatdate()
        msg.set_payload(content)
        try:
                failed=server.sendmail(SMTP_USER,to,str(msg))
        except Exception,e:
                #print "send mail to %s failed" % to
                pass

def sendMail(to,subject=default_mail_subject,content=default_mail_content):
        if to and subject:
                server=connectToSMTP()
                sendMessage(server,to,subject,content)

def sendNotification(mailContent=''):
        mailAddrList=['email1','email2']
        for mail_addr  in mailAddrList:
                sendMail(mail_addr,default_mail_subject,mailContent)
