<?php

declare(strict_types=1);

use Jeremeamia\Slack\BlockKit\Slack;

require __DIR__ . '/../vendor/autoload.php';

$msg = Slack::newMessage();
$msg->newSection('b1')
    ->mrkdwnText('*foo* _bar_')
    ->fieldMap(['foo' => 'bar', 'fizz' => 'buzz'])
    ->newButtonAccessory('a1')
        ->text('Click me!')
        ->value('two');
$msg->divider('b2');
$msg->newImage('b3')
    ->title('This meeting has gone off the rails!')
    ->url('https://i.imgflip.com/3dezi8.jpg')
    ->altText('A train that has come of the railroad tracks');
$msg->newContext('b4')
    ->image('https://i.imgflip.com/3dezi8.jpg', 'off the friggin rails again')
    ->mrkdwnText('*foo* _bar_');
$msg->text('Hello!', 'b5');
$msg->newActions('b6')
    ->newButton('a2')
    ->text('Submit')
    ->value('Hi!');

echo Slack::newRenderer()->forJson()->render($msg) . "\n";
echo Slack::newRenderer()->forKitBuilder()->render($msg) . "\n";
