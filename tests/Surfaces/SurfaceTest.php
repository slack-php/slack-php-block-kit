<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Surfaces;

use SlackPhp\BlockKit\Blocks\Section;
use SlackPhp\BlockKit\Blocks\Virtual\TwoColumnTable;
use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Tests\TestCase;

/**
 * @covers \SlackPhp\BlockKit\Surfaces\Surface
 */
class SurfaceTest extends TestCase
{
    public function testCanAddSingleBlocks(): void
    {
        $surface = $this->getMockSurface();

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

    public function testCanAddVirtualBlocks(): void
    {
        $surface = $this->getMockSurface();

        $dummyBlock = new Section();
        for ($i = 0; $i < 3; $i++) {
            $virtualBlock = $this->getMockVirtualBlock([$dummyBlock, $dummyBlock, $dummyBlock]);
            $surface->add($virtualBlock);
        }

        $blocks = $surface->getBlocks();
        $this->assertCount(9, $blocks);
        foreach ($blocks as $block) {
            $this->assertSame($dummyBlock, $block);
        }
    }

    public function testCanAddVirtualBlockEarlyOrLateAndBlockCountIsTheSame(): void
    {
        $rows = [
            'a' => '1',
            'b' => '2',
            'c' => '3',
        ];

        $surface1 = $this->getMockSurface();
        $table = (new TwoColumnTable())
            ->caption('Hello, World!')
            ->cols('Foo', 'Bar')
            ->rows($rows);
        $surface1->add($table);
        $this->assertCount(4, $surface1->getBlocks());

        $surface2 = $this->getMockSurface();
        $surface2->newTwoColumnTable()
            ->caption('Hello, World!')
            ->cols('Foo', 'Bar')
            ->rows($rows);
        $this->assertCount(4, $surface2->getBlocks());
    }

    public function testCanValidateDupilcateBlockId(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Slack Block Kit Error: The following block_ids are duplicated : test-block-1, test-block-3 ]'
        );

        $surface = $this->getMockSurface()
            ->add(
                Section::new()
                    ->blockId('test-block-1')
                    ->plainText('test plain text.')
            )
            ->add(
                Section::new()
                    ->blockId('test-block-1')
                    ->plainText('test plain text.')
            )
            ->add(
                Section::new()
                    ->blockId('test-block-2')
                    ->plainText('test plain text.')
            )
            ->add(
                Section::new()
                    ->blockId('test-block-3')
                    ->plainText('test plain text.')
            )
            ->add(
                Section::new()
                    ->blockId('test-block-3')
                    ->plainText('test plain text.')
            )
            ->toArray();
    }
}
