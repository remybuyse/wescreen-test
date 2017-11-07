<?php

class Mail
{
    public $subject;
    public $bodyText;
    public $body;
    public $recieverMail;
    public $recieverName;
    public $senderMail;
    public $senderName;
    private $_vars = array();

    public function __construct($senderMail, $senderName=null)
    {
        $this->senderMail = $senderMail;
        $this->senderName = $senderName;
    }
    
    public function setVar($k, $v)
    {
        $this->_vars[$k] = $v;
    }
    
    private function parseVars()
    {
        $arr_reg = array();
        $arr_rep = array();

        foreach ($this->_vars as $k => $v)
        {
            $arr_reg[] = '/\[#' . $k . '#\]/';
            $arr_rep[] = $v;
        }
        $this->subject = preg_replace($arr_reg, $arr_rep, $this->subject);
        if(!empty($this->bodyText)) $this->bodyText = preg_replace($arr_reg, $arr_rep, $this->bodyText);
        $this->body = preg_replace($arr_reg, $arr_rep, $this->body);
    }
    
    private function envoiMail($multiPart)
    {
        require_once 'Swift.php';
        require_once 'Swift/Connection/SMTP.php';
        
        //Start Swift
        $swift = & new Swift(new Swift_Connection_SMTP("localhost"));
        
        if(!$multiPart)
        {
            //Create the message
            $message = & new Swift_Message($this->subject, $this->body);
            $message->setContentType("text/html");
            $recipient = new Swift_Address($this->recieverMail, $this->recieverName);
            $sender = new Swift_Address($this->senderMail, $this->senderName);
        }
        else
        {
            // Create the message
            $message = & new Swift_Message($this->subject);
            $message->setContentType("multipart/alternative");
            $recipient = new Swift_Address($this->recieverMail, $this->recieverName);
            $sender = new Swift_Address($this->senderMail, $this->senderName);

            //Add some "parts"
            $message->attach(new Swift_Message_Part($this->bodyText, "text/plain"));
            $message->attach(new Swift_Message_Part($this->body, "text/html"));
        }

        //Now check if Swift actually sends it
        if ($swift->send($message, $recipient, $sender)) return true;
        else return false;
    }
    
    public function send($multiPart = null)
    {
        $this->parseVars();
        return $this->envoiMail($multiPart);
    }
}