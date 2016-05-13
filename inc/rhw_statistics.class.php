<?php
/*!
 * 访问统计类
 */

class rhw_statistics {
	//数据表名，不带前缀
	const table_name = 'rhw_statistics';
	//初始化
	public function setup() {
		global $wpdb;
		$table_name = $wpdb->prefix . self::table_name;
		if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" )==$table_name ) return false;
		//创建数据表，id是主键，type是类型(主页home，文章或页面post)，pid是文章或页面的id，traffic是浏览次数
		$result = $wpdb->query( "
			CREATE TABLE `$table_name` (
			`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			`type` varchar(20) DEFAULT NULL,
			`pid` tinytext,
			`traffic` bigint(20) UNSIGNED DEFAULT NULL,
			PRIMARY KEY (`id`)
			);
		" );
		if ( !$result ) return false;
	}
	//获取数据
	public function get( $type, $pid ) {
		global $wpdb;
    	$table_name = $wpdb->prefix . self::table_name;
		if( $type == 'post' ) {
			$sql = "SELECT traffic FROM $table_name WHERE type='post' AND pid='$pid'";
		} else {
			$sql = "SELECT traffic FROM $table_name WHERE type='home'";
		}
		$check = $wpdb->get_var( $sql );
		return isset($check) ? absint($check) : 0;
	}
	//更新数据
	public function update( $type, $pid ) {
		global $wpdb;
		$table_name = $wpdb->prefix . self::table_name;
		$check = $wpdb->get_var( "SELECT traffic FROM $table_name WHERE type='$type' AND pid='$pid'" );
		if( isset($check) ) {
			//更新
			$traffic = (int)$check+1;
			$wpdb->update(
				$table_name, 
				array( 
					'traffic' => $traffic
				), 
				array(
					'type' => $type,
					'pid' => $pid
			) );
		} else {
			//插入
			$traffic = 1;
			$wpdb->insert(
				$table_name, 
				array(
					'type' => $type,
					'pid' => $pid,
					'traffic' => $traffic
			) );
		}
		return $traffic;
	}
	//删除数据
	public function delete( $type, $pid ) {
		global $wpdb;
		$table_name = $wpdb->prefix . self::table_name;
		if( $wpdb->get_var( "SELECT traffic FROM $table_name WHERE type='$type' AND pid='$pid'" ) ) {
			$wpdb->delete( $table_name, array( 'type' => $type, 'pid' => $pid ) );
			return true;
		}
		return false;
	}
}