<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\AllOf;
use Stefmachine\Validation\Tests\Mock\ConstraintMock;

class AllOfTest extends TestCase
{
    /** @test */
    public function Should_ReturnTrue_When_AllConstraintsAreValid()
    {
        $all = new AllOf([
            new ConstraintMock(true),
            new ConstraintMock(true),
        ]);
        $input = true;
    
        $result = $all->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_NoConstraintsGiven()
    {
        $all = new AllOf([]);
        $input = true;
    
        $result = $all->validate($input);
    
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_AnyConstraintIsInvalid()
    {
        $all = new AllOf([
            new ConstraintMock(true),
            new ConstraintMock(false),
        ]);
        $input = true;
    
        $result = $all->validate($input);
    
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnMessage_When_AnyConstraintIsInvalid()
    {
        $errorMessage = 'The value is invalid.';
        $all = new AllOf([
            new ConstraintMock(true),
            new ConstraintMock(false),
        ], $errorMessage);
        $input = true;
    
        $result = $all->validate($input);
    
        $this->assertEquals($errorMessage, $result);
    }
    
    /** @test */
    public function Should_ReturnFirstConstraintMessage_When_AnyConstraintIsInvalid()
    {
        $errorMessage = 'The value is invalid.';
        $all = new AllOf([
            new ConstraintMock(true, 'Value is not true.'),
            new ConstraintMock(false, $errorMessage),
            new ConstraintMock(null, 'Value is not null.'),
        ]);
        $input = true;
    
        $result = $all->validate($input);
    
        $this->assertEquals($errorMessage, $result);
    }
    
    /** @test */
    public function Should_ThrowException_When_NonConstraintIsGiven()
    {
        $this->expectException(InvalidArgumentException::class);
        
        new AllOf([1]);
    }
}
