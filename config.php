<?php
defined('MOODLE_INTERNAL') || die();

$THEME->name = 'moodle_dsfr';
$THEME->parents = ['boost'];
$THEME->sheets = ['dsfr-overrides'];
$THEME->layouts = [
    'default' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
];
