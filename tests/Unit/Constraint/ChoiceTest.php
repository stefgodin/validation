<?php


namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Choice;

class ChoiceTest extends TestCase
{
    /** @test */
    public function Should_Succeed_When_ElementInList()
    {
        $choice = 'my_choice';
        $choices = new Choice([$choice, 'other_choice']);
        
        $result = $choices->validate($choice);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainError_When_ElementNotInList()
    {
        $choice = 'my_choice';
        $choices = new Choice(['some_choice', 'other_choice']);
        
        $result = $choices->validate($choice);
        
        $this->assertTrue($result->hasError());
    }
    
    /** @test */
    public function Should_Succeed_When_ElementInLooseList()
    {
        $choice = 1.0;
        $choices = new Choice(['1.0', 'other_choice']);
        $choices->loose();
        
        $result = $choices->validate($choice);
        
        $this->assertTrue($result->isValid());
    }
    
    /** @test */
    public function Should_ContainError_When_WrongElementTypeInDefaultList()
    {
        $choice = 1.0;
        $choices = new Choice(['1.0', 'other_choice']);
        
        $result = $choices->validate($choice);
        
        $this->assertTrue($result->hasError());
    }
    
    /** @test */
    public function Should_ContainError_When_WrongElementTypeInStrictList()
    {
        $choice = 1.0;
        $choices = new Choice(['1.0', 'other_choice']);
        $choices->strict();
        
        $result = $choices->validate($choice);
        
        $this->assertTrue($result->hasError());
    }
    
    /** @test */
    public function Should_ContainError_When_ListIsEmpty()
    {
        $choices = new Choice([]);
        $result = $choices->validate('');
        
        $this->assertTrue($result->hasError());
    }
    
    /** @test */
    public function Should_ContainInvalidChoiceError_When_Invalid()
    {
        $errorMessage = 'Choice not in choices.';
        $choices = new Choice(['some_choice', 'other_choice'], $errorMessage);
        
        $result = $choices->validate('my_choice');
        
        foreach($result->getErrors() as $error) {
            $this->assertEquals(Choice::INVALID_CHOICE_ERROR, $error->getUuid());
        }
    }
    
    /** @test */
    public function Should_ReturnInstance_When_UsingLooseModifier()
    {
        $choices = new Choice(['some_choice']);
        
        $sameInstance = $choices->loose();
        
        $this->assertEquals($choices, $sameInstance);
    }
    
    /** @test */
    public function Should_ReturnInstance_When_UsingStrictModifier()
    {
        $choices = new Choice(['some_choice']);
        
        $sameInstance = $choices->strict();
        
        $this->assertEquals($choices, $sameInstance);
    }
}
