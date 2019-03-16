<?php
/*
Plugin Name: 安琪基金用户的表单
Plugin URI: #
Description: 插件的简单描述
Version: 插件版本号, 例如: 1.0
Author: 安琪基金
Author URI: #
*/
/**
 * 安装数据表
 */
global $wpdb;
global $tableName;
$tableName='quest_info';
define( 'ANGLEINFO__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
function angleInfo_install(){
    global $wpdb;
    global $tableName;
	$table_name = $wpdb->prefix . $tableName;
	$charset_collate = $wpdb->get_charset_collate();
   $sql= "CREATE TABLE if not Exists $table_name ( 
       id INT(10) NOT NULL AUTO_INCREMENT COMMENT '消息的id' ,
        is_delete INT(1) NOT NULL DEFAULT '0' COMMENT '0不删除;1删除' ,
         is_deal INT(1) NOT NULL DEFAULT '0' COMMENT '0不处理；1处理' ,
          user VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名' , 
          tel INT(13) NOT NULL COMMENT '手机号' , 
          remark TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注信息' , 
          PRIMARY KEY (id)) ENGINE = InnoDB $charset_collate COMMENT = '用户提交的信息表';";
    $wpdb->query($sql);
}

function angleInfo_uninstall(){
    global $tableName;
    echo "angleInfo_uninstall";
    global $wpdb;
    $table_name = $wpdb->prefix . $tableName;
    $sql="DROP TABLE $table_name";
}

 register_activation_hook(__FILE__,'angleInfo_install');
 register_deactivation_hook(__FILE__,'angleInfo_uninstall');
/** Step 2 (from text above). */
add_action( 'admin_menu', 'angleInfo_plugin_menu' );
/** Step 1. */
function angleInfo_plugin_menu() {
    //add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 'my_plugin_options' );
    add_menu_page('设置', '留言', 'manage_options', 'angleInfo-identifier-slug', 'angleInfo_plugin_options','dashicons-media-default');
    add_submenu_page( 'angleInfo-identifier-slug', '设置', '设置', 'manage_options', 'angleInfo-set-slug', 'angleInfo_plugin_set_options');
}
/** Step 3. */
function angleInfo_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( '您没有权行访问改页面的数据' ) );
	}
	require_once(ANGLEINFO__PLUGIN_DIR.'view/list.php');
}

function angleInfo_plugin_set_options(){
    require_once(ANGLEINFO__PLUGIN_DIR.'view/set.php');
}


function get_ajax_video() {
    header( "Content-Type: application/json" );
    $user=$_POST['user'];
    $tel=$_POST['tel'];
    $remark=$_POST['remark'];
    global $tableName;
    global $wpdb;
    $table_name = $wpdb->prefix . $tableName;
    $res= $wpdb->insert($table_name,array('user'=>$user,'tel'=>$tel,'remark'=>$remark), array('%s','%d','%s'));
    echo $res;
    exit;
  }
  add_action( 'wp_ajax_get_ajax_video', 'get_ajax_video' );
  /**
   * 删除数据
   */
  if($_GET['action']=='delete'){
    $id= intval($_GET['id']);
    $table_name = $wpdb->prefix . $tableName;
    $wpdb->update($table_name,array('is_delete'=>'1'),array('id'=>$id));
     echo "<script>location.href='".$_SERVER["HTTP_REFERER"]."';</script>"; 
  }
  /**
   * 隐藏数据
   */
  if($_GET['action']=='deal'){
    $id= intval($_GET['id']);
    $table_name = $wpdb->prefix . $tableName;
    $wpdb->update($table_name,array('is_deal'=>'1'),array('id'=>$id));
     echo "<script>location.href='".$_SERVER["HTTP_REFERER"]."';</script>"; 
  }
?>