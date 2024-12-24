<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\RichTextPreformatted;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class RichTextPreformattedTest extends TestCase
{
    public function testItCreatesMinimalRichTextPreformatted(): void
    {
        $expected = [
            'type'     => 'rich_text_preformatted',
            'elements' => [
                [
                    'type' => 'text',
                    'text' => 'composer require slack-php/slack-block-kit',
                ],
            ],
        ];

        $properties = new RichTextPreformatted();
        $properties->elements->append('composer require slack-php/slack-block-kit');

        $constructor = new RichTextPreformatted(['composer require slack-php/slack-block-kit']);
        $fluent = RichTextPreformatted::new()->elements('composer require slack-php/slack-block-kit');
        $kit = Kit::richTextPreformatted(['composer require slack-php/slack-block-kit']);

        $properties->validate();
        $constructor->validate();
        $fluent->validate();
        $kit->validate();

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $fluent->toArray());
        self::assertEquals($expected, $kit->toArray());
    }

    public function testItCreatesAdvancedRichTextPreformatted(): void
    {
        $expected = [
            'type'     => 'rich_text_preformatted',
            'border'   => 1,
            'elements' => [
                [
                    'type' => 'text',
                    'text' => 'composer require slack-php/slack-block-kit',
                ],
            ],
        ];

        $properties = new RichTextPreformatted();
        $properties->elements->append('composer require slack-php/slack-block-kit');
        $properties->border = 1;

        $constructor = new RichTextPreformatted(['composer require slack-php/slack-block-kit'], 1);

        $fluent = RichTextPreformatted::new()
            ->elements('composer require slack-php/slack-block-kit')
            ->border(1);

        $kit = Kit::richTextPreformatted(['composer require slack-php/slack-block-kit'], 1);

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
