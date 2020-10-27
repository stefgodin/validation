<?php


namespace Stefmachine\Validation\Helper;


class ErrorParser
{
    public static function parse(string $_error)
    {
        $parts = explode('.', $_error);
        $message = array_pop($parts);
        $propertyPath = implode('.', $parts);
        
        $message = str_replace(')', '', $message);
        $messageParts = explode('(', $message);
        
        if(!empty($messageParts[1])) {
            $values = explode(',', $messageParts[1]);
            $values = array_map(function (string $_value) {
                $paramValue = explode(':', $_value);
                if (count($paramValue) !== 2) {
                    throw new \LogicException("Error params should always match param:value pattern.");
                }
                return [$paramValue[0] => $paramValue[1]];
            }, $values);
    
            $params = array();
            foreach ($values as $paramValue) {
                $params = array_merge($params, $paramValue);
            }
        }
        else{
            $params = [];
        }
        
        return array(
            'id' => "{$propertyPath}.{$messageParts[0]}",
            'error' => $messageParts[0],
            'params' => $params,
            'property' => $propertyPath
        );
    }
}