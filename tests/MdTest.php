<?php

namespace SlackPhp\BlockKit\Tests;

use SlackPhp\BlockKit\Md;

/**
 * @covers \SlackPhp\BlockKit\Md
 */
class MdTest extends TestCase
{
    public function testCanDoSimpleTextFormatting(): void
    {
        $f = Md::new();
        $this->assertEquals('*hello*', $f->bold('hello'));
        $this->assertEquals('_hello_', $f->italic('hello'));
        $this->assertEquals('~hello~', $f->strike('hello'));
        $this->assertEquals('`hello`', $f->code('hello'));
    }

    public function testCanDoEntityReferenceFormatting(): void
    {
        $f = Md::new();
        $this->assertEquals('<!channel>', $f->atChannel());
        $this->assertEquals('<!everyone>', $f->atEveryone());
        $this->assertEquals('<!here>', $f->atHere());
        $this->assertEquals('<#C01>', $f->channel('C01'));
        $this->assertEquals('<@U01>', $f->user('U01'));
        $this->assertEquals('<!subteam^G01>', $f->userGroup('G01'));
    }

    public function testCanInterpolateAndEscapeText(): void
    {
        $f = Md::new();
        $text = $f->escape($f->sub('There is {name} & John.', ['name' => 'Jim']));
        $this->assertEquals('There is Jim &amp; John.', $text);
    }

    public function testCanFormatLinks(): void
    {
        $f = Md::new();
        $this->assertEquals(
            '<https://slack.com|slack website>',
            $f->link('https://slack.com', 'slack website'),
        );
        $this->assertEquals(
            '<https://slack.com|&lt;slack&amp;website&gt;>',
            $f->link('https://slack.com', '<slack&website>'),
        );
        $this->assertEquals(
            '<mailto:noreply@slack.com|email slack>',
            $f->emailLink('noreply@slack.com', 'email slack'),
        );
    }

    public function testCanDoComplexFormatting(): void
    {
        $f = Md::new();
        $this->assertEquals(
            "> hello\n> world\n",
            $f->blockQuote("hello\nworld"),
        );
        $this->assertEquals(
            "```\necho \"hello\";\n```",
            $f->codeBlock('echo "hello";'),
        );
        $this->assertEquals(
            "• a\n• b\n• c\n",
            $f->bulletedList(['a', 'b', 'c']),
        );
        $this->assertEquals(
            "1. a\n2. b\n3. c\n",
            $f->numberedList(['a', 'b', 'c']),
        );

        $time = time();
        $this->assertEquals(
            "<!date^{$time}^{time}^http:/slack.com|foo>",
            $f->time($time, fallback: 'foo', link: 'http:/slack.com'),
        );
    }
}
