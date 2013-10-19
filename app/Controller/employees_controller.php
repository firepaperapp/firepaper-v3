<?php // File -> app/controllers/employees_controller.php 

class EmployeesController extends AppController { 
    var $name = 'Employees'; 
    var $components = array('SwiftMailer'); 
     
    function mail() {       
        $this->SwiftMailer->smtpType = 'tls'; 
        $this->SwiftMailer->smtpHost = 'smtp.gmail.com'; 
        $this->SwiftMailer->smtpPort = 465; 
        $this->SwiftMailer->smtpUsername = 'nsberrow@gmail.com'; 
        $this->SwiftMailer->smtpPassword = 'steven1980'; 

        $this->SwiftMailer->sendAs = 'html'; 
        $this->SwiftMailer->from = 'nsberrow@gmail.com'; 
        $this->SwiftMailer->fromName = 'New bakery component'; 
        $this->SwiftMailer->to = 'nsberrow@gmail.com'; 
        //set variables to template as usual 
        $this->set('message', 'My message'); 
         
        try { 
            if(!$this->SwiftMailer->send('im_excited', 'My subject')) { 
                $this->log("Error sending email"); 
            } 
        } 
        catch(Exception $e) { 
              $this->log("Failed to send email: ".$e->getMessage()); 
        } 
        $this->redirect($this->referer(), null, true); 
    } 
} 
?>