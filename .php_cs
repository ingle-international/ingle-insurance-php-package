<?php

$fixers = [
    // PSR-0
    '-psr0',

    // PSR-1
    'encoding',
    'short_tag',

    // Symfony
    'blankline_after_open_tag',
    'duplicate_semicolon',
    'empty_return',
    'extra_empty_lines',
    'include',
    'list_commas',
    'namespace_no_leading_whitespace',
    'new_with_braces',
    'no_blank_lines_after_class_opening',
    'no_empty_lines_after_phpdocs',
    'phpdoc_indent',
    'phpdoc_no_access',
    'phpdoc_no_package',
    'phpdoc_scalar',
    'phpdoc_short_description',
    'phpdoc_to_comment',
    'phpdoc_trim',
    'phpdoc_type_to_var',
    'phpdoc_var_without_name',
    'print_to_echo',
    'remove_leading_slash_use',
    'remove_lines_between_uses',
    'self_accessor',
    'single_blank_line_before_namespace',
    'single_quote',
    'spaces_before_semicolon',
    'standardize_not_equal',
    'ternary_spaces',
    'trim_array_spaces',
    'unary_operators_spaces',
    'unneeded_control_parentheses',
    'unused_use',
    'whitespacy_lines',

    // Contrib
    'multiline_spaces_before_semicolon',
    'newline_after_open_tag',
    'ordered_use',
    'php_unit_construct',
    'php_unit_strict',
    'phpdoc_order',
    'short_array_syntax',
    'short_echo_tag',
];

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__)
;

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers($fixers)
    ->finder($finder)
    ->setUsingCache(true)
;