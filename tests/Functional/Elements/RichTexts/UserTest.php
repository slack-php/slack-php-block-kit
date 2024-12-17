<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\User;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Parts\MentionStyle;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class UserTest extends TestCase
{
    public function testItCreatesMinimalUsers(): void
    {
        $expected = [
            'type'    => 'user',
            'user_id' => 'U123ABC456',
        ];

        $properties = new User();
        $properties->userId = 'U123ABC456';

        $constructor = new User('U123ABC456');
        $fluent = User::new()->userId('U123ABC456');
        $kit = Kit::user('U123ABC456');

        $properties->validate();
        $constructor->validate();
        $fluent->validate();
        $kit->validate();

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $fluent->toArray());
        self::assertEquals($expected, $kit->toArray());
    }

    public function testItCreatesAdvancedUsers(): void
    {
        $expected = [
            'type'    => 'user',
            'user_id' => 'U123ABC456',
            'style'   => [
                'bold'             => true,
                'italic'           => true,
                'strike'           => true,
                'highlight'        => true,
                'client_highlight' => true,
                'unlink'           => true,
            ],
        ];

        $style = new MentionStyle(true, true, true, true, true, true);

        $properties = new User();
        $properties->userId = 'U123ABC456';
        $properties->style = $style;

        $constructor = new User('U123ABC456', $style);
        $fluent = User::new()->userId('U123ABC456')->style($style);
        $kit = Kit::user('U123ABC456', $style);

        $properties->validate();
        $constructor->validate();
        $fluent->validate();
        $kit->validate();

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $fluent->toArray());
        self::assertEquals($expected, $kit->toArray());
    }
}
