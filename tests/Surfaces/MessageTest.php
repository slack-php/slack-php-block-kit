<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Surfaces;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Surfaces\Attachment;
use SlackPhp\BlockKit\Surfaces\Message;
use SlackPhp\BlockKit\Surfaces\MessageDirective\ResponseType;
use SlackPhp\BlockKit\Tests\TestCase;

/**
 * @covers \SlackPhp\BlockKit\Surfaces\Message
 */
class MessageTest extends TestCase
{
    private const TEST_BLOCKS = [
        [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => 'foo',
            ],
        ],
        [
            'type' => 'section',
            'text' => [
                'type' => 'mrkdwn',
                'text' => 'bar',
            ],
        ],
    ];

    private const TEST_ATTACHMENTS = [
        ['blocks' => self::TEST_BLOCKS],
        ['blocks' => self::TEST_BLOCKS],
    ];

    public function testCanApplyEphemeralMessageType(): void
    {
        $msg = new Message(['foo', 'bar']);
        $msg->ephemeral();

        $this->assertJsonData([
            'response_type' => 'ephemeral',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanApplyInChannelMessageType(): void
    {
        $msg = new Message(['foo', 'bar']);
        $msg->inChannel();

        $this->assertJsonData([
            'response_type' => 'in_channel',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanApplyReplaceOriginal(): void
    {
        $msg = new Message(['foo', 'bar']);
        $msg->replaceOriginal();

        $this->assertJsonData([
            'replace_original' => 'true',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanApplyDontReplaceOriginal(): void
    {
        $msg = new Message(['foo', 'bar']);
        $msg->replaceOriginal(false);

        $this->assertJsonData([
            'replace_original' => 'false',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanRemoveReplaceOriginal(): void
    {
        $msg = new Message(['foo', 'bar']);
        $msg->replaceOriginal()
            ->replaceOriginal(null);
        $data = $msg->toArray();

        $this->assertArrayNotHasKey('replace_original', $data);
    }

    public function testCanApplyDeleteOriginalDirectives(): void
    {
        $msg = new Message(['foo', 'bar']);
        $msg->deleteOriginal();

        $this->assertJsonData([
            'delete_original' => 'true',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanApplyDontDeleteOriginalDirectives(): void
    {
        $msg = new Message(['foo', 'bar']);
        $msg->deleteOriginal(false);

        $this->assertJsonData([
            'delete_original' => 'false',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanRemoveDeleteOriginalDirectives(): void
    {
        $msg = new Message(['foo', 'bar']);
        $msg->deleteOriginal()
            ->deleteOriginal(null);
        $data = $msg->toArray();

        $this->assertArrayNotHasKey('delete_original', $data);
    }

    public function testDoesNotApplyDirectivesWhenNotSet(): void
    {
        $msg = new Message(['foo', 'bar']);
        $data = $msg->toArray();

        $this->assertArrayNotHasKey('response_type', $data);
        $this->assertArrayNotHasKey('replace_original', $data);
        $this->assertArrayNotHasKey('delete_original', $data);
    }

    public function testCanOnlyApplyOneResponseType(): void
    {
        $msg = new Message(['foo', 'bar']);
        $msg->ephemeral()
            ->inChannel();

        $data = $msg->toArray();

        $this->assertArrayHasKey('response_type', $data);
        $this->assertEquals('in_channel', $data['response_type']);
    }

    public function testCanApplyMoreDirectives(): void
    {
        $msg = new Message(['foo', 'bar']);
        $msg->ephemeral()
            ->replaceOriginal()
            ->deleteOriginal()
            ->inChannel();

        $data = $msg->toArray();

        $this->assertArrayHasKey('response_type', $data);
        $this->assertArrayHasKey('delete_original', $data);
        $this->assertArrayHasKey('replace_original', $data);
        $this->assertEquals('in_channel', $data['response_type']);
        $this->assertEquals('true', $data['delete_original']);
        $this->assertEquals('true', $data['replace_original']);
    }

    public function testCanAddAttachments(): void
    {
        $msg = new Message(
            blocks: ['foo', 'bar'],
            attachments: [
                new Attachment(['foo', 'bar']),
                new Attachment(['foo', 'bar']),
            ],
        );

        $this->assertJsonData([
            'blocks' => self::TEST_BLOCKS,
            'attachments' => self::TEST_ATTACHMENTS,
        ], $msg);
    }

    public function testCanAddAttachmentsWithoutPrimaryBlocks(): void
    {
        $msg = Message::new()->attachments(
            new Attachment(['foo', 'bar']),
            new Attachment(['foo', 'bar']),
        );

        $this->assertJsonData([
            'attachments' => self::TEST_ATTACHMENTS,
        ], $msg);
    }

    public function testCanAddFallbackText(): void
    {
        $msg = new Message(blocks: ['foo', 'bar'], text: 'foo bar');

        $this->assertJsonData([
            'text' => 'foo bar',
            'blocks' => self::TEST_BLOCKS,
        ], $msg);
    }

    public function testCanConvertToAnArray(): void
    {
        $msg = new Message(['foo', 'bar'], ResponseType::EPHEMERAL, 'foo bar');
        $data = $msg->toArray();

        $this->assertArrayHasKey('blocks', $data);
        $this->assertEquals(self::TEST_BLOCKS, $data['blocks']);
        $this->assertArrayHasKey('response_type', $data);
        $this->assertEquals('ephemeral', $data['response_type']);
        $this->assertArrayHasKey('text', $data);
        $this->assertEquals('foo bar', $data['text']);
    }

    public function testCanCreateFromAnArray(): void
    {
        $data = [
            'response_type' => 'ephemeral',
            'text' => 'foo bar',
            'blocks' => self::TEST_BLOCKS,
            'attachments' => self::TEST_ATTACHMENTS,
        ];

        $msg = Message::fromArray($data);

        $this->assertEquals($data, $msg->toArray());
    }

    public function testMustAddBlocksOrAttachmentsOrFallbackText(): void
    {
        $msg = new Message();

        $this->expectException(Exception::class);
        $msg->validate();
    }

    public function testCannotHaveInvalidDirective(): void
    {
        $this->expectException(Exception::class);
        Message::fromArray(['response_type' => 'foo']);
    }
}
