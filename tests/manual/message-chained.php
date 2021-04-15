<?php

declare(strict_types=1);

use SlackPhp\BlockKit\Blocks\{Actions, Context, Header, Image, Section};
use SlackPhp\BlockKit\Inputs\Button;
use SlackPhp\BlockKit\Inputs\DatePicker;
use SlackPhp\BlockKit\Surfaces\Message;

require __DIR__ . '/bootstrap.php';

$msg = Message::new()
    ->add(Header::new()->text('Header'))
    ->add(Section::new()
        ->blockId('b1')
        ->mrkdwnText('*foo* _bar_')
        ->fieldMap(['foo' => 'bar', 'fizz' => 'buzz'])
        ->setAccessory(Button::new()
            ->actionId('a1')
            ->text('Click me!')
            ->value('two')))
    ->divider('b2')
    ->add(Image::new()
        ->blockId('b3')
        ->title('This meeting has gone off the rails!')
        ->url('https://i.imgflip.com/3dezi8.jpg')
        ->altText('A train that has come of the railroad tracks'))
    ->add(Context::new()
        ->blockId('b4')
        ->image('https://i.imgflip.com/3dezi8.jpg', 'off the friggin rails again')
        ->mrkdwnText('*foo* _bar_'))
    ->text('Hello!', 'b5')
    ->add(Actions::new()
        ->blockId('b6')
        ->add(Button::new()
            ->actionId('a2')
            ->text('Submit')
            ->value('Hi!'))
        ->add(DatePicker::new()
            ->placeholder('Choose a date')
            ->initialDate('2020-01-01')
            ->confirm('Proceed?', 'If this is correct, click "OK".')));

view($msg);
