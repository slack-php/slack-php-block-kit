<?php

namespace Jeremeamia\Slack\BlockKit\Tests;

use PHPUnit\Framework\TestCase as PhpUnitTestCase;

class TestCase extends PhpUnitTestCase
{
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
        if (!$json) {
            $this->fail('JSON encoding error in test.');
        }

        return (string) $json;
    }
}
