<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Partials;

use Jeremeamia\Slack\BlockKit\Partials\OptionList;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Partials\OptionList
 * @covers \Jeremeamia\Slack\BlockKit\Partials\HasOptions
 */
class OptionListTest extends TestCase
{
    public function testCanCreateAnOptionsListWithOptions()
    {
        $optionsList = OptionList::new()
            ->option('foobar', '123')
            ->option('foobaz', '456')
            ->option('fizzbuzz', '789');

        $this->assertJsonData([
            'options' => [
                [
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'foobar',
                    ],
                    'value' => '123',
                ],
                [
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'foobaz',
                    ],
                    'value' => '456',
                ],
                [
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'fizzbuzz',
                    ],
                    'value' => '789',
                ],
            ]
        ], $optionsList);
    }
}
