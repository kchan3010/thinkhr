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

interface Validator
{
    public function isValidPhone($phone);
    
}