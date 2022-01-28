<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional;

use SlackPhp\BlockKit\Blocks\Section;
use SlackPhp\BlockKit\Surfaces\Message;

class ModifyTest extends TestCase
{
    /**
     * @dataProvider providesJsonModifications
     */
    public function testModificationsToComponentsMatchExpectedOutput(string $expectedFile, callable $modify)
    {
        $originalJson = $this->loadAssetJson('modify/restaurants-original');
        $expectedJson = $this->loadAssetJson("modify/restaurants-{$expectedFile}");

        $surface = Message::fromJson($originalJson);
        $surface->validate();
        $modify($surface);
        $surface->validate();
        $newJson = $surface->toJson();

        $this->assertJsonStringEqualsJsonString($expectedJson, $newJson);
    }

    public function providesJsonModifications(): iterable
    {
        yield ['with-added', function (Message $msg) {
            $msg->blocks(new Section('ADDED'));
        }];

        yield ['with-added', function (Message $msg) {
            $msg->blocks[] = new Section('ADDED');
        }];

        yield ['with-deleted', function (Message $msg) {
            unset($msg->blocks[6]);
        }];

        yield ['with-modified', function (Message $msg) {
            $msg->blocks[6]?->elements[0]?->text?->text('MODIFIED');
        }];
    }
}
