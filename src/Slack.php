<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit;

use Jeremeamia\Slack\BlockKit\Surfaces\{
    AppHome,
    Message,
    Modal,
    WorkflowStep,
};
use Jeremeamia\Slack\BlockKit\Renderers\RendererFactory;

abstract class Slack
{
    public static function newAppHome(): AppHome
    {
        return new AppHome();
    }

    public static function newMessage(): Message
    {
        return new Message();
    }

    public static function newModal(): Modal
    {
        return new Modal();
    }

    public static function newWorkflowStep(): WorkflowStep
    {
        return new WorkflowStep();
    }

    public static function newRenderer(): RendererFactory
    {
        return new RendererFactory();
    }
}
