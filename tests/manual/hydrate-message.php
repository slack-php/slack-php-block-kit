<?php

declare(strict_types=1);

use SlackPhp\BlockKit\Surfaces\Message;

require __DIR__ . '/bootstrap.php';

$json = <<<JSON
{
    "response_type": "in_channel",
    "blocks": [
        {
            "type": "section",
            "block_id": "block1",
            "text": {
                "type": "mrkdwn",
                "text": "*foo*"
            }
        },
        {
            "type": "section",
            "block_id": "block2",
            "text": {
                "type": "plain_text",
                "text": "foo"

            }
        },
        {
            "type": "divider"
        },
        {
            "type": "section",
            "block_id": "block3",
            "fields": [
                {
                    "type": "mrkdwn",
                    "text": "*foo*"
                },
                {
                    "type": "plain_text",
                    "text": "foo",
                    "emoji": true
                }
            ]
        },
        {
            "type": "context",
            "block_id": "block4",
            "elements": [
                {
                    "type": "image",
                    "image_url": "https://google.com/favicon.ico",
                    "alt_text": "foo"
                },
                {
                    "type": "mrkdwn",
                    "text": "*foo*"
                },
                {
                    "type": "plain_text",
                    "text": "foo",
                    "emoji": true
                }
            ]
        },
        {
            "type": "image",
            "block_id": "block5",
            "title": {
                "type": "plain_text",
                "text": "foo"
            },
            "image_url": "https://google.com/favicon.ico",
            "alt_text": "foo"
        },
        {
            "type": "actions",
            "elements": [
                {
                    "type": "button",
                    "text": {
                        "type": "plain_text",
                        "text": "Click Me :smile:",
                        "emoji": true
                    },
                    "value": "btn",
                    "action_id": "action1",
                    "style": "primary",
                    "confirm": {
                        "title": {
                            "type": "plain_text",
                            "text": "Confirm"
                        },
                        "text": {
                            "type": "mrkdwn",
                            "text": "Do you really want to confirm?"
                        },
                        "confirm": {
                            "type": "plain_text",
                            "text": "Yes"
                        },
                        "deny": {
                            "type": "plain_text",
                            "text": "Cancel"
                        }
                    }
                }
            ]
        }
    ]
}
JSON;

$data = json_decode($json, true);
$message = Message::fromArray($data);
assert(json_encode($data) === json_encode($message));
view($message);
