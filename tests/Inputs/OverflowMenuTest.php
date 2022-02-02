<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Inputs;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Inputs\OverflowMenu;
use SlackPhp\BlockKit\Partials\Confirm;
use SlackPhp\BlockKit\Tests\TestCase;
use SlackPhp\BlockKit\Type;

/**
 * @covers \SlackPhp\BlockKit\Inputs\OverflowMenu
 */
class OverflowMenuTest extends TestCase
{
    public function testOverflowMenuWithConfirm(): void
    {
        $input = (new OverflowMenu('overflow-identifier'))
            ->option('foo', 'foo')
            ->urlOption('bar', 'bar', 'https://example.org')
            ->option('foobar', 'foobar')
            ->setConfirm(new Confirm('Choose', 'Do you really want to choose this?', 'Yes choose'));

        $this->assertJsonData([
            'type' => Type::OVERFLOW_MENU,
            'action_id' => 'overflow-identifier',
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
                    'url' => 'https://example.org'
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
                    'text' => 'Choose',
                ],
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => 'Do you really want to choose this?',
                ],
                'confirm' => [
                    'type' => 'plain_text',
                    'text' => 'Yes choose',
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
        $input = (new OverflowMenu())
            ->option('foo', 'foo')
            ->option('foo', 'foo')
            ->option('foo', 'foo')
            ->option('foo', 'foo')
            ->option('foo', 'foo')
            ->option('foo', 'foo');
        $input->validate();
    }

    public function testTooFewOptions(): void
    {
        $this->expectException(Exception::class);
        $input = (new OverflowMenu())
            ->option('foo', 'foo');
        $input->validate();
    }
}
