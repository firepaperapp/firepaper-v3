<?php
/*
 * Cache Objects component.
 * Read and write to cache with “garbage collector”
 * It will delete the expired ones automatically even
 * if they aren't accessed.
 * You have to define the expiration date at write.
 *
 * It's thread safe with mutex.
 *
 * @author      RosSoft
 * @version     0.2
 * @license        MIT
 *
 */

define('CACHE_COMPONENT_INFO_FILENAME',CACHE .'cache_component_info' );
define('CACHE_COMPONENT_INFO_DIR','cache_component_objects/' );

class CacheObjectComponent extends Component
{
    /**    Mutex variable */
    var $mutex;

    /** Info of items */
    var $info;

    /** array of items added / modified */
    var $modified;

    /** array of items deleted */
    var $deleted;

    function __construct()
    {
        $this->modified=array();
        $this->deleted=array();

        $this->_load_info();
    }

    function _load_info($lock=true)
    {
        //Load the cache info file
        if (file_exists(CACHE_COMPONENT_INFO_FILENAME))
        {
            if ($lock)
            {
                $this->_mutex_lock();
            }
            $this->info=unserialize(file_get_contents(CACHE_COMPONENT_INFO_FILENAME));
            if ($lock)
            {
                $this->_mutex_unlock();
            }
        }
        else
        {
            $this->info=array();
        }
    }

    /**
     * save the cache info
     */
    function _write_info()
    {
        if (count($this->modified)>0 || count($this->deleted)>0)
        {
            $this->_mutex_lock();
            $this->_load_info(false);
            foreach ($this->modified as $name=>$value)
            {
                $this->info[$name]=$value;
            }

            foreach ($this->deleted as $name)
            {
                unset($this->info[$name]);
            }
            file_put_contents(CACHE_COMPONENT_INFO_FILENAME,serialize($this->info));
            $this->modified=array();
            $this->deleted=array();
            $this->_mutex_unlock();
        }
    }

    /**
     * Locks a mutex
     */
    function _mutex_lock()
    {
        $this->mutex = @fopen(CACHE_COMPONENT_INFO_FILENAME . '.lock', 'w');
        if ( false == $this->mutex)
        {
            return false;
        }
        flock($this->mutex, LOCK_EX);
        return true;
    }

    /**
     * Releases a mutex
     */
    function _mutex_unlock()
    {
        // Release write lock.
        flock($this->mutex, LOCK_UN);
        fclose($this->mutex);
        @unlink(CACHE_COMPONENT_INFO_FILENAME . '.lock');
    }

    function __destruct()
    {
        //delete expirated files
        $names=array_keys($this->info);
        foreach ($names as $name)
        {
            if ($this->expired($name))
            {
                @unlink(CACHE . CACHE_COMPONENT_INFO_DIR  . $name);
                unset($this->info[$name]);
                $this->deleted[]=$name;
            }
        }
        $this->_write_info();

    }

    /**
     * Read a data from cache file
     * @param  string $name File path within /tmp/cache to read the file.
     * @return mixed  The contents of the temporary file. False if expired
     */
    function read($name)
    {
        if ($this->expired($name))
        {
            return false;
        }
        else
        {
            return unserialize(cache(CACHE_COMPONENT_INFO_DIR . $name,null,'+1 year'));
        }
    }

    /**
     * Write data to cache file
     * @param  string $name File path within /tmp/cache to save the file.
     * @param  mixed  $data    The data to save to the temporary file.
     * @param  mixed  $expires A valid strtotime string when the data expires.
     */
    function write($name,$data,$expires='+1 day')
    {
           $expires = strtotime($expires);
        $this->info[$name]=$expires;
        $this->modified[$name]=$expires;

        cache(CACHE_COMPONENT_INFO_DIR . $name,serialize($data)); //writes to cache

    }

    /**
     * Tests if a cache file has expired
     * @return boolean True if expired
     */
    function expired($name)
    {
        if (!isset($this->info[$name]))
        {
            return true;
        }
        else
        {
            return ($this->info[$name]<time());
        }
    }

    /**
     * Clears all the cache files
     */
    function clear()
    {
            $this->_write_info();
            foreach (array_keys($this->info) as $name)
            {
                @unlink(CACHE . CACHE_COMPONENT_INFO_DIR  . $name);
                $this->deleted[]=$name;
            }
            $this->_write_info();
    }

}

?>