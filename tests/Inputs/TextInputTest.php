<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Inputs;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Inputs\TextInput;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Inputs\TextInput
 */
class TextInputTest extends TestCase
{
    public function testCanConfigureTextInput()
    {
        $input = (new TextInput())
            ->placeholder('foo')
            ->initialValue('bar')
            ->multiline(false)
            ->minLength(1)
            ->maxLength(3);

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
        ], $input);
    }

    public function testCannotSetMinLengthLessThanZero()
    {
        $this->expectException(Exception::class);
        $input = (new TextInput())->minLength(-1);
    }

    public function testCannotSetMaxLengthLessThanOne()
    {
        $this->expectException(Exception::class);
        $input = (new TextInput())->maxLength(0);
    }

    public function testCannotSetMaxLengthLessThanMinLength()
    {
        $this->expectException(Exception::class);
        $input = (new TextInput())->minLength(5)->maxLength(3);
        $input->validate();
    }

    public function testCannotSetMinLengthGreaterThan3000()
    {
        $this->expectException(Exception::class);
        $input = (new TextInput())->minLength(3001);
        $input->validate();
    }
}
