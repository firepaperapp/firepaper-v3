<?php 
/**
 * This is a component to send email from CakePHP using PHPMailer
 * @link http://bakery.cakephp.org/articles/view/94
 * @see http://bakery.cakephp.org/articles/view/94
 */

class EmailComponent extends Component
{
  /**
   * Send email using SMTP Auth by default.
   */
    var $from         = null;
    var $fromName     = null;
    var $smtpUserName = '';  // SMTP username
    var $smtpAuth = '';  // SMTP username
    var $smtpPassword = ''; // SMTP password
    var $smtpHostNames= "";  // specify main and backup server
    var $text_body = null;
    var $html_body = null;
    var $to = null;
    var $toName = null;
    var $subject = null;
    var $cc = null;
    var $bcc = null;
    var $template = 'email/html';
    var $attachments = null;
    var $to_arr = null;

    var $controller;

    function startup( &$controller ) {
      $this->controller = &$controller;
    }

    function bodyText() {
    /** This is the body in plain text for non-HTML mail clients
     */
   
      ob_start();
      $this->template . '_text';
      $temp_layout = $this->controller->layout;
      $this->controller->layout = '';  // Turn off the layout wrapping
      $this->controller->render($this->template . '_text'); 
      $mail = ob_get_clean();
      $this->controller->layout = $temp_layout; // Turn on layout wrapping again
      return $mail;
    }

    function bodyHTML() {
    /** This is HTML body text for HTML-enabled mail clients
     */
      ob_start();
      $temp_layout = $this->controller->layout;
      $this->controller->layout = 'email';  //  HTML wrapper for my html email in /app/views/layouts
      $this->controller->render($this->template . '_html'); 
      $mail = ob_get_clean();
      $this->controller->layout = $temp_layout; // Turn on layout wrapping again
      return $mail;
    }

    function attach($filename, $asfile = '') {
      if (empty($this->attachments)) {
        $this->attachments = array();
        $this->attachments[0]['filename'] = $filename;
        $this->attachments[0]['asfile'] = $asfile;
      } else {
        $count = count($this->attachments);
        $this->attachments[$count+1]['filename'] = $filename;
        $this->attachments[$count+1]['asfile'] = $asfile;
      }
    }


    function send()
    {
    App::import('Vendor', 'phpmailer', array('file' => 'phpmailer'.DS.'class.phpmailer.php')); 

    $mail = new PHPMailer();
    
    $mail->IsMail();            // set mailer to use SMTP
    $mail->SMTPAuth = false;     // turn on SMTP authentication
    $mail->Host   = 'localhost';
    $mail->Username = '';
    $mail->Password = '';
    
       
     $mail->From     = $this->from;
     $mail->FromName = $this->fromName;
     
     if (!empty($this->to_arr)) {
        foreach ($this->to_arr as $val) {
          $mail->AddAddress($val['to_address'], $val['to_name']);
        }
      }
     
    $mail->CharSet  = 'UTF-8';
    $mail->WordWrap = 50;  // set word wrap to 50 characters

    if (!empty($this->attachments)) {
      foreach ($this->attachments as $attachment) {
        if (empty($attachment['asfile'])) {
          $mail->AddAttachment($attachment['filename']);
        } else {
          $mail->AddAttachment($attachment['filename'], $attachment['asfile']);
        }
      }
    }

    $mail->IsHTML(true);  // set email format to HTML

    $mail->Subject = $this->subject;
  
    $mail->Body=$this->text_body; 

    $result = $mail->Send();

    if($result == false ) $result = $mail->ErrorInfo;

    return $result;
    }
    
    function sendEmail()
    {
    App::import('Vendor', 'phpmailer', array('file' => 'phpmailer'.DS.'class.phpmailer.php')); 

    $mail = new PHPMailer();
    
    $mail->IsMail();            // set mailer to use SMTP
    $mail->SMTPAuth = false;     // turn on SMTP authentication
    $mail->Host   = 'localhost';
    $mail->Username = '';
    $mail->Password = '';
    
       
     $mail->From     = $this->from;
     $mail->FromName = $this->fromName;
     $mail->AddAddress($this->to, $this->toName); 
     
     
    $mail->CharSet  = 'UTF-8';
    $mail->WordWrap = 50;  // set word wrap to 50 characters

    if (!empty($this->attachments)) {
      foreach ($this->attachments as $attachment) {
        if (empty($attachment['asfile'])) {
          $mail->AddAttachment($attachment['filename']);
        } else {
          $mail->AddAttachment($attachment['filename'], $attachment['asfile']);
        }
      }
    }

    $mail->IsHTML(true);  // set email format to HTML

    $mail->Subject = $this->subject;
  
    $mail->Body=$this->text_body; 

    $result = $mail->Send();

    if($result == false ) $result = $mail->ErrorInfo;

    return $result;
    }
    
    
	function attach_to($to_address, $to_name = '') {
		if (empty($this->to_arr)) {
			$this->to_arr = array();
			$this->to_arr[0]['to_address'] = $to_address;
			$this->to_arr[0]['to_name'] = $to_name;
		} else {
			$count = count($this->to_arr);
			$this->to_arr[$count+1]['to_address'] = $to_address;
			$this->to_arr[$count+1]['to_name'] = $to_name;
		}
	}    
}
?>