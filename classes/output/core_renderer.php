<?php
namespace theme_moodle_dsfr\output;

defined('MOODLE_INTERNAL') || die();

class core_renderer extends \theme_boost\output\core_renderer {
    /**
     * Affiche les blocs de la région side-pre (compat avec anciens layouts).
     */
    public function firstview_fakeblocks(): string {
        if ($this->page->blocks->region_has_content('side-pre', $this)) {
            return $this->blocks('side-pre');
        }
        return '';
    }
}
