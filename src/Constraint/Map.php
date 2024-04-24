<?php


namespace Stefmachine\Validation\Constraint;

use InvalidArgumentException;
use Stefmachine\Validation\Constraint\Traits\ErrorMessageTrait;
use Stefmachine\Validation\ConstraintInterface;
use Stefmachine\Validation\Report\ValidationReport;
use Traversable;

class Map implements ConstraintInterface
{
    use ErrorMessageTrait;
    
    const MISSING_KEY_ERROR = '5b865d1b-6d3b-41e1-a3c4-8b13bb8c7c96';
    const EXTRA_KEY_ERROR = 'e4a1fecd-0f76-4616-9f5d-ddcdd9fc1fdb';
    const INVALID_ARRAY_ERROR = 'e84df245-c25f-4db3-b3e5-cbdd6a3bcd3f';
    
    protected function getErrorName(string $uuid): string
    {
        return match ($uuid) {
            self::MISSING_KEY_ERROR => 'MISSING_KEY_ERROR',
            self::EXTRA_KEY_ERROR => 'EXTRA_KEY_ERROR',
            self::INVALID_ARRAY_ERROR => 'INVALID_ARRAY_ERROR',
        };
    }
    
    protected function getErrorMessage(string $uuid): string
    {
        return match ($uuid) {
            self::MISSING_KEY_ERROR => 'The key \'{key}\' is missing.',
            self::EXTRA_KEY_ERROR => 'The key \'{key}\' is not a valid defined key.',
            self::INVALID_ARRAY_ERROR => 'The value is not an array or traversable.',
        };
    }
    
    /**
     * @param ConstraintInterface[] $map
     */
    public function __construct(
        protected array      $map,
        protected array|null $allowExtra = [],
        protected array      $allowMissing = [],
    )
    {
        foreach($this->map as $validation) {
            if(!$validation instanceof ConstraintInterface) {
                throw new InvalidArgumentException("Expected array of " . ConstraintInterface::class . ".");
            }
        }
    }
    
    public function allowExtra(array|null $_keys = null): Map
    {
        $this->allowExtra = $_keys;
        return $this;
    }
    
    public function disallowExtra(): Map
    {
        return $this->allowExtra([]);
    }
    
    public function allowMissing(array|null $_keys = null): Map
    {
        $this->allowMissing = $_keys ?? array_keys($this->map);
        return $this;
    }
    
    public function disallowMissing(): Map
    {
        return $this->allowMissing([]);
    }
    
    public function validate(mixed $value): ValidationReport
    {
        $report = new ValidationReport();
        if(!is_array($value) && !$value instanceof Traversable) {
            return $report->addError($this->newError(self::INVALID_ARRAY_ERROR));
        }
        
        $missingKeys = array_keys($this->map);
        foreach($value as $key => $v) {
            $index = array_search($key, $missingKeys, true);
            if($index !== false) {
                unset($missingKeys[$index]);
                
                $report->merge($this->map[$key]->validate($v), $key);
            } else if(is_array($this->allowExtra) && !in_array($key, $this->allowExtra, true)) {
                $report->addError($this->newError(self::EXTRA_KEY_ERROR, ['{key}' => $key]));
            }
        }
        
        foreach($missingKeys as $key) {
            if(!in_array($key, $this->allowMissing, true)) {
                $report->addError($this->newError(self::MISSING_KEY_ERROR, ['{key}' => $key]));
            }
        }
        
        return $report;
    }
}