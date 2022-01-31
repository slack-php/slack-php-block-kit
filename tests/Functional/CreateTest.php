<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional;

use SlackPhp\BlockKit\Blocks\Virtual\VirtualBlock;
use SlackPhp\BlockKit\Collections\ComponentCollection;
use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Enums\Type;
use SlackPhp\BlockKit\Kit;
use SlackPhp\BlockKit\Tools\PrivateMetadata;
use SlackPhp\BlockKit\Tools\ValidationException;

class CreateTest extends TestCase
{
    public function testCreatedComponentsMatchExpectedOutputJson()
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

    public function testCreatedVirtualComponentsMatchExpectedOutputJson()
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

    public function testCreateModalWithPrivateMetadata()
    {
        $modal = Kit::modal(
            title: 'My App',
            privateMetadata: [
                'foo' => 'bar',
            ],
            blocks: [
                Kit::section('Hello, world!'),
            ],
        );

        $modal->validate();

        $expectedJson = $this->loadAssetJson('create/modal-metadata');
        $this->assertJsonStringEqualsJsonString($expectedJson, $modal->toJson());

        $this->assertNull(PrivateMetadata::decode(''));
        $metadata = PrivateMetadata::decode($modal->privateMetadata);
        $this->assertEquals('bar', $metadata['foo']);
        $this->assertTrue(isset($metadata['foo']));
        $metadata['foo'] = 'baz';
        $this->assertEquals('baz', $metadata['foo']);
        unset($metadata['foo']);
        $this->assertFalse(isset($metadata['foo']));

        $modal->privateMetadata(Kit::privateMetadata([]));
        $this->assertJsonStringEqualsJsonString(
            $this->loadAssetJson('create/modal-removed-metadata'),
            $modal->toJson()
        );
    }

    public function testFailsValidationIfMissingData()
    {
        $msg = Kit::message();
        $this->expectException(ValidationException::class);
        $msg->validate();
    }

    public function testFailsValidationIfInvalidData()
    {
        $msg = Kit::message()->blocks(Kit::section(str_repeat('x', 5000)));
        $this->expectException(ValidationException::class);
        $msg->validate();
    }

    public function testCanCreatePreviewLink()
    {
        $msg = Kit::message([Kit::section('Hello, world!')]);
        $url = Kit::preview($msg);
        $headers = get_headers($url, true);
        $this->assertArrayHasKey('x-slack-backend', $headers);
    }

    public function testThatAllKitComponentMethodsReturnComponents()
    {
        static $skip = [
            'fieldsFromMap',
            'fieldsFromPairs',
            'privateMetadata',
            'formatter',
            'preview',
            'hydrate',
        ];

        static $virtual = [
            'twoColumnTable',
            'codeBlock',
        ];

        $class = new \ReflectionClass(Kit::class);
        foreach ($class->getMethods(\ReflectionMethod::IS_STATIC) as $method) {
            if (in_array($method->getName(), $skip, true)) {
                continue;
            }

            $result = $method->invoke(null);
            if (str_contains($method->getName(), 'Collection') || $method->getName() === 'optionSet') {
                $this->assertInstanceOf(ComponentCollection::class, $result);
            } elseif (in_array($method->getName(), $virtual, true)) {
                $this->assertInstanceOf(VirtualBlock::class, $result);
            } else {
                $this->assertInstanceOf(Component::class, $result);
            }
        }
    }
}
