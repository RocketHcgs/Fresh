<?php
/*!
 * 模版函数
 */

//载入/inc 下的所有.php文件
foreach ( glob( get_template_directory() . '/inc/*.php' ) as $filename ) {
  require $filename;
}

//访问统计，在启用主题时初始化数据库
function rhw_db_setup() {
	global $pagenow;
	if(
		false===is_admin()
		|| 'themes.php'!=$pagenow
		|| false===isset($_GET['activated'])
	) {
		return;
	}
	rhw_statistics::setup();
}
add_action( 'load-themes.php', 'rhw_db_setup' );

//初始化
function rhw_setup() {
	//让WordPress处理标题
	add_theme_support( 'title-tag' );
	//启用特色图像
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 200, 9999 );
	//注册菜单
	register_nav_menus( array(
		'header_menu' => __( '头部菜单' ),
		'footer_menu'  => __( '链接' ),
	) );
}
add_action( 'after_setup_theme', 'rhw_setup' );

//移除emoji表情处理
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

//加载css和js
function rhw_scripts() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/src/css/bootstrap.min.css', array(), '3.3.5' );
	wp_enqueue_style( 'aplayer', get_template_directory_uri() . '/src/css/APlayer.min.css', array(), '1.0' );
	wp_enqueue_style( 'custom', get_bloginfo('stylesheet_url'), array(), '0.1' );
	wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', get_template_directory_uri() . '/src/js/jquery.min.js', array(), '2.1.4' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/src/js/bootstrap.min.js', array( 'jquery' ), '3.3.5' );
	wp_enqueue_script( 'aplayer', get_template_directory_uri() . '/src/js/APlayer.min.js', array(), '1.0' );
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/src/js/js.js', array( 'jquery' ), '0.1' );
}
add_action( 'wp_enqueue_scripts', 'rhw_scripts' );

