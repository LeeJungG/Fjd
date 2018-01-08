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
    <form name="main_form" method="POST" action="/index.php/Admin/Role/edit/role_id/7.html" enctype="multipart/form-data" >
    	<input type="hidden" name="role_id" value="<?php echo $data['role_id']; ?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">角色名：</td>
                <td>
                    <input  type="text" name="role_name" value="<?php echo $data['role_name']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">权限列表：</td>
                <td>
                <?php foreach ($priData as $k => $v): if(strpos(','.$pri_id.',',','.$v['pri_id'].',') !== false) $check = 'checked="checked"'; else $check = ''; ?>
                <?php echo str_repeat('-',$v['level']*8); ?>
                    <input <?php echo ($check); ?> level="<?php echo ($v['level']); ?>" type="checkbox" name="pri_id[]" value="<?php echo ($v["pri_id"]); ?>" /><?php echo ($v["pri_name"]); ?><br />
                <?php endforeach; ?>
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
$(":checkbox").click(function(){
//先取出权限的level值是多少
var cur_level = $(this).attr("level");
    //判断是选中还是取消
    if($(this).attr("checked"))
    {
        var tmplevel = cur_level; //给一个临时变量后面要进行-操作
        //先取出这个复选框所有前面的复选框
        var allprev = $(this).prevAll(":checkbox");
        //循环每一个前面的复选框判断是不是上级的
        $(allprev).each(function(k,v){
            //判断是不是上级的权限
            if($(v).attr("level")< tmplevel)
            {
                tmplevel--; //向上提一级
                $(v).attr("checked","checked");
            }
        });
        //所有子权限也选中
        //先取出这个复选框所有前面的复选框
        var allprev = $(this).nextAll(":checkbox");
        //循环每一个前面的复选框判断是不是上级的
        $(allprev).each(function(k,v){
            //判断是不是上级权限
            if($(v).attr("level") > cur_level)
                $(v).attr("checked","checked");
            else
                return false; //遇到一个平级就不判断了
        });

    }else{
        //先取出这个复选框所有前面的复选框
        var allprev = $(this).nextAll(":checkbox");
        //循环每一个前面的复选框判断是不是上级的
        $(allprev).each(function(k,v){
            //判断是不是上级
            if($(v).attr("level") > cur_level)
                $(v).removeAttr("checked");
            else
                return false; 
        });
    }
}
    );
</script>
<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/js/tron.js"></script>