<?php


namespace Stefmachine\Validation\Helper;


use Stefmachine\Validation\Errors;

class ErrorTranslator
{
    /**
     * @param Errors $_errors
     * @param string[] $_translations
     * @param ErrorMatcher|string $matcher - The matcher class
     * @return string[]
     */
    public static function translateErrors(Errors $_errors, array $_translations, string $matcher = ErrorMatcher::class): array
    {
        $translatedList = array();
        foreach ($_errors as $error){
            $parsedError = ErrorParser::parse($error);
            
            $params = array();
            foreach ($parsedError['params'] as $param => $value){
                $params["{{$param}}"] = $value;
            }
            
            $found = false;
            foreach (static::orderByPrecision($_translations) as $search => $message){
                if(!$found && $matcher::matches($error, $search)){
                    $translatedList[$parsedError['id']] = strtr($message, $params);
                    $found = true;
                }
            }
            
            if(!$found){
                $translatedList[$error] = $error; // Leave error as is
            }
        }
        
        return $translatedList;
    }
    
    protected static function orderByPrecision(array $_translations)
    {
        uksort($_translations, function(string $_a, string $_b){
            return -(substr_count($_a, '.') <=> substr_count($_b, '.')); // More '.' goes first
        });
        
        return $_translations;
    }
}