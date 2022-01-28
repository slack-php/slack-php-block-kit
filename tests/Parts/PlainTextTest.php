<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Parts;

use SlackPhp\BlockKit\Parts\PlainText;
use SlackPhp\BlockKit\Tests\TestCase;

/**
 * @covers \SlackPhp\BlockKit\Parts\PlainText
 */
class PlainTextTest extends TestCase
{
    public function testThatSomethingDoesSomething()
    {
        $this->assertTrue(class_exists(PlainText::class));
    }
}
