<?php

namespace SlackPhp\BlockKit\Tests;

use SlackPhp\BlockKit\Blocks\Section;
use SlackPhp\BlockKit\{Exception, Kit, Type};

/**
 * @covers \SlackPhp\BlockKit\Type
 */
class TypeTest extends TestCase
{
    public function testCanMapDefinedElementClassToADefinedType()
    {
        $this->assertEquals(Type::SECTION, Type::mapClass(Section::class));
    }

    public function testThrowsErrorIfMappingClassesNotRegisteredInTypeMaps()
    {
        $this->expectException(Exception::class);
        Type::mapClass(Kit::class);
    }

    public function testCanMapDefinedElementTypeToADefinedClass()
    {
        $this->assertEquals(Section::class, Type::mapType(Type::SECTION));
    }

    public function testThrowsErrorIfMappingTypesNotRegisteredInTypeMaps()
    {
        $this->expectException(Exception::class);
        Type::mapType('shoe');
    }
}
