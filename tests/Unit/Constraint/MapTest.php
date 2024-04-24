<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Map;
use Stefmachine\Validation\Tests\Mock\ConstraintMock;

class MapTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_EveryElementIsValid()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
            'two' => new ConstraintMock(true),
        ]);
        $input = [
            'one' => '',
            'two' => '',
        ];
        
        $result = $map->validate($input);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainError_When_AnyElementIsInvalid()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
            'two' => new ConstraintMock(false),
        ]);
        
        $input = [
            'one' => '',
            'two' => '',
        ];
        
        $result = $map->validate($input);
        
        $this->assertTrue($result->hasError());
    }
    
    /** @test */
    public function Should_ContainError_When_AnyElementIsMissingAndMissingKeyIsDisabled()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
            'two' => new ConstraintMock(true),
        ]);
        $map->disallowMissing();
        
        $result = $map->validate(['one' => '']);
        
        $this->assertTrue($result->hasError());
    }
    
    /** @test */
    public function Should_ContainMissingKeyError_When_AnyElementIsMissingWithDefaultMissingKeySetting()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
        ]);
        
        $input = [];
        
        $result = $map->validate($input);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Map::MISSING_KEY_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_Succeed_When_AnyElementIsMissingAndMissingKeyIsEnabled()
    {
        $map = new Map([
            'one' => new ConstraintMock(false),
        ]);
        $map->allowMissing();
        
        $input = [];
        
        $result = $map->validate($input);
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_SpecificElementIsMissingAndMissingSpecificKeyIsEnabled()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
        ]);
        $map->allowMissing(['one']);
        
        $input = [];
        
        $result = $map->validate($input);
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainMissingKeyError_When_AnyMissingElementIsMissingWithMissingKeyDisabled()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
        ]);
        $map->disallowMissing();
        
        $input = [];
        
        $result = $map->validate($input);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Map::MISSING_KEY_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ContainMissingKeyError_When_AnyMissingElementIsMissingWithSpecificMissingKeyEnabled()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
        ]);
        $map->allowMissing(['two']);
        
        $input = [];
        
        $result = $map->validate($input);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Map::MISSING_KEY_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ContainErrorMessage_When_AnyElementIsInvalid()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
            'two' => new ConstraintMock(false),
            'three' => new ConstraintMock(false),
        ]);
        
        $input = [
            'one' => '',
            'two' => '',
            'three' => '',
        ];
        
        $result = $map->validate($input);
        
        $this->assertCount(2, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(ConstraintMock::ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ContainExtraKeyError_When_ExtraFieldsAreDisabledByDefault()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
        ]);
        
        $input = [
            'one' => true,
            'two' => false,
        ];
        
        $result = $map->validate($input);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Map::EXTRA_KEY_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ContainExtraKeyError_When_ExtraFieldsAreDisabled()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
        ]);
        $map->disallowExtra();
        
        $input = [
            'one' => true,
            'two' => false,
        ];
        
        $result = $map->validate($input);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Map::EXTRA_KEY_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_Succeed_When_ExtraFieldsAreAllowed()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
        ]);
        $map->allowExtra();
        
        $input = [
            'one' => true,
            'two' => false,
        ];
        
        $result = $map->validate($input);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_Succeed_When_SpecificExtraFieldsAreAllowed()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
        ]);
        $map->allowExtra(['two']);
        
        $input = [
            'one' => true,
            'two' => false,
        ];
        
        $result = $map->validate($input);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainError_When_SpecificExtraFieldsAreAllowedButGivenExtraFieldIsNotInList()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
        ]);
        $map->allowExtra(['two']);
        
        $input = [
            'one' => true,
            'three' => false,
        ];
        
        $result = $map->validate($input);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Map::EXTRA_KEY_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_Succeed_When_ExtraFieldsAreAllowedAndNoConstrainsGiven()
    {
        $map = new Map([]);
        $map->allowExtra();
        
        $input = [
            'one' => true,
            'two' => false,
        ];
        
        $result = $map->validate($input);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ReturnInstance_When_UsingAllowExtraModifier()
    {
        $instance = new Map(['one' => new ConstraintMock(true)]);
        
        $sameInstance = $instance->allowExtra();
        
        $this->assertEquals($instance, $sameInstance);
    }
    
    /** @test */
    public function Should_ReturnInstance_When_UsingDisallowExtraModifier()
    {
        $instance = new Map(['one' => new ConstraintMock(true)]);
        
        $sameInstance = $instance->disallowExtra();
        
        $this->assertEquals($instance, $sameInstance);
    }
    
    /** @test */
    public function Should_ContainInvalidArrayError_When_ValueIsNotTraversable()
    {
        $map = new Map([
            'one' => new ConstraintMock(true),
        ]);
        
        $result = $map->validate(null);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Map::INVALID_ARRAY_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ThrowException_When_NonConstraintIsGiven()
    {
        $this->expectException(InvalidArgumentException::class);
        
        new Map(['stuff' => 1]);
    }
    
    /** @test */
    public function Should_MapSubErrorsWithKeyPath_When_ConstraintIsFailing()
    {
        $map = new Map([
            'test1' => new Map([
                'test2' => new ConstraintMock(false),
            ]),
        ]);
        
        $result = $map->validate(['test1' => ['test2' => null]]);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(ConstraintMock::ERROR, $error->getUuid());
            $this->assertEquals('test1.test2', $error->getPath());
        }
    }
}
