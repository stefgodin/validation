<?php


namespace Stefmachine\Validation;


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
        
        $this->errors[] = $_error;
        return $this;
    }
    
    /**
     * @return string[]
     */
    public function get(): array
    {
        return $this->errors;
    }
    
    public function has(string $_error): bool
    {
        return in_array($_error, $this->errors);
    }
    
    public function merge(Errors $_errors, string $_prefix = ''): Errors
    {
        foreach ($_errors as $error){
            $this->add("{$_prefix}{$error}");
        }
        
        return $this;
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