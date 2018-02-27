<?php

namespace App\Core;

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

class Email {

	protected $mail;

	public function __construct(){

		$this->mail = new PHPMailer(true);

		try{

			$this->mail->SMTPDebug = 0;                                 
		    $this->mail->isSMTP();                                      
		    $this->mail->Host = MAILHOST;  								
		    $this->mail->SMTPAuth = true;                               
		    $this->mail->Username = MAILUSER;                 
		    $this->mail->Password = MAILPASS;                           
		    $this->mail->SMTPSecure = 'ssl';                            
			$this->mail->Port = MAILPORT;  

		}catch (Exception $e){
			echo 'Message could not be sent. Mailer Error: ', $this->mail->ErrorInfo;
		}
	}

	public function send($from,$to,$subject,$body,$plain = '',$fromName = '',$toName = ''){

		$this->mail->setFrom($from,$fromName);
		$this->mail->addAddress($to,$toName);
		$this->mail->isHTML(true);
		$this->mail->Subject = $subject;
		$this->mail->Body = $body;
		$this->mail->AltBody = $plain;

		return $this->mail->send();
	}
}