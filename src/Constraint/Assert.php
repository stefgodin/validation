<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;

abstract class Assert
{
    private function __construct(){}
    
    public static function Required(?string $_errorMessage = null): NotNull
    {
        return new NotNull($_errorMessage);
    }
    
    public static function Optional(ConstraintInterface $_constraint, ?string $_errorMessage = null): Optional
    {
        return new Optional($_constraint, $_errorMessage);
    }
    
    public static function Choice(array $_choices, ?string $_errorMessage = null): Choice
    {
        return new Choice($_choices, $_errorMessage);
    }
    
    public static function Equals($_value, ?string $_errorMessage = null): Choice
    {
        return new Choice([$_value], $_errorMessage);
    }
    
    public static function Email(?string $_errorMessage = null): Email
    {
        return new Email($_errorMessage);
    }
    
    public static function Type(string $_type, ?string $_errorMessage = null): Type
    {
        return new Type($_type, $_errorMessage);
    }
    
    public static function Boolean(?string $_errorMessage = null): Type
    {
        return self::Type(Type::BOOLEAN, $_errorMessage);
    }
    
    public static function String(?string $_errorMessage = null): Type
    {
        return self::Type(Type::STRING, $_errorMessage);
    }
    
    public static function Double(?string $_errorMessage = null): Type
    {
        return self::Type(Type::DOUBLE, $_errorMessage);
    }
    
    public static function Integer(?string $_errorMessage = null): Type
    {
        return self::Type(Type::INTEGER, $_errorMessage);
    }
    
    public static function Float(?string $_errorMessage = null): Type
    {
        return self::Type(Type::FLOAT, $_errorMessage);
    }
    
    public static function Numeric(?string $_errorMessage = null): Type
    {
        return self::Type(Type::NUMERIC, $_errorMessage);
    }
    
    public static function Array(?string $_errorMessage = null): Type
    {
        return self::Type(Type::ARRAY, $_errorMessage);
    }
    
    public static function MinLength(int $_min, ?string $_errorMessage = null): MinLength
    {
        return new MinLength($_min, $_errorMessage);
    }
    
    public static function MaxLength(int $_max, ?string $_errorMessage = null): MaxLength
    {
        return new MaxLength($_max, $_errorMessage);
    }
    
    public static function Length(int $_min, int $_max, ?string $_errorMessage = null): AllOf
    {
        return self::AllOf([
            self::MinLength($_min),
            self::MaxLength($_max)
        ], $_errorMessage);
    }
    
    public static function Regex(string $_regex, ?string $_errorMessage = null): Regex
    {
        return new Regex($_regex, $_errorMessage);
    }
    
    public static function Min(int $_min, ?string $_errorMessage = null): Min
    {
        return new Min($_min, $_errorMessage);
    }
    
    public static function Max(int $_max, ?string $_errorMessage = null): Max
    {
        return new Max($_max, $_errorMessage);
    }
    
    public static function Range(int $_min, int $_max, ?string $_errorMessage = null): AllOf
    {
        return self::AllOf([
            self::Min($_min),
            self::Max($_max)
        ], $_errorMessage);
    }
    
    public static function MinCount(int $_min, ?string $_errorMessage = null): MinCount
    {
        return new MinCount($_min, $_errorMessage);
    }
    
    public static function MaxCount(int $_max, ?string $_errorMessage = null): MaxCount
    {
        return new MaxCount($_max, $_errorMessage);
    }
    
    public static function WithinCount(int $_min, int $_max, ?string $_errorMessage = null): AllOf
    {
        return Assert::AllOf([
            Assert::MinCount($_min),
            Assert::MaxCount($_max)
        ], $_errorMessage);
    }
    
    public static function Map(array $_map, ?string $_errorMessage = null): Map
    {
        return new Map($_map, $_errorMessage);
    }
    
    public static function Each(ConstraintInterface $_constraint, ?string $_errorMessage = null): Each
    {
        return new Each($_constraint, $_errorMessage);
    }
    
    public static function AllOf(array $_constraints, ?string $_errorMessage = null): AllOf
    {
        return new AllOf($_constraints, $_errorMessage);
    }
    
    public static function AnyOf(array $_constraints, ?string $_errorMessage = null): AnyOf
    {
        return new AnyOf($_constraints, $_errorMessage);
    }
}