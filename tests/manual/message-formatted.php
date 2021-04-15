<?php

declare(strict_types=1);

use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Surfaces\Message;

require __DIR__ . '/bootstrap.php';

$msg = Kit::newMessage()->tap(function (Message $msg) {
    $f = Kit::formatter();
    $msg->text(<<<MRKDWN
    {$f->escape('<&>')}
    {$f->bold('hello')} world
    {$f->italic('hello')} world
    {$f->strike('hello')} world
    {$f->code('hello')} world
    {$f->blockQuote("this\nis\na\nblockquote")}
    {$f->codeBlock("this\nis\na\ncode block")}
    {$f->bulletedList(['this', 'is', 'a', 'bulleted list'])}
    {$f->numberedList("this\nis\na\nnumbered list")}
    Today is {$f->date(time(), '{date}')}
    Link: {$f->link('http://google.com', 'Google')}
    MailTo: {$f->emailLink('jeremy@example.org', 'Email Jeremy')}
    Join {$f->channel('general')}
    Talk to {$f->user('jeremy.lindblom')}
    Talk to {$f->userGroup('devs')}
    Hey {$f->atHere()}
    Hey {$f->atChannel()}
    Hey {$f->atEveryone()}
    MRKDWN);

    $event = (object) [
        'timestamp' => strtotime('+2 days'),
        'hostId' => 'U123456',
        'channelId' => 'C123456',
    ];
    $msg->text($f->sub(
        'Hello, {audience}! On {date}, {host} will be hosting an AMA in the {channel} channel at {time}.',
        [
            'audience' => $f->atHere(),
            'date'     => $f->date($event->timestamp),
            'host'     => $f->user($event->hostId),
            'channel'  => $f->channel($event->channelId),
            'time'     => $f->time($event->timestamp),
        ]
    ));
});

view($msg);
