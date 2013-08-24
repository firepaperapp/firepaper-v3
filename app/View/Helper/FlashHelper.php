<?php 
class FlashHelper extends Helper
{
  var $helpers = array('Session');
  function show()
  {
    // Get the messages from the session
    $messages = $this->Session->read('messages');
    $html = '';
    
    // Add a div for each message using the type as the class
    foreach ($messages as $type => $msgs)
    {
      foreach ($msgs as $msg)
      {
        if (!empty($msg)) {
          $html .= "<div class='$type'><p>$msg</p></div>";
        }        
      }
    }
    $html .= "</div>";
    
    // Clear the messages array from the session
    $this->Session->delete('messages');
    
    return $this->output($html);
  }  
}