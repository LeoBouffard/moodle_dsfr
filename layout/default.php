<?php
defined('MOODLE_INTERNAL') || die();

echo $OUTPUT->doctype();
?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <?php echo $OUTPUT->standard_head_html(); ?>

    <!-- Importation du design system DSFR -->
    <link rel="stylesheet" href="<?php echo $CFG->wwwroot; ?>/theme/moodle_dsfr/lib/dsfr-assets/dsfr.min.css">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>
<?php echo $OUTPUT->standard_top_of_body_html(); ?>

<!-- Header DSFR -->
<header class="fr-header">
    <div class="fr-header__body">
        <div class="fr-container fr-header__body-row ml-5">
            <div class="fr-header__brand fr-enlarge-link">
                <a href="<?php echo $CFG->wwwroot; ?>" class="fr-header__brand-link">
                    <p class="fr-logo">
                        République<br>Française
                    </p>
                    <span class="fr-header__service">
                        <span class="fr-header__service-title">Plateforme Moodle DSFR</span>
                        <span class="fr-header__service-tagline">Formation et innovation numérique</span>
                    </span>
                </a>
            </div>

            <!-- Menu utilisateur -->
            <div class="fr-header__tools">
                <div class="fr-header__tools-links">
                    <?php echo $OUTPUT->user_menu(); ?>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Barre de navigation Moodle -->
<nav class="navbar navbar-light bg-light ml-5" aria-label="Fil d’Ariane Moodle">
    <div class="container-fluid">
        <?php echo $OUTPUT->navbar(); ?>
        <div class="ms-auto"><?php echo $OUTPUT->search_box(); ?></div>
    </div>
</nav>

<!-- Contenu principal -->
<div id="page" class="container-fluid my-4">
    <div id="page-content" class="row">
        <!-- Drawer latéral Boost -->
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

<!-- Footer DSFR -->
<footer class="fr-footer" role="contentinfo" id="footer">
    <div class="fr-container">
        <div class="fr-footer__body">
            <div class="fr-footer__brand fr-enlarge-link">
                <p class="fr-logo">République<br>Française</p>
            </div>
            <div class="fr-footer__content">
                <ul class="fr-footer__content-list">
                    <li class="fr-footer__content-item"><a href="#">Accessibilité : partiellement conforme</a></li>
                    <li class="fr-footer__content-item"><a href="#">Mentions légales</a></li>
                    <li class="fr-footer__content-item"><a href="#">Données personnelles</a></li>
                </ul>
            </div>
        </div>
        <div class="fr-footer__bottom">
            <p>© 2025 - Moodle DSFR - Thème basé sur Boost et le Design Système de l’État</p>
        </div>
    </div>
</footer>

<!-- Scripts standards -->
<?php echo $OUTPUT->standard_end_of_body_html(); ?>

<!-- Import JS DSFR -->
<script type="module" src="<?php echo $CFG->wwwroot; ?>/theme/moodle_dsfr/lib/dsfr-assets/dsfr.module.min.js"></script>
<script nomodule src="<?php echo $CFG->wwwroot; ?>/theme/moodle_dsfr/lib/dsfr-assets/dsfr.nomodule.min.js"></script>

</body>
</html>
