<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\Emoji;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class EmojiTest extends TestCase
{
    public function testItCreatesMinimalEmojis(): void
    {
        $expected = [
            'type' => 'emoji',
            'name' => 'basketball',
        ];

        $properties = new Emoji();
        $properties->name = 'basketball';

        $constructor = new Emoji('basketball');
        $fluent = Emoji::new()->name('basketball');
        $kit = Kit::emoji('basketball');

        $properties->validate();
        $constructor->validate();
        $fluent->validate();
        $kit->validate();

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $fluent->toArray());
        self::assertEquals($expected, $kit->toArray());
    }

    public function testItCreatesAdvancedEmojis(): void
    {
        $expected = [
            'type'    => 'emoji',
            'name'    => 'basketball',
            'unicode' => '\uD83C\uDFC0',
        ];

        $properties = new Emoji();
        $properties->name = 'basketball';
        $properties->unicode = '\uD83C\uDFC0';

        $constructor = new Emoji('basketball', '\uD83C\uDFC0');
        $fluent = Emoji::new()->name('basketball')->unicode('\uD83C\uDFC0');
        $kit = Kit::emoji('basketball', '\uD83C\uDFC0');

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
