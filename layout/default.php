<?php
defined('MOODLE_INTERNAL') || die();

echo $OUTPUT->doctype();
?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <?php echo $OUTPUT->standard_head_html(); ?>
    <link rel="stylesheet" href="<?php echo $CFG->wwwroot; ?>/theme/moodle_dsfr/lib/dsfr-assets/dsfr.min.css">
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
    'sitetitle' => format_string($SITE->shortname),
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
        <div class="fr-footer__body">
            <div class="fr-footer__brand fr-enlarge-link">
                <p class="fr-logo">République<br>Française</p>
            </div>
        </div>
        <div class="fr-footer__bottom">
            <p>© 2025 - Moodle DSFR</p>
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
