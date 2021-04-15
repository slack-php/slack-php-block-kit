<?php

declare(strict_types=1);

use SlackPhp\BlockKit\Surfaces\Message;

require __DIR__ . '/bootstrap.php';

$msg = Message::new()->tap(function (Message $msg) {
    $msg->text('Primary Content');
    $msg->newAttachment()->color('#ff0000')->text('Attachment 1');
    $msg->newAttachment()->color('#00ff00')->text('Attachment 2');
    $msg->newAttachment()->color('#0000ff')->text('Attachment 3');
});

view($msg);
