<?php

namespace SlackPhp\BlockKit\Tests;

use SlackPhp\BlockKit\Blocks\Section;
use SlackPhp\BlockKit\{Exception, Kit, Type};

/**
 * @covers \SlackPhp\BlockKit\Type
 */
class TypeTest extends TestCase
{
    public function testCanMapDefinedElementClassToADefinedType(): void
    {
        $this->assertEquals(Type::SECTION, Type::mapClass(Section::class));
    }

    public function testThrowsErrorIfMappingClassesNotRegisteredInTypeMaps(): void
    {
        $this->expectException(Exception::class);
        Type::mapClass(Kit::class);
    }

    public function testCanMapDefinedElementTypeToADefinedClass(): void
    {
        $this->assertEquals(Section::class, Type::mapType(Type::SECTION));
    }

    public function testThrowsErrorIfMappingTypesNotRegisteredInTypeMaps(): void
    {
        $this->expectException(Exception::class);
        Type::mapType('shoe');
    }
}
