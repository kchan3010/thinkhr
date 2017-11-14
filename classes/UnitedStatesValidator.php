<?php
/**
 * UnitedStatesValidator.php
 *
 * @company StitchLabs
 * @project thinkHr
 *
 * @author  kennychan
 */

namespace Classes;

use Interfaces\Validator;

/**
 * Class UnitedStatesValidator
 *
 * @package Classes
 */
class UnitedStatesValidator implements Validator

{
    
    /**
     * @param $phone
     *
     * @return bool
     */
    public function isValidPhone($phone)
    {
        $ret_val = false;
    
        if (preg_match("/^[0-9]{3}\s[0-9]{3}\s[0-9]{4}$/", $phone)) {
            $ret_val = true;
        }
        
        return $ret_val;
    }
    
}