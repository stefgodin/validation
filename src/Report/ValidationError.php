<?php


namespace Stefmachine\Validation\Report;

class ValidationError
{
    public function __construct(
        protected string $uuid,
        protected string $name,
        protected string $message,
        protected array  $params = [],
        protected string $path = '',
    ) {}
    
    public function getUuid(): string
    {
        return $this->uuid;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getMessage(): string
    {
        return strtr($this->message, $this->params);
    }
    
    public function getMessageTemplate(): string
    {
        return $this->message;
    }
    
    public function getParams(): array
    {
        return $this->params;
    }
    
    public function getPath(): string
    {
        return $this->path;
    }
}