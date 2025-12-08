<?php
defined('MOODLE_INTERNAL') || die();

echo $OUTPUT->doctype();
?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>

<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <?php echo $OUTPUT->standard_head_html(); ?>
    <link rel="stylesheet" href="<?php echo $CFG->wwwroot; ?>/theme/moodle_dsfr/lib/dsfr-assets/dsfr.min.css">
    <link rel="stylesheet" href="<?php echo $CFG->wwwroot; ?>/theme/moodle_dsfr/style/dsfr-overrides.css">

</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>
    <?php echo $OUTPUT->standard_top_of_body_html(); ?>

    <?php
    global $PAGE, $SITE;
    $renderer = $PAGE->get_renderer('core');

    // Primary menu
    $primary = new core\navigation\output\primary($PAGE);
    $primarymenu = $primary->export_for_template($renderer);

    // User et langue menu
    $usermenu = $OUTPUT->user_menu();
    $langmenu = $OUTPUT->lang_menu();

    // Contexte header
    $headercontext = [
        'wwwroot' => $CFG->wwwroot,
        'sitetitle' => format_string($SITE->fullname),
        'siteline' => "Formation et innovation numérique",
        'usermenu' => $usermenu,
        'langmenu' => $langmenu,
        'primarymenu' => $primarymenu,
    ];

    // Affichage header
    echo $OUTPUT->render_from_template('theme_moodle_dsfr/header', $headercontext);
    ?>

    <!-- Contenu et fil d’Ariane -->
    <nav class="navbar navbar-light bg-light pl-2" aria-label="Fil d’Ariane Moodle">
        <div class="container-fluid">
            <?php echo $OUTPUT->navbar(); ?>
            <div class="ms-auto"><?php echo $OUTPUT->search_box(); ?></div>
        </div>
    </nav>

    <div id="page" class="container-fluid my-4">
        <div id="page-content" class="row">
            <?php if (!empty($OUTPUT->blocks('side-pre'))): ?>
                <aside id="region-side-pre" class="col-md-3">
                    <?php echo $OUTPUT->blocks('side-pre'); ?>
                </aside>
            <?php endif; ?>

            <main id="region-main" class="col">
                <?php echo $OUTPUT->main_content(); ?>
            </main>
        </div>
    </div>

<footer class="fr-footer" role="contentinfo" id="footer">
    <div class="fr-container">

        <!-- SECTION PRINCIPALE -->
        <div class="fr-footer__body fr-footer__body--operator">

            <!-- LOGO MINARM -->
            <div class="fr-footer__brand fr-enlarge-link">
                <a class="fr-footer__brand-link" href="/" title="Retour à l’accueil">
                    <p class="fr-logo">
                        Ministère<br>
                        des Armées<br>
                        et des Anciens<br>
                        combattants
                    </p>
                </a>
            </div>
        </div>

        <!-- BAS DU FOOTER -->
        <div class="fr-footer__bottom">

            <div class="fr-footer__bottom-copy">
                <p>© 2025 - Moodle DSFR</p>
            </div>

        </div>

    </div>
</footer>


    <?php
    echo $OUTPUT->standard_end_of_body_html();
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.dsfr && dsfr.core && typeof dsfr.core.start === 'function') {
                dsfr.core.start({
                    exclude: '.usermenu' // Exclut le menu utilisateur Moodle
                });
            }
        });

        // Force l'affichage des menus déroulants au clique
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggles = document.querySelectorAll('[data-bs-toggle="dropdown"]');

            dropdownToggles.forEach(toggle => {
                // Trouve la div parent
                const parent = toggle.closest('div');
                if (!parent) return;

                // Trouve le menu dropdown dans le parent
                const baseMenu = parent.querySelector('.dropdown-menu');
                if (!baseMenu) return;

                // Clone du menu
                const manualMenu = baseMenu.cloneNode(true);
                manualMenu.style.display = 'none'; // caché par défaut
                manualMenu.classList.add('dropdown-menu');

                // Supprime l'ancien menu
                baseMenu.remove();

                // Ajoute le clone dans le parent
                parent.appendChild(manualMenu);

                // Gestion du clic bouton
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const isVisible = manualMenu.style.display === 'block';
                    manualMenu.style.display = isVisible ? 'none' : 'block';
                });

                // Fermeture en cliquant ailleurs
                document.addEventListener('click', function(e) {
                    if (!toggle.contains(e.target) && !manualMenu.contains(e.target)) {
                        manualMenu.style.display = 'none';
                    }
                });
            });
        });
    </script>


</body>

</html>