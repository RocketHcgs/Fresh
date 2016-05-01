<?php
/*!
 * 边栏模版
 */
?>
<div class="col-md-4">
  <?php if ( is_active_sidebar( 'sidebar-1' )  ) : ?>
    <aside id="mainsidebar" class="sidebar widget-area" role="complementary">
      <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </aside>
  <?php endif; ?>
</div>