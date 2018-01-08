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
    <form name="main_form" method="POST" action="/index.php/Admin/Category/add.html" enctype="multipart/form-data">
        <table cellspacing="1" cellpadding="3" width="100%">
			<tr>
				<td class="label">上级权限：</td>
				<td>
					<select name="parent_id">
						<option value="0">顶级权限</option>
						<?php foreach ($parentData as $k => $v): ?>						<option value="<?php echo $v['cat_id']; ?>"><?php echo str_repeat('-', 8*$v['level']).$v['cat_name']; ?></option>
						<?php endforeach; ?>					</select>
				</td>
			</tr>
            <tr>
                <td class="label">分类名称：</td>
                <td>
                    <input  type="text" name="cat_name" value="" />
                </td>
            </tr>
                <tr>
                <td class="label">筛选属性：</td>
                <td>
                    <ul>
                        <li>
                        <a href="javascript:void(0);" onclick="addNed(this);">[+]</a>
                            <select name="type_id[]">
                                <option value="">-请选择类型-</option>
                                <?php foreach ($type as $k => $v):?>
                                <option value="<?php echo ($v["type_id"]); ?>"><?php echo ($v["type_name"]); ?></option>
                                <?php endforeach;?>
                            </select>

                            <select name="attr_id[]">
                                <option>-请选择属性-</option>
                            </select>
                        </li>
                    </ul>
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
$("select[name='type_id[]']").change(function(){

    var _this = $(this);
    var typeid = $(this).val();
    var opt = "<option value=''>选择属性</option>";
    if(typeid != "")
    {
        $.ajax({
            type : "GET",
            url : "<?php echo U('Admin/Goods/ajaxGetAttr','',false);?>/type_id/"+typeid,
            dataType : "json",
            success : function(data)
            {
                $(data).each(function(k,v){
                    opt += "<option value='"+v.attr_id+"'>"+v.attr_name+"</option>";
                });
                _this.next("select").html(opt);
            }
        });
    }else
    _this.next("select").html(opt);
});

function addNed(a)
{
    var li = $(a).parent();
    if($(a).html() == "[+]")
    {
        var newbel = li.clone(true);
        newbel.find("a").html("[-]");
        li.after(newbel);

    }else
    li.remove();
}
</script>
<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/js/tron.js"></script>