<?php
defined('MOODLE_INTERNAL') || die();

$THEME->name = 'moodle_dsfr';
$THEME->parents = ['boost'];
$THEME->enable_dock = false;
$THEME->yuicssmodules = array();
$THEME->rendererfactory = 'theme_overridden_renderer_factory'; // instruction pour override le thème parent
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;

$CFG->cachejs = false;

// Appliquer le layout DSFR partout
$THEME->layouts = [
    'base' => [
        'file' => 'default.php',
        'regions' => [],
        'options' => [],
    ],
    'standard' => [
        'file' => 'default.php',
        'regions' => [],
        'defaultregion' => '',
    ],
    'course' => [
        'file' => 'default.php',
        'regions' => [],
        'defaultregion' => '',
    ],
    'coursecategory' => [
        'file' => 'default.php',
        'regions' => [],
        'defaultregion' => '',
    ],
    'incourse' => [
        'file' => 'default.php',
        'regions' => [],
        'defaultregion' => '',
    ],
    'frontpage' => [
        'file' => 'default.php',
        'regions' => [],
        'defaultregion' => '',
    ],
    'admin' => [
        'file' => 'default.php',
        'regions' => [],
        'defaultregion' => '',
    ],
    'mydashboard' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'mypublic' => [
        'file' => 'default.php',
        'regions' => [],
        'defaultregion' => '',
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
        'regions' => [],
        'defaultregion' => '',
    ],

];
