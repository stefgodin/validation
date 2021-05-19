<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;


use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Regex;
use UnexpectedValueException;

class RegexTest extends TestCase
{
    /** @test */
    public function Should_ReturnTrue_When_ValueMatchesRegex()
    {
        $regex = new Regex('/^abcdefg$/');
        $input = 'abcdefg';
        
        $result = $regex->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_ValueMismatchRegex()
    {
        $regex = new Regex('/^abcdefg$/');
        $input = 'gfedcba';
    
        $result = $regex->validate($input);
    
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnMessage_When_ValueMismatchRegex()
    {
        $errorMessage = 'Value does not matche regex.';
        $regex = new Regex('/^abcdefg$/', $errorMessage);
        $input = 'gfedcba';
    
        $result = $regex->validate($input);
    
        $this->assertEquals($errorMessage, $result);
    }
    
    /** @test */
    public function Should_ThrowException_When_RegexIsInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        
        new Regex('abcdefg');
    }
    
    /** @test */
    public function Should_ThrowException_When_ValueIsNotString()
    {
        $this->expectException(UnexpectedValueException::class);
        
        $regex = new Regex('/^abcdefg$/');
        $input = null;
        
        $regex->validate($input);
    }
}