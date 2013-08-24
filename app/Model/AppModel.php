<?php
/* SVN FILE: $Id: app_model.php 2951 2006-05-25 22:12:33Z phpnut $ */
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright (c)	2006, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright (c) 2006, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP Project
 * @package			cake
 * @subpackage		cake.cake
 * @since			CakePHP v 0.2.9
 * @version			$Revision: 2951 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2006-05-25 17:12:33 -0500 (Thu, 25 May 2006) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Application model for Cake.
 *
 * This is a placeholder class.
 * Create the same file in app/app_model.php
 * Add your application-wide methods to the class, your models will inherit them.
 *
 * @package		cake
 * @subpackage	cake.cake
 */
class AppModel extends Model{

 /**
     * Adds to a HABTM association some instances
     *
     * @param integer $id The id of the record in this model
     * @param mixed $assoc_name The name of the HABTM association
     * @param mixed $assoc_id The associated id or an array of id's to be added
     * @return boolean Success
     */
    function addAssoc($id,$assoc_name,$assoc_id)
    {
        $data=$this->_auxAssoc($id,$assoc_name);
        if (!is_array($assoc_id)) $assoc_id=array($assoc_id);
        $data[$assoc_name][$assoc_name]=am($data[$assoc_name][$assoc_name],$assoc_id);
        return $this->save($data);
    }

    /**
     * Deletes from a HABTM association some instances
     *
     * @param integer $id The id of the record in this model
     * @param mixed $assoc_name The name of the HABTM association
     * @param mixed $assoc_id The associated id or an array of id's to be removed
     * @return boolean Success
     */
    function deleteAssoc($id,$assoc_name,$assoc_id)
    {
        $data=$this->_auxAssoc($id,$assoc_name);
        if (!is_array($assoc_id)) $assoc_id=array($assoc_id);
        $result=array();
        foreach ($data[$assoc_name][$assoc_name] as $id)
        {
            if (!in_array($id, $assoc_id)) $result[]=$id;
        }
        $data[$assoc_name][$assoc_name]=$result;
        return $this->save($data);
    }

    /**
     * Returns the data associated with a HABTM in an array
     * suitable for save without deleting the current relationships
     *
     * @param integer $id The id of the record in this model
     * @param mixed $assoc_name The name of the HABTM association
     * @return array Data array with current HABTM association intact
     */
    function _auxAssoc($id,$assoc_name)
    {
        //disable query cache
        $back_cache=$this->cacheQueries;
        $this->cacheQueries=false;

        $this->recursive=1;
        $this->unbindAll(array('hasAndBelongsToMany'=>array($assoc_name)));
        $data=$this->findById($id);
        $assoc_data=array();
		
        foreach ($data[$assoc_name] as $assoc)
        {
            $assoc_data[]=$assoc['id'];
        }
        unset($data[$assoc_name]);
        $data[$assoc_name][$assoc_name]=$assoc_data;

        //restore previous setting of query cache
        $this->cacheQueries=$back_cache;

        return $data;
    }
	
	function unbindAll($params = array())
	{
		foreach($this->__associations as $ass)
		{
			if(!empty($this->{$ass}))
			{
				$this->__backAssociation[$ass] = $this->{$ass};
				if(isset($params[$ass]))
				{
					foreach($this->{$ass} as $model => $detail)
					{
						if(!in_array($model,$params[$ass]))
						{
							$this->__backAssociation = array_merge($this->__backAssociation, $this->{$ass});
							unset($this->{$ass}[$model]);
						}
					}
				}else
				{
					$this->__backAssociation = array_merge($this->__backAssociation, $this->{$ass});
					$this->{$ass} = array();
				}
			
			}
		}
		return true;
	}
	
}
?>