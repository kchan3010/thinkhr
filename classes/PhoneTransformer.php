<?php
/**
 * Created by PhpStorm.
 * User: kennychan
 * Date: 11/13/17
 * Time: 8:34 PM
 */

namespace Classes;


use Interfaces\Transformer;

class PhoneTransformer implements Transformer
{

    public function transform($phone)
    {
        if (strpos($phone, "(")) {
            $phone = str_replace("(", "", $phone);
        }

        if (strpos($phone, ")")) {
            $phone = str_replace(")", "", $phone);
        }
        if (strpos($phone, "-")) {
            $phone = str_replace("-", " ", $phone);
        }

        return $phone;
    }
}