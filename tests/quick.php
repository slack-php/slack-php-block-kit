<?php

declare(strict_types=1);

use Jeremeamia\Slack\BlockKit\Slack;

require __DIR__ . '/../vendor/autoload.php';

$msg = Slack::newMessage();
$msg->newSection('init-block')
    ->mrkdwnText('*foo* _bar_')
    ->fieldMap(['foo' => 'bar', 'fizz' => 'buzz'])
    ->newButtonAccessory('my_btn')
        ->text('Click me!')
        ->value('two');
$msg->divider();
$msg->newImage('rails-image')
    ->title('This meeting has gone off the rails!')
    ->url('https://i.imgflip.com/3dezi8.jpg')
    ->altText('A train that has come of the railroad tracks');
$msg->newContext('my-context')
    ->image('https://i.imgflip.com/3dezi8.jpg', 'off the friggin rails again')
    ->mrkdwnText('*foo* _bar_');
$msg->text('Hello!');

echo Slack::newRenderer()->forJson()->render($msg) . "\n";
echo Slack::newRenderer()->forKitBuilder()->render($msg) . "\n";
