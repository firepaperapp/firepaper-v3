<?php
App::uses('Component', 'Controller');
class GeneralFunctionComponent extends Component {
    
    public $components = array('Session', 'Cookie');

   public function startup(Controller $controller) {
       $this->Controller = $controller; 
     
    }
    public function checkUserLogin(){
         if(!$this->Session->read('userid')){
             echo "<script>window.location.href='".SITE_HTTP_URL.'login'."' </script>";
            // $this->Controller->redirect();
         }
    }
    
}