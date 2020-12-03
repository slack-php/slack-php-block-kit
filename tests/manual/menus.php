<?php

declare(strict_types=1);

use Jeremeamia\Slack\BlockKit\Partials\Confirm;
use Jeremeamia\Slack\BlockKit\Slack;

require __DIR__ . '/../../vendor/autoload.php';

$msg = Slack::newMessage();
$actions = $msg->newActions('b1');
$actions->newSelectMenu('m1')
    ->forStaticOptions()
    ->placeholder('Choose a letter?')
    ->options([
        'a' => 'x',
        'b' => 'y',
        'c' => 'z',
    ]);
$actions->newSelectMenu('m2')
    ->forUsers()
    ->placeholder('Choose a user...');
$msg->newActions('b2')
    ->newSelectMenu('m3')
        ->forStaticOptions()
        ->placeholder('Choose a letter?')
        ->option('a', 'x')
        ->option('b', 'y', true)
        ->option('c', 'z');
$msg->newActions('b3')
    ->newSelectMenu('m4')
        ->forStaticOptions()
        ->placeholder('Choose a letter?')
        ->optionGroups([
            'Letters' => [
                'a' => 'l1',
                'b' => 'l2',
                'c' => 'l3',
            ],
            'Numbers' => [
                '1' => 'n1',
                '2' => 'n2',
                '3' => 'n3',
            ]
        ])
        ->initialOption('b', 'l2');
$msg->newSection('b4')
    ->mrkdwnText('Select some letters and numbers')
    ->newMultiSelectMenuAccessory('m5')
        ->forStaticOptions()
        ->placeholder('Choose a letter?')
        ->maxSelectedItems(2)
        ->optionGroups([
            'Letters' => [
                'a' => 'l1',
                'b' => 'l2',
                'c' => 'l3',
            ],
            'Numbers' => [
                '1' => 'n1',
                '2' => 'n2',
                '3' => 'n3',
            ]
        ])
        ->initialOptions(['b' => 'l2', 'c' => 'l3']);
$msg->newSection('b5')
    ->mrkdwnText('Select from Overflow Menu')
    ->newOverflowMenuAccessory('m6')
    ->option('foo', 'foo')
    ->urlOption('bar', 'bar', 'https://example.org')
    ->option('foobar', 'foobar')
    ->setConfirm(new Confirm('Choose', 'Do you really want to choose this?', 'Yes choose'));
//echo Slack::newRenderer()->forJson()->render($msg) . "\n";
echo Slack::newRenderer()->forKitBuilder()->render($msg) . "\n";
// echo Slack::newRenderer()->forCli()->render($msg) . "\n";
