<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\Date;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class DateTest extends TestCase
{
    public function testItCreatesMinimalDates(): void
    {
        $expected = [
            'type'      => 'date',
            'timestamp' => 1720710212,
            'format'    => '{date_num} at {time}',
        ];

        $properties = new Date();
        $properties->timestamp = 1720710212;
        $properties->format = '{date_num} at {time}';

        $constructor = new Date(1720710212, '{date_num} at {time}');
        $fluent = Date::new()->timestamp(1720710212)->format('{date_num} at {time}');
        $kit = Kit::date(1720710212, '{date_num} at {time}');

        $properties->validate();
        $constructor->validate();
        $fluent->validate();
        $kit->validate();

        self::assertEquals($expected, $properties->toArray());
        self::assertEquals($expected, $constructor->toArray());
        self::assertEquals($expected, $fluent->toArray());
        self::assertEquals($expected, $kit->toArray());
    }

    public function testItCreatesAdvancedDates(): void
    {
        $expected = [
            'type'      => 'date',
            'timestamp' => 1720710212,
            'format'    => '{date_num} at {time}',
            'url'       => 'https://api.slack.com',
            'fallback'  => 'Current time',
        ];

        $properties = new Date();
        $properties->timestamp = 1720710212;
        $properties->format = '{date_num} at {time}';
        $properties->url = 'https://api.slack.com';
        $properties->fallback = 'Current time';

        $constructor = new Date(
            1720710212,
            '{date_num} at {time}',
            'https://api.slack.com',
            'Current time',
        );

        $fluent = Date::new()
            ->timestamp(1720710212)
            ->format('{date_num} at {time}')
            ->url('https://api.slack.com')
            ->fallback('Current time');

        $kit = Kit::date(
            1720710212,
            '{date_num} at {time}',
            'https://api.slack.com',
            'Current time',
        );

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
