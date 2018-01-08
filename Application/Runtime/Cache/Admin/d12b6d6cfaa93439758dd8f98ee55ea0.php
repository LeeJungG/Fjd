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

<p>
<select onchange="location.href='/index.php/Admin/Attribute/lst/type_id/'+this.value;">
	<option value="">选择类型</option>
	<?php foreach ($typeDate as $k => $v): if($v['type_id'] == $type_id) $lef = 'selected="selected"'; else $lef = ''; ?>
	<option <?php echo ($lef); ?> value="<?php echo ($v["type_id"]); ?>"><?php echo ($v["type_name"]); ?></option>
<?php endforeach; ?>
</select>
</p>
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th >属性名称</th>
            <th >属性的类型</th>
            <th >属性的可选值，多个可选值用，隔开</th>
            <th >所在的类型id</th>
			<th width="60">操作</th>
        </tr>
		<?php foreach ($data as $k => $v): ?>            
			<tr class="tron">
				<td><?php echo $v['attr_name']; ?></td>
				<td><?php echo $v['attr_type']; ?></td>
				<td><?php echo $v['attr_option_values']; ?></td>
				<td><?php echo $v['type_id']; ?></td>
		        <td align="center">
		        	<a href="<?php echo U('edit?attr_id='.$v['attr_id'].'&p='.I('get.p').'&type_id='.$type_id); ?>" title="编辑">编辑</a> |
	                <a href="<?php echo U('delete?attr_id='.$v['attr_id'].'&p='.I('get.p').'&type_id='.$type_id); ?>" onclick="return confirm('确定要删除吗？');" title="移除">移除</a> 
		        </td>
	        </tr>
        <?php endforeach; ?> 
		<?php if(preg_match('/\d/', $page)): ?>  
        <tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr> 
        <?php endif; ?> 
	</table>
</div>
<script>
</script>
<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/js/tron.js"></script>