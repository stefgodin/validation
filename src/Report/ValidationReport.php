<?php


namespace Stefmachine\Validation\Report;

class ValidationReport
{
    /** @var ValidationError[] */
    protected array $errors;
    
    public function __construct()
    {
        $this->errors = [];
    }
    
    public function addError(ValidationError $error): static
    {
        $this->errors[] = $error;
        return $this;
    }
    
    public function merge(ValidationReport $report, string|int|null $subPath = null): ValidationReport
    {
        foreach($report->getErrors() as $error) {
            if($subPath === null) {
                $this->errors[] = $error;
            } else {
                if(is_int($subPath)) {
                    $subPath = "[$subPath]";
                }
                
                $prefixPath = $subPath;
                $oldPath = $error->getPath();
                if(!empty($oldPath) && !str_starts_with($oldPath, '[')) {
                    $prefixPath .= '.';
                }
                
                $this->errors[] = new ValidationError(
                    $error->getUuid(),
                    $error->getName(),
                    $error->getMessageTemplate(),
                    $error->getParams(),
                    $prefixPath . $oldPath
                );
            }
        }
        
        return $this;
    }
    
    public function isValid(): bool
    {
        return empty($this->errors);
    }
    
    public function hasError(): bool
    {
        return !$this->isValid();
    }
    
    public function getErrors(): array
    {
        return $this->errors;
    }
}