<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\AllOf;
use Stefmachine\Validation\Constraint\AnyOf;
use Stefmachine\Validation\Constraint\Assert;
use Stefmachine\Validation\Constraint\Callback;
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
    /** @test */
    public function Should_ReturnNotNullInstance_When_UsingRequired()
    {
        $this->assertInstanceOf(NotNull::class, Assert::required());
    }
    
    /** @test */
    public function Should_ReturnOptionalInstance_When_UsingOptional()
    {
        $this->assertInstanceOf(Optional::class, Assert::optional(new ConstraintMock(true)));
    }
    
    /** @test */
    public function Should_ReturnChoiceInstance_When_UsingChoice()
    {
        $this->assertInstanceOf(Choice::class, Assert::choice([]));
    }
    
    /** @test */
    public function Should_ReturnChoiceInstance_When_UsingEquals()
    {
        $this->assertInstanceOf(Choice::class, Assert::equals(true));
    }
    
    /** @test */
    public function Should_ReturnEmailInstance_When_UsingEmail()
    {
        $this->assertInstanceOf(Email::class, Assert::email());
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingType()
    {
        $this->assertInstanceOf(Type::class, Assert::type(Type::BOOLEAN));
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingBoolean()
    {
        $this->assertInstanceOf(Type::class, Assert::boolean());
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingString()
    {
        $this->assertInstanceOf(Type::class, Assert::string());
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingStringable()
    {
        $this->assertInstanceOf(Type::class, Assert::stringable());
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingDouble()
    {
        $this->assertInstanceOf(Type::class, Assert::double());
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingInteger()
    {
        $this->assertInstanceOf(Type::class, Assert::integer());
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingFloat()
    {
        $this->assertInstanceOf(Type::class, Assert::float());
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingNumeric()
    {
        $this->assertInstanceOf(Type::class, Assert::numeric());
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingArray()
    {
        $this->assertInstanceOf(Type::class, Assert::array());
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingTraversable()
    {
        $this->assertInstanceOf(Type::class, Assert::traversable());
    }
    
    /** @test */
    public function Should_ReturnTypeInstance_When_UsingScalar()
    {
        $this->assertInstanceOf(Type::class, Assert::scalar());
    }
    
    /** @test */
    public function Should_ReturnMinLengthInstance_When_UsingMinLength()
    {
        $this->assertInstanceOf(MinLength::class, Assert::minLength(0));
    }
    
    /** @test */
    public function Should_ReturnMaxLengthInstance_When_UsingMaxLength()
    {
        $this->assertInstanceOf(MaxLength::class, Assert::maxLength(0));
    }
    
    /** @test */
    public function Should_ReturnAllOfInstance_When_UsingLength()
    {
        $this->assertInstanceOf(AllOf::class, Assert::length(0, 1));
    }
    
    /** @test */
    public function Should_ReturnRegexInstance_When_UsingRegex()
    {
        $this->assertInstanceOf(Regex::class, Assert::regex('/a/'));
    }
    
    /** @test */
    public function Should_ReturnMinInstance_When_UsingMin()
    {
        $this->assertInstanceOf(Min::class, Assert::min(0));
    }
    
    /** @test */
    public function Should_ReturnMaxInstance_When_UsingMax()
    {
        $this->assertInstanceOf(Max::class, Assert::max(0));
    }
    
    /** @test */
    public function Should_ReturnAllOfInstance_When_UsingRange()
    {
        $this->assertInstanceOf(AllOf::class, Assert::range(0, 1));
    }
    
    /** @test */
    public function Should_ReturnMinCountInstance_When_UsingMinCount()
    {
        $this->assertInstanceOf(MinCount::class, Assert::minCount(1));
    }
    
    /** @test */
    public function Should_ReturnMaxCountInstance_When_UsingMaxCount()
    {
        $this->assertInstanceOf(MaxCount::class, Assert::maxCount(1));
    }
    
    /** @test */
    public function Should_ReturnAllOfInstance_When_UsingWithinCount()
    {
        $this->assertInstanceOf(AllOf::class, Assert::withinCount(0, 1));
    }
    
    /** @test */
    public function Should_ReturnMapInstance_When_UsingMap()
    {
        $this->assertInstanceOf(Map::class, Assert::map([]));
    }
    
    /** @test */
    public function Should_ReturnEachInstance_When_UsingEach()
    {
        $this->assertInstanceOf(Each::class, Assert::each(new ConstraintMock(true)));
    }
    
    /** @test */
    public function Should_ReturnAllOfInstance_When_UsingAllOf()
    {
        $this->assertInstanceOf(AllOf::class, Assert::allOf([]));
    }
    
    /** @test */
    public function Should_ReturnAnyOfInstance_When_UsingAnyOf()
    {
        $this->assertInstanceOf(AnyOf::class, Assert::anyOf([]));
    }
    
    /** @test */
    public function Should_ReturnCallbackInstance_When_UsingCallback()
    {
        $this->assertInstanceOf(Callback::class, Assert::callback(fn() => true));
    }
}
