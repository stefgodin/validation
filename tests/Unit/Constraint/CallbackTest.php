<?php


namespace Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Callback;
use Stefmachine\Validation\Report\ValidationError;
use Stefmachine\Validation\Report\ValidationReport;

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
    
    /** @test */
    public function Should_ContainCustomError_When_CallbackFailsWithCustomError()
    {
        $errorUuid = '3444606d-cde0-4d6b-b302-f7ff2b0d2a65';
        $callback = new Callback(fn() => new ValidationError(
            $errorUuid,
            'CUSTOM_ERROR',
            'This is an error message.'
        ));
        
        $result = $callback->validate(1);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals($errorUuid, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ContainCustomErrors_When_CallbackFailsWithValidationReport()
    {
        $error1Uuid = '93dda90e-c996-4e0e-91ef-0635003462fd';
        $error2Uuid = '7f0bbc28-2e68-4330-b1d2-0b723ee09bb5';
        $callback = new Callback(function() use ($error1Uuid, $error2Uuid) {
            $report = new ValidationReport();
            $report->addError(new ValidationError(
                $error1Uuid,
                'CUSTOM_ERROR',
                'This is an error message.'
            ));
            
            $report->addError(new ValidationError(
                $error2Uuid,
                'CUSTOM_ERROR_2',
                'This is an other error message.'
            ));
            return $report;
        });
        
        $result = $callback->validate(1);
        
        $this->assertCount(2, $result->getErrors());
        foreach($result->getErrors() as $i => $error) {
            if($i === 0) {
                $this->assertEquals($error1Uuid, $error->getUuid());
            } else {
                $this->assertEquals($error2Uuid, $error->getUuid());
            }
        }
    }
}
