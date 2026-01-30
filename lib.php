<?php
defined('MOODLE_INTERNAL') || die;

/**
 * Fonction de service de fichier pour le thème DSFR.
 */
function theme_moodle_dsfr_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    
    // 1. Vérification de sécurité : Contexte Système uniquement
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        return false;
    }

    // 2. Vérification de sécurité : Bonnes zones de fichiers
    if ($filearea !== 'legal_pdf' && $filearea !== 'doc_pdf') {
        return false;
    }

    // 3. Récupération du stockage de fichiers
    $fs = get_file_storage();
    
    // 4. On récupère tous les fichiers de la zone (il n'y en a qu'un)
    // Cela évite les erreurs de chemin "/" ou de nom encodé.
    $files = $fs->get_area_files(
        $context->id, 
        'theme_moodle_dsfr', 
        $filearea, 
        0, // Item ID est toujours 0 pour les settings
        'sortorder DESC, id DESC', 
        false // False = on exclut les dossiers, on veut juste les fichiers
    );

    // Si la zone est vide, erreur
    if (empty($files)) {
        return false;
    }

    // On prend le premier fichier trouvé
    $file = reset($files);

    // 5. Envoi du fichier au navigateur
    send_stored_file($file, 0, 0, $forcedownload, $options);
}