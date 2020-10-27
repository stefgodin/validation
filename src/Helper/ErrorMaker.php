<?php


namespace Stefmachine\Validation\Helper;


class ErrorMaker
{
    public static function makeError(string $_id, array $_params = array()): string
    {
        $params = array();
        foreach ($_params as $param => $value){
            $params[] = "{$param}:{$value}";
        }
        $params = implode(',', $params);
        
        return "{$_id}({$params})";
    }
}