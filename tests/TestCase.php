<?php

namespace Jeremeamia\Slack\BlockKit\Tests;

use Jeremeamia\Slack\BlockKit\Blocks\BlockElement;
use Jeremeamia\Slack\BlockKit\Blocks\Virtual\VirtualBlock;
use Jeremeamia\Slack\BlockKit\Surfaces\Surface;
use Jeremeamia\Slack\BlockKit\Type;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;

class TestCase extends PhpUnitTestCase
{
    protected const TYPE_MOCK = 'mock';

    /**
     * @param object|array $expectedData
     * @param object|array $actualData
     */
    protected function assertJsonData($expectedData, $actualData)
    {
        $expected = $this->jsonEncode($expectedData);
        $actual = $this->jsonEncode($actualData);
        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }

    /**
     * @param object|array $data
     * @return string
     */
    protected function jsonEncode($data): string
    {
        $json = json_encode($data);
        if (!is_string($json)) {
            $this->fail('JSON encoding error in test.');
        }

        return (string) $json;
    }

    /**
     * @return Surface
     */
    protected function getMockSurface(): Surface
    {
        return new class () extends Surface {
            public function getType(): string
            {
                return Type::MESSAGE;
            }
        };
    }

    protected function getMockVirtualBlock(): VirtualBlock
    {
        return new class () extends VirtualBlock {
            public function add(BlockElement $block): self
            {
                return $this->appendBlock($block);
            }

            public function getType(): string
            {
                return Type::SECTION;
            }
        };
    }
}
