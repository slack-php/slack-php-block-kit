<?php

declare(strict_types=1);

use SlackPhp\BlockKit\Partials\Confirm;
use SlackPhp\BlockKit\Surfaces\WorkflowStep;

require __DIR__ . '/bootstrap.php';

$step = WorkflowStep::new()
    ->privateMetadata('foo=bar')
    ->callbackId('my_foo')
    ->text('Hello!', 'b1');
$step->newInput('b2')
    ->label('Date')
    ->newDatePicker('a1')
        ->placeholder('Choose a date')
        ->initialDate('2020-01-01');
$step->newInput('c1')
    ->label('Multiline')
    ->newTextInput('text_input')
        ->placeholder('Text Input')
        ->multiline(true)
        ->minLength(10)
        ->maxLength(100);
$step->newInput('c2')
    ->label('Radio Buttons')
    ->newRadioButtons('radio_buttons')
    ->option('foo', 'foo')
    ->option('bar', 'bar', true)
    ->option('foobar', 'foobar')
    ->setConfirm(new Confirm('Switch', 'Do you really want to switch?', 'Yes switch'));
$step->newInput('c3')
    ->label('Checkboxes')
    ->newCheckboxes('checkboxes')
    ->option('foo', 'foo')
    ->option('bar', 'bar', true)
    ->option('foobar', 'foobar', true)
    ->setConfirm(new Confirm('Switch', 'Do you really want to switch?', 'Yes switch'));

echo "JSON: {$step->toJson(true)}\n";
