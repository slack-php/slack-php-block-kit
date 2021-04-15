<?php

declare(strict_types=1);

use SlackPhp\BlockKit\Partials\Confirm;
use SlackPhp\BlockKit\Kit;

require __DIR__ . '/bootstrap.php';

$msg = Kit::newModal()
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
$msg->newInput('c2')
    ->label('Radio Buttons')
    ->newRadioButtons('radio_buttons')
    ->option('foo', 'foo')
    ->option('bar', 'bar', true)
    ->option('foobar', 'foobar')
    ->setConfirm(new Confirm('Switch', 'Do you really want to switch?', 'Yes switch'));
$msg->newInput('c3')
    ->label('Checkboxes')
    ->newCheckboxes('checkboxes')
    ->option('foo', 'foo')
    ->option('bar', 'bar', true)
    ->option('foobar', 'foobar', true)
    ->setConfirm(new Confirm('Switch', 'Do you really want to switch?', 'Yes switch'));

view($msg);
