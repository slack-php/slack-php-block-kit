<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Blocks;

use SlackPhp\BlockKit\Blocks\Actions;
use SlackPhp\BlockKit\Tests\TestCase;
use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Inputs\Button;

/**
 * @covers \SlackPhp\BlockKit\Blocks\Actions
 */
class ActionsTest extends TestCase
{
    public function testCanValidateDupilcateActionId(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Slack Block Kit Error: The following action_ids are duplicated : test-action-1, test-action-3 ]'
        );

        $surface = $this->getMockSurface()
            ->add(
                Actions::new()
                ->add(
                    Button::new()
                    ->actionId('test-action-1')
                    ->text('Submit')
                    ->value('Hi!')
                )
                ->add(
                    Button::new()
                    ->actionId('test-action-1')
                    ->text('Submit')
                    ->value('Hi!')
                )
                ->add(
                    Button::new()
                    ->actionId('test-action-2')
                    ->text('Submit')
                    ->value('Hi!')
                )
                ->add(
                    Button::new()
                    ->actionId('test-action-3')
                    ->text('Submit')
                    ->value('Hi!')
                )
                ->add(
                    Button::new()
                    ->actionId('test-action-3')
                    ->text('Submit')
                    ->value('Hi!')
                )
            )
            ->toArray();
    }
}
