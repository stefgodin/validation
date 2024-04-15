<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Stefmachine\Validation\Constraint\MinLength;

class MinLengthTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_SingleByteStringLengthGreaterThanMin()
    {
        $minLength = new MinLength(3);
        $result = $minLength->validate("Abcd");
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_SingleByteStringLengthEqualToMin()
    {
        $minLength = new MinLength(3);
        $result = $minLength->validate("Abc");
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainTooShortError_When_SingleByteStringLengthLessThanMin()
    {
        $minLength = new MinLength(3);
        $result = $minLength->validate("Ab");
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(MinLength::TOO_SHORT_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_Succeed_When_MultiByteStringLengthGreaterThanMin()
    {
        $minLength = new MinLength(3);
        $result = $minLength->validate("ÉÈÔÎ");
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_MultiByteStringLengthEqualToMin()
    {
        $minLength = new MinLength(3);
        $result = $minLength->validate("ÉÈÔ");
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainTooShortError_When_MultiByteStringLengthLessThanMin()
    {
        $minLength = new MinLength(3);
        $result = $minLength->validate("ÉÈ");
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(MinLength::TOO_SHORT_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_Succeed_When_MultiByteStringLengthGreaterThanMinSingleByte()
    {
        $minLength = (new MinLength(3))->singleByte();
        
        // In single byte it should compare to 3
        $result = $minLength->validate("AÉ");
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ReturnInstance_When_UsingSingleByteModifier()
    {
        $minLengthInstance = new MinLength(5);
        
        $sameInstance = $minLengthInstance->singleByte();
        
        $this->assertEquals($minLengthInstance, $sameInstance);
    }
    
    /** @test */
    public function Should_ReturnInstance_When_UsingMultiByteModifier()
    {
        $minLengthInstance = new MinLength(5);
        
        $sameInstance = $minLengthInstance->multiByte();
        
        $this->assertEquals($minLengthInstance, $sameInstance);
    }
    
    /** @test */
    public function Should_ThrowException_When_MinLengthIsLessThan0()
    {
        $this->expectException(InvalidArgumentException::class);
        
        new MinLength(-1);
    }
    
    /** @test */
    public function Should_ContainNotStringableError_When_NonString()
    {
        $minLength = new MinLength(3);
        
        $result = $minLength->validate(new stdClass());
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(MinLength::NOT_STRINGABLE_ERROR, $error->getUuid());
        }
    }
}
