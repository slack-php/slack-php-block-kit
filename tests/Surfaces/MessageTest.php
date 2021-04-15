<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Surfaces;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Surfaces\Message;
use SlackPhp\BlockKit\Tests\TestCase;
use SlackPhp\BlockKit\Type;

/**
 * @covers \SlackPhp\BlockKit\Surfaces\Message
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
        [
            'type' => Type::SECTION,
            'text' => [
                'type' => Type::MRKDWNTEXT,
                'text' => 'bar',
            ],
        ],
    ];

    private const TEST_ATTACHMENTS = [
        [
            'blocks' => self::TEST_BLOCKS,
        ],
        [
            'blocks' => self::TEST_BLOCKS,
        ],
    ];

    public function testCanApplyEphemeralDirectives(): void
    {
        $msg = Message::new()
            ->ephemeral()
            ->text('foo')
            ->text('bar');
        $data = $msg->toArray();

        $this->assertArrayHasKey('blocks', $data);
        $this->assertArrayHasKey('response_type', $data);
        $this->assertEquals('ephemeral', $data['response_type']);
        $this->assertJsonData([
            'response_type' => 'ephemeral',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanApplyInChannelDirectives(): void
    {
        $msg = Message::new()
            ->inChannel()
            ->text('foo')
            ->text('bar');

        $this->assertJsonData([
            'response_type' => 'in_channel',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanApplyReplaceOriginalDirectives(): void
    {
        $msg = Message::new()
            ->replaceOriginal()
            ->text('foo')
            ->text('bar');

        $this->assertJsonData([
            'replace_original' => 'true',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanApplyDeleteOriginalDirectives(): void
    {
        $msg = Message::new()
            ->deleteOriginal()
            ->text('foo')
            ->text('bar');

        $this->assertJsonData([
            'delete_original' => 'true',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanOnlyApplyOneDirective(): void
    {
        $msg = Message::new()
            ->text('foo')
            ->text('bar')
            ->ephemeral()
            ->replaceOriginal()
            ->deleteOriginal();

        $this->assertJsonData([
            'delete_original' => 'true',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testDoesNotApplyDirectivesWhenNotSet(): void
    {
        $data = Message::new()
            ->text('foo')
            ->text('bar')
            ->toArray();

        $this->assertArrayNotHasKey('response_type', $data);
        $this->assertArrayNotHasKey('replace_original', $data);
        $this->assertArrayNotHasKey('delete_original', $data);
    }

    public function testCanAddAttachments(): void
    {
        $msg = Message::new()->tap(function (Message $msg) {
            $msg->text('foo');
            $msg->text('bar');
            $msg->newAttachment()->text('foo')->text('bar');
            $msg->newAttachment()->text('foo')->text('bar');
        });

        $this->assertJsonData([
            'blocks' => self::TEST_BLOCKS,
            'attachments' => self::TEST_ATTACHMENTS,
        ], $msg);
    }

    public function testCanAddAttachmentsWithoutPrimaryBlocks(): void
    {
        $msg = Message::new()->tap(function (Message $msg) {
            $msg->newAttachment()->text('foo')->text('bar');
            $msg->newAttachment()->text('foo')->text('bar');
        });

        $this->assertJsonData([
            'attachments' => self::TEST_ATTACHMENTS,
        ], $msg);
    }

    public function testCanAddFallbackText(): void
    {
        $msg = Message::new()
            ->text('foo')
            ->text('bar')
            ->fallbackText('foo bar', true);

        $this->assertJsonData([
            'text' => 'foo bar',
            'mrkdwn' => true,
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testMustAddBlocksOrAttachmentsOrFallbackText(): void
    {
        $this->expectException(Exception::class);
        Message::new()->validate();
    }

    public function testCanCreateBlockKitBuilderCompatibleMessageFromExisting(): void
    {
        $msg = Message::new()
            ->ephemeral()
            ->text('foo')
            ->text('bar')
            ->fallbackText('foo bar');

        $this->assertJsonData([
            'blocks' => self::TEST_BLOCKS,
        ], $msg->asPreviewableMessage());
    }

    public function testHydration(): void
    {
        $json = [
            'response_type' => 'ephemeral',
            'text' => 'foo bar',
            'blocks' => self::TEST_BLOCKS,
            'attachments' => self::TEST_ATTACHMENTS,
        ];

        $msg = Message::fromArray($json);

        $this->assertEquals($json, $msg->toArray());
    }

    public function testCannotHaveInvalidDirective(): void
    {
        $this->expectException(Exception::class);
        Message::fromArray(['response_type' => 'foo']);
    }
}
