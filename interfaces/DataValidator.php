<?php
/**
 * validator.php
 *
 * @company StitchLabs
 * @project thinkHr
 *
 * @author  kennychan
 */

/**
 * Interface validator
 */

namespace Interfaces;

interface DataValidator
{
    public function isValidPhone($phone);
    
    public function isValidZipCode($zip_code);
    
}