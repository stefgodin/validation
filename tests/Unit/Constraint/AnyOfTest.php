<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\AnyOf;
use Stefmachine\Validation\Tests\Mock\ConstraintMock;

class AnyOfTest extends TestCase
{
    /** @test */
    public function Should_ReturnTrue_When_AnyConstraintIsValid()
    {
        $any = new AnyOf([
            new ConstraintMock(true),
            new ConstraintMock(null),
        ]);
        $input = true;
        
        $result = $any->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_NoConstraintsIsGiven()
    {
        $any = new AnyOf([]);
        $input = true;
        
        $result = $any->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_NoConstraintIsValid()
    {
        $any = new AnyOf([
            new ConstraintMock(false),
            new ConstraintMock(null),
        ]);
        $input = true;
        
        $result = $any->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnMessage_When_NoConstraintIsValid()
    {
        $errorMessage = 'The value is invalid';
        $any = new AnyOf([
            new ConstraintMock(false),
            new ConstraintMock(null),
        ], $errorMessage);
        $input = true;
        
        $result = $any->validate($input);
        
        $this->assertEquals($errorMessage, $result);
    }
    
    /** @test */
    public function Should_ReturnConcatenatedMessage_When_NoConstraintIsValid()
    {
        $message1 = 'The value is not false.';
        $message2 = 'The value is not null.';
        $any = new AnyOf([
            new ConstraintMock(false, $message1),
            new ConstraintMock(null, $message2),
        ]);
        $input = true;
        
        $result = $any->validate($input);
        
        $this->assertEquals("{$message1} {$message2}", $result);
    }
    
    /** @test */
    public function Should_ThrowException_When_NonConstraintIsGiven()
    {
        $this->expectException(InvalidArgumentException::class);
        
        new AnyOf([1]);
    }
}
