<?php


namespace Stefmachine\Validation\Constraint;

use Stefmachine\Validation\ConstraintInterface;

abstract class Assert
{
    private function __construct() {}
    
    public static function required(): NotNull
    {
        return new NotNull();
    }
    
    public static function optional(ConstraintInterface $constraint): Optional
    {
        return new Optional($constraint);
    }
    
    public static function choice(array $choices): Choice
    {
        return new Choice($choices);
    }
    
    public static function equals($value): Choice
    {
        return new Choice([$value]);
    }
    
    public static function email(): Email
    {
        return new Email();
    }
    
    public static function type(string $type): Type
    {
        return new Type($type);
    }
    
    public static function boolean(): Type
    {
        return self::type(Type::BOOLEAN);
    }
    
    public static function string(): Type
    {
        return self::type(Type::STRING);
    }
    
    public static function stringable(): Type
    {
        return self::type(Type::STRINGABLE);
    }
    
    public static function double(): Type
    {
        return self::type(Type::DOUBLE);
    }
    
    public static function integer(): Type
    {
        return self::type(Type::INTEGER);
    }
    
    public static function float(): Type
    {
        return self::type(Type::FLOAT);
    }
    
    public static function numeric(): Type
    {
        return self::type(Type::NUMERIC);
    }
    
    public static function array(): Type
    {
        return self::type(Type::ARRAY);
    }
    
    public static function traversable(): Type
    {
        return self::type(Type::TRAVERSABLE);
    }
    
    public static function scalar(): Type
    {
        return self::type(Type::SCALAR);
    }
    
    public static function minLength(int $min): MinLength
    {
        return new MinLength($min);
    }
    
    public static function maxLength(int $max): MaxLength
    {
        return new MaxLength($max);
    }
    
    public static function length(int $min, int $max): AllOf
    {
        return self::allOf([
            self::minLength($min),
            self::maxLength($max),
        ]);
    }
    
    public static function regex(string $regex): Regex
    {
        return new Regex($regex);
    }
    
    public static function min(int $min): Min
    {
        return new Min($min);
    }
    
    public static function max(int $max): Max
    {
        return new Max($max);
    }
    
    public static function range(int $min, int $max): AllOf
    {
        return self::allOf([
            self::min($min),
            self::max($max),
        ]);
    }
    
    public static function minCount(int $min): MinCount
    {
        return new MinCount($min);
    }
    
    public static function maxCount(int $max): MaxCount
    {
        return new MaxCount($max);
    }
    
    public static function withinCount(int $min, int $max): AllOf
    {
        return Assert::allOf([
            Assert::minCount($min),
            Assert::maxCount($max),
        ]);
    }
    
    public static function map(array $map): Map
    {
        return new Map($map);
    }
    
    public static function each(ConstraintInterface $constraint): Each
    {
        return new Each($constraint);
    }
    
    public static function allOf(array $constraints): AllOf
    {
        return new AllOf($constraints);
    }
    
    public static function anyOf(array $constraints): AnyOf
    {
        return new AnyOf($constraints);
    }
    
    public static function callback(callable $callback): Callback
    {
        return new Callback($callback);
    }
    
    public static function dateFormat(string $format): DateFormat
    {
        return new DateFormat($format);
    }
}