<?php
/*!
 * 主页模版
 */

get_header(); ?>
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-body">
        <?php
		  rhw_breadcrumbs();
		  rhw_statistics::update( 'home','1' );
		  rhw_home_meta();
		?>
		</div>
      </div>
      <?php
          if ( have_posts() ) {
            while ( have_posts() ) : the_post(); ?>
            <div class="panel panel-default post">
              <h4>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <?php if ( is_sticky() && is_home() && ! is_paged() ) {
			    echo '<span class="label top-post">置顶</span>';
		        } ?>
              </h4>
              <div class="panel-body">
			  <?php
			    rhw_post_meta();
			    the_excerpt();
			    rhw_post_thumbnail();
			  ?>
              </div>
            </div>
			<?php endwhile; ?>
			<div class="panel panel-default">
              <div class="panel-body">
                <?php rhw_paging_nav(); ?>
              </div>
            </div>
            <?php } else {
			echo '<div class="panel panel-default"><div class="panel-body">';
			echo '<p>再怎么找也没有啦⊙﹏⊙</p>';
			get_search_form();
			echo '</div></div>';
		  }?>
      </div>
    <?php get_sidebar();?>
  </div>
</div>
<?php get_footer(); ?>