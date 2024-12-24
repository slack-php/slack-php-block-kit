<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\ListStyle;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class ListStyleTest extends TestCase
{
    public function testItCreatesEnumInstancesFromGivenValue(): void
    {
        self::assertEquals(ListStyle::BULLET, ListStyle::fromValue(ListStyle::BULLET));
        self::assertEquals(ListStyle::ORDERED, ListStyle::fromValue(ListStyle::ORDERED));

        self::assertEquals(ListStyle::BULLET, ListStyle::fromValue('bullet'));
        self::assertEquals(ListStyle::ORDERED, ListStyle::fromValue('ordered'));

        self::assertNull(ListStyle::fromValue(null));
    }
}
