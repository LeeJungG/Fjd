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

<div class="main-div">
    <form name="main_form" method="POST" action="/index.php/Admin/Attribute/edit/attr_id/1/type_id/1.html" enctype="multipart/form-data" >
    	<input type="hidden" name="attr_id" value="<?php echo $data['attr_id']; ?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">属性名称：</td>
                <td>
                    <input  type="text" name="attr_name" value="<?php echo $data['attr_name']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">属性的类型：</td>
                <td>
                	<input type="radio" name="attr_type" value="0" <?php if($data['attr_type'] == '0') echo 'checked="checked"'; ?> />唯一 
                	<input type="radio" name="attr_type" value="1" <?php if($data['attr_type'] == '1') echo 'checked="checked"'; ?> />可选 
                </td>
            </tr>
            <tr>
                <td class="label">属性的可选值，多个可选值用，隔开：</td>
                <td>
                    <input  type="text" name="attr_option_values" value="<?php echo $data['attr_option_values']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">所在的类型id：</td>
                <td>
                    <select name="type_id">
                        <option value="">选择类型</option>
                        <?php foreach ($typeDate as $k => $v): if($v['type_id'] == $type_id) $lef = 'selected="selected"'; else $lef = ''; ?>
                        <option <?php echo ($lef); ?> value="<?php echo ($v["type_id"]); ?>"><?php echo ($v["type_name"]); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>
<script>
</script>
<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/js/tron.js"></script>