<?php


namespace Stefmachine\Validation\Constraint\Traits;

use Stefmachine\Validation\Report\ValidationError;

trait ErrorMessageTrait
{
    protected array $errorMessages = [];
    
    protected function newError(string $uuid, array $params = []): ValidationError
    {
        $messages = $this->errorMessages[$uuid] ?? $this->getErrorMessage($uuid);
        return new ValidationError($uuid, $this->getErrorName($uuid), $messages, $params);
    }
    
    public function setErrorMessage(string $uuid, string $message): static
    {
        $this->errorMessages[$uuid] = $message;
        return $this;
    }
    
    abstract protected function getErrorName(string $uuid): string;
    
    abstract protected function getErrorMessage(string $uuid): string;
}