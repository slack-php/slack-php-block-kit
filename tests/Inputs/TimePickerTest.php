<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Inputs;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Inputs\TimePicker;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Inputs\TimePicker
 */
class TimePickerTest extends TestCase
{
    public function testCanConfigureTimePicker()
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

    public function testMustAdhereToCorrectTimeFormat()
    {
        $this->expectException(Exception::class);
        $input = (new TimePicker())->initialTime('nope');
    }
}
