### 使用建立文件夹angle_info将数据都放到该目录中

### 将插件放到wp-content/plugins的文件夹中

效果
![](https://github.com/yll1024335892/wordpress_plugin_message-/blob/master/1.png)
#
![](https://github.com/yll1024335892/wordpress_plugin_message-/blob/master/2.png)
#
![](https://github.com/yll1024335892/wordpress_plugin_message-/blob/master/3.png)
#

### 前端表单的处理
```
//表单
<section class="container client">
    <div class="contain">
        <div class="client-c">
            <div class="client-left">
                <div class="client-l-form">
                    <div class="l-f-tit">在线留言</div>
                    <div class="l-f-user">姓名&nbsp;&nbsp;<input type="text" id="username"/></div>
                    <div class="l-f-tel">电话&nbsp;&nbsp;<input type="text" id="tel"/></div>
                    <div class="l-f-remark">
                        <textarea id="remark"></textarea>
                    </div>
                    <?php
                        if(esc_attr(get_option('is_angle_info'))==1){
                            ?>
                             <div class="c-f-btn"><button id="submitBtn">提交</button></div>
                            <?php
                        }
                    ?>
                </div>
                <div>
                    <p>联系我们</p>
                    <p class="l-f-link"><span class="span-left">Email :Q.Angel@blockox.vc</span><span  class="span-right">Telegram :1888888888</span></p>
                    <div class="l-f-view">
                        <p>关注我们</p>
                        <img src="<?php bloginfo('template_url'); ?>/images/client_ewm.png" width="70px" height="70ox" />
                    </div>
                </div>
            </div>
            <div class="client-right">
                <img src="<?php bloginfo('template_url'); ?>/images/client_right.png" />
            </div>
        </div>

    </div>
</section>
//jquery中提交的数据
var ajaxurl = '<?php echo admin_url('admin-ajax.php')?>';
        $("#submitBtn").click(function(){
            $.post(ajaxurl,{"user":$("#username").val(),"tel":$("#tel").val(),"remark":$("#remark").val(),"action":"get_ajax_video"},function(res){
                if(res!=1){
                    alert("留言失败");
                    return;
                }else{
                    alert("留言成功");
                    $("#username,#tel,#remark").val("");
                    return;
                }
            });  
});
```