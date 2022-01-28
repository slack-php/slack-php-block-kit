<?php

namespace SlackPhp\BlockKit\Tests;

use JsonException;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;

abstract class TestCase extends PhpUnitTestCase
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
        try {
            $json = json_encode($data, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            $this->fail('JSON encoding error in test.');
        }

        return (string) $json;
    }
}
