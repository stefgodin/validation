<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Stefmachine\Validation\Constraint\MaxLength;

class MaxLengthTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_EmptyString()
    {
        $maxLength = new MaxLength(5);
        
        $result = $maxLength->validate("");
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_SingleByteStringLengthLessThanMax()
    {
        $maxLength = new MaxLength(5);
        
        $result = $maxLength->validate("Abcd");
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_SingleByteStringLengthEqualToMax()
    {
        $maxLength = new MaxLength(5);
        
        $result = $maxLength->validate("Abcde");
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainTooLongError_When_SingleByteStringLengthMoreThanMax()
    {
        $maxLength = new MaxLength(5);
        
        $result = $maxLength->validate("AbcdeF");
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(MaxLength::TOO_LONG_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_Succeed_When_MultiByteStringLengthLessThanMax()
    {
        $maxLength = new MaxLength(5);
        
        $result = $maxLength->validate("ÉÈÔÎ");
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_MultiByteStringLengthEqualToMax()
    {
        $maxLength = new MaxLength(5);
        
        $result = $maxLength->validate("ÉÈÔÎï");
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainTooLongError_When_MultiByteStringLengthMoreThanMax()
    {
        $maxLength = new MaxLength(5);
        
        $result = $maxLength->validate("ÉÈÔÎïÀ");
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(MaxLength::TOO_LONG_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ContainTooLongError_When_MultiByteStringLengthMoreThanMaxSingleByte()
    {
        $maxLength = (new MaxLength(5))->singleByte();
        
        $result = $maxLength->validate("AbcdÉ");
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(MaxLength::TOO_LONG_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ReturnInstance_When_UsingSingleByteModifier()
    {
        $maxLengthInstance = new MaxLength(5);
        
        $sameInstance = $maxLengthInstance->singleByte();
        
        $this->assertEquals($maxLengthInstance, $sameInstance);
    }
    
    /** @test */
    public function Should_ReturnInstance_When_UsingMultiByteModifier()
    {
        $maxLengthInstance = new MaxLength(5);
        
        $sameInstance = $maxLengthInstance->multiByte();
        
        $this->assertEquals($maxLengthInstance, $sameInstance);
    }
    
    /** @test */
    public function Should_ThrowException_When_MaxLengthIsLessThan0()
    {
        $this->expectException(InvalidArgumentException::class);
        
        new MaxLength(-1);
    }
    
    /** @test */
    public function Should_ContainNotStringableError_When_NonStringable()
    {
        $maxLength = new MaxLength(5);
        
        $result = $maxLength->validate(new stdClass());
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(MaxLength::NOT_STRINGABLE_ERROR, $error->getUuid());
        }
    }
}
