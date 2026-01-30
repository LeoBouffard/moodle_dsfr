<?php
// This file is part of Moodle - http://moodle.org/
defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // 1. Création de la page de réglages
    // CORRECTION MAJEURE : On change l'identifiant 'theme_moodle_dsfr' en 'themesettingmoodle_dsfr'
    // pour éviter le conflit avec le nom du composant.
    $settings = new admin_settingpage('themesettingmoodle_dsfr', get_string('pluginname', 'theme_moodle_dsfr'));

    // --- CHAMP 1 : MENTIONS LÉGALES (FILE) ---
    $name = 'theme_moodle_dsfr/legal_pdf';
    $title = get_string('legalfile', 'theme_moodle_dsfr');
    $description = get_string('legalfile_desc', 'theme_moodle_dsfr');
    
    $setting = new admin_setting_configstoredfile(
        $name, 
        $title, 
        $description, 
        'legal_pdf', 
        0, 
        ['subdirs' => 0, 'maxfiles' => 1, 'accepted_types' => ['.pdf']]
    );
    // On ajoute le callback comme dans Boost pour vider le cache après modif
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);


    // --- CHAMP 2 : DOCUMENTATION PES (FILE) ---
    $name = 'theme_moodle_dsfr/doc_pdf';
    $title = get_string('docfile', 'theme_moodle_dsfr');
    $description = get_string('docfile_desc', 'theme_moodle_dsfr');
    
    $setting = new admin_setting_configstoredfile(
        $name, 
        $title, 
        $description, 
        'doc_pdf', 
        0, 
        ['subdirs' => 0, 'maxfiles' => 1, 'accepted_types' => ['.pdf']]
    );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // 2. Ajout final à l'arbre 'themes'
    $ADMIN->add('themes', $settings);
}