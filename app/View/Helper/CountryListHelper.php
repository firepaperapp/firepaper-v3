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


class CountryListHelper extends FormHelper
{
    
    var $helpers = array('Form');
    
    function select($fieldname, $label, $default=" ", $attributes="")
    {
        $list = '<div class="fl w200 tal" style="width:100px;">';
       // $list .= $this->Form->label($fieldname, $label);
        $list .= $this->Form->select($fieldname , array(
            ' '  =>__('Please select a country'),
            '1' =>__('Afganistan'),
            '2' =>__('Albania'),
            '3' =>__('Algeria'),
            '4' => __('American Samoa'),
            '5' => __('Andorra'), 
            '6' => __('Angola')
            ), $default, $attributes);
        $list .= '</div>';
        return $this->output($list);
    }
    
   

}
?> 