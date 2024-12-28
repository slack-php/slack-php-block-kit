<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\Usergroup;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Parts\MentionStyle;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class UsergroupTest extends TestCase
{
    public function testItCreatesMinimalUsergroups(): void
    {
        $expected = [
            'type'         => 'usergroup',
            'usergroup_id' => 'G123ABC456',
        ];

        $properties = new Usergroup();
        $properties->usergroupId = 'G123ABC456';

        $constructor = new Usergroup('G123ABC456');
        $fluent = Usergroup::new()->usergroupId('G123ABC456');
        $kit = Kit::usergroup('G123ABC456');

        $properties->validate();
        $constructor->validate();
        $fluent->validate();
        $kit->validate();

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $fluent->toArray());
        self::assertEquals($expected, $kit->toArray());
    }

    public function testItCreatesAdvancedUsergroups(): void
    {
        $expected = [
            'type'         => 'usergroup',
            'usergroup_id' => 'G123ABC456',
            'style'        => [
                'bold'             => true,
                'italic'           => true,
                'strike'           => true,
                'highlight'        => true,
                'client_highlight' => true,
                'unlink'           => true,
            ],
        ];

        $style = new MentionStyle(true, true, true, true, true, true);

        $properties = new Usergroup();
        $properties->usergroupId = 'G123ABC456';
        $properties->style = $style;

        $constructor = new Usergroup('G123ABC456', $style);
        $fluent = Usergroup::new()->usergroupId('G123ABC456')->style($style);
        $kit = Kit::usergroup('G123ABC456', $style);

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
