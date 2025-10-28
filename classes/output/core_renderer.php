<?php
namespace theme_moodle_dsfr\output;

defined('MOODLE_INTERNAL') || die();

class core_renderer extends \theme_boost\output\core_renderer {
    /**
     * Affiche les blocs de la région side-pre (compat avec anciens layouts).
     */
    public function firstview_fakeblocks(): bool {
        if ($this->page->blocks->region_has_content('side-pre', $this)) {
            return $this->blocks('side-pre');
        }
        return true;
    }


    public function navbar(): string {
        global $PAGE;
        $items = $PAGE->navbar->get_items();
        if (empty($items)) {
            return '';
        }

        $breadcrumb = '<nav class="fr-breadcrumb mb-2" aria-label="Fil d’Ariane">';
        $breadcrumb .= '<div class="fr-collapse"><ol class="fr-breadcrumb__list">';

        foreach ($items as $item) {
            $text = $item->text;
            $url = $item->action;
            $islast = $item === end($items);

            if ($url && !$islast) {
                $breadcrumb .= '<li><a href="'.$url.'">'.$text.'</a></li>';
            } else {
                $breadcrumb .= '<li aria-current="page">'.$text.'</li>';
            }
        }

        $breadcrumb .= '</ol></div></nav>';
        return $breadcrumb;
    }

}
