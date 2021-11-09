<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Inputs;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Inputs\Checkboxes;
use SlackPhp\BlockKit\Partials\Confirm;
use SlackPhp\BlockKit\Tests\TestCase;
use SlackPhp\BlockKit\Type;

/**
 * @covers \SlackPhp\BlockKit\Inputs\Checkboxes
 */
class CheckBoxesTest extends TestCase
{
    public function testCheckboxesWithConfirm(): void
    {
        $input = (new Checkboxes('checkboxes-identifier'))
            ->option('foo', 'foo')
            ->option('bar', 'bar', true)
            ->option('foobar', 'foobar', true)
            ->setConfirm(new Confirm('Switch', 'Do you really want to switch?', 'Yes switch'));

        $this->assertJsonData([
            'type' => Type::CHECKBOXES,
            'action_id' => 'checkboxes-identifier',
            'initial_options' => [
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
                ]
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
        $input = (new Checkboxes())
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
        $input = new Checkboxes();
        $input->validate();
    }
}
