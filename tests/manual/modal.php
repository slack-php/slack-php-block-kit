<?php

declare(strict_types=1);

use Jeremeamia\Slack\BlockKit\Slack;

require __DIR__ . '/../../vendor/autoload.php';

$msg = Slack::newModal()
    ->title('My Modal')
    ->submit('Submit')
    ->close('Cancel')
    ->privateMetadata('foo=bar')
    ->text('Hello!', 'b1');
$msg->newInput('b2')
    ->label('Date')
    ->newDatePicker('a1')
        ->placeholder('Choose a date')
        ->initialDate('2020-01-01');
$msg->newInput('c1')
    ->label('Multiline')
    ->newTextInput('text_input')
        ->placeholder('Text Input')
        ->multiline(true)
        ->minLength(10)
        ->maxLength(100);

// echo Slack::newRenderer()->forJson()->render($msg) . "\n";
echo Slack::newRenderer()->forKitBuilder()->render($msg) . "\n";
// echo Slack::newRenderer()->forCli()->render($msg) . "\n";
