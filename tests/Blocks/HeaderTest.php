<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Blocks;

use SlackPhp\BlockKit\Blocks\Header;
use SlackPhp\BlockKit\Tests\TestCase;
use SlackPhp\BlockKit\Type;

/**
 * @covers \SlackPhp\BlockKit\Blocks\Header
 */
class HeaderTest extends TestCase
{
    public function testThatHeaderRendersToJsonCorrectly(): void
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
