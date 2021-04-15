<?php

declare(strict_types=1);

use SlackPhp\BlockKit\Surfaces\Modal;

require __DIR__ . '/bootstrap.php';

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

$json = $modal->toJson();
$hydratedModal = Modal::fromJson($json);
assert($json === $hydratedModal->toJson());
view($hydratedModal);
