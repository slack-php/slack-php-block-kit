<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Tests\Partials;

use SlackPhp\BlockKit\Exception;
use SlackPhp\BlockKit\Partials\Filter;
use SlackPhp\BlockKit\Tests\TestCase;

/**
 * @covers \SlackPhp\BlockKit\Partials\Filter
 */
class FilterTest extends TestCase
{
    public function testCanCreateConversationFilter(): void
    {
        $filter = Filter::new()
            ->includeIm()
            ->includeMpim()
            ->includePublic()
            ->includePrivate()
            ->excludeBotUsers(true)
            ->excludeExternalSharedChannels(true);

        $this->assertJsonData([
            'include' => ['im', 'mpim', 'public', 'private'],
            'exclude_bot_users' => true,
            'exclude_external_shared_channels' => true,
        ], $filter);
    }

    public function testCannotCreateConversationFilterWithNoProperties(): void
    {
        $filter = Filter::new();
        $this->expectException(Exception::class);
        $filter->validate();
    }

    public function testCanHydrateConversationFilter(): void
    {
        $json = <<<JSON
        {
            "include": ["private"],
            "exclude_bot_users": true,
            "exclude_external_shared_channels": true
        }
        JSON;

        $filter = Filter::fromJson($json);

        $this->assertJsonData([
            'include' => ['private'],
            'exclude_bot_users' => true,
            'exclude_external_shared_channels' => true
        ], $filter);
    }
}
