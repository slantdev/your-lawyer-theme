<?php
/*
 * https://www.acf-extended.com/features/fields/flexible-content
 *
 * @array   $layout Layout settings (without values)
 * @array   $field Flexible content field settings
 * @bool    $is_preview True during AJAX preview
 */

?>

<div class="acf-layout <?php echo ($is_preview) ? 'is-preview' : ''; ?>">

    <?php display_contact_section_block(get_contact_section_content()); ?>

</div>