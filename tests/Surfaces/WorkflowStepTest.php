<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Surfaces;

use SlackPhp\BlockKit\Surfaces\WorkflowStep;
use SlackPhp\BlockKit\Tests\TestCase;

/**
 * @covers \SlackPhp\BlockKit\Surfaces\WorkflowStep
 */
class WorkflowStepTest extends TestCase
{
    public function testCanConfigureTextInput()
    {
        $workflowStep = WorkflowStep::new()
            ->callbackId('my_step')
            ->privateMetadata('foo=bar');
        $workflowStep->newInput()
            ->label('Config')
            ->newTextInput('step_config');

        $this->assertJsonData([
            'type' => 'workflow_step',
            'callback_id' => 'my_step',
            'private_metadata' => 'foo=bar',
            'blocks' => [
                [
                    'type' => 'input',
                    'label' => [
                        'type' => 'plain_text',
                        'text' => 'Config',
                    ],
                    'element' => [
                        'type' => 'plain_text_input',
                        'action_id' => 'step_config',
                    ],
                ],
            ],
        ], $workflowStep);
    }
}
