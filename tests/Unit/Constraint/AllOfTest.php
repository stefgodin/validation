<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\AllOf;
use Stefmachine\Validation\Tests\Mock\ConstraintMock;

class AllOfTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_AllConstraintsAreValid()
    {
        $all = new AllOf([
            new ConstraintMock(true),
            new ConstraintMock(true),
        ]);
        
        $result = $all->validate('');
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_NoConstraintsGiven()
    {
        $all = new AllOf([]);
        
        $result = $all->validate('');
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainError_When_AnyConstraintIsInvalid()
    {
        $all = new AllOf([
            new ConstraintMock(true),
            new ConstraintMock(false),
            new ConstraintMock(true),
        ]);
        
        $result = $all->validate('');
        
        $this->assertTrue($result->hasError());
    }
    
    /** @test */
    public function Should_ContainErrorMessage_When_AnyConstraintIsInvalid()
    {
        $all = new AllOf([
            new ConstraintMock(true),
            new ConstraintMock(false),
        ]);
        
        $result = $all->validate('');
        
        foreach($result->getErrors() as $error) {
            $this->assertEquals(ConstraintMock::ERROR_MESSAGE, $error->getMessageTemplate());
        }
    }
    
    /** @test */
    public function Should_ThrowException_When_NonConstraintIsGiven()
    {
        $this->expectException(InvalidArgumentException::class);
        
        new AllOf([1]);
    }
}
