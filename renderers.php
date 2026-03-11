<?php
defined('MOODLE_INTERNAL') || die;

// Inclusion du fichier parent obligatoire
require_once($CFG->dirroot . '/course/renderer.php');

class theme_moodle_dsfr_core_course_renderer extends core_course_renderer {

    /**
     * Surcharge COMPLÈTE de l'affichage d'une catégorie (La Carte)
     */
    protected function coursecat_category(coursecat_helper $chelper, $coursecat, $depth) {
        
        // 1. Préparation des classes (Code standard)
        $classes = array('category');
        if (empty($coursecat->visible)) {
            $classes[] = 'dimmed_category';
        }
        if ($chelper->get_subcat_depth() > 0 && $depth >= $chelper->get_subcat_depth()) {
            $categorycontent = '';
            $classes[] = 'notloaded';
            if ($coursecat->get_children_count() || ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_COLLAPSED && $coursecat->get_courses_count())) {
                $classes[] = 'with_children collapsed';
            }
        } else {
            $categorycontent = $this->coursecat_category_content($chelper, $coursecat, $depth);
            $classes[] = 'loaded';
            if (!empty($categorycontent)) {
                $classes[] = 'with_children';
                $this->categoryexpandedonload = true;
            }
        }
        $this->coursecat_include_js();

        // 2. DÉBUT DE LA CARTE
        $content = html_writer::start_tag('div', array(
            'class' => join(' ', $classes),
            'data-categoryid' => $coursecat->id,
            'data-depth' => $depth,
            'data-showcourses' => $chelper->get_show_courses(),
            'data-type' => self::COURSECAT_TYPE_CATEGORY,
        ));

        // --- 3. GESTION IMAGE & TEXTE (CUSTOM DSFR) ---
        $description = $chelper->get_category_formatted_description($coursecat);
        $imagehtml = '';
        $texthtml = ''; // Variable pour le texte restant

        // A. Extraction de l'image
        if ($description && preg_match('/<img([^>]*)>/i', $description, $matches)) {
            $img_tag = $matches[0]; 
            $imagehtml = html_writer::div($img_tag, 'category-image-container');
            
            // ASTUCE : On retire l'image de la description pour ne garder que le texte
            $texthtml = str_replace($img_tag, '', $description);
        } else {
            // Pas d'image -> Dégradé
            $styleclass = ($coursecat->id % 2 == 0) ? 'pattern-purple' : 'pattern-grey';
            $imagehtml = html_writer::div('', 'category-image-container ' . $styleclass);
            // On garde toute la description comme texte
            $texthtml = $description;
        }

        // On injecte l'image en premier
        $content .= $imagehtml;

        // --- 4. BLOC INFO (TITRE + DESCRIPTION) ---
        $content .= html_writer::start_tag('div', array('class' => 'info'));

