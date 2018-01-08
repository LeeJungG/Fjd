<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/Public/datepicker/jquery-ui-1.9.2.custom.min.css">
<script type="text/javascript" charset="utf-8" src="/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript"  language="javascript" src="/Public/datepicker/jquery-1.7.2.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/datepicker/datepicker_zh-cn.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/datepicker/jquery-ui-1.9.2.custom.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo $btnLink; ?>"><?php echo $btnName; ?></a></span><!-- -->
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $title; ?> </span><!-- -->
    <div style="clear:both"></div>
</h1>

<div class="form-div search_form_div">
    <form method="GET" name="search_form">
		<p>
			用户名：
	   		<input type="text" name="admin_name" size="30" value="<?php echo I('get.admin_name'); ?>" />
		</p>
		<p>
			是否启用：
			<input type="radio" value="-1" name="is_use" <?php if(I('get.is_use', -1) == -1) echo 'checked="checked"'; ?> /> 全部 
			<input type="radio" value="1" name="is_use" <?php if(I('get.is_use', -1) == '1') echo 'checked="checked"'; ?> /> 启用 
			<input type="radio" value="0" name="is_use" <?php if(I('get.is_use', -1) == '0') echo 'checked="checked"'; ?> /> 禁用 
		</p>
		<p><input type="submit" value=" 搜索 " class="button" /></p>
    </form>
</div>
<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th >用户名</th>
            <th >密码</th>
            <th >是否启用</th>
			<th width="60">操作</th>
        </tr>
		<?php foreach ($data as $k => $v): ?>            
			<tr class="tron">
				<td><?php echo $v['admin_name']; ?></td>
				<td><?php echo $v['admin_password']; ?></td>
				<td admin_id="<?php echo ($v["admin_id"]); ?>" class="is_use" ><?php echo $v['is_use']==1 ? '启用' : '禁用'; ?></td>
		        <td align="center">
		        	<a href="<?php echo U('edit?admin_id='.$v['admin_id'].'&p='.I('get.p')); ?>" title="编辑">编辑</a> 
					<?php if($v['admin_id'] != 1): ?>
		        	|
	                <a href="<?php echo U('delete?admin_id='.$v['admin_id'].'&p='.I('get.p')); ?>" onclick="return confirm('确定要删除吗？');" title="移除">移除</a> 
	            <?php endif; ?>
		        </td>
	        </tr>
        <?php endforeach; ?> 
		<?php if(preg_match('/\d/', $page)): ?>  
        <tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr> 
        <?php endif; ?> 
	</table>
</div>
<script>
$('.is_use').click(function(){
	//先获取点击的admin_id
	var admin_id = $(this).attr("admin_id");
	if(admin_id == 1){
		alert('超级管理员不能修改');
		return false;
	}
	var _this = $(this);
	$.ajax({
		//使用什么方式传
		type : "GET",
		//默认U函数的地址是带.html后缀的:/index.php/Admin/Admin/ajaxUpdateIsuse.html/admin_id/3,这样会报错
		//所有需要认U生成的地址不带.html
		//在使用ajax的时候使用U函数需要设置第三个参数为false不生成.html后缀
		url : "<?php echo U('ajaxUpdateIsuse','',false); ?>/admin_id/"+admin_id,

		success : function (data){
				if(data == 0)
					_this.html("禁用");
				else
					_this.html("启用");

			}
		});
});
</script>
<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/js/tron.js"></script>