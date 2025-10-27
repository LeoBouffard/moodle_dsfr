<?php
defined('MOODLE_INTERNAL') || die();

function theme_moodle_dsfr_get_main_scss_content($theme) {
    global $CFG;

    // Récupère le SCSS du parent Boost.
    $scss = theme_boost_get_main_scss_content($theme);

    // Ajoute ton CSS personnalisé à la fin.
    $customcss = file_get_contents($CFG->dirroot . '/theme/moodle_dsfr/style/dsfr-overrides.css');

    return $scss . "\n" . $customcss;
}
