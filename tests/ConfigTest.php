<?php

namespace Jeremeamia\Slack\BlockKit\Tests;

use Jeremeamia\Slack\BlockKit\Config;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Config
 */
class ConfigTest extends TestCase
{
    public function testCanSetConfigValuesWithFluentSyntax()
    {
        $c = Config::new()
            ->setDefaultEmojiSetting(true)
            ->setDefaultVerbatimSetting(true);

        $this->assertTrue($c->getDefaultEmojiSetting());
        $this->assertTrue($c->getDefaultVerbatimSetting());
    }

    public function testCanUseDefaultConfigValues()
    {
        $c = Config::new();

        $this->assertNull($c->getDefaultEmojiSetting());
        $this->assertNull($c->getDefaultVerbatimSetting());
    }
}
