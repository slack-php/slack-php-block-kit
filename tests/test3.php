<?php

declare(strict_types=1);

use Jeremeamia\Slack\BlockKit\Slack;

require __DIR__ . '/../vendor/autoload.php';

$m = Slack::newModal()
    ->title('My Modal')
    ->submit('Submit')
    ->close('Cancel')
    ->privateMetadata('foo=bar')
    ->text('Hello!', 'b1');
$m->newInput('b2')
    ->label('Date')
    ->newDatePicker('a1')
        ->placeholder('Choose a date')
        ->initialDate('2020-01-01');

echo Slack::newRenderer()->forJson()->render($m) . "\n";
echo Slack::newRenderer()->forKitBuilder()->render($m) . "\n";
