<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Surfaces;

use Jeremeamia\Slack\BlockKit\Surfaces\Message;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Surfaces\Message
 */
class MessageTest extends TestCase
{
    /**
     * @param Message $message
     * @param string $directiveKey
     * @param string $directiveValue
     * @dataProvider provideDirectivesUseCases
     */
    public function testCanApplyDirectives(Message $message, string $directiveKey, string $directiveValue)
    {
        $data = $message->text('foo')->toArray();
        $this->assertArrayHasKey('blocks', $data);
        $this->assertArrayHasKey($directiveKey, $data);
        $this->assertEquals($directiveValue, $data[$directiveKey]);
    }

    public function provideDirectivesUseCases()
    {
        return [
            [Message::new()->ephemeral(), 'response_type', 'ephemeral'],
            [Message::new()->inChannel(), 'response_type', 'in_channel'],
            [Message::new()->replaceOriginal(), 'replace_original', 'true'],
            [Message::new()->deleteOriginal(), 'delete_original', 'true'],
        ];
    }

    public function testDoesNotApplyDirectivesWhenNotSet()
    {
        $data = Message::new()->text('foo')->toArray();
        $this->assertArrayHasKey('blocks', $data);
        $this->assertArrayNotHasKey('response_type', $data);
        $this->assertArrayNotHasKey('replace_original', $data);
        $this->assertArrayNotHasKey('delete_original', $data);
    }
}
