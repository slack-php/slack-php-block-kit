<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Inputs;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Inputs\TextInput;
use SlackPhp\BlockKit\Tests\TestCase;

/**
 * @covers \SlackPhp\BlockKit\Inputs\TextInput
 */
class TextInputTest extends TestCase
{
    public function testCanConfigureTextInput(): void
    {
        $input = (new TextInput())
            ->placeholder('foo')
            ->initialValue('bar')
            ->multiline(false)
            ->minLength(1)
            ->maxLength(3)
            ->triggerActionOnCharacterEntered()
            ->triggerActionOnEnterPressed();

        $this->assertJsonData([
            'type' => 'plain_text_input',
            'placeholder' => [
                'type' => 'plain_text',
                'text' => 'foo',
            ],
            'initial_value' => 'bar',
            'multiline' => false,
            'min_length' => 1,
            'max_length' => 3,
            'dispatch_action_config' => [
                'trigger_actions_on' => ['on_character_entered', 'on_enter_pressed'],
            ],
        ], $input);
    }

    public function testCannotSetMinLengthLessThanZero(): void
    {
        $this->expectException(Exception::class);
        (new TextInput())->minLength(-1);
    }

    public function testCannotSetMaxLengthLessThanOne(): void
    {
        $this->expectException(Exception::class);
        (new TextInput())->maxLength(0);
    }

    public function testCannotSetMaxLengthLessThanMinLength(): void
    {
        $this->expectException(Exception::class);
        $input = (new TextInput())->minLength(5)->maxLength(3);
        $input->validate();
    }

    public function testCannotSetMinLengthGreaterThan3000(): void
    {
        $this->expectException(Exception::class);
        $input = (new TextInput())->minLength(3001);
        $input->validate();
    }
}
