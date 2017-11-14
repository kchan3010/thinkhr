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


    public static function transform($entry_data)
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
            $phone    = PhoneTransformer::transform($entry_data[3]);
        } elseif (count($entry_data) == self::SPLIT_NAME_PARTS_COUNT) {
            if (is_numeric($entry_data[2])) {
                $first_name = $entry_data[0];
                $last_name  = $entry_data[1];
                $zip_code   = $entry_data[2];
                $phone      = PhoneTransformer::transform($entry_data[3]);
                $color      = $entry_data[4];

            } else {
                $last_name  = $entry_data[0];
                $first_name = $entry_data[1];
                $phone      = PhoneTransformer::transform($entry_data[2]);
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
    
    public static function jsonPrint($json)
    {
        $result          = '';
        $level           = 0;
        $in_quotes       = false;
        $in_escape       = false;
        $ends_line_level = null;
        $json_length     = strlen($json);
        
        for ($i = 0; $i < $json_length; $i++) {
            $char           = $json[$i];
            $new_line_level = null;
            $post           = "";
            if ($ends_line_level !== null) {
                $new_line_level  = $ends_line_level;
                $ends_line_level = null;
            }
            if ($in_escape) {
                $in_escape = false;
            } else if ($char === '"') {
                $in_quotes = !$in_quotes;
            } else if (!$in_quotes) {
                switch ($char) {
                    case '}':
                    case ']':
                        $level--;
                        $ends_line_level = null;
                        $new_line_level  = $level;
                        break;
                    
                    case '{':
                    case '[':
                        $level++;
                    case ',':
                        $ends_line_level = $level;
                        break;
                    
                    case ':':
                        $post = " ";
                        break;
                    
                    case " ":
                    case "\t":
                    case "\n":
                    case "\r":
                        $char            = "";
                        $ends_line_level = $new_line_level;
                        $new_line_level  = null;
                        break;
                }
            } else if ($char === '\\') {
                $in_escape = true;
            }
            if ($new_line_level !== null) {
                $result .= "\n" . str_repeat("  ", $new_line_level);
            }
            $result .= $char . $post;
        }
        
        return $result;
    }
    
}