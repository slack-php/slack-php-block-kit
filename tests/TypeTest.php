<?php

namespace Jeremeamia\Slack\BlockKit\Tests;

use Jeremeamia\Slack\BlockKit\Blocks\Section;
use Jeremeamia\Slack\BlockKit\{Exception, Slack, Type};
use PHPUnit\Framework\TestCase;

class TypeTest extends TestCase
{
    public function testCanMapDefinedElementClassToADefinedType()
    {
        $this->assertEquals(Type::SECTION, Type::mapClass(Section::class));
    }

    public function testThrowsErrorIfMappingClassesNotRegisteredInTypeMaps()
    {
        $this->expectException(Exception::class);
        Type::mapClass(Slack::class);
    }
}
