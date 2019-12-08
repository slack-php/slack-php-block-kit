<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Blocks;

use Jeremeamia\Slack\BlockKit\Blocks\Divider;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;
use Jeremeamia\Slack\BlockKit\Type;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Blocks\Divider
 */
class DividerTest extends TestCase
{
    public function testThatDividerRendersToJsonCorrectly()
    {
        $divider = new Divider();
        $this->assertJsonData([
            'type' => Type::DIVIDER,
        ], $divider);
    }
}
