<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Surfaces;

use Jeremeamia\Slack\BlockKit\Blocks\Section;
use Jeremeamia\Slack\BlockKit\Blocks\Virtual\VirtualBlock;
use Jeremeamia\Slack\BlockKit\Surfaces\Surface;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Surfaces\Surface
 */
class SurfaceTest extends TestCase
{
    public function testCanAddSingleBlocks()
    {
        $surface = new class () extends Surface {
            public function getType(): string
            {
                return 'message';
            }
        };

        $dummyBlock = new Section();
        $surface->add($dummyBlock);
        $surface->add($dummyBlock);
        $surface->add($dummyBlock);

        $blocks = $surface->getBlocks();
        $this->assertCount(3, $blocks);
        foreach ($blocks as $block) {
            $this->assertSame($dummyBlock, $block);
        }
    }

    public function testCanAddVirtualBlocks()
    {
        $surface = new class () extends Surface {
            public function getType(): string
            {
                return 'message';
            }
        };

        $dummyBlock = new Section();
        for ($i = 0; $i < 3; $i++) {
            $virtualBlock = new class () extends VirtualBlock {
                public function add(Section $section)
                {
                    $this->appendBlock($section);
                }
            };
            for ($j = 0; $j < 3; $j++) {
                $virtualBlock->add($dummyBlock);
            }
            $surface->add($virtualBlock);
        }

        $blocks = $surface->getBlocks();
        $this->assertCount(9, $blocks);
        foreach ($blocks as $block) {
            $this->assertSame($dummyBlock, $block);
        }
    }
}
