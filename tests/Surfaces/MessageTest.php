<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Surfaces;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Surfaces\Message;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;
use Jeremeamia\Slack\BlockKit\Type;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Surfaces\Message
 */
class MessageTest extends TestCase
{
    private const TEST_BLOCKS = [
        [
            'type' => Type::SECTION,
            'text' => [
                'type' => Type::MRKDWNTEXT,
                'text' => 'foo',
            ],
        ],
    ];

    public function testCanApplyEphemeralDirectives()
    {
        $data = Message::new()->ephemeral()->text('foo')->toArray();
        $this->assertArrayHasKey('blocks', $data);
        $this->assertArrayHasKey('response_type', $data);
        $this->assertEquals('ephemeral', $data['response_type']);

        $msg = Message::new()->ephemeral()->text('foo');
        $this->assertJsonData([
            'response_type' => 'ephemeral',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanApplyInChannelDirectives()
    {
        $msg = Message::new()->inChannel()->text('foo');
        $this->assertJsonData([
            'response_type' => 'in_channel',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanApplyReplaceOriginalDirectives()
    {
        $msg = Message::new()->replaceOriginal()->text('foo');
        $this->assertJsonData([
            'replace_original' => 'true',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanApplyDeleteOriginalDirectives()
    {
        $msg = Message::new()->deleteOriginal()->text('foo');
        $this->assertJsonData([
            'delete_original' => 'true',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanOnlyApplyOneDirective()
    {
        $msg = Message::new()
            ->text('foo')
            ->ephemeral()
            ->replaceOriginal()
            ->deleteOriginal();

        $this->assertJsonData([
            'delete_original' => 'true',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCannotInvalidDirective()
    {
        $msg = Message::new()
            ->text('foo')
            ->ephemeral()
            ->directives(['foo' => 'bar']);

        $this->expectException(Exception::class);
        $msg->validate();
    }

    public function testDoesNotApplyDirectivesWhenNotSet()
    {
        $data = Message::new()->text('foo')->toArray();
        $this->assertArrayNotHasKey('response_type', $data);
        $this->assertArrayNotHasKey('replace_original', $data);
        $this->assertArrayNotHasKey('delete_original', $data);
    }

    public function testCanAddAttachments()
    {
        $msg = Message::new()->tap(function (Message $msg) {
            $msg->text('foo');
            $msg->newAttachment()->text('bar');
            $msg->newAttachment()->text('baz');
        });

        $this->assertJsonData([
            'blocks' => [
                [
                    'type' => Type::SECTION,
                    'text' => [
                        'type' => Type::MRKDWNTEXT,
                        'text' => 'foo',
                    ],
                ],
            ],
            'attachments' => [
                [
                    'blocks' => [
                        [
                            'type' => Type::SECTION,
                            'text' => [
                                'type' => Type::MRKDWNTEXT,
                                'text' => 'bar',
                            ],
                        ],
                    ],
                ],
                [
                    'blocks' => [
                        [
                            'type' => Type::SECTION,
                            'text' => [
                                'type' => Type::MRKDWNTEXT,
                                'text' => 'baz',
                            ],
                        ],
                    ],
                ],
            ]
        ], $msg);
    }

    public function testCanAddAttachmentsWithoutPrimaryBlocks()
    {
        $msg = Message::new()->tap(function (Message $msg) {
            $msg->newAttachment()->text('foo');
        });

        $this->assertJsonData([
            'attachments' => [
                [
                    'blocks' => self::TEST_BLOCKS,
                ],
            ]
        ], $msg);
    }

    public function testMustAddBlocksAndOrAttachments()
    {
        $this->expectException(Exception::class);
        Message::new()->validate();
    }
}
