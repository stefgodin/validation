<?php


namespace Stefmachine\Validation\Helper;


class ErrorMatcher
{
    protected static $specialCharacters = [
        '**' => '[a-zA-Z0-9_.]+', // Anything
        '*' => '[a-zA-Z0-9_]+', // Any word
    ];
    
    public static function matches(string $_error, string $_search): bool
    {
        $regex = static::searchToRegex($_search);
        return preg_match($regex, $_error) != false;
    }
    
    private static function searchToRegex(string $_search): string
    {
        $_search = preg_quote($_search);
    
        foreach (static::$specialCharacters as $character => $regexReplacement){
            $_search = str_replace(preg_quote($character), $regexReplacement, $_search);
        }
    
        return "/^".$_search."(\(.*\))?$/";
    }
}