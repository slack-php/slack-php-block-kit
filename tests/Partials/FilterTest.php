<?php

declare(strict_types=1);

namespace Jeremeamia\Slack\BlockKit\Tests\Partials;

use Jeremeamia\Slack\BlockKit\Exception;
use Jeremeamia\Slack\BlockKit\Partials\Filter;
use Jeremeamia\Slack\BlockKit\Tests\TestCase;

/**
 * @covers \Jeremeamia\Slack\BlockKit\Partials\Filter
 */
class FilterTest extends TestCase
{
    public function testCanCreateConversationFilter()
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

    public function testCannotCreateConversationFilterWithNoProperties()
    {
        $filter = Filter::new();
        $this->expectException(Exception::class);
        $filter->validate();
    }

    public function testCanHydrateConversationFilter()
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
