<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Blocks;

use Jeremeamia\Slack\BlockKit\Blocks\Header;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;
use Jeremeamia\Slack\BlockKit\Type;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Blocks\Header
 */
class HeaderTest extends TestCase
{
    public function testThatHeaderRendersToJsonCorrectly()
    {
        $header = new Header('id1');
        $header->text('foo');
        $this->assertJsonData([
            'type' => Type::HEADER,
            'block_id' => 'id1',
            'text' => [
                'type' => Type::PLAINTEXT,
                'text' => 'foo',
            ]
        ], $header);
    }
}
