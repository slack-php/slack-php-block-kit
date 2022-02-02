<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Inputs;

use SlackPhp\BlockKit\Inputs\InputElement;
use SlackPhp\BlockKit\Tests\TestCase;

/**
 * @covers \SlackPhp\BlockKit\Inputs\InputElement
 */
class InputElementTest extends TestCase
{
    public function testCanSetActionId(): void
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

    public function testCanSetActionIdWhenConstructing(): void
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
