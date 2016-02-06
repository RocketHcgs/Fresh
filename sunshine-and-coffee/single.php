<?php
/*!
 * 文章模版
 */

get_header(); ?>
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <?php
		rhw_statistics::update( 'post',get_the_ID() );
		while ( have_posts() ) :
	  ?>
      <div class="panel panel-default">
        <div class="panel-body">
          <?php
		    rhw_breadcrumbs();
		    the_post();
          ?>
          <h3>
			<?php
			  the_title();
			  if( current_user_can('edit_post', get_the_ID()) ) {
				printf( ' <a class="edit-link" href="%1$s">编辑</a>',get_edit_post_link( get_the_ID() ) );
			  }
			?>
          </h3>
          <div class="meta-div">
          <?php rhw_post_meta(); ?> 
          </div>
		  <?php the_content(); ?>
        </div>
      </div>
      <?php comments_template(); ?>
      <?php endwhile; ?>
    </div>
    <?php get_sidebar();?>
  </div>
</div>
<?php get_footer(); ?>