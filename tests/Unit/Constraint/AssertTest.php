<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\AllOf;
use Stefmachine\Validation\Constraint\AnyOf;
use Stefmachine\Validation\Constraint\Assert;
use Stefmachine\Validation\Constraint\Choice;
use Stefmachine\Validation\Constraint\Each;
use Stefmachine\Validation\Constraint\Email;
use Stefmachine\Validation\Constraint\Map;
use Stefmachine\Validation\Constraint\Max;
use Stefmachine\Validation\Constraint\MaxCount;
use Stefmachine\Validation\Constraint\MaxLength;
use Stefmachine\Validation\Constraint\Min;
use Stefmachine\Validation\Constraint\MinCount;
use Stefmachine\Validation\Constraint\MinLength;
use Stefmachine\Validation\Constraint\NotNull;
use Stefmachine\Validation\Constraint\Optional;
use Stefmachine\Validation\Constraint\Regex;
use Stefmachine\Validation\Constraint\Type;
use Stefmachine\Validation\Tests\Mock\ConstraintMock;

class AssertTest extends TestCase
{
    private const ERROR_MESSAGE = 'The value is invalid.';
    
    /** @test */
    public function Should_ReturnNotNullInstance_When_UsingRequired()
    {
        $this->assertInstanceOf(NotNull::class, Assert::Required());
    }
    
    /** @test */
    public function Should_ReturnMessage_When_RequiredIsInvalid()
    {
        $this->assertEquals(self::ERROR_MESSAGE, Assert::Required(self::ERROR_MESSAGE)->validate(null));
    }
    
