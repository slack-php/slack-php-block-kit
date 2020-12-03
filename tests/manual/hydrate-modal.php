<?php

declare(strict_types=1);

use Jeremeamia\Slack\BlockKit\Slack;
use Jeremeamia\Slack\BlockKit\Surfaces\Modal;

require __DIR__ . '/../../vendor/autoload.php';

$modal = Modal::new()
    ->title('Foo Bar')
    ->submit('Submit')
    ->close('Cancel')
    ->callbackId('callback-id')
    ->externalId('external-id')
    ->notifyOnClose(true)
    ->clearOnClose(true)
    ->privateMetadata('foo=bar')
    ->tap(function (Modal $m) {
        $m->newHeader('id1')->text('Header');
        $m->newInput('id2')->label('Stuff')->newTextInput('a1')->placeholder('type something');
    });

$json = json_encode($modal);
$hydratedModal = Modal::fromJson($json);
assert($json === json_encode($hydratedModal));
echo Slack::newRenderer()->forJson()->render($hydratedModal) . "\n";
echo Slack::newRenderer()->forKitBuilder()->render($hydratedModal) . "\n";
