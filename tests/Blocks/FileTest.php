<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Blocks;

use SlackPhp\BlockKit\Blocks\File;
use SlackPhp\BlockKit\Tests\TestCase;
use SlackPhp\BlockKit\Type;

/**
 * @covers \SlackPhp\BlockKit\Blocks\File
 */
class FileTest extends TestCase
{
    public function testThatFileRendersToJsonCorrectly(): void
    {
        $file = new File('id1');
        $file->externalId('foo');
        $this->assertJsonData([
            'type' => Type::FILE,
            'block_id' => 'id1',
            'external_id' => 'foo',
            'source' => 'remote',
        ], $file);
    }
}
