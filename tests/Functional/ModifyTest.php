<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional;

use SlackPhp\BlockKit\Blocks\Section;
use SlackPhp\BlockKit\Surfaces\Message;
use SlackPhp\BlockKit\Hydration\HydrationException;

class ModifyTest extends TestCase
{
    /**
     * @dataProvider providesJsonModifications
     */
    public function testModificationsToComponentsMatchExpectedOutputJson(string $expectedFile, callable $modify): void
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

    public function testFailsValidationOnInvalidData(): void
    {
        $this->expectException(HydrationException::class);
        Message::fromJson($this->loadAssetJson('modify/restaurants-broken'));
    }
}
