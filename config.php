<?php
defined('MOODLE_INTERNAL') || die();

$THEME->name = 'moodle_dsfr';
$THEME->parents = ['boost'];
$THEME->rendererfactory = 'theme_overridden_renderer_factory'; // instruction pour override le thème parent

// Appliquer le layout DSFR partout
$THEME->layouts = [
    'base' => [
        'file' => 'default.php',
        'regions' => [],
        'options' => [],
    ],
    'standard' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'course' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'coursecategory' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'incourse' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'frontpage' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'admin' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'mydashboard' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'mypublic' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'login' => [
        'file' => 'login.php',
        'regions' => [],
        'options' => ['nofooter' => true, 'noheader' => true],
    ],
    'mycourses' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'report' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],

];
