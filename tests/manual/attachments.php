<?php

declare(strict_types=1);

use Jeremeamia\Slack\BlockKit\Slack;
use Jeremeamia\Slack\BlockKit\Surfaces\Message;

require __DIR__ . '/../../vendor/autoload.php';

$msg = Message::new()->tap(function (Message $msg) {
    $msg->text('Primary Content');
    $msg->newAttachment()->color('#ff0000')->text('Attachment 1');
    $msg->newAttachment()->color('#00ff00')->text('Attachment 2');
    $msg->newAttachment()->color('#0000ff')->text('Attachment 3');
});

//echo Slack::newRenderer()->forJson()->render($msg) . "\n";
echo Slack::newRenderer()->forKitBuilder()->render($msg) . "\n";
// echo Slack::newRenderer()->forCli()->render($msg) . "\n";
