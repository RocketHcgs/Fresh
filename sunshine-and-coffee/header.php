<?php
/*!
 * 头部模版
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color"content="#59524c">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
  </head>
  <body>
    <?php if( rhw_opt::get( 'theme_loadanimation' ) == 'true' ) : ?>
    <div id="loading" style="display:none;">
      <div class="loadcontainer">
        <span class="glyphicon glyphicon-hourglass glyphicon-spin glyphicon-5x"></span>
      </div>
    </div>
    <?php endif; ?>
    <nav class="navbar navbar-custom navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#header-navbar-collapse">
            <span class="sr-only">切换菜单</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="header-navbar-collapse" class="collapse navbar-collapse" role="navigation" itemscope="">
          <?php
          if ( has_nav_menu( 'header_menu' ) ) {
            wp_nav_menu( array(
              'menu'              => 'header_menu',
              'theme_location'    => 'header_menu',
              'depth'             => 0,
              'container'         => '',
              'container_class'   => '',
              'menu_class'        => 'nav navbar-nav',
              'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
              'walker'            => new rhw_navwalker()
            ) );
          }?>
		  <form class="navbar-form navbar-right" role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="搜索…" name="s" id="s" required="">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-default" id="searchsubmit"><span class="glyphicon glyphicon-search"></span></button>
                </span>
              </div>
            </div>
          </form>
        </div>
      </div>
    </nav>
    <header id="topheader">
      <div id="head-content" class="container">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2 text-center">
            <div class="header-div">
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="header-name"><a class="header-link" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></div>
                  <div class="header-description"><?php bloginfo('description'); ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>