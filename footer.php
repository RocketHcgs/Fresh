<?php
/*!
 * 底部模版
 */
?>
    <footer id="mainfooter" class="container">
      <div class="panel panel-default">
        <?php if ( has_nav_menu( 'footer_menu' ) ) : ?>
        <div class="panel-body">
        <?php
          wp_nav_menu( array(
              'menu'              => 'footer_menu',
              'theme_location'    => 'footer_menu',
              'depth'             => -1,
              'container'         => '',
              'container_class'   => '',
              'menu_id'           => 'footer_menu',
              'menu_class'        => 'breadcrumb',
              'items_wrap'        => '<ul id="%1$s" class="%2$s"><li class="active"><span class="glyphicon glyphicon-list-alt"></span> '.__('链接').'</li> %3$s</ul>',
              'walker'            => new rhw_navwalker()
          ) );
	    ?>
        </div>
        <?php endif; ?>
        <div class="panel-footer clearfix footer-div">
          <?php if( rhw_opt::get( 'footer_text' ) == '' ) : ?>
          &copy; 2016 <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a> | Powered by WordPress.
          <?php
		  else : echo rhw_opt::get( 'footer_text' );
          endif;
		  ?>
          <span class="pull-right">Theme <a href="https://github.com/RHWTeam/Sunshine-and-coffee" target="_blank">Sunshine and coffee</a>. | Based on <a href="http://getbootstrap.com/" target="_blank">Bootstrap</a>.</span>
        </div>
      </div>
    </footer>
    <div class="float-nav">
      <a href="<?php echo home_url( '/' ) . 'wp-admin'; ?>">
        <div class="float-nav-li" style="margin-bottom:10px">
          <span class="glyphicon glyphicon-cog"></span>
        </div>
      </a>
      <a href="javascript:;">
        <div id="go-foot" class="float-nav-li">
          <span class="glyphicon glyphicon-chevron-down"></span>
        </div>
      </a>
    </div>
    <?php echo rhw_opt::get( 'analytics_code' ); ?>
    <?php wp_footer(); ?>
  </body>
</html>