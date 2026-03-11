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
    <link rel="icon" type="image/png" href="<?php echo s($CFG->wwwroot . '/theme/moodle_dsfr/pix/favicon.ico'); ?>">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>
    <?php echo $OUTPUT->standard_top_of_body_html(); ?>
    <?php
    global $PAGE, $SITE;
    $renderer = $PAGE->get_renderer('core');

    // Primary menu
    $primary = new core\navigation\output\primary($PAGE);
    $primarymenu = $primary->export_for_template($renderer);

    $secondarynavigation = false;
    
    // 1. On vérifie si la page possède une navigation secondaire (Admin, Cours, etc.)
    if ($PAGE->has_secondary_navigation()) {
        
        // 2. On récupère les données brutes de navigation
        $nav_data = $PAGE->secondarynav;
        
        // 3. On injecte ces données dans le composant "More Menu" (Onglets)
        $moremenu = new \core\navigation\output\more_menu($nav_data, 'nav-tabs');
        
        // 4. On génère le rendu pour le template
        $secondarynavigation = $moremenu->export_for_template($OUTPUT);
    }

    // User et langue menu
    $usermenu = $OUTPUT->user_menu();
    $langmenu = $OUTPUT->lang_menu();
    $navbar = $OUTPUT->navbar();
    $searchbox = $OUTPUT->search_box();

    // Récupération du Switch d'édition et des Notifications/Messagerie
    $editswitch = $OUTPUT->edit_switch();
    $navbarplugins = $OUTPUT->navbar_plugin_output();

    // Contexte header
    $headercontext = [
        'wwwroot' => $CFG->wwwroot,
        'sitetitle' => format_string($SITE->fullname),
        'siteline' => "Formation et innovation numérique",
        'usermenu' => $usermenu,
        'langmenu' => $langmenu,
        'primarymenu' => $primarymenu,
        'secondarymenu' => $secondarynavigation,
        'editswitch' => $editswitch,
        'navbarplugins' => $navbarplugins,
        'searchbox' => $searchbox,
        'navbar' => $navbar
    ];

    // Affichage header
    echo $OUTPUT->render_from_template('theme_moodle_dsfr/header', $headercontext);
    ?>

    <!-- Contenu et fil d’Ariane -->
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
            <div class="fr-footer__body fr-footer__body--operator">
                <div class="fr-footer__brand fr-enlarge-link">
                    <a class="fr-footer__brand-link" href="/" title="Retour à l’accueil">
                        <p class="fr-logo">
                            Ministère<br>des Armées<br>et des Anciens<br>combattants
                        </p>
                    </a>
                </div>
            </div>
            
            <div class="fr-footer__bottom">
                <?php
                // --- FONCTION POUR RECUPERER L'URL DU FICHIER ---
                // (Idéalement cette fonction irait dans une classe renderer, mais ici c'est plus simple)
                $fs = get_file_storage();
                $context = context_system::instance();
                
                // 1. URL Mentions Légales
                $url_legal = null;
                // On cherche dans la zone 'legal_pdf' définie dans settings.php
                $files = $fs->get_area_files($context->id, 'theme_moodle_dsfr', 'legal_pdf', 0, 'itemid, filepath, filename', false);
                if ($files) {
                    $file = reset($files); // On prend le premier fichier trouvé
                    // On génère l'URL publique
                    $url_legal = moodle_url::make_pluginfile_url($context->id, 'theme_moodle_dsfr', 'legal_pdf', 0, '/', $file->get_filename());
                }

                // 2. URL Documentation
                $url_doc = null;
                // On cherche dans la zone 'doc_pdf'
                $files = $fs->get_area_files($context->id, 'theme_moodle_dsfr', 'doc_pdf', 0, 'itemid, filepath, filename', false);
                if ($files) {
                    $file = reset($files);
                    $url_doc = moodle_url::make_pluginfile_url($context->id, 'theme_moodle_dsfr', 'doc_pdf', 0, '/', $file->get_filename());
                }
                ?>

                <ul class="fr-footer__bottom-list">
                    
                    <?php if ($url_legal): ?>
                    <li class="fr-footer__bottom-item">
                        <a class="fr-footer__bottom-link" href="<?php echo $url_legal; ?>" target="_blank">
                            Mentions légales
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if ($url_doc): ?>
                    <li class="fr-footer__bottom-item">
                        <a class="fr-footer__bottom-link" href="<?php echo $url_doc; ?>" target="_blank">
                            Documentation (PES)
                        </a>
                    </li>
                    <?php endif; ?>

                    <li class="fr-footer__bottom-item">
                        <span class="fr-footer__bottom-link">© 2025 - Moodle DSFR</span>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <?php
    echo $OUTPUT->standard_after_main_region_html();
    echo $OUTPUT->standard_footer_html();
    echo $OUTPUT->standard_end_of_body_html();
    ?>
    <script>
        require([
            'core/moremenu',
            'theme_boost/bootstrap/collapse', 
            'theme_boost/bootstrap/dropdown',
            'theme_boost/bootstrap/tab',
            'theme_boost/bootstrap/alert',
            'theme_boost/bootstrap/button',
            'theme_boost/bootstrap/carousel',
            'theme_boost/bootstrap/modal',
            'theme_boost/bootstrap/popover',
            'theme_boost/bootstrap/scrollspy',
            'theme_boost/bootstrap/tooltip',
            'theme_boost/bootstrap/toast',
            'theme_boost/bootstrap/util',
        ], function(MoreMenu) {
            
            // Fonction d'initialisation principale
            const initMoodleDSFR = () => {
                console.log('Moodle DSFR: Initialisation Vanilla JS.');

                // --- 1. GESTION DES ONGLETS ADMIN (NAVIGATION SECONDAIRE) ---
                const navTabs = document.querySelector('.secondary-navigation');

                if (navTabs) {
                    // Moodle a besoin d'initialiser MoreMenu partout (Cours, Admin, etc.)
                    try {
                        MoreMenu(navTabs);
                    } catch (e) {
                        console.warn('MoreMenu erreur:', e);
                    }

                    // On vérifie si ce menu est le menu de l'administration du site.
                    // Seul le menu admin possède un onglet avec data-key="siteadminnode"
                    const isAdminMenu = navTabs.querySelector('li[data-key="siteadminnode"]');

                    if (isAdminMenu) {
                        const isAdminMainPage = document.querySelector('.tab-content #linkroot') !== null;
                        const wwwroot = (typeof M !== 'undefined' && M.cfg) ? M.cfg.wwwroot : window.location.origin;
                        const adminSearchUrl = wwwroot + '/admin/search.php';

                        // 1. On prépare les liens avec des URLs absolues
                        const allListItems = navTabs.querySelectorAll('li[data-key]');
                        allListItems.forEach(li => {
                            const link = li.querySelector('a');
                            const key = li.getAttribute('data-key');
                            
                            if (link && key) {
                                const targetHash = (key === 'siteadminnode') ? '#linkroot' : '#link' + key;
                                
                                link.setAttribute('href', adminSearchUrl + targetHash);
                                
                                if (isAdminMainPage) {
                                    link.setAttribute('data-toggle', 'tab');
                                }
                            }
                        });

                        // 2. LA GESTION DU CLIC INTELLIGENTE
                        navTabs.addEventListener('click', function(e) {
                            const clickedLink = e.target.closest('a');
                            
                            if (clickedLink && clickedLink.closest('li[data-key]')) {
                                if (isAdminMainPage) {
                                    e.preventDefault(); 
                                    e.stopPropagation();

                                    const targetId = clickedLink.getAttribute('href').split('#')[1];
                                    const targetContent = document.getElementById(targetId);

                                    if (targetContent) {
                                        navTabs.querySelectorAll('a.active').forEach(nav => {
                                            nav.classList.remove('active');
                                            nav.setAttribute('aria-selected', 'false');
                                        });
                                        
                                        document.querySelectorAll('.tab-pane').forEach(pane => {
                                            pane.classList.remove('active', 'show');
                                        });

                                        clickedLink.classList.add('active');
                                        clickedLink.setAttribute('aria-selected', 'true');
                                        targetContent.classList.add('active', 'show');
                                        
                                        history.replaceState(null, null, '#' + targetId);
                                    }
                                }
                            }
                        });

                        // 3. OUVERTURE AUTOMATIQUE
                        if (isAdminMainPage && window.location.hash) {
                            const activeHash = window.location.hash;
                            const linkToActivate = navTabs.querySelector(`a[href$="${activeHash}"]`);
                            if (linkToActivate) {
                                linkToActivate.click();
                            }
                        }
                    }
                    // Si on n'est pas dans l'admin (ex: on est dans un cours), on ne fait rien ! 
                    // Les liens "Participants", "Notes", etc. garderont leur URL d'origine.
                }

                
                // --- 2. TRANSFORMATION DES CATÉGORIES EN TUILES (STYLE CARD) ---
                // --- SCRIPT TUILES CATÉGORIES (SIMPLIFIÉ) ---
                // Note : L'image est maintenant gérée par le PHP (renderers.php)
                const categories = document.querySelectorAll('.course_category_tree .category');

                if (categories.length > 0) {
                    categories.forEach(cat => {
                        
                        // 1. On ajoute la classe fr-card pour le style
                        cat.classList.add('fr-card');

                        // 2. On rend toute la carte cliquable
                        // (Plus besoin de déplacer l'image, elle est déjà au bon endroit grâce au PHP)
                        cat.style.cursor = 'pointer';
                        cat.addEventListener('click', function(e) {
                            const link = cat.querySelector('.categoryname a');
                            // Si on clique ailleurs que sur le lien, on simule le clic
                            if (link && e.target !== link) {
                                window.location.href = link.href;
                            }
                        });
                    });
                }

                // --- 3. INITIALISATION DSFR (OPTIONNEL) ---
                if (window.dsfr && dsfr.core) {
                    try { 
                        dsfr.core.start({ exclude: '.usermenu' }); 
                    } catch(e) { console.warn(e); }
                }

                // --- GESTION MENU ACTIF (Fix pour Catégories vs Accueil) ---
                const currentUrl = window.location.href;
                
                // On vérifie si on est sur la page des catégories
                if (currentUrl.includes('/course/index.php')) {
                    
                    // 1. On désactive "Accueil" (ou tout autre lien actif par erreur)
                    const activeItems = document.querySelectorAll('.fr-nav__item--active');
                    activeItems.forEach(item => {
                        item.classList.remove('fr-nav__item--active');
                        const link = item.querySelector('a');
                        if (link) link.removeAttribute('aria-current');
                    });

                    // 2. On active "Catégories"
                    const catNavItem = document.getElementById('nav-categories');
                    if (catNavItem) {
                        catNavItem.classList.add('fr-nav__item--active');
                        const catLink = catNavItem.querySelector('a');
                    }
                }
            };

            // Gestion du chargement du DOM
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initMoodleDSFR);
            } else {
                initMoodleDSFR();
            }
        });
        
    </script>
</body>

</html>