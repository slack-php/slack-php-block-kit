<?php

declare(strict_types=1);

use Jeremeamia\Slack\BlockKit\Actions\Button;
use Jeremeamia\Slack\BlockKit\Slack;

require __DIR__ . '/../vendor/autoload.php';

$msg = Slack::message();
$msg->section('init-block')
    ->mrkdwnText('*foo* _bar_')
    ->fieldMap(['foo' => 'bar', 'fizz' => 'buzz'])
    ->setAccessory(Button::new()->text('Click me!')->value('two')->actionId('my_btn'));
$msg->divider();
$msg->image('rails-image')
    ->url('https://i.imgflip.com/3dezi8.jpg')
    ->altText('A train that has come of the railroad tracks')
    ->title('This meeting has gone off the rails!');
$msg->context('my-context')
    ->image('https://i.imgflip.com/3dezi8.jpg', 'off the friggin rails again')
    ->mrkdwnText('*foo* _bar_');

echo Slack::rendererForJson()->render($msg) . "\n";
echo Slack::rendererForKitBuilder()->render($msg) . "\n";
