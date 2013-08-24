<?
class AppError extends ErrorHandler {

 function error404() {
  $this->controller->beforeFilter(); 
  parent::error404();
 }

}

?>

