<?php

namespace Jeremeamia\Slack\BlockKit\Tests;

use Jeremeamia\Slack\BlockKit\Blocks\Section;
use Jeremeamia\Slack\BlockKit\{Element, Exception, Type};
use Jeremeamia\Slack\BlockKit\Surfaces\Modal;

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

    public function testCanTapIntoElementForChaining()
    {
        $element = $this->getMockElement()->tap(function (Element $e) {
            $e->setExtra('fizz', 'buzz');
        });

        $this->assertInstanceOf(Element::class, $element);
        $this->assertJsonData($element, [
            'type' => 'mock',
            'text' => 'foo',
            'fizz' => 'buzz',
        ]);
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

    public function testHydration()
    {
        $beforeJson = <<<JSON
        {
            "type": "modal",
            "title": {
                "type": "plain_text",
                "text": "Foo Bar"
            },
            "submit": {
                "type": "plain_text",
                "text": "Submit"
            },
            "close": {
                "type": "plain_text",
                "text": "Cancel"
            },
            "foo": "bar",
            "blocks": [
                {
                    "type": "header",
                    "block_id": "id1",
                    "text": {
                        "type": "plain_text",
                        "text": "Foo Bar"
                    }
                },
                {
                    "type": "input",
                    "block_id": "id2",
                    "label": {
                        "type": "plain_text",
                        "text": "Type Something"
                    },
                    "element": {
                        "type": "plain_text_input",
                        "action_id": "a1",
                        "placeholder": {
                            "type": "plain_text",
                            "text": "anything"
                        }
                    }
                }
            ]
        }
        JSON;

        $modal = Modal::fromJson($beforeJson);
        $afterJson = $modal->toJson();
        $this->assertJsonStringEqualsJsonString($beforeJson, $afterJson);
    }
}
