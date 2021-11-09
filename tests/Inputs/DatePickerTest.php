<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Inputs;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Inputs\DatePicker;
use SlackPhp\BlockKit\Tests\TestCase;

/**
 * @covers \SlackPhp\BlockKit\Inputs\DatePicker
 */
class DatePickerTest extends TestCase
{
    public function testCanConfigureDatePicker(): void
    {
        $input = (new DatePicker())
            ->actionId('my_id')
            ->placeholder('foo')
            ->initialDate('2020-12-25');

        $this->assertJsonData([
            'type' => 'datepicker',
            'action_id' => 'my_id',
            'placeholder' => [
                'type' => 'plain_text',
                'text' => 'foo',
            ],
            'initial_date' => '2020-12-25',
        ], $input);
    }

    public function testMustAdhereToCorrectTimeFormat(): void
    {
        $this->expectException(Exception::class);
        (new DatePicker())->initialDate('nope');
    }
}
