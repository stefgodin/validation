<?php

namespace Stefmachine\Validation\Tests\Unit\Constraint;

use PHPUnit\Framework\TestCase;
use Stefmachine\Validation\Constraint\Choice;

class ChoiceTest extends TestCase
{
    /** @test */
    public function Should_ReturnTrue_When_ElementInList()
    {
        $choice = 'my_choice';
        $choices = new Choice([$choice, 'other_choice']);
        
        $result = $choices->validate($choice);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_ElementNotInList()
    {
        $choice = 'my_choice';
        $choices = new Choice(['some_choice', 'other_choice']);
    
        $result = $choices->validate($choice);
    
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnTrue_When_ElementInLooseList()
    {
        $choice = 1.0;
        $choices = new Choice(['1.0', 'other_choice']);
        $choices->loose();
        
        $result = $choices->validate($choice);
        
        $this->assertTrue($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_WrongElementTypeInDefaultList()
    {
        $choice = 1.0;
        $choices = new Choice(['1.0', 'other_choice']);
        
        $result = $choices->validate($choice);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_WrongElementTypeInStrictList()
    {
        $choice = 1.0;
        $choices = new Choice(['1.0', 'other_choice']);
        $choices->strict();
    
        $result = $choices->validate($choice);
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnFalse_When_ListIsEmpty()
    {
        $choices = new Choice([]);
        $result = $choices->validate('');
        
        $this->assertFalse($result);
    }
    
    /** @test */
    public function Should_ReturnMessage_When_Invalid()
    {
        $errorMessage = 'Choice not in choices.';
        $choices = new Choice(['some_choice', 'other_choice'], $errorMessage);
    
        $result = $choices->validate('my_choice');
    
        $this->assertEquals($errorMessage, $result);
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
