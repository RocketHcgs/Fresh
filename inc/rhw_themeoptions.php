<?php
/*!
 * 主题设置页面
 */

//添加设置页面
function rhw_themeoptions_init() {
	add_theme_page( '主题设置', '主题设置', 'edit_themes', basename(__FILE__), 'rhw_themeoptions_page' );
}
add_action( 'admin_menu', 'rhw_themeoptions_init' );

//设置页面内容
function rhw_themeoptions_page() {
	if( $_POST['rhw_themeoptions_update'] == 'true' ) { rhw_themeoptions_update(); }
?>
<div class="wrap">
  <h1>Sunshine and coffee主题设置</h1>
  <form method='POST' action=''>
    <table class="form-table">
      <tbody>
        <input type='hidden' name='rhw_themeoptions_update' value='true'>
        <tr>
          <th>网站头部meta信息</th>
          <td>
            <p><label for="keyword">关键字(keyword)</label></p>
            <p><input type="text" name="keyword" id="keyword" class="regular-text code" value="<?php echo rhw_opt::get( 'keyword' ); ?>" placeholder="留空为不设置,每个关键字之间以半角逗号隔开"></p>
            <p><label for="description">网站描述(description)</label></p>
            <p><textarea rows="3" name="description" id="description" class="large-text code" placeholder="留空为不设置"><?php echo rhw_opt::get( 'description' ); ?></textarea></p>
          </td>
        </tr>
        <tr>
          <th>页面加载动画</th>
          <td>
            <label><input type="checkbox" id="theme_loadanimation" name="theme_loadanimation" value="1" <?php if( rhw_opt::get( 'theme_loadanimation' ) == 'true' ) echo 'checked="checked"'; ?>> 启用页面加载动画</label>
          </td>
        </tr>
        <tr>
          <th>底部文字</th>
          <td>
            <p><label for="footer_text">自定义底部文字，支持HTML</label></p>
            <p><textarea rows="4" name="footer_text" id="footer_text" class="large-text code" placeholder="留空为默认文字"><?php echo rhw_opt::get( 'footer_text' ); ?></textarea></p>
          </td>
        </tr>
        <tr>
          <th>网页统计代码</th>
          <td>
            <p><label for="analytics_code">插入Google Analytics、百度统计等代码</label></p>
            <p><textarea rows="10" name="analytics_code" id="analytics_code" class="large-text code"><?php echo rhw_opt::get( 'analytics_code' ); ?></textarea></p>
          </td>
        </tr>
      </tbody>
    </table>
    <p class="submit"><input type='submit' name='submit' id='submit' class='button button-primary' value='保存更改'></p>
  </form>
</div>
<?php
}

//设置保存
function rhw_themeoptions_update() {
	rhw_opt::set( 'keyword', stripslashes( $_POST['keyword'] ) );
	rhw_opt::set( 'description', stripslashes( $_POST['description'] ) );
	if( $_POST['theme_loadanimation'] == '1' ) {
		rhw_opt::set( 'theme_loadanimation', 'true' );
	} else {
		rhw_opt::set( 'theme_loadanimation', 'false' );
	}
	rhw_opt::set( 'footer_text', stripslashes( $_POST['footer_text'] ) );
	rhw_opt::set( 'analytics_code', stripslashes( $_POST['analytics_code'] ) );
}


//设置操作类
class rhw_opt {
	//数据表名，不带前缀
	const table_name = "rhw_themeoptions";
	//初始化数据库
	public function setup() {
		global $wpdb;
		$rhw_tb = $wpdb->prefix . self::table_name;
		if( $wpdb->get_var( "SHOW TABLES LIKE '$rhw_tb'" ) == $rhw_tb ) return false;
		$wpdb->query( "
			CREATE TABLE IF NOT EXISTS `$rhw_tb` (
			`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			`opt_name` varchar(40) NOT NULL,
			`opt_value` longtext NOT NULL,
			PRIMARY KEY (`id`)
			);
		" );
		$wpdb->query( "
			ALTER TABLE `$rhw_tb` ADD UNIQUE(`opt_name`);
		" );
		$wpdb->insert(
			$rhw_tb,
			array(
				'id' => 1,
				'opt_name' => 'keyword',
				'opt_value' => ''
		) );
		$wpdb->insert(
			$rhw_tb,
			array(
				'opt_name' => 'description',
				'opt_value' => ''
		) );
		$wpdb->insert(
			$rhw_tb,
			array(
				'opt_name' => 'theme_loadanimation',
				'opt_value' => 'false'
		) );
		$wpdb->insert(
			$rhw_tb,
			array(
				'opt_name' => 'footer_text',
				'opt_value' => ''
		) );
		$wpdb->insert(
			$rhw_tb,
			array(
				'opt_name' => 'analytics_code',
				'opt_value' => ''
		) );
	}
	//读取设置
	public function get( $opt ) {
		global $wpdb;
		$rhw_tb = $wpdb->prefix . self::table_name;
		$res = $wpdb->get_var( "SELECT opt_value FROM $rhw_tb WHERE opt_name='$opt'" );
		return isset($res) ? $res : '';
	}
	//更改设置
	public function set( $opt, $var ) {
		global $wpdb;
		$rhw_tb = $wpdb->prefix . self::table_name;
		$wpdb->update(
			$rhw_tb,
			array(
				'opt_value' => $var
			),
			array(
				'opt_name' => $opt
		) );
	}
}