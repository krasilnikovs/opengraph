<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PHP84Migration' => true,
        'declare_strict_types' => true,
        'global_namespace_import' => true,
        'no_leading_import_slash' => true,
        'no_unneeded_import_alias' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'single_import_per_statement' => true,
        'single_line_after_imports' => true,
        'single_blank_line_at_eof' => true,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
;
