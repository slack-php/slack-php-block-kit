<?php

$finder = PhpCsFixer\Finder::create()->in(['src', 'tests']);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'strict_param' => true, // Makes sure you add the 3rd arg to things like array_search, in_array.
        'single_import_per_statement' => false, // I prefer supporting this PHP feature.
        'ternary_operator_spaces' => false, // Currently interferes with string-backed Enum definitions.
    ])
    ->setFinder($finder)
;
