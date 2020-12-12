<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Blocks;

use Jeremeamia\Slack\BlockKit\Blocks\File;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;
use Jeremeamia\Slack\BlockKit\Type;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Blocks\File
 */
class FileTest extends TestCase
{
    public function testThatFileRendersToJsonCorrectly()
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
