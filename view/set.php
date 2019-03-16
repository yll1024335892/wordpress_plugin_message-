<?php
    if($_POST['test_hidden']=="y"){
        update_option('is_angle_info',$_POST['is_angle_info']);
    }
?>
<div class="wrap">
<h1>留言设置</h1>
<form method="post" action="">
<table class="form-table">
<tbody><tr>
<th scope="row">您的主页显示</th>
<td id="front-static-pages"><fieldset><legend class="screen-reader-text"><span>您的主页显示</span></legend>
	<p><label>
    <input type="hidden" name="test_hidden" value="y"  />
		<input name="is_angle_info" type="checkbox" value="1"   <?php
            if(esc_attr(get_option('is_angle_info'))==1){
                ?>checked<?php
            }
        ?>  class="tog">
		您的最新文章	</label>
	</p>
	</fieldset></td>
</tr>
</tbody></table>
<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="保存更改"></p></form>
</div>