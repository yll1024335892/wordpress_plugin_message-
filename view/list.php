<?php
     global $tableName;
     global $wpdb;
     $table_name = $wpdb->prefix . $tableName;
    $sqlTotal="SELECT COUNT(id) FROM $table_name WHERE is_delete = 0";
    $total = $wpdb->get_var($sqlTotal);
        $info_per_page = 10;
        $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
        $nowPage = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;		
        $offset = ($nowPage-1)*$info_per_page;
        $sql="select id,user,tel,remark,is_deal from $table_name where is_delete = 0 order by id desc limit ".$offset.",".$info_per_page;
        $res = $wpdb->get_results($sql);
        $pageHtml= paginate_links( array(
            'base' => add_query_arg( 'cpage', '%#%' ),
            'format' => '',
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'total' => ceil($total / $info_per_page),
            'current' => $page
        ));
    

?>
<div class="wrap">
<h1>留言管理</h1>
<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
		<td id="cb" class="manage-column column-cb check-column">
        <label class="screen-reader-text" for="cb-select-all-1">全选</label>
        <input id="cb-select-all-1" type="checkbox"></td>
        <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">内容</th>
        <th scope="col" id="author" class="manage-column column-author">用户</th>
        <th scope="col" id="categories" class="manage-column column-categories">手机号</th>
        <th scope="col" class="manage-column column-categories">状态</th>
    </tr>
	</thead>
	<tbody id="the-list">
    <?php
        foreach($res as $key=>$val){
        ?>
            <tr id="post-<?php echo $val->id;?>" class="iedit">
                <th scope="row" class="check-column">
                <input id="cb-select-<?php echo $val->id;?>" type="checkbox" name="post[]" value="<?php echo $val->id;?>">
                </th>
                <td class="title column-title has-row-actions column-primary page-title">
                <strong><?php echo $val->remark;?></strong>
                    <div class="row-actions">
                        <span class="edit"><a href="<?php echo  home_url().$_SERVER['REQUEST_URI'];?>&action=delete&id=<?php echo $val->id;?>">删除</a>  </span>
                       <?php if(($val->is_deal)==0){
                            ?>
                            <span class="inline hide-if-no-js">|<a href="<?php echo  home_url().$_SERVER['REQUEST_URI'];?>&action=deal&id=<?php echo $val->id;?>"><button type="button" class="button-link editinline">处理</button></a> | </span>
                            <?php
                       }?>
                    </div>
            </td>
            <td class="author column-author" data-colname="作者">
                <?php echo $val->user;?>
            </td>
            <td class="categories column-categories" data-colname="分类目录">
                <span> <?php echo $val->tel;?></span>
            </td>
            <td class="categories column-categories" data-colname="分类目录">
                <?php if(($val->is_deal)==0){
                        ?>
                        <span style="color:red">未处理</span>
                        <?php
                    }else{
                        ?>
                         <span style="color:#E8E9EC;">已处理</span>
                        <?php
                    }
                ?>
            </td>
        </tr>
            <?php
        }
    ?>
        </tbody>
</table>
<div class="tablenav-pages">
<?php echo $pageHtml;?>
</div>
<style type="text/css">
.tablenav-pages{ padding-top:20px; text-align: center;}
.tablenav-pages span{ padding:5px 10px; }
.tablenav-pages a{  padding:5px 10px;   background: #fff;text-decoration: none;} 
</style>