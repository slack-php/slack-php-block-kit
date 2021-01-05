<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests;

use Jeremeamia\Slack\BlockKit\Config;
use Jeremeamia\Slack\BlockKit\Formatter;
use Jeremeamia\Slack\BlockKit\Kit;
use Jeremeamia\Slack\BlockKit\Surfaces\{AppHome, Message, Modal};

/**
 * @covers \Jeremeamia\Slack\BlockKit\Kit
 */
class KitTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->setStaticProperties(Kit::class, [
            'config' => null,
            'formatter' => null,
            'previewer' => null,
        ]);
    }

    public function testCanCreateSurfaces()
    {
        $this->assertInstanceOf(Message::class, Kit::newMessage());
        $this->assertInstanceOf(Modal::class, Kit::newModal());
        $this->assertInstanceOf(AppHome::class, Kit::newAppHome());
    }

    public function testStoresConfigAsSingleton()
    {
        $config1 = Kit::config();
        $config2 = Kit::config();
        $this->assertInstanceOf(Config::class, $config1);
        $this->assertInstanceOf(Config::class, $config2);
        $this->assertSame($config1, $config2);
    }

    public function testStoresFormatterAsSingleton()
    {
        $formatter1 = Kit::formatter();
        $formatter2 = Kit::formatter();
        $this->assertInstanceOf(Formatter::class, $formatter1);
        $this->assertInstanceOf(Formatter::class, $formatter2);
        $this->assertSame($formatter1, $formatter2);
    }

    public function testCanUsePreviewerToGenerateUrl()
    {
        $msg = Kit::newMessage()->text('foo');
        $url = Kit::preview($msg);
        $this->assertStringStartsWith('https://', $url);
        $this->assertStringContainsString('#%7B"blocks"', $url);
    }
}
