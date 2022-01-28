<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional;

use SlackPhp\BlockKit\Enums\Type;
use SlackPhp\BlockKit\Kit;
use function MongoDB\BSON\toJSON;

class CreateTest extends TestCase
{
    public function testCreatedComponentsMatchExpectedOutput()
    {
        $modal = Kit::modal(
            title: 'My App',
            submit: 'Submit',
            close: 'Cancel',
            blocks: [
                Kit::input(
                    label: 'Choose a letter',
                    element: Kit::multiStaticSelectMenu(
                        placeholder: 'Select letter',
                        optionGroups: [
                            Kit::optionGroup('Group 1', [
                                Kit::option('a', 'value-a'),
                                Kit::option('b', 'value-b'),
                                Kit::option('c', 'value-c'),
                            ]),
                            Kit::optionGroup('Group 2', [
                                Kit::option('x', 'value-x'),
                                Kit::option('y', 'value-y'),
                                Kit::option('z', 'value-z'),
                            ]),
                        ],
                        confirm: Kit::confirm(
                            title: 'Are you sure?',
                            text: 'Think about it.',
                        ),
                    ),
                )
            ],
        );

        $modal->validate();
        $data = $modal->toArray();

        $modal2 = Kit::hydrate($data, Type::MODAL);
        $modal2->validate();

        $expectedJson = $this->loadAssetJson('create/option-groups');
        $this->assertJsonStringEqualsJsonString($expectedJson, $modal->toJson());
        $this->assertJsonStringEqualsJsonString($expectedJson, $modal2->toJson());
    }

    public function testVirtualComponents()
    {
        $message = Kit::message(
            blocks: [
                Kit::twoColumnTable(
                    blockId: 'foo',
                    cols: ['left', 'right'],
                    rows: [
                        ['a', 'b'],
                        ['c', 'd'],
                    ],
                    borders: true,
                ),
                Kit::codeBlock(
                    blockId: 'bar',
                    caption: 'my-code.txt',
                    code: <<<CODE
                    This is
                    my code
                    CODE,
                ),
            ],
        );

        $message->validate();

        $expectedJson = $this->loadAssetJson('create/virtual-blocks');
        $this->assertJsonStringEqualsJsonString($expectedJson, $message->toJson());
    }
}
