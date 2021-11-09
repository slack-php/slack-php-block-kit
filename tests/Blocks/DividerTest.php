<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Blocks;

use SlackPhp\BlockKit\Blocks\Divider;
use SlackPhp\BlockKit\Tests\TestCase;
use SlackPhp\BlockKit\Type;

/**
 * @covers \SlackPhp\BlockKit\Blocks\Divider
 */
class DividerTest extends TestCase
{
    public function testThatDividerRendersToJsonCorrectly(): void
    {
        $divider = new Divider();
        $this->assertJsonData([
            'type' => Type::DIVIDER,
        ], $divider);
    }
}
