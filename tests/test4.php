<?php

declare(strict_types=1);

use Jeremeamia\Slack\BlockKit\Slack;

require __DIR__ . '/../vendor/autoload.php';

$msg = Slack::newMessage();
$msg->newTwoColumnTable('table1')
    ->caption('My Kids')
    ->cols('Name', 'Age')
    ->row('Joey', '10')
    ->row('Izzy', '8')
    ->row('Livy', '5')
    ->row('Emmy', '0');
$msg->divider();
$msg->newTwoColumnTable('table2')
    ->caption('My Kids')
    ->cols('Name', 'Age')
    ->rows([
        ['Joey', '10'],
        ['Izzy', '8'],
        ['Livy', '5'],
        ['Emmy', '0'],
    ]);
$msg->divider();
$msg->newTwoColumnTable('table3')
    ->caption('My Kids')
    ->cols('Name', 'Age')
    ->rows([
        'Joey' => '10',
        'Izzy' => '8',
        'Livy' => '5',
        'Emmy' => '0',
    ]);

echo Slack::newRenderer()->forJson()->render($msg) . "\n";
echo Slack::newRenderer()->forKitBuilder()->render($msg) . "\n";
