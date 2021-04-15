<?php

declare(strict_types=1);

use SlackPhp\BlockKit\Kit;

require __DIR__ . '/bootstrap.php';

$msg = Kit::newMessage();
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

view($msg);
