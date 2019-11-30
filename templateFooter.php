<?php date_default_timezone_set('America/Denver'); ?>
<footer>
    <span>This site is super cool and made for edu-ma-cational purposes. This page was last updated <?php echo date('m/d/y H:i', filemtime( (substr( $current_page, 0, 2) == 'a_' ? (substr( $current_page, 2)) : $current_page) . '.php'))?></span>
</footer>