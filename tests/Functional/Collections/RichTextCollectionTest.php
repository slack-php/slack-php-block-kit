<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Collections;

use SlackPhp\BlockKit\Collections\RichTextCollection;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class RichTextCollectionTest extends TestCase
{
    public function testItCreatesRichTextCollections(): void
    {
        $expected = [
            [
                'type' => 'text',
                'text' => 'Hello there, ',
            ],
            [
                'type' => 'text',
                'text' => 'I am a basic rich text!',
            ],
        ];

        $properties = new RichTextCollection();
        $properties->append('Hello there, ');
        $properties->append('I am a basic rich text!');

        $constructor = new RichTextCollection(['Hello there, ', 'I am a basic rich text!']);
        $kit = Kit::richTextCollection(['Hello there, ', 'I am a basic rich text!']);

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $kit->toArray());
    }
}
