<?php

declare(strict_types=1);

use SlackPhp\BlockKit\Kit;

require __DIR__ . '/bootstrap.php';

$msg = Kit::newMessage();
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
$actions = $msg->newActions('b6');
$actions->newButton('a2')
    ->text('Complete')
    ->value('completed')
    ->asPrimary();
$actions->newButton('a3')
    ->text('Next')
    ->value('next');
$actions->newButton('a4')
    ->text('Remove')
    ->value('remove')
    ->confirm('Are you sure?', 'If you want to remove it, click "OK".')
    ->asDangerous();
$msg->newActions('b7')
    ->newDatePicker('a5')
        ->placeholder('Choose a date')
        ->initialDate('2020-01-01')
        ->confirm('Proceed?', 'If this is correct, click "OK".');

view($msg);
