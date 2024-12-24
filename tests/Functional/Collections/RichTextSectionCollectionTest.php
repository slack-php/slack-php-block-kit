<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Collections;

use SlackPhp\BlockKit\Collections\RichTextSectionCollection;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class RichTextSectionCollectionTest extends TestCase
{
    public function testItCreatesRichTextSectionCollections(): void
    {
        $expected = [
            [
                'type'     => 'rich_text_section',
                'elements' => [
                    [
                        'type' => 'text',
                        'text' => 'Huddles',
                    ],
                ],
            ],
            [
                'type'     => 'rich_text_section',
                'elements' => [
                    [
                        'type' => 'text',
                        'text' => 'Canvas',
                    ],
                ],
            ],
            [
                'type'     => 'rich_text_section',
                'elements' => [
                    [
                        'type' => 'text',
                        'text' => 'Developing with Block Kit',
                    ],
                ],
            ],
        ];

        $properties = new RichTextSectionCollection();
        $properties->append('Huddles');
        $properties->append('Canvas');
        $properties->append('Developing with Block Kit');

        $constructor = new RichTextSectionCollection(['Huddles', 'Canvas', 'Developing with Block Kit']);
        $kit = Kit::richTextSectionCollection(['Huddles', 'Canvas', 'Developing with Block Kit']);

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $kit->toArray());
    }
}
