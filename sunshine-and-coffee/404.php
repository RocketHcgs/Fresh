<?php
/*!
 * 404模版
 */
 
 get_header(); ?>
 <div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-body">
        <?php
		  rhw_breadcrumbs();
		  rhw_home_meta();
		?>
		</div>
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <p>404</p>
          <p>再怎么找也没有啦⊙﹏⊙</p>
          <p>试试搜索：</p>
          <?php get_search_form(); ?>
        </div>
      </div>
    </div>
    <?php get_sidebar();?>
  </div>
</div>
<?php get_footer(); ?>