        $content .= html_writer::div(mb_strtoupper(get_string('menu_category', 'theme_moodle_dsfr')), 'category-desc');
        // Le Titre
        $categoryname = $coursecat->get_formatted_name();
        $categoryname = html_writer::link(new moodle_url('/course/index.php', array('categoryid' => $coursecat->id)), $categoryname);
        if ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_COUNT && ($coursescount = $coursecat->get_courses_count())) {
            $categoryname .= html_writer::tag('span', ' ('. $coursescount.')', array('title' => get_string('numberofcourses'), 'class' => 'numberofcourse'));
        }
        $content .= html_writer::tag(($depth > 1) ? 'h4' : 'h3', $categoryname, array('class' => 'categoryname aabtn'));

        // La Description (Texte)
        
        // 1. On nettoie le texte pour enlever le HTML restant (<p>, <strong>, etc.)
        // Cela permet de compter les "vrais" caractères visibles
        $clean_text = trim(strip_tags($texthtml));

        if (!empty($clean_text)) {
            // 2. On définit la limite
            $limit = 100;

            // 3. Vérification de la longueur (mb_strlen gère les accents français)
            if (mb_strlen($clean_text) > $limit) {
                // Si c'est trop long : on coupe à 100 et on ajoute "..."
                $final_text = mb_substr($clean_text, 0, $limit) . '...';
            } else {
                // Sinon : on garde le texte tel quel
                $final_text = $clean_text;
            }

            // 4. Affichage
            $content .= html_writer::div($final_text, 'category-desc');
        }

        $content .= html_writer::end_tag('div'); // .info

        // 5. Contenu caché (sous-catégories)
        $content .= html_writer::tag('div', $categorycontent, array('class' => 'content'));
        $content .= html_writer::end_tag('div'); // .category

        return $content;
    }

    /**
     * Surcharge de l'affichage d'un COURS (Liste des cours dans une catégorie)
     */
    protected function coursecat_coursebox(coursecat_helper $chelper, $course, $additionalclasses = '') {
        global $PAGE;
        // --- 1. Initialisation (Code Moodle Standard) ---
        if (!isset($this->strings->summary)) {
            $this->strings->summary = get_string('summary');
        }
        if ($chelper->get_show_courses() <= self::COURSECAT_SHOW_COURSES_COUNT) {
            return '';
        }
        if ($course instanceof stdClass) {
            $course = new core_course_list_element($course);
        }
        
        $content = '';
        $classes = trim('coursebox clearfix '. $additionalclasses);
        if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED) {
            $classes .= ' collapsed';
        }

        // DÉBUT DE LA CARTE COURS
        $content .= html_writer::start_tag('div', array(
            'class' => $classes,
            'data-courseid' => $course->id,
            'data-type' => self::COURSECAT_TYPE_COURSE,
        ));

        // --- 2. GESTION DE L'IMAGE / DÉGRADÉ (CUSTOM DSFR) ---
        $coverhtml = '';
        $has_image = false;

        // A. On regarde si le cours a une image de résume (Feature standard Moodle)
        foreach ($course->get_course_overviewfiles() as $file) {
            if ($file->is_valid_image()) {
                $imageurl = moodle_url::make_file_url('/pluginfile.php',
                    '/' . $file->get_contextid() . '/' . $file->get_component() . '/' .
                    $file->get_filearea() . $file->get_filepath() . $file->get_filename());
                
                $coverhtml = html_writer::div(
                    html_writer::empty_tag('img', ['src' => $imageurl, 'alt' => '']), 
                    'course-cover-container'
                );
                $has_image = true;
                break; // On prend la première image trouvée
            }
        }

        // B. Si pas d'image, on génère un dégradé basé sur l'ID du cours
        if (!$has_image) {
            // On définit 4 styles de dégradés (voir CSS plus bas)
            $gradients = ['gradient-blue', 'gradient-purple', 'gradient-green', 'gradient-orange'];
            // L'opérateur modulo (%) permet d'attribuer une couleur fixe selon l'ID
            $styleindex = $course->id % count($gradients);
            $gradientClass = $gradients[$styleindex];

            $coverhtml = html_writer::div('', 'course-cover-container no-image ' . $gradientClass);
        }

        // On injecte le cover (Image ou Dégradé) en PREMIER
        $content .= $coverhtml;

        // --- 3. LE TITRE ET INFOS (.info) ---
        $content .= html_writer::start_tag('div', array('class' => 'info'));
        $content .= html_writer::div(mb_strtoupper(get_string('menu_course', 'theme_moodle_dsfr')), 'category-desc');

        // On récupère l'objet catégorie à partir de l'ID stocké dans le cours
        if (!empty($course->category) && $PAGE->pagetype === 'site-index') {
            $cat = core_course_category::get($course->category, IGNORE_MISSING);
            if ($cat) {
                // On crée un petit badge ou texte pour la catégorie
                $catname = $cat->get_formatted_name();
                $caturl = new moodle_url('/course/index.php', array('categoryid' => $cat->id));
                $link = html_writer::link($caturl, $catname);
                $content .= html_writer::div($link, 'course-card-category');            
                }
        }
        // -----------------------------------------

        // On récupère le nom formaté via le helper
        $content .= $this->course_name($chelper, $course);
        $content .= $this->course_enrolment_icons($course);
        $content .= html_writer::end_tag('div');


        // --- 4. LE RÉSUMÉ (.content) ---
        $content .= html_writer::start_tag('div', array('class' => 'content'));
        $content .= $this->coursecat_coursebox_content($chelper, $course);
        $content .= html_writer::end_tag('div');

        $content .= html_writer::end_tag('div'); // Fin .coursebox

        return $content;
    }

    public function frontpage_available_courses() {
        // 1. On récupère la liste des cours (la grille)
        $content = parent::frontpage_available_courses();

        // 2. On crée le bouton vers les catégories
        $url = new moodle_url('/course/index.php');
        
        $button = html_writer::link($url, get_string('all_categories', 'theme_moodle_dsfr'), [
            'class' => 'btn btn-primary'
        ]);

        // 3. On enveloppe le bouton
        $buttonContainer = html_writer::div($button, 'text-right fr-mb-3w');

        // 4. INVERSION ICI : Le bouton d'abord, le contenu ensuite
        return $buttonContainer . $content;
    }
}