<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Blocks;

use SlackPhp\BlockKit\Blocks\BlockElement;
use SlackPhp\BlockKit\Tests\TestCase;

/**
 * @covers \SlackPhp\BlockKit\Blocks\BlockElement
 */
class BlockElementTest extends TestCase
{
    public function testCanSetBlockId(): void
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

    public function testCanSetBlockIdWhenConstructing(): void
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
