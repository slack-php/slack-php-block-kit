<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Inputs;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Inputs\TimePicker;
use SlackPhp\BlockKit\Tests\TestCase;

/**
 * @covers \SlackPhp\BlockKit\Inputs\TimePicker
 */
class TimePickerTest extends TestCase
{
    public function testCanConfigureTimePicker(): void
    {
        $input = (new TimePicker())
            ->actionId('my_id')
            ->placeholder('foo')
            ->initialTime('08:05');

        $this->assertJsonData([
            'type' => 'timepicker',
            'action_id' => 'my_id',
            'placeholder' => [
                'type' => 'plain_text',
                'text' => 'foo',
            ],
            'initial_time' => '08:05',
        ], $input);
    }

    public function testMustAdhereToCorrectTimeFormat(): void
    {
        $this->expectException(Exception::class);
        (new TimePicker())->initialTime('nope');
    }
}
