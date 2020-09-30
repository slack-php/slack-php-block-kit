<?php

namespace Jeremeamia\Slack\BlockKit\Tests;

use Jeremeamia\Slack\BlockKit\{Blocks\Section, Element, Exception, Type};

/**
 * @covers \Jeremeamia\Slack\BlockKit\Element
 */
class ElementTest extends TestCase
{
    public function testCanSerializeValidElementToJson()
    {
        $element = $this->getMockElement();

        $this->assertJsonData($element, [
            'type' => 'mock',
            'text' => 'foo',
        ]);
    }

    public function testThrowsErrorElementIsInvalid()
    {
        $this->expectException(Exception::class);
        $element = $this->getMockElement(false);
        $this->jsonEncode($element);
    }

    public function testCanSetParentWithFluidInterfaceAndGetParentBack()
    {
        $parent = $this->getMockElement();
        $element = $this->getMockElement();
        $elementMutated = $element->setParent($parent);
        $this->assertSame($element, $elementMutated);
        $this->assertSame($parent, $element->getParent());
    }

    public function testCanUseNewAsFactoryForChildClasses()
    {
        $element = Section::new();
        $this->assertEquals(Type::SECTION, $element->getType());
        $this->assertInstanceOf(Section::class, $element);
    }

    public function testCanSetExtraFieldsForArbitraryData()
    {
        $element = $this->getMockElement();

        $element->setExtra('fizz', 'buzz');

        $this->assertJsonData($element, [
            'type' => 'mock',
            'text' => 'foo',
            'fizz' => 'buzz',
        ]);
    }

    public function testErrorIfExtraFieldIsInvalid()
    {
        $element = $this->getMockElement();

        $this->expectException(Exception::class);
        $element->setExtra('fizz', new \SplQueue());
    }

    private function getMockElement(bool $valid = true): Element
    {
        return new class ($valid) extends Element {
            private $text;
            private $valid;

            public function __construct(bool $valid)
            {
                $this->text = 'foo';
                $this->valid = $valid;
            }

            public function getType(): string
            {
                return 'mock';
            }

            public function validate(): void
            {
                if (!$this->valid) {
                    throw new Exception('Mock element was invalid');
                }
            }

            public function toArray(): array
            {
                return parent::toArray() + ['text' => $this->text];
            }
        };
    }
}
