<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Blocks;

use Jeremeamia\Slack\BlockKit\Blocks\BlockElement;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Blocks\BlockElement
 */
class BlockElementTest extends TestCase
{
    public function testCanSetBlockId()
    {
        $block = new class () extends BlockElement {
            public function validate(): void
            {
                return;
            }
        };
        $blockMutated = $block->blockId('foo');

        $this->assertSame($block, $blockMutated);
        $this->assertEquals('foo', $block->getBlockId());
    }

    public function testCanSetBlockIdWhenConstructing()
    {
        $block = new class ('foo') extends BlockElement {
            public function validate(): void
            {
                return;
            }

            public function getType(): string
            {
                return 'mock';
            }
        };
        $this->assertEquals('foo', $block->getBlockId());
        $this->assertJsonData([
            'type' => 'mock',
            'block_id' => 'foo',
        ], $block);
    }
}
