<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests;

use SlackPhp\BlockKit\Config;
use SlackPhp\BlockKit\Formatter;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Surfaces\{AppHome, Message, Modal};

/**
 * @covers \SlackPhp\BlockKit\Kit
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

    public function testCanCreateSurfaces(): void
    {
        $this->assertInstanceOf(Message::class, Kit::newMessage());
        $this->assertInstanceOf(Modal::class, Kit::newModal());
        $this->assertInstanceOf(AppHome::class, Kit::newAppHome());
    }

    public function testStoresConfigAsSingleton(): void
    {
        $config1 = Kit::config();
        $config2 = Kit::config();
        $this->assertInstanceOf(Config::class, $config1);
        $this->assertInstanceOf(Config::class, $config2);
        $this->assertSame($config1, $config2);
    }

    public function testStoresFormatterAsSingleton(): void
    {
        $formatter1 = Kit::formatter();
        $formatter2 = Kit::formatter();
        $this->assertInstanceOf(Formatter::class, $formatter1);
        $this->assertInstanceOf(Formatter::class, $formatter2);
        $this->assertSame($formatter1, $formatter2);
    }

    public function testCanUsePreviewerToGenerateUrl(): void
    {
        $msg = Kit::newMessage()->text('foo');
        $url = Kit::preview($msg);
        $this->assertStringStartsWith('https://', $url);
        $this->assertStringContainsString('#%7B"blocks"', $url);
    }
}
