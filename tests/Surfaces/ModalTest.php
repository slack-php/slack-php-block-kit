<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Surfaces;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Surfaces\Modal;
use SlackPhp\BlockKit\Tests\TestCase;
use SlackPhp\BlockKit\Type;

/**
 * @covers \SlackPhp\BlockKit\Surfaces\Modal
 * @covers \SlackPhp\BlockKit\Surfaces\View
 */
class ModalTest extends TestCase
{
    private const TEST_BLOCKS = [
        [
            'type' => Type::SECTION,
            'text' => [
                'type' => Type::MRKDWNTEXT,
                'text' => 'foo',
            ],
        ],
        [
            'type' => Type::SECTION,
            'text' => [
                'type' => Type::MRKDWNTEXT,
                'text' => 'bar',
            ],
        ],
    ];

    public function testCanCreateSimpleModal(): void
    {
        $modal = Modal::new()
            ->title('foo bar')
            ->callbackId('foo-bar') // in View
            ->externalId('fizz-buzz') // in View
            ->privateMetadata('foo=bar') // in View
            ->text('foo')
            ->text('bar');

        $expectedData = [
            'type' => 'modal',
            'title' => [
                'type' => 'plain_text',
                'text' => 'foo bar',
            ],
            'callback_id' => 'foo-bar',
            'external_id' => 'fizz-buzz',
            'private_metadata' => 'foo=bar',
            'blocks' => self::TEST_BLOCKS,
        ];

        $this->assertJsonData($expectedData, $modal);

        // Test basic hydration too.
        $hydratedModal = Modal::fromArray($modal->toArray());
        $this->assertJsonData($expectedData, $hydratedModal);
    }

    public function testModalMustHaveTitle(): void
    {
        $modal = Modal::new()->text('foo');
        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/Modals must have a "title"/');
        $modal->validate();
    }

    public function testModalMustHaveSubmitIfContainsInputBlocks(): void
    {
        $modal = Modal::new()->title('foo');
        $modal->newInput()->label('foo')->newTextInput();
        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/Modals must have a "submit" button/');
        $modal->validate();
    }
}
