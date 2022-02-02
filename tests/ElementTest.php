<?php

namespace SlackPhp\BlockKit\Tests;

use SlackPhp\BlockKit\Blocks\Section;
use SlackPhp\BlockKit\{
    Element,
    Exception,
    HydrationException,
    Type,
};
use SlackPhp\BlockKit\Surfaces\Modal;

/**
 * @covers \SlackPhp\BlockKit\Element
 */
class ElementTest extends TestCase
{
    public function testCanSerializeValidElementToJson(): void
    {
        $element = $this->getMockElement();

        $this->assertJsonData($element, [
            'type' => 'mock',
            'text' => 'foo',
        ]);
    }

    public function testThrowsErrorElementIsInvalid(): void
    {
        $this->expectException(Exception::class);
        $element = $this->getMockElement(false);
        $this->jsonEncode($element);
    }

    public function testCanSetParentWithFluidInterfaceAndGetParentBack(): void
    {
        $parent = $this->getMockElement();
        $element = $this->getMockElement();
        $elementMutated = $element->setParent($parent);
        $this->assertSame($element, $elementMutated);
        $this->assertSame($parent, $element->getParent());
    }

    public function testCanUseNewAsFactoryForChildClasses(): void
    {
        $element = Section::new();
        $this->assertEquals(Type::SECTION, $element->getType());
        $this->assertInstanceOf(Section::class, $element);
    }

    public function testCanSetExtraFieldsForArbitraryData(): void
    {
        $element = $this->getMockElement();

        $element->setExtra('fizz', 'buzz');

        $this->assertJsonData($element, [
            'type' => 'mock',
            'text' => 'foo',
            'fizz' => 'buzz',
        ]);
    }

    public function testCanTapIntoElementForChaining(): void
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

    public function testCanConditionallyTapIntoElementForChaining(): void
    {
        $callable = function (Element $e) {
            $e->setExtra('fizz', 'buzz');
        };
        $tappedElement = $this->getMockElement()->tapIf(true, $callable);
        $untappedElement = $this->getMockElement()->tapIf(false, $callable);

        $this->assertInstanceOf(Element::class, $tappedElement);
        $this->assertInstanceOf(Element::class, $untappedElement);
        $this->assertJsonData($tappedElement, [
            'type' => 'mock',
            'text' => 'foo',
            'fizz' => 'buzz',
        ]);
        $this->assertJsonData($untappedElement, [
            'type' => 'mock',
            'text' => 'foo',
        ]);
    }

    private function getMockElement(bool $valid = true): Element
    {
        return new class ($valid) extends Element {
            private string $text;
            private bool $valid;

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

    public function testHydration(): void
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

    public function testFromJsonThrowsExceptionOnBadJson(): void
    {
        $this->expectException(HydrationException::class);
        Modal::fromJson('{"foo":"Bar",}');
    }

    public function testCanExportToJsonWithPrettyPrint(): void
    {
        $element = $this->getMockElement();
        $json = $element->toJson(true);
        $this->assertStringContainsString("\n", $json);
    }
}
