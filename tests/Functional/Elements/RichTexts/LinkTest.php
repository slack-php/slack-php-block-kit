<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\Link;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Parts\Style;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class LinkTest extends TestCase
{
    public function testItCreatesMinimalLinks(): void
    {
        $expected = [
            'type' => 'link',
            'url'  => 'https://api.slack.com',
        ];

        $properties = new Link();
        $properties->url = 'https://api.slack.com';

        $constructor = new Link('https://api.slack.com');
        $fluent = Link::new()->url('https://api.slack.com');
        $kit = Kit::link('https://api.slack.com');

        $properties->validate();
        $constructor->validate();
        $fluent->validate();
        $kit->validate();

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $fluent->toArray());
        self::assertEquals($expected, $kit->toArray());
    }

    public function testItCreatesAdvancedLinks(): void
    {
        $expected = [
            'type'   => 'link',
            'url'    => 'https://api.slack.com',
            'text'   => 'Unlock your productivity potential with Slack Platform | Slack',
            'unsafe' => false,
            'style'  => [
                'bold'   => true,
                'italic' => true,
                'strike' => true,
                'code'   => true,
            ],
        ];

        $style = new Style(true, true, true, true);

        $properties = new Link();
        $properties->url = 'https://api.slack.com';
        $properties->text = 'Unlock your productivity potential with Slack Platform | Slack';
        $properties->unsafe = false;
        $properties->style = $style;

        $constructor = new Link(
            'https://api.slack.com',
            'Unlock your productivity potential with Slack Platform | Slack',
            false,
            $style,
        );

        $fluent = Link::new()
            ->url('https://api.slack.com')
            ->text('Unlock your productivity potential with Slack Platform | Slack')
            ->unsafe(false)
            ->style($style);

        $kit = Kit::link(
            'https://api.slack.com',
            'Unlock your productivity potential with Slack Platform | Slack',
            false,
            $style,
        );

        $properties->validate();
        $constructor->validate();
        $fluent->validate();
        $kit->validate();

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $fluent->toArray());
        self::assertEquals($expected, $kit->toArray());
    }
}
