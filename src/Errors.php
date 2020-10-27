<?php


namespace Stefmachine\Validation;


use Stefmachine\Validation\Helper\ErrorMatcher;
use Stefmachine\Validation\Helper\ErrorParser;

class Errors implements \IteratorAggregate, \Countable
{
    protected $errors;
    
    public function __construct()
    {
        $this->errors = [];
    }
    
    public static function from(?string ...$_error): Errors
    {
        $list = new Errors();
        foreach ($_error as $error){
            $list->add($error);
        }
        
        return $list;
    }
    
    public static function none(): Errors
    {
        return new Errors();
    }
    
    public function any(): bool
    {
        return count($this) > 0;
    }
    
    public function empty(): bool
    {
        return !$this->any();
    }
    
    public function add(string $_error): Errors
    {
        if(empty($_error)){
            throw new \InvalidArgumentException("Error must contain at least one character.");
        }
        
        if(!in_array($_error, $this->errors)){
            $this->errors[] = $_error;
        }
        return $this;
    }
    
    /**
     * @return string[]
     */
    public function get(): array
    {
        return $this->errors;
    }
    
    /**
     * @param string $_search
     * @param ErrorMatcher|string $_matcher
     * @return bool
     */
    public function has(string $_search, string $_matcher = ErrorMatcher::class): bool
    {
        return count(
            array_filter($this->errors, function($error) use($_search, $_matcher){
                $_matcher::matches($error, $_search);
            })
        ) > 0;
    }
    
    public function merge(Errors $_errors, string $_prefix = ''): Errors
    {
        foreach ($_errors as $error){
            $this->add("{$_prefix}{$error}");
        }
        
        return $this;
    }
    
    public function toArray(): array
    {
        return $this->errors;
    }
    
    public function getIterator()
    {
        return new \ArrayIterator($this->errors);
    }
    
    public function count()
    {
        return count($this->errors);
    }
}