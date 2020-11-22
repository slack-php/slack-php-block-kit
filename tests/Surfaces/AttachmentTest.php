<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Surfaces;

use Jeremeamia\Slack\BlockKit\Surfaces\Attachment;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;
use Jeremeamia\Slack\BlockKit\Type;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Surfaces\Attachment
 */
class AttachmentTest extends TestCase
{
    public function testCanCreateAttachment()
    {
        $msg = Attachment::new()->color('00ff00')->text('foo');

        $this->assertJsonData([
            'color' => '#00ff00',
            'blocks' => [
                [
                    'type' => Type::SECTION,
                    'text' => [
                        'type' => Type::MRKDWNTEXT,
                        'text' => 'foo',
                    ],
                ],
            ],
        ], $msg);
    }
}
