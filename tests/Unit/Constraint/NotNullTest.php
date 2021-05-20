<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\NotNull;

class NotNullTest extends TestCase
{
    /** @test */
    public function Should_ReturnTrue_When_ValueIsNotNull()
    {
        $notNull = new NotNull();
        $input = "";
        
        $result = $notNull->validate($input);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_ValueIsNull()
    {
        $notNull = new NotNull();
        $input = null;
        
        $result = $notNull->validate($input);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnMessage_When_ValueIsInvalid()
    {
        $errorMessage = "Value is null.";
        $notNull = new NotNull($errorMessage);
        $input = null;
        
        $result = $notNull->validate($input);
        
        $this->assertEquals($errorMessage, $result);
    }
}
