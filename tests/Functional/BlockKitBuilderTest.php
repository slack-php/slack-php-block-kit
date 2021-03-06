<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional;

use SlackPhp\BlockKit\Surfaces\AppHome;
use SlackPhp\BlockKit\Surfaces\Message;
use SlackPhp\BlockKit\Surfaces\Modal;
use SlackPhp\BlockKit\Surfaces\Surface;

class BlockKitBuilderTest extends TestCase
{
    /**
     * @param class-string<Surface> $class
     * @dataProvider providesJsonFiles
     */
    public function testMatchesBlockKitBuilderJson(string $file, string $class): void
    {
        $json = $this->loadAssetJson($file);

        $hydrate = [$class, 'fromJson'](...);
        $surface = $hydrate($json);
        $surface->validate();
        $newJson = $surface->toJson();

        $this->assertJsonStringEqualsJsonString($json, $newJson);
    }

    public function providesJsonFiles(): array
    {
        return [
            ['block-kit-builder/restaurants', Message::class],
            ['block-kit-builder/modal-with-inputs', Modal::class],
            ['block-kit-builder/loaded-message', Message::class],
            ['block-kit-builder/apphome-expense-app', AppHome::class],
            ['block-kit-builder/message-legacy', Message::class],
            ['block-kit-builder/modal-ticket-app', Modal::class],
        ];
    }
}