    /** @test */
    public function Should_ReturnOptionalInstance_When_UsingOptional()
    {
        $this->assertInstanceOf(Optional::class, Assert::Optional(new ConstraintMock(true)));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_OptionalIsInvalid()
    {
        $result = Assert::Optional(new ConstraintMock(true), self::ERROR_MESSAGE)->validate(false);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnChoiceInstance_When_UsingChoice()
    {
        $this->assertInstanceOf(Choice::class, Assert::Choice([]));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_ChoiceIsInvalid()
    {
        $result = Assert::Choice([], self::ERROR_MESSAGE)->validate(null);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnChoiceInstance_When_UsingEquals()
    {
        $this->assertInstanceOf(Choice::class, Assert::Equals(true));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_EqualsIsInvalid()
    {
        $result = Assert::Equals(true, self::ERROR_MESSAGE)->validate(null);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnEmailInstance_When_UsingEmail()
    {
        $this->assertInstanceOf(Email::class, Assert::Email());
    }
    
    /** @test */
    public function Should_ReturnMessage_When_EmailIsInvalid()
    {
        $result = Assert::Email(self::ERROR_MESSAGE)->validate('');
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingType()
    {
        $this->assertInstanceOf(Type::class, Assert::Type(Type::BOOLEAN));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_TypeIsInvalid()
    {
        $result = Assert::Type(Type::BOOLEAN, self::ERROR_MESSAGE)->validate(null);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingBoolean()
    {
        $this->assertInstanceOf(Type::class, Assert::Boolean());
    }
    
    /** @test */
    public function Should_ReturnMessage_When_BooleanIsInvalid()
    {
        $result = Assert::Boolean(self::ERROR_MESSAGE)->validate(null);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingString()
    {
        $this->assertInstanceOf(Type::class, Assert::String());
    }
    
    /** @test */
    public function Should_ReturnMessage_When_StringIsInvalid()
    {
        $result = Assert::String(self::ERROR_MESSAGE)->validate(null);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingDouble()
    {
        $this->assertInstanceOf(Type::class, Assert::Double());
    }
    
    /** @test */
    public function Should_ReturnMessage_When_DoubleIsInvalid()
    {
        $result = Assert::Double(self::ERROR_MESSAGE)->validate(null);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingInteger()
    {
        $this->assertInstanceOf(Type::class, Assert::Integer());
    }
    
    /** @test */
    public function Should_ReturnMessage_When_IntegerIsInvalid()
    {
        $result = Assert::Integer(self::ERROR_MESSAGE)->validate(null);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingFloat()
    {
        $this->assertInstanceOf(Type::class, Assert::Float());
    }
    
    /** @test */
    public function Should_ReturnMessage_When_FloatIsInvalid()
    {
        $result = Assert::Float(self::ERROR_MESSAGE)->validate(null);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingNumeric()
    {
        $this->assertInstanceOf(Type::class, Assert::Numeric());
    }
    
    /** @test */
    public function Should_ReturnMessage_When_NumericIsInvalid()
    {
        $result = Assert::Numeric(self::ERROR_MESSAGE)->validate(null);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingArray()
    {
        $this->assertInstanceOf(Type::class, Assert::Array());
    }
    
    /** @test */
    public function Should_ReturnMessage_When_ArrayIsInvalid()
    {
        $result = Assert::Array(self::ERROR_MESSAGE)->validate(null);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnMinLengthInstance_When_UsingMinLength()
    {
        $this->assertInstanceOf(MinLength::class, Assert::MinLength(0));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_MinLengthIsInvalid()
    {
        $result = Assert::MinLength(1,self::ERROR_MESSAGE)->validate('');
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnMaxLengthInstance_When_UsingMaxLength()
    {
        $this->assertInstanceOf(MaxLength::class, Assert::MaxLength(0));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_MaxLengthIsInvalid()
    {
        $result = Assert::MaxLength(1,self::ERROR_MESSAGE)->validate('ab');
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnAllOfInstance_When_UsingLength()
    {
        $this->assertInstanceOf(AllOf::class, Assert::Length(0, 1));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_LengthIsInvalid()
    {
        $result = Assert::Length(0, 1,self::ERROR_MESSAGE)->validate('ab');
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnRegexInstance_When_UsingRegex()
    {
        $this->assertInstanceOf(Regex::class, Assert::Regex('/a/'));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_RegexIsInvalid()
    {
        $result = Assert::Regex('/a/',self::ERROR_MESSAGE)->validate('');
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnMinInstance_When_UsingMin()
    {
        $this->assertInstanceOf(Min::class, Assert::Min(0));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_MinIsInvalid()
    {
        $result = Assert::Min(0,self::ERROR_MESSAGE)->validate(-1);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnMaxInstance_When_UsingMax()
    {
        $this->assertInstanceOf(Max::class, Assert::Max(0));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_MaxIsInvalid()
    {
        $result = Assert::Max(0,self::ERROR_MESSAGE)->validate(1);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnAllOfInstance_When_UsingRange()
    {
        $this->assertInstanceOf(AllOf::class, Assert::Range(0, 1));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_RangeIsInvalid()
    {
        $result = Assert::Range(0, 1,self::ERROR_MESSAGE)->validate(2);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnMinCountInstance_When_UsingMinCount()
    {
        $this->assertInstanceOf(MinCount::class, Assert::MinCount(1));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_MinCountIsInvalid()
    {
        $result = Assert::MinCount(1,self::ERROR_MESSAGE)->validate([]);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnMaxCountInstance_When_UsingMaxCount()
    {
        $this->assertInstanceOf(MaxCount::class, Assert::MaxCount(1));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_MaxCountIsInvalid()
    {
        $result = Assert::MaxCount(1,self::ERROR_MESSAGE)->validate([1, 2]);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnAllOfInstance_When_UsingWithinCount()
    {
        $this->assertInstanceOf(AllOf::class, Assert::WithinCount(0, 1));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_WithinCountIsInvalid()
    {
        $result = Assert::WithinCount(0, 1,self::ERROR_MESSAGE)->validate([1, 2]);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnMapInstance_When_UsingMap()
    {
        $this->assertInstanceOf(Map::class, Assert::Map([]));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_MapIsInvalid()
    {
        $result = Assert::Map([],self::ERROR_MESSAGE)->validate(['a' => 1]);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnEachInstance_When_UsingEach()
    {
        $this->assertInstanceOf(Each::class, Assert::Each(new ConstraintMock(true)));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_EachIsInvalid()
    {
        $result = Assert::Each(new ConstraintMock(true),self::ERROR_MESSAGE)->validate([false]);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnAllOfInstance_When_UsingAllOf()
    {
        $this->assertInstanceOf(AllOf::class, Assert::AllOf([]));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_AllOfIsInvalid()
    {
        $result = Assert::AllOf([new ConstraintMock(true)],self::ERROR_MESSAGE)->validate(false);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
    
    /** @test */
    public function Should_ReturnAnyOfInstance_When_UsingAnyOf()
    {
        $this->assertInstanceOf(AnyOf::class, Assert::AnyOf([]));
    }
    
    /** @test */
    public function Should_ReturnMessage_When_AnyOfIsInvalid()
    {
        $result = Assert::AnyOf([new ConstraintMock(true)],self::ERROR_MESSAGE)->validate(false);
        $this->assertEquals(self::ERROR_MESSAGE, $result);
    }
}
