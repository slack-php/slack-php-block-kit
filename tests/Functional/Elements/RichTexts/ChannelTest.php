<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\Channel;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Parts\MentionStyle;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class ChannelTest extends TestCase
{
    public function testItCreatesMinimalChannels(): void
    {
        $expected = [
            'type'       => 'channel',
            'channel_id' => 'U123ABC456',
        ];

        $properties = new Channel();
        $properties->channelId = 'U123ABC456';

        $constructor = new Channel('U123ABC456');
        $fluent = Channel::new()->channelId('U123ABC456');
        $kit = Kit::channel('U123ABC456');

        $properties->validate();
        $constructor->validate();
        $fluent->validate();
        $kit->validate();

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $fluent->toArray());
        self::assertEquals($expected, $kit->toArray());
    }

    public function testItCreatesAdvancedChannels(): void
    {
        $expected = [
            'type'       => 'channel',
            'channel_id' => 'U123ABC456',
            'style'      => [
                'bold'             => true,
                'italic'           => true,
                'strike'           => true,
                'highlight'        => true,
                'client_highlight' => true,
                'unlink'           => true,
            ],
        ];

        $style = new MentionStyle(true, true, true, true, true, true);

        $properties = new Channel();
        $properties->channelId = 'U123ABC456';
        $properties->style = $style;

        $constructor = new Channel('U123ABC456', $style);
        $fluent = Channel::new()->channelId('U123ABC456')->style($style);
        $kit = Kit::channel('U123ABC456', $style);

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
