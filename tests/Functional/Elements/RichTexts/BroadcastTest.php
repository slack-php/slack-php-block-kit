<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\Broadcast;
use SlackPhp\BlockKit\Elements\RichTexts\Range;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class BroadcastTest extends TestCase
{
    public function testItCreatesBroadcasts(): void
    {
        $expected = [
            'type'  => 'broadcast',
            'range' => 'channel',
        ];

        $properties = new Broadcast();
        $properties->range = Range::CHANNEL;

        $constructor = new Broadcast(Range::CHANNEL);
        $fluent = Broadcast::new()->range(Range::CHANNEL);
        $kit = Kit::broadcast(Range::CHANNEL);

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
