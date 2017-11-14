<?php
/**
 * Person.php
 *
 * @company StitchLabs
 * @project thinkHr
 *
 * @author  kennychan
 */

namespace Classes;

/**
 * Class Person
 *
 * @package Classes
 */
class Person
{
    protected $favorite_color;
    protected $first_name;
    protected $last_name;
    protected $phone;
    protected $zip;
    
    public function __construct($personal_data)
    {
        
    }
    
    /**
     * @param mixed $favorite_color
     *
     * @return Person
     */
    public function setFavoriteColor($favorite_color)
    {
        $this->favorite_color = $favorite_color;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getFavoriteColor()
    {
        return $this->favorite_color;
    }
    
    /**
     * @param mixed $first_name
     *
     * @return Person
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }
    
    /**
     * @param mixed $last_name
     *
     * @return Person
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }
    
    /**
     * @param mixed $phone
     *
     * @return Person
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * @param mixed $zip
     *
     * @return Person
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }
    
}