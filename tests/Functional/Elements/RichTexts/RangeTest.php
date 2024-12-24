<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Functional\Elements\RichTexts;

use SlackPhp\BlockKit\Elements\RichTexts\Range;
use SlackPhp\BlockKit\Tests\Functional\TestCase;

class RangeTest extends TestCase
{
    public function testItCreatesEnumInstancesFromGivenValue(): void
    {
        self::assertEquals(Range::CHANNEL, Range::fromValue(Range::CHANNEL));
        self::assertEquals(Range::EVERYONE, Range::fromValue(Range::EVERYONE));
        self::assertEquals(Range::HERE, Range::fromValue(Range::HERE));

        self::assertEquals(Range::CHANNEL, Range::fromValue('channel'));
        self::assertEquals(Range::EVERYONE, Range::fromValue('everyone'));
        self::assertEquals(Range::HERE, Range::fromValue('here'));

        self::assertNull(Range::fromValue(null));
    }
}
