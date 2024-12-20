<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\RichTextSection;
use SlackPhp\BlockKit\Elements\RichTexts\Text;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Parts\Style;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class RichTextSectionTest extends TestCase
{
    public function testItCreatesRichTextSections(): void
    {
        $expected = [
            'type'     => 'rich_text_section',
            'elements' => [
                [
                    'type' => 'text',
                    'text' => 'Hello there, ',
                ],
                [
                    'type'  => 'text',
                    'text'  => 'I am a bold rich text block!',
                    'style' => [
                        'bold' => true,
                    ],
                ],
            ],
        ];

        $basic = new Text('Hello there, ');
        $bold = new Text('I am a bold rich text block!', new Style(true));

        $properties = new RichTextSection();
        $properties->elements->append($basic, $bold);

        $constructor = new RichTextSection([$basic, $bold]);
        $fluent = RichTextSection::new()->elements($basic, $bold);
        $kit = Kit::richTextSection([$basic, $bold]);

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
