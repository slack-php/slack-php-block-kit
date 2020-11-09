<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Surfaces;

use Jeremeamia\Slack\BlockKit\Slack;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Surfaces\WorkflowStep
 */
class WorkflowStepTest extends TestCase
{
    public function testCanConfigureTextInput()
    {
        $workflowStep = Slack::newWorkflowStep()
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
