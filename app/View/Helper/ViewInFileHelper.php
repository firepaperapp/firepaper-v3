<?php
/**
 * ViewInFile helper. Allow the rendered view to be captured to a file
 */
class ViewInFileHelper extends Helper 
{   
      /* we use afterRender to get the content of the rendered view and store it in the file (if found) */
     
    function afterRender()
    {
           $lview = ClassRegistry::getObject('view'); 

       $OutInFile = $lview->getVar('ViewInFile');
       
       if(!empty($OutInFile) && isset($OutInFile['file']))
       {
          if(isset($OutInFile['clean']) && $OutInFile['clean'] === true)
          {
             $out = ob_get_clean();
             ob_start();
          }   
          else
             $out = ob_get_contents();
          
          /* this might not work in PHP4 ?? */
                     
          file_put_contents($OutInFile['file'], $out);     

          if(isset($OutInFile['redirect']) && !empty($OutInFile['redirect']))          
          {                         
             echo '<script type="text/javascript">';
             echo 'window.location.href="'.FULL_BASE_URL.$lview->loaded['html']->url($OutInFile['redirect']).'";';               
             echo '</script>';
          }
           }   
    }
    
    /* Allow to get the file name into the view itself */
    
    function getOutFileName()
    {
         $lview = ClassRegistry::getObject('view'); 
       $OutInFile = $lview->getVar('ViewInFile');
       
       return is_array($OutInFile) && isset($OutInFile['file']) ? $OutInFile['file'] : null;          
    }
}
?> 