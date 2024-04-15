<?php


namespace Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Callback;

class CallbackTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_CallbackSucceeds()
    {
        $callback = new Callback(fn(mixed $value): bool => $value === 1);
        
        $result = $callback->validate(1);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainInvalidValueError_When_CallbackFails()
    {
        $callback = new Callback(fn(mixed $value): bool => $value === 1);
        
        $result = $callback->validate(2);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Callback::INVALID_VALUE_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ContainInvalidValueError_When_CallbackReturnsNothing()
    {
        $callback = new Callback(function(): void {});
        
        $result = $callback->validate(1);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Callback::INVALID_VALUE_ERROR, $error->getUuid());
        }
    }
}
