<?php
/*!
 * 评论模版
 */

if ( post_password_required() ) {
  return;
}

if( comments_open() ) :?>
<div class="panel panel-default">
  <div class="panel-body">
<?php endif;

comment_form( array(
	'comment_field'			=> '<p><textarea class="form-control" style="height:100px;resize:vertical" id="comment" name="comment" aria-required="true" required="required" placeholder="说点什么吧(￣︶￣)"></textarea></p>',
	'logged_in_as'			=> '<p>' . sprintf( __( '已作为 <a href="%1$s">%2$s</a> 登录。 <a href="%3$s">退出登录 »</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
	'comment_notes_before'	=> '<p>电子邮件地址不会被公开</p>',
	'comment_notes_after'	=> '',
	'title_reply'			=> __( '发表评论' ),
	'title_reply_to'		=> __( '给 %s 回复' ),
	'cancel_reply_link'		=> __( '取消回复' ),
	'label_submit'			=> __( '发射' ),
	'class_submit'			=> 'btn btn-default'
) );

if ( have_comments() ) : ?>
<div id="respond">
	<h3>
		<?php
			printf( __( '%1$s条评论' ), number_format_i18n( get_comments_number() ) );
		?>
	</h3>
    <?php the_comments_navigation(); ?>
	<ul>
		<?php
			wp_list_comments( array(
				'callback'		=> 'rhw_comment',
				'style'			=> 'ul'
			) );
		?>
	</ul>
</div>
<?php elseif( comments_open() ) : ?>
<div id="respond">
  <p>还没有评论哦~快点发表评论吧！~</p>
</div>
<?php endif;
if( comments_open() ) :?>
  </div>
</div>
<?php endif;