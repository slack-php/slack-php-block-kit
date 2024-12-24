<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\RichTextQuote;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class RichTextQuoteTest extends TestCase
{
    public function testItCreatesMinimalRichTextQuotes(): void
    {
        $expected = [
            'type'     => 'rich_text_quote',
            'elements' => [
                [
                    'type' => 'text',
                    'text' => 'What we need is good examples in our documentation.',
                ],
            ],
        ];

        $properties = new RichTextQuote();
        $properties->elements->append('What we need is good examples in our documentation.');

        $constructor = new RichTextQuote(['What we need is good examples in our documentation.']);
        $fluent = RichTextQuote::new()->elements('What we need is good examples in our documentation.');
        $kit = Kit::richTextQuote(['What we need is good examples in our documentation.']);

        $properties->validate();
        $constructor->validate();
        $fluent->validate();
        $kit->validate();

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $fluent->toArray());
        self::assertEquals($expected, $kit->toArray());
    }

    public function testItCreatesAdvancedRichTextQuotes(): void
    {
        $expected = [
            'type'     => 'rich_text_quote',
            'elements' => [
                [
                    'type' => 'text',
                    'text' => 'What we need is good examples in our documentation.',
                ],
            ],
            'border'   => 1,
        ];

        $properties = new RichTextQuote();
        $properties->elements->append('What we need is good examples in our documentation.');
        $properties->border = 1;

        $constructor = new RichTextQuote(['What we need is good examples in our documentation.'], 1);

        $fluent = RichTextQuote::new()
            ->elements('What we need is good examples in our documentation.')
            ->border(1);

        $kit = Kit::richTextQuote(['What we need is good examples in our documentation.'], 1);

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
