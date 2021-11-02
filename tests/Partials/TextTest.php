<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Partials;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Partials\Text;
use SlackPhp\BlockKit\Tests\TestCase;

/**
 * @covers \SlackPhp\BlockKit\Partials\Text
 */
class TextTest extends TestCase
{
    private const MAX_LENGTH = 5;
    private const MIN_LENGTH = 2;

    public function testCanValidateEnglishText()
    {
        $text = new class () extends Text {
        };

        $text->validateString('abc', self::MAX_LENGTH);

        $this->expectException(Exception::class);

        $this->expectExceptionMessage('Text element must have a "text" value with a length of at most 5');
        $text->validateString('abcdefg', self::MAX_LENGTH);

        $this->expectExceptionMessage('Text element must have a "text" value with a length of at least 2');
        $text->validateString('a', self::MAX_LENGTH, self::MIN_LENGTH);
    }

    public function testCanValidateJapaneseText()
    {
        $text = new class () extends Text {
        };

        $text->validateString('いろは', self::MAX_LENGTH);

        $this->expectException(Exception::class);

        $this->expectExceptionMessage('Text element must have a "text" value with a length of at most 5');
        $text->validateString('いろはにほへと', self::MAX_LENGTH);

        $this->expectExceptionMessage('Text element must have a "text" value with a length of at least 2');
        $text->validateString('い', self::MAX_LENGTH, self::MIN_LENGTH);
    }
}
