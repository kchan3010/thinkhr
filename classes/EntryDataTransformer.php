<?php
/**
 * Created by PhpStorm.
 * User: kennychan
 * Date: 11/13/17
 * Time: 8:59 PM
 */

namespace Classes;


use Interfaces\Transformer;

class EntryDataTransformer implements Transformer
{

    const FULL_NAME_PARTS_COUNT = 4;
    const SPLIT_NAME_PARTS_COUNT = 5;


    public function transform($entry_data)
    {
        if(empty($entry_data)) {
            return [];
        }
    
        $first_name = null;
        $last_name  = null;
        $phone      = null;
        $zip_code   = null;
        $color      = null;

        if (count($entry_data) == self::FULL_NAME_PARTS_COUNT) {
            list($first_name, $last_name) = explode(" ", $entry_data[0]);
            $color    = $entry_data[1];
            $zip_code = $entry_data[2];
            $phone    = $this->transformPhone($entry_data[3]);
        } elseif (count($entry_data) == self::SPLIT_NAME_PARTS_COUNT) {
            if (is_numeric($entry_data[2])) {
                $first_name = $entry_data[0];
                $last_name  = $entry_data[1];
                $zip_code   = $entry_data[2];
                $phone      = $this->transformPhone($entry_data[3]);
                $color      = $entry_data[4];

            } else {
                $last_name  = $entry_data[0];
                $first_name = $entry_data[1];
                $phone      = $this->transformPhone($entry_data[2]);
                $color      = $entry_data[3];
                $zip_code   = $entry_data[4];
            }
        }
    
        $output = [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'phone'      => trim($phone),
            'zip_code'   => trim($zip_code),
            'color'      => trim($color),
        ];

        return $output;
    }
    
    public function prepareJson($data)
    {
        $json = '';
        
        if (!empty($data)) {
            $json = preg_replace_callback(
                '/^ +/m',
                function ($m) {
                    return str_repeat(' ', strlen($m[0]) / 2);
                },
                json_encode($data, JSON_PRETTY_PRINT)
            );
        }
        
        return $json;
    }
    
    private function transformPhone($phone)
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