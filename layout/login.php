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
    <div class="login-container">
        <h1 class="text-center mb-4"><?php echo format_string($SITE->fullname); ?></h1>
        <div class="login-form">
            <?php echo $OUTPUT->login_info(); ?>
            <?php echo $OUTPUT->main_content(); ?> <!-- Le formulaire Moodle -->
        </div>
    </div>
    <?php echo $OUTPUT->standard_end_of_body_html(); ?>
</body>
</html>
