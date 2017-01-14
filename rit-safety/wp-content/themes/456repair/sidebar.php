<div class="col-md-3">
<?php if ( is_active_sidebar(1) ){?>
    <div class="sidebar">
    <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Main Sidebar') ) ?>
    </div>
<?php } ?>
</div>