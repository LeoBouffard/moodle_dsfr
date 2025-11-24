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
    'sitetitle' => "EFORM",
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

            <!-- BLOCS DE LIENS (catégories horizontales) -->
            <div class="fr-footer__content-group">

                <!-- Bloc 1 -->
                <div class="fr-footer__content">
                    <h4 class="fr-footer__content-title">Liens utiles</h4>
                    <ul class="fr-footer__content-list">
                        <li class="fr-footer__content-item">
                            <a href="#" class="fr-footer__content-link">Accueil</a>
                        </li>
                        <li class="fr-footer__content-item">
                            <a href="#" class="fr-footer__content-link">À propos de nous</a>
                        </li>
                        <li class="fr-footer__content-item">
                            <a href="#" class="fr-footer__content-link">Nous contacter</a>
                        </li>
                        <li class="fr-footer__content-item">
                            <a href="#" class="fr-footer__content-link">FAQ</a>
                        </li>
                    </ul>
                </div>

                <!-- Bloc 2 -->
                <div class="fr-footer__content">
                    <h4 class="fr-footer__content-title">Services</h4>
                    <ul class="fr-footer__content-list">
                        <li class="fr-footer__content-item">
                            <a href="#" class="fr-footer__content-link">Support</a>
                        </li>
                        <li class="fr-footer__content-item">
                            <a href="#" class="fr-footer__content-link">Documentation</a>
                        </li>
                        <li class="fr-footer__content-item">
                            <a href="#" class="fr-footer__content-link">Mon compte</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <!-- BAS DU FOOTER -->
        <div class="fr-footer__bottom">

            <ul class="fr-footer__bottom-list">
                <li class="fr-footer__bottom-item">
                    <a href="#" class="fr-footer__bottom-link">Plan du site</a>
                </li>
                <li class="fr-footer__bottom-item">
                    <a href="#" class="fr-footer__bottom-link">Accessibilité</a>
                </li>
                <li class="fr-footer__bottom-item">
                    <a href="#" class="fr-footer__bottom-link">Mentions légales</a>
                </li>
                <li class="fr-footer__bottom-item">
                    <a href="#" class="fr-footer__bottom-link">Données personnelles</a>
                </li>
                <li class="fr-footer__bottom-item">
                    <a href="#" class="fr-footer__bottom-link">Gestion des cookies</a>
                </li>
            </ul>

            <div class="fr-footer__bottom-copy">
                <p>© 2025 - Moodle DSFR</p>
            </div>

        </div>

    </div>
</footer>


<?php echo $OUTPUT->standard_end_of_body_html(); ?>

<script type="module" src="<?php echo $CFG->wwwroot; ?>/theme/moodle_dsfr/lib/dsfr-assets/dsfr.module.min.js"></script>
<script nomodule src="<?php echo $CFG->wwwroot; ?>/theme/moodle_dsfr/lib/dsfr-assets/dsfr.nomodule.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.dsfr && dsfr.core && typeof dsfr.core.start === 'function') {
        dsfr.core.start({
            exclude: '.usermenu' // Exclut le menu utilisateur Moodle
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const userButton = document.querySelector('#action-menu-toggle-0'); // bouton du user menu
    const baseMenu = document.querySelector('#action-menu-0-menu'); // menu généré par Moodle

    if (!userButton || !baseMenu) return;

    // Clone le menu pour l'affichage manuel
    const manualMenu = baseMenu.cloneNode(true);
    manualMenu.id = 'manual-usermenu';
    manualMenu.style.display = 'none'; // caché par défaut
    manualMenu.classList.add('dropdown-menu'); // conserve le style DSFR/Bootstrap

    // Injecte après le bouton
    userButton.parentNode.appendChild(manualMenu);

    // Gestion du clic
    userButton.addEventListener('click', function(e) {
        e.preventDefault();
        const isVisible = manualMenu.style.display === 'block';
        manualMenu.style.display = isVisible ? 'none' : 'block';
    });

    // Ferme si on clique ailleurs
    document.addEventListener('click', function(e) {
        if (!userButton.contains(e.target) && !manualMenu.contains(e.target)) {
            manualMenu.style.display = 'none';
        }
    });
});

</script>


</body>
</html>
