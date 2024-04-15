<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Email;

class EmailTest extends TestCase
{
    protected $emails;
    
    protected function setUp(): void
    {
        $this->emails = [
            'valid' => [
                'email@example.com',
                'firstname.lastname@example.com',
                'email@subdomain.example.com',
                'firstname+lastname@example.com',
                'email@123.123.123.123',
                '1234567890@example.com',
                'email@example-one.com',
                '_______@example.com',
                'email@example.name',
                'email@example.museum',
                'email@example.co.jp',
                'firstname-lastname@example.com',
            ],
            'invalid' => [
                '',
                'plainaddress',
                '@example.com',
                'email.example.com',
                'email@example.com (Joe Smith)',
                'email@example',
            ],
        ];
    }
    
    /** @test */
    public function Should_ReturnTrue_When_StringIsValidEmail()
    {
        $email = new Email();
        
        foreach($this->emails['valid'] as $input) {
            $result = $email->validate($input);
            $this->assertTrue($result->isValid(), "Failed to succeed on email value '{$input}'.");
        }
    }
    
    /** @test */
    public function Should_ReturnFalse_When_StringIsInvalidEmail()
    {
        $email = new Email();
        
        foreach($this->emails['invalid'] as $input) {
            $result = $email->validate($input);
            $this->assertTrue($result->hasError(), "Failed to fail on email value '{$input}'.");
        }
    }
    
    /** @test */
    public function Should_ContainInvalidPatternError_When_Invalid()
    {
        $email = new Email();
        
        $result = $email->validate("");
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Email::PATTERN_MISMATCH_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ThrowException_When_ValueIsNotString()
    {
        $email = new Email();
        
        $result = $email->validate(null);
        
        $this->assertCount(1, $result->getErrors());
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Email::NOT_STRINGABLE_ERROR, $error->getUuid());
        }
    }
}
