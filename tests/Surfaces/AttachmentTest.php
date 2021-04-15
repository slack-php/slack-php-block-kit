<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Surfaces;

use SlackPhp\BlockKit\Surfaces\{Attachment, Message};
use SlackPhp\BlockKit\Tests\TestCase;
use SlackPhp\BlockKit\Type;

/**
 * @covers \SlackPhp\BlockKit\Surfaces\Attachment
 */
class AttachmentTest extends TestCase
{
    public function testCanCreateAttachment(): void
    {
        $att = Attachment::new()->color('00ff00')->text('foo');

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
        ], $att);
    }

    public function testCanCreateMessageFromAttachment(): void
    {
        $att = Attachment::new()->color('00ff00')->text('foo');
        $msg = $att->asMessage();

        $this->assertInstanceOf(Message::class, $msg);
    }
}
