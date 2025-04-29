<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\ListStyle;
use SlackPhp\BlockKit\Elements\RichTexts\RichTextList;
use SlackPhp\BlockKit\Elements\RichTexts\RichTextSection;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class RichTextListTest extends TestCase
{
    public function testItCreatesMinimalRichTextLists(): void
    {
        $expected = [
            'type'     => 'rich_text_list',
            'style'    => 'bullet',
            'elements' => [
                [
                    'type'     => 'rich_text_section',
                    'elements' => [
                        [
                            'type' => 'text',
                            'text' => 'Hashbrowns',
                        ],
                    ],
                ],
                [
                    'type'     => 'rich_text_section',
                    'elements' => [
                        [
                            'type' => 'text',
                            'text' => 'Eggs',
                        ],
                    ],
                ],
            ],
        ];

        $hashbrowns = new RichTextSection(['Hashbrowns']);
        $eggs = new RichTextSection(['Eggs']);

        $properties = new RichTextList();
        $properties->elements->append($hashbrowns, $eggs);
        $properties->style = ListStyle::BULLET;

        $constructor = new RichTextList([$hashbrowns, $eggs], ListStyle::BULLET);
        $fluent = RichTextList::new()->elements($hashbrowns, $eggs)->style(ListStyle::BULLET);
        $kit = Kit::richTextList([$hashbrowns, $eggs], ListStyle::BULLET);

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
