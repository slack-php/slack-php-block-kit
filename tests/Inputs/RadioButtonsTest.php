<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Inputs;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Inputs\RadioButtons;
use Jeremeamia\Slack\BlockKit\Partials\Confirm;
use Jeremeamia\Slack\BlockKit\Partials\Option;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;
use Jeremeamia\Slack\BlockKit\Type;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Inputs\RadioButtons
 */
class RadioButtonsTest extends TestCase
{
    public function testRadioButtonsWithConfirm()
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

    public function testTooManyOptions()
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

    public function testNoOptions()
    {
        $this->expectException(Exception::class);
        $input = new RadioButtons();
        $input->validate();
    }
}
