<?php


namespace Stefmachine\Validation\Constraint;


use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Traversable;

class Type implements ConstraintInterface
{
    const BOOLEAN = 'bool';
    const STRING = 'string';
    const STRINGABLE = 'stringable';
    const DOUBLE = 'double';
    const INTEGER = 'integer';
    const FLOAT = 'float';
    const NUMERIC = 'numeric';
    const ARRAY = 'array';
    const TRAVERSABLE = 'traversable';
    const SCALAR = 'scalar';
    
    private const TYPES = [
        self::BOOLEAN,
        self::STRING,
        self::STRINGABLE,
        self::DOUBLE,
        self::INTEGER,
        self::FLOAT,
        self::NUMERIC,
        self::ARRAY,
        self::TRAVERSABLE,
        self::SCALAR,
    ];
    
    protected $type;
    
    use ErrorMessageTrait;
    
    public function __construct(string $_type, ?string $_errorMessage = null)
    {
        if(!in_array($_type, self::TYPES)){
            throw new InvalidArgumentException(sprintf("Specified type must be one of %s.", implode(', ', self::TYPES)));
        }
        
        $this->type = $_type;
        $this->setErrorMessage($_errorMessage);
    }
    
    public function validate($_value)
    {
        $function = "is_{$this->type}";
        if (function_exists($function) && $function($_value) || gettype($_value) == $this->type) {
            return true;
        }
        // Special case for object with __toString
        elseif ($this->type == self::STRINGABLE
            && ($_value === null
                || is_scalar($_value)
                || (is_object($_value) && method_exists($_value, '__toString')))){
            return true;
        }
        // Special case for traversable
        elseif($this->type === self::TRAVERSABLE && (is_array($_value) || $_value instanceof Traversable)){
            return true;
        }
        
        return $this->getError();
    }
}