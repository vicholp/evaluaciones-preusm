<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/app/')
    ->in(__DIR__ . '/config/')
    ->in(__DIR__ . '/database/')
    ->in(__DIR__ . '/resources/')
    ->in(__DIR__ . '/routes/')
    ->in(__DIR__ . '/tests/');

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@Symfony' => true,
    'no_empty_comment' => false,
    'yoda_style' => false,
])->setFinder($finder);
