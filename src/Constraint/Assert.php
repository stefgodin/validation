<?php


namespace Stefmachine\Validation\Constraint;


use Stefmachine\Validation\ConstraintInterface;

abstract class Assert
{
    private function __construct(){}
    
    public static function Required()
    {
        return new NotNull();
    }
    
    public static function Optional(ConstraintInterface $_constraint)
    {
        return new Optional($_constraint);
    }
    
    public static function Choice(array $_choices, bool $_loose = false)
    {
        return new Choice($_choices, $_loose);
    }
    
    public static function Equals($_value, bool $_loose = false)
    {
        return new Choice([$_value], $_loose);
    }
    
    public static function Email()
    {
        return new Email();
    }
    
    public static function Type(string $_type)
    {
        return new Type($_type);
    }
    
    public static function Boolean()
    {
        return self::Type('bool');
    }
    
    public static function String(?string $_encoding = null)
    {
        if($_encoding === null){
            return self::Type('string');
        }
        
        return Assert::AllOf([
            Assert::String(),
            Assert::Encoding($_encoding)
        ]);
    }
    
    public static function Double()
    {
        return self::Type('double');
    }
    
    public static function Integer()
    {
        return self::Type('integer');
    }
    
    public static function Float()
    {
        return self::Type('float');
    }
    
    public static function Numeric()
    {
        return self::Type('numeric');
    }
    
    public static function Array()
    {
        return self::Type('array');
    }
    
    public static function MinLength(int $_min)
    {
        return new MinLength($_min);
    }
    
    public static function MaxLength(int $_max)
    {
        return new MaxLength($_max);
    }
    
    public static function Length(int $_min, int $_max)
    {
        return self::AllOf([
            self::MinLength($_min),
            self::MaxLength($_max)
        ]);
    }
    
    public static function ExactLength(int $_length)
    {
        return self::Length($_length, $_length);
    }
    
    public static function Min(int $_min)
    {
        return new Min($_min);
    }
    
    public static function Max(int $_max)
    {
        return new Map($_max);
    }
    
    public static function Range(int $_min, int $_max)
    {
        return self::AllOf([
            self::Min($_min),
            self::Max($_max)
        ]);
    }
    
    public static function MinCount(int $_min)
    {
        return new MinCount($_min);
    }
    
    public static function MaxCount(int $_max)
    {
        return new MaxCount($_max);
    }
    
    public static function ExactCount(int $_count)
    {
        return Assert::AllOf([
            Assert::MinCount($_count),
            Assert::MaxCount($_count)
        ]);
    }
    
    public static function Map(array $_map = array())
    {
        return new Map($_map);
    }
    
    public static function Each(array $_constraints = array())
    {
        return new Each($_constraints);
    }
    
    public static function AllOf(array $_constraints = array())
    {
        return self::XOf(count($_constraints), $_constraints);
    }
    
    public static function OneOf(array $_constraints = array())
    {
        return self::XOf(1, $_constraints);
    }
    
    public static function XOf(int $_expects, array $_constraints = array())
    {
        return new XOf($_expects, $_constraints);
    }
    
    public static function Encoding(string $_encoding)
    {
        return new Encoding($_encoding);
    }
    
    public static function FileExists()
    {
        return new FileExists();
    }
    
    public static function MaxFileSize(int $_size)
    {
        return new MaxFileSize($_size);
    }
    
    public static function MimeType(string $_mimeType)
    {
        return new MimeType($_mimeType);
    }
}