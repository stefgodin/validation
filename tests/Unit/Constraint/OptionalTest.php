<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Optional;
use Stefmachine\Validation\Tests\Mock\ConstraintMock;

class OptionalTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_ValueIsNull()
    {
        $optional = new Optional(new ConstraintMock(false));
        
        $result = $optional->validate(null);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_ValueIsNotNullAndConstraintIsValid()
    {
        $optional = new Optional(new ConstraintMock(true));
        
        $result = $optional->validate('');
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainError_When_ValueIsNotNullAndConstraintIsInvalid()
    {
        $optional = new Optional(new ConstraintMock(false));
        
        $result = $optional->validate('');
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(ConstraintMock::ERROR, $error->getUuid());
        }
    }
}
