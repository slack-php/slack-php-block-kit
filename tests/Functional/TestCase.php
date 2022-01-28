<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional;

use RuntimeException;
use SlackPhp\BlockKit\Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function loadAssetJson(string $file): string
    {
        $file = realpath(__DIR__ . "/assets/{$file}.json");
        if (!$file) {
            throw new RuntimeException("Could not load file at ./assets/{$file}.json");
        }

        $json = file_get_contents($file);
        if (!$json || $json[0] !== '{') {
            throw new RuntimeException("Could not load json data from ./assets/{$file}.json");
        }

        return $json;
    }
}
