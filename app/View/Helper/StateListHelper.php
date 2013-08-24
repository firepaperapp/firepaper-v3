<?php 
/**
 * Helper for outputing a country select list.
 *
 * Allows you to include a selec list of all countries using 1 line of code.
 *
 * Author: Tane Piper (digitalspaghetti@gmail.com)
 * URL: http://digitalspaghetti.me.uk
 *
 * PHP versions 4 and 5
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 */

class StateListHelper extends FormHelper
{
    
    var $helpers = array('Form');
    
    function select($fieldname, $label, $default="  ", $attributes = null)
    {
        $list = '<div class="fl w200 tal">';
        //$list .= $this->Form->label($label);
        $list .= $this->Form->select($fieldname ,array(
                '  ' =>    __('Please select a state'),  
                '1'=>"Alabama",
                '2'=>"Alaska", 
                '3'=>"Arizona", 
                '4'=>"Arkansas", 
                '5'=>"California", 
                '6'=>"Colorado", 
                '7'=>"Connecticut" 
                ), $default, $attributes);
        $list .= '</div>';
        return $this->output($list);
    }

} 
?>