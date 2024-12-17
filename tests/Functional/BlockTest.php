<?php

namespace SlackPhp\BlockKit\Tests\Functional;

use SlackPhp\BlockKit\Blocks\Block;
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
            ['blocks/video', Video::class],
        ];
    }
}
