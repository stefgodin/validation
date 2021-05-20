<?php


namespace Stefmachine\Validation\Constraint\Traits;


trait ErrorMessageTrait
{
    protected $errorMessage = null;
    
    protected function setErrorMessage(?string $_message = null)
    {
        $this->errorMessage = $_message;
        return $this;
    }
    
    /**
     * @return string|false
     */
    protected function getError()
    {
        return $this->errorMessage ?: false;
    }
}