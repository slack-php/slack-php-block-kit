<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Inputs;

use Jeremeamia\Slack\BlockKit\Inputs\InputElement;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Inputs\InputElement
 */
class InputElementTest extends TestCase
{
    public function testCanSetActionId()
    {
        $input = new class () extends InputElement {
            public function validate(): void
            {
                return;
            }

            public function getType(): string
            {
                return 'mock';
            }
        };
        $inputMutated = $input->actionId('foo');

        $this->assertSame($input, $inputMutated);
        $this->assertJsonData([
            'type' => 'mock',
            'action_id' => 'foo',
        ], $input);
    }

    public function testCanSetActionIdWhenConstructing()
    {
        $input = new class ('foo') extends InputElement {
            public function validate(): void
            {
                return;
            }

            public function getType(): string
            {
                return 'mock';
            }
        };

        $this->assertJsonData([
            'type' => 'mock',
            'action_id' => 'foo',
        ], $input);
    }
}
