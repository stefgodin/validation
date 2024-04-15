<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\NotNull;

class NotNullTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_ValueIsNotNull()
    {
        $notNull = new NotNull();
        $input = "";
        
        $result = $notNull->validate($input);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainIsNullError_When_ValueIsNull()
    {
        $notNull = new NotNull();
        $input = null;
        
        $result = $notNull->validate($input);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(NotNull::IS_NULL_ERROR, $error->getUuid());
        }
    }
}
