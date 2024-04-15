<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\AnyOf;
use Stefmachine\Validation\Tests\Mock\ConstraintMock;

class AnyOfTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_AnyConstraintIsValid()
    {
        $any = new AnyOf([
            new ConstraintMock(true),
            new ConstraintMock(false),
        ]);
        
        $result = $any->validate('');
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_NoConstraintsIsGiven()
    {
        $any = new AnyOf([]);
        
        $result = $any->validate('');
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainError_When_NoConstraintIsValid()
    {
        $any = new AnyOf([
            new ConstraintMock(false),
            new ConstraintMock(false),
        ]);
        
        $result = $any->validate('');
        
        $this->assertTrue($result->hasError());
    }
    
    /** @test */
    public function Should_ContainErrorMessages_When_NoConstraintIsValid()
    {
        $any = new AnyOf([
            new ConstraintMock(false),
            new ConstraintMock(false),
        ]);
        
        $result = $any->validate('');
        
        foreach($result->getErrors() as $error) {
            $this->assertEquals($error->getMessageTemplate(), ConstraintMock::ERROR_MESSAGE);
        }
        
        $this->assertCount(2, $result->getErrors());
    }
    
    /** @test */
    public function Should_ThrowException_When_NonConstraintIsGiven()
    {
        $this->expectException(InvalidArgumentException::class);
        
        new AnyOf([1]);
    }
}
