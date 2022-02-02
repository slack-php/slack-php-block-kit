<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Inputs;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Inputs\RadioButtons;
use SlackPhp\BlockKit\Partials\Confirm;
use SlackPhp\BlockKit\Tests\TestCase;
use SlackPhp\BlockKit\Type;

/**
 * @covers \SlackPhp\BlockKit\Inputs\RadioButtons
 */
class RadioButtonsTest extends TestCase
{
    public function testRadioButtonsWithConfirm(): void
    {
        $input = (new RadioButtons('radio-buttons-identifier'))
            ->option('foo', 'foo')
            ->option('bar', 'bar', true)
            ->option('foobar', 'foobar')
            ->setConfirm(new Confirm('Switch', 'Do you really want to switch?', 'Yes switch'));

        $this->assertJsonData([
            'type' => Type::RADIO_BUTTONS,
            'action_id' => 'radio-buttons-identifier',
            'initial_option' => [
                'text' => [
                    'type' => 'plain_text',
                    'text' => 'bar',
                ],
                'value' => 'bar',
            ],
            'options' => [
                [
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'foo',
                    ],
                    'value' => 'foo',
                ],
                [
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'bar',
                    ],
                    'value' => 'bar',
                ],
                [
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'foobar',
                    ],
                    'value' => 'foobar',
                ],
            ],
            'confirm' => [
                'title' => [
                    'type' => 'plain_text',
                    'text' => 'Switch',
                ],
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => 'Do you really want to switch?',
                ],
                'confirm' => [
                    'type' => 'plain_text',
                    'text' => 'Yes switch',
                ],
                'deny' => [
                    'type' => 'plain_text',
                    'text' => 'Cancel',
                ],
            ]
        ], $input);
    }

    public function testTooManyOptions(): void
    {
        $this->expectException(Exception::class);
        $input = (new RadioButtons())
            ->option('foo', 'foo')
            ->option('foo', 'foo')
            ->option('foo', 'foo')
            ->option('foo', 'foo')
            ->option('foo', 'foo')
            ->option('foo', 'foo')
            ->option('foo', 'foo')
            ->option('foo', 'foo')
            ->option('foo', 'foo')
            ->option('foo', 'foo')
            ->option('foo', 'foo');
        $input->validate();
    }

    public function testNoOptions(): void
    {
        $this->expectException(Exception::class);
        $input = new RadioButtons();
        $input->validate();
    }

    public function testTooManyInitialOptions(): void
    {
        $this->expectException(Exception::class);
        $input = (new RadioButtons())
            ->option('foo', 'foo', true)
            ->option('foo', 'foo', true);
        $input->validate();
    }
}
