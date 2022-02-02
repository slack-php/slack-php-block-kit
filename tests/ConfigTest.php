<?php

namespace SlackPhp\BlockKit\Tests;

use SlackPhp\BlockKit\Config;

/**
 * @covers \SlackPhp\BlockKit\Config
 */
class ConfigTest extends TestCase
{
    public function testCanSetConfigValuesWithFluentSyntax(): void
    {
        $c = Config::new()
            ->setDefaultEmojiSetting(true)
            ->setDefaultVerbatimSetting(true);

        $this->assertTrue($c->getDefaultEmojiSetting());
        $this->assertTrue($c->getDefaultVerbatimSetting());
    }

    public function testCanUseDefaultConfigValues(): void
    {
        $c = Config::new();

        $this->assertNull($c->getDefaultEmojiSetting());
        $this->assertNull($c->getDefaultVerbatimSetting());
    }
}
