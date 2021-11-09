<?php

namespace SlackPhp\BlockKit\Tests;

use SlackPhp\BlockKit\Formatter;

/**
 * @covers \SlackPhp\BlockKit\Formatter
 */
class FormatterTest extends TestCase
{
    public function testCanDoSimpleTextFormatting(): void
    {
        $f = Formatter::new();
        $this->assertEquals('*hello*', $f->bold('hello'));
        $this->assertEquals('_hello_', $f->italic('hello'));
        $this->assertEquals('~hello~', $f->strike('hello'));
        $this->assertEquals('`hello`', $f->code('hello'));
    }

    public function testCanDoEntityReferenceFormatting(): void
    {
        $f = Formatter::new();
        $this->assertEquals('<!channel>', $f->atChannel());
        $this->assertEquals('<!everyone>', $f->atEveryone());
        $this->assertEquals('<!here>', $f->atHere());
        $this->assertEquals('<#C01>', $f->channel('C01'));
        $this->assertEquals('<@U01>', $f->user('U01'));
        $this->assertEquals('<!subteam^G01>', $f->userGroup('G01'));
    }

    public function testCanInterpolateAndEscapeText(): void
    {
        $f = Formatter::new();
        $text = $f->escape($f->sub('There is {name} & John.', ['name' => 'Jim']));
        $this->assertEquals('There is Jim &amp; John.', $text);
    }
}
