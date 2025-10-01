<?php
defined('MOODLE_INTERNAL') || die();
echo $OUTPUT->doctype(); ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
  <title><?php echo $OUTPUT->page_title(); ?></title>
  <?php echo $OUTPUT->standard_head_html(); ?>
  <!-- Importation des styles DSFR -->
  <link rel="stylesheet" href="<?php echo $CFG->wwwroot ?>/theme/moodle_dsfr/lib/dsfr-assets/dist/dsfr.min.css">
</head>
<body <?php echo $OUTPUT->body_attributes(); ?>>
  <?php echo $OUTPUT->standard_top_of_body_html(); ?>

  <header class="fr-header">
    <!-- Exemple : utiliser le header DSFR -->
    <div class="fr-container">
      <a class="fr-header__brand" href="#">Moodle DSFR</a>
    </div>
  </header>

  <div id="page-content" class="container">
    <?php echo $OUTPUT->main_content(); ?>
  </div>

  <footer class="fr-footer">
    <div class="fr-container">© 2025 - Moodle DSFR</div>
  </footer>

  <?php echo $OUTPUT->standard_end_of_body_html(); ?>
  <!-- Importation éventuelle du JS DSFR -->
  <script src="<?php echo $CFG->wwwroot ?>/theme/moodle_dsfr/lib/dsfr-assets/dist/dsfr.module.min.js"></script>
</body>
</html>