//注册小工具区域
function rhw_widgets_init() {
	register_sidebar( array(
		'name'          => __( '侧边栏' ),
		'id'            => 'sidebar-1',
		'description'   => __( '在这里添加小工具' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'rhw_widgets_init' );

//去除自带导航
add_filter('show_admin_bar', '__return_false');

//显示面包屑导航
function rhw_breadcrumbs() {
	$delimiter = '›'; //分隔符
	$before = '<li class="active">'; //在当前链接前插入
	$after = '</li>'; //在当前链接后插入
	echo '<ol id="head-breadcrumb" class="breadcrumb" itemscope itemtype="http://schema.org/WebPage">';
	global $wp_query;
	global $post;
	$homeLink = home_url();
	echo '<a itemprop="breadcrumb" href="' . $homeLink . '">' . get_bloginfo('name') . '</a> ' . $delimiter . ' ';
	if ( is_category() ) { // 分类 存档
		$cat_obj = $wp_query->get_queried_object();
		$thisCat = $cat_obj->term_id;
		$thisCat = get_category($thisCat);
		$parentCat = get_category($thisCat->parent);
		if ($thisCat->parent != 0){
			$cat_code = get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' ');
			echo $cat_code = str_replace ('<a','<a itemprop="breadcrumb"', $cat_code );
		}
		echo $before . '' . single_cat_title('', false) . '' . $after;
	} elseif ( is_day() ) { // 天 存档
		echo '<a itemprop="breadcrumb" href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
		echo '<a itemprop="breadcrumb"  href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
		echo $before . get_the_time('d') . $after;
	} elseif ( is_month() ) { // 月 存档
		echo '<a itemprop="breadcrumb" href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
		echo $before . get_the_time('F') . $after;
	} elseif ( is_year() ) { // 年 存档
		echo $before . get_the_time('Y') . $after;
	} elseif ( is_single() && !is_attachment() ) { // 文章
		if ( get_post_type() != 'post' ) { // 自定义文章类型
			$post_type = get_post_type_object(get_post_type());
			$slug = $post_type->rewrite;
			echo '<a itemprop="breadcrumb" href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} else { // 文章 post
			$cat = get_the_category(); $cat = $cat[0];
			$cat_code = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			echo $cat_code = str_replace ('<a','<a itemprop="breadcrumb"', $cat_code );
			echo $before . get_the_title() . $after;
		}
	} elseif ( is_attachment() ) { // 附件
		$parent = get_post($post->post_parent);
		$cat = get_the_category($parent->ID); $cat = $cat[0];
		echo '<a itemprop="breadcrumb" href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
		echo $before . get_the_title() . $after;
	} elseif ( is_page() && !$post->post_parent ) { // 页面
		echo $before . get_the_title() . $after;
	} elseif ( is_page() && $post->post_parent ) { // 父级页面
		$parent_id  = $post->post_parent;
		$breadcrumbs = array();
		while ($parent_id) {
			$page = get_page($parent_id);
			$breadcrumbs[] = '<a itemprop="breadcrumb" href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
			$parent_id  = $page->post_parent;
		}
		$breadcrumbs = array_reverse($breadcrumbs);
		foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
		echo $before . get_the_title() . $after;
	} elseif ( is_search() ) { // 搜索结果
		echo $before ;
		_e( '搜索结果' );
		echo  $after;
	} elseif ( is_tag() ) { //标签 存档
		echo $before ;
		printf( __( '标签: %s' ), single_tag_title( '', false ) );
		echo  $after;
	} elseif ( is_author() ) { // 作者存档
		global $author;
		$userdata = get_userdata($author);
		echo $before ;
		printf( __( '%s的文章' ),  $userdata->display_name );
		echo  $after;
	} elseif ( is_404() ) { // 404 页面
		echo $before;
		_e( '404' );
		echo  $after;
	} elseif ( !is_single() && !is_page() && get_post_type() != 'post' ) {
		$post_type = get_post_type_object(get_post_type());
		echo $before . $post_type->labels->singular_name . $after;
	}
	if ( get_query_var('paged') ) { // 分页
		if ( is_home() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
			echo $before . sprintf( __( '第 %s 页' ), get_query_var('paged') ) . $after;
	} elseif ( is_home() ) { //首页
		echo $before . __( '首页' ) . $after;
	}
	echo '</ol>';
}

//显示主页信息
function rhw_home_meta() {
	$published_posts = wp_count_posts()->publish;
	echo '<div class="home-meta">';
	printf( '%1$s篇文章 %2$s次浏览', $published_posts, rhw_statistics::get( 'home','1' ) );
	echo '</div>';
}

//显示文章信息
function rhw_post_meta() {
	printf( '<span class="post-meta"><a href="%1$s">%2$s</a> %3$s %4$s %5$s',
	esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
	get_the_author(),
	get_the_time('m-d G:i'),
	get_the_category_list( ' ' ),
	get_the_tag_list( '标签: ',' ' )
	);
	if(get_comments_number() != 0) {
		printf( ' %1$s条评论', get_comments_number() );
	}
	printf( ' %1$s次围观</span>',rhw_statistics::get( 'post',get_the_ID() ) );
}

//显示特色图像
function rhw_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}
	printf( '<a href="%1$s" aria-hidden="true">', get_the_permalink() );
	the_post_thumbnail(); 
	echo '</a>';
}

//显示分页链接
function rhw_paging_nav(){
	global $wp_query;
	$big = 999999999;
	$pages = $wp_query->max_num_pages;
	if ( $pages < 2 ) {
		_e( '没有更多了⊙﹏⊙' );
		return;
	}
	$pagination_links = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $pages,
		'type' => 'array'
	) );
	echo '<ul id="paging_nav" class="pagination" role="navigation">';
	foreach( $pagination_links as $value ) {
		echo '<li class="' , setActive( $value ) , '">'.$value.'</li>';
	}
	echo '</ul>';
}
function setActive( $var ) {
	if( substr( $var , 0 , 5 ) == '<span' ) {
		echo 'active';
	}
}

//替换默认评论框字段
function rhw_comments_fields($fields) {
	$fields['author'] = '<div class="row"><div class="col-sm-4"><p><label for="author">' . __( '昵称(必填)' ) . '</label> <input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"></p></div>';
	$fields['email'] = '<div class="col-sm-4"><p><label for="email">' . __( '邮箱(必填)' ) . '</label> <input class="form-control" id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '"></p></div>';
	$fields['url'] = '<div class="col-sm-4"><p><label for="url">' . __( '网址(没有可不填)' ) . '</label> <input class="form-control" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '"></p></div></div>';
	return $fields;
}
add_filter('comment_form_default_fields','rhw_comments_fields');

//评论callback
function rhw_comment( $comment, $args, $depth ) {
	$GLOBALS[ 'comment' ] = $comment;
	global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	  <article id="comment-<?php comment_ID(); ?>">
		<?php
		printf('<div class="comments-author">%1$s</div>',
		get_comment_author_link() );
		if ( '0' == $comment->comment_approved ) : ?>
			<p><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
		<?php endif; ?>
		<div class="comment comment-content">
		  <?php
		    comment_text();
			printf( '<time class="post-meta" datetime="%1$s">%2$s</time>',
				get_comment_time('c'),
				sprintf( '%1$s %2$s', get_comment_date( 'y-m-d' ), get_comment_time( 'G:i' ) )
			);
		  ?>
		  <?php comment_reply_link(array_merge($args, array('reply_text' => __( '回复' ), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
		  <?php edit_comment_link( __( '编辑' ) ); ?>
		</div>
	  </article>
      
	<?php
}

//删除文章时同时删除该文章流量统计
function rhw_delete_statistics( $postid ) {
	rhw_statistics::delete( 'post', $postid );
}
add_action('before_delete_post', 'rhw_delete_statistics');