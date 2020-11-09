<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Inputs;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Inputs\DatePicker;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Inputs\DatePicker
 */
class DatePickerTest extends TestCase
{
    public function testCanConfigureTextInput()
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

    public function testMustAdhereToCorrectTimeFormat()
    {
        $this->expectException(Exception::class);
        $input = (new DatePicker())->initialDate('nope');
    }
}
