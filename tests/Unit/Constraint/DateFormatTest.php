<?php


namespace Constraint;

use PHPUnit\Framework\TestCase;
use stdClass;
use Stefmachine\Validation\Constraint\DateFormat;

class DateFormatTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_ValueIsInCorrectFormat()
    {
        $formats = [
            'Y-m-d' => '2024-01-01',
            'Y-m-d H:i' => '2024-01-01 12:00',
            'H:i' => '12:00',
        ];
        
        foreach($formats as $format => $value) {
            $dateFormat = new DateFormat($format);
            $result = $dateFormat->validate($value);
            $this->assertTrue($result->isValid());
        }
    }
    
    /** @test */
    public function Should_ContainDateFormatError_When_ValueIsNotInCorrectFormat()
    {
        $formats = [
            'Y-m-d' => '2024-01-01 1:00',
            'Y-m-d H' => '',
            'Y-m-d H:i' => '12:00',
            'H:i' => '2024-01-01',
        ];
        
        foreach($formats as $format => $value) {
            $dateFormat = new DateFormat($format);
            $result = $dateFormat->validate($value);
            
            $this->assertCount(1, $result->getErrors());
            foreach($result->getErrors() as $error) {
                $this->assertEquals(DateFormat::INVALID_DATE_FORMAT_ERROR, $error->getUuid());
            }
        }
    }
    
    /** @test */
    public function Should_ContainNonStringableError_When_ValueIsNotString()
    {
        $dateFormat = new DateFormat('Y-m-d');
        
        $result = $dateFormat->validate(new stdClass());
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(DateFormat::NOT_STRINGABLE_ERROR, $error->getUuid());
        }
    }
}
