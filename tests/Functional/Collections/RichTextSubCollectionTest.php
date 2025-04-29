<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Collections;

use SlackPhp\BlockKit\Collections\RichTextSubCollection;
use SlackPhp\BlockKit\Elements\RichTexts\RichTextSection;
use SlackPhp\BlockKit\Elements\RichTexts\Text;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Parts\Style;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class RichTextSubCollectionTest extends TestCase
{
    public function testItCreatesRichTextSubCollections(): void
    {
        $expected = [
            [
                'type'     => 'rich_text_section',
                'elements' => [
                    [
                        'type' => 'text',
                        'text' => 'Hello there, I am a basic rich text!',
                    ],
                ],
            ],
            [
                'type'     => 'rich_text_section',
                'elements' => [
                    [
                        'type' => 'text',
                        'text' => 'Hello there, ',
                    ],
                    [
                        'type'  => 'text',
                        'text'  => 'I am a bold rich text!',
                        'style' => [
                            'bold' => true,
                        ],
                    ],
                ],
            ],
        ];

        $basic = new RichTextSection(['Hello there, I am a basic rich text!']);
        $bold = new RichTextSection([
            'Hello there, ',
            new Text('I am a bold rich text!', new Style(true)),
        ]);

        $properties = new RichTextSubCollection();
        $properties->append($basic);
        $properties->append($bold);

        $constructor = new RichTextSubCollection([$basic, $bold]);
        $kit = Kit::richTextSubCollection([$basic, $bold]);

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $kit->toArray());
    }
}
