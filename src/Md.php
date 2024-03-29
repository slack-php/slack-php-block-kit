<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit;

use function array_filter;
use function array_map;
use function date;
use function explode;
use function implode;
use function is_array;
use function is_callable;
use function is_null;
use function is_string;
use function strtr;
use function time;

/**
 * Md consists of text formatting helpers to support the use of Slack's Mrkdwn format in messages, modals, etc.
 *
 * Some characters ("<", ">", "&") should be escaped when they are not a part of formatting that requires those
 * characters. The formatting helpers in this class automatically escape input in situations where the text is place
 * within angle brackets, such as with dates and links.
 */
final class Md
{
    private static ?self $instance = null;

    public const DATE = '{date}';
    public const DATE_LONG = '{date_long}';
    public const DATE_LONG_PRETTY = '{date_long_pretty}';
    public const DATE_NUM = '{date_num}';
    public const DATE_PRETTY = '{date_pretty}';
    public const DATE_SHORT = '{date_short}';
    public const DATE_SHORT_PRETTY = '{date_short_pretty}';
    public const TIME = '{time}';
    public const TIME_SECS = '{time_secs}';

    public static function new(): self
    {
        return (self::$instance ??= new self());
    }

    /**
     * Escapes ambiguous characters to their HTML entities.
     *
     * @param string $text
     * @return string
     */
    public function escape(string $text): string
    {
        return strtr($text, [
            '&' => '&amp;',
            '<' => '&lt;',
            '>' => '&gt;',
        ]);
    }

    /**
     * Performs a string interpolation by substituting keys (in curly braces) for their values.
     *
     * @param string $text
     * @param array<string, mixed> $values
     * @return string
     */
    public function sub(string $text, array $values): string
    {
        $replacements = [];
        foreach ($values as $key => $value) {
            $replacements["{{$key}}"] = $value;
        }

        return strtr($text, $replacements);
    }

    #region Helpers for @here, @channel, and @everyone mentions.
    public function atChannel(): string
    {
        return '<!channel>';
    }

    public function atEveryone(): string
    {
        return '<!everyone>';
    }

    public function atHere(): string
    {
        return '<!here>';
    }
    #endregion

    #region Helpers for mentioning/linking specific channels, users, or user groups.
    public function channel(string $id): string
    {
        return "<#{$id}>";
    }

    public function user(string $id): string
    {
        return "<@{$id}>";
    }

    public function userGroup(string $id): string
    {
        return "<!subteam^{$id}>";
    }
    #endregion

    #region Helpers for basic text formatting (B/I/S) and links.
    public function bold(string $text): string
    {
        return "*{$text}*";
    }

    public function code(string $text): string
    {
        return "`{$this->escape($text)}`";
    }

    public function italic(string $text): string
    {
        return "_{$text}_";
    }

    public function strike(string $text): string
    {
        return "~{$text}~";
    }

    public function link(string $url, ?string $text = null): string
    {
        return isset($text) ? "<{$url}|{$this->escape($text)}>" : "<{$url}>";
    }

    public function emailLink(string $email, ?string $text = null): string
    {
        return $this->link("mailto:{$email}", $text);
    }
    #endregion

    #region Helpers for multi-line content blocks like lists and quotes.
    /**
     * @param array<string>|string $lines
     */
    public function blockQuote(array|string $lines): string
    {
        return $this->lines($this->explode($lines), '> ', false);
    }

    public function codeBlock(string $text): string
    {
        return "```\n{$this->escape($text)}\n```";
    }

    /**
     * @param array<string>|string $items
     */
    public function bulletedList(array|string $items, string $bullet = '•'): string
    {
        return $this->lines($this->explode($items), "{$bullet} ");
    }

    /**
     * @param array<string>|string $items
     */
    public function numberedList(array|string $items): string
    {
        $index = 0;
        return $this->lines($this->explode($items), function (string $item) use (&$index) {
            $index++;
            return "{$index}. {$item}";
        });
    }

    /**
     * Takes a list of lines/strings, and concatenates them with newlines, filtering out any empty lines.
     *
     * Optionally applies a prefix to each line. You can use a closure if the prefix varies per line.
     *
     * @param array<string> $lines
     */
    public function lines(array $lines, string|callable|null $prefix = null, bool $filter = true): string
    {
        if (is_string($prefix)) {
            $prefix = function (string $value) use ($prefix) {
                return "{$prefix}{$value}";
            };
        }

        if (!is_null($prefix)) {
            $lines = array_map($prefix, $lines);
        }

        if ($filter) {
            $lines = array_filter($lines, static function ($line) {
                return $line !== null && $line !== '';
            });
        }

        return implode("\n", $lines) . "\n";
    }
    #endregion

    #region Helpers for formatting dates and times.
    /**
     * Formats a timestamp as a date in mrkdwn.
     *
     * @param int|null $timestamp Timestamp to format. Defaults to now.
     * @param string $format Format name supported by Slack. Defaults to "{date}".
     * @param string|null $fallback Fallback text for old Slack clients. Defaults to an ISO-formatted timestamp.
     * @param string|null $link URL, if the date is to act as a link.
     * @see https://api.slack.com/reference/surfaces/formatting#date-formatting
     */
    public function date(
        ?int $timestamp = null,
        string $format = self::DATE,
        ?string $fallback = null,
        ?string $link = null
    ): string {
        $timestamp = $timestamp ?? time();
        $fallback = $this->escape($fallback ?? date('c', $timestamp));
        $link = $link ? "^{$this->escape($link)}" : '';

        return "<!date^{$timestamp}^{$this->escape($format)}{$link}|{$fallback}>";
    }

    /**
     * Formats a timestamp as a time in mrkdwn.
     *
     * Equivalent to Formatter::date(), but uses the TIME format as default.
     *
     * @param int|null $timestamp Timestamp to format. Defaults to now.
     * @param string $format Format name supported by Slack. Defaults to "{time}".
     * @param string|null $fallback Fallback text for old Slack clients. Defaults to an ISO-formatted timestamp.
     * @param string|null $link URL, if the time is to act as a link.
     */
    public function time(
        ?int $timestamp = null,
        string $format = self::TIME,
        ?string $fallback = null,
        ?string $link = null
    ): string {
        return $this->date($timestamp, $format, $fallback, $link);
    }
    #endregion

    /**
     * Ensures the provided items are an array.
     *
     * Explodes strings on "\n" if a string is provided.
     *
     * @param array<string>|string $items
     * @return array<string>
     */
    private function explode(array|string $items): array
    {
        if (is_array($items)) {
            return $items;
        }

        return explode("\n", $items);
    }
}
