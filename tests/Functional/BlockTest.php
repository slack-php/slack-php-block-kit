<?php

namespace SlackPhp\BlockKit\Tests\Functional;

use SlackPhp\BlockKit\Blocks\Block;
use SlackPhp\BlockKit\Blocks\RichText;
use SlackPhp\BlockKit\Blocks\Video;

class BlockTest extends TestCase
{
    /**
     * @param class-string<Block> $class
     * @dataProvider providesJsonFiles
     */
    public function testMatchesJsonFromReferenceDocumentation(string $file, string $class): void
    {
        $json = $this->loadAssetJson($file);

        $hydrate = [$class, 'fromJson'](...);
        $block = $hydrate($json);
        $block->validate();
        $newJson = $block->toJson();

        $this->assertJsonStringEqualsJsonString($json, $newJson);
    }

    public static function providesJsonFiles(): array
    {
        return [
            ['blocks/rich_text_broadcast', RichText::class],
            ['blocks/rich_text_channel', RichText::class],
            ['blocks/rich_text_color', RichText::class],
            ['blocks/rich_text_date', RichText::class],
            ['blocks/rich_text_emoji', RichText::class],
            ['blocks/rich_text_link', RichText::class],
            ['blocks/rich_text_list', RichText::class],
            ['blocks/rich_text_preformatted', RichText::class],
            ['blocks/rich_text_quote', RichText::class],
            ['blocks/rich_text_section_basic', RichText::class],
            ['blocks/rich_text_section_bold', RichText::class],
            ['blocks/rich_text_section_italic', RichText::class],
            ['blocks/rich_text_section_strikethrough', RichText::class],
            ['blocks/rich_text_text', RichText::class],
            ['blocks/rich_text_user', RichText::class],
            ['blocks/rich_text_usergroup', RichText::class],
            ['blocks/video', Video::class],
        ];
    }
}
