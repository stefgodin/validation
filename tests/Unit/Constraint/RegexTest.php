<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Stefmachine\Validation\Constraint\Regex;

class RegexTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_ValueMatchesRegex()
    {
        $regex = new Regex('/^abcdefg$/');
        $result = $regex->validate('abcdefg');
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainPatternMismatchError_When_ValueMismatchRegex()
    {
        $regex = new Regex('/^abcdefg$/');
        $input = 'gfedcba';
        
        $result = $regex->validate($input);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Regex::PATTERN_MISMATCH_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ThrowException_When_RegexIsInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        
        new Regex('abcdefg');
    }
    
    /** @test */
    public function Should_ContainNonStringableError_When_ValueIsNotString()
    {
        $regex = new Regex('/^abcdefg$/');
        
        $result = $regex->validate(new stdClass());
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Regex::NOT_STRINGABLE_ERROR, $error->getUuid());
        }
    }
}