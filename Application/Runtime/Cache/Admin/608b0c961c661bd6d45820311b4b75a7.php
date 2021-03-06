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

<style type="text/css">
ul.prcs_url li{list-style-type:none; float:left;margin:5px; height:180px;}
</style>
<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front">基本信息</span>
            <span class="tab-back">商品描述</span>
            <span class="tab-back">会员价格</span>
            <span class="tab-back">商品属性</span>
            <span class="tab-back">商品相册</span>
        </p>
    </div>
<div class="main-div">
    <form name="main_form" method="POST" action="/index.php/Admin/Goods/edit/goods_id/16/p/1.html" enctype="multipart/form-data" >
        <input type='hidden' name="oltype_id" value="<?php echo ($data["type_id"]); ?>">
    	<input type="hidden" name="goods_id" value="<?php echo $data['goods_id']; ?>" />
		<input type="hidden" name="old_logo" value="<?php echo $data['logo']; ?>" />
		<input type="hidden" name="old_sm_logo" value="<?php echo $data['sm_logo']; ?>" />
        <table class="table_content" cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">商品名称：</td>
                <td>
                    <input  type="text" name="goods_name" value="<?php echo $data['goods_name']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">主分类：</td>
                <td>
                    <select name="cat_id">
                        <option value="">-请选择-</option>
                        <?php foreach ($cat as $k => $v): if($v['cat_id'] == $data['cat_id']) $select = 'selected="selected"'; else $select = ''; ?>
                            <option <?php echo ($select); ?> value="<?php echo ($v["cat_id"]); ?>"><?php echo str_repeat('-',$v['level']*8); echo ($v["cat_name"]); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">扩展分类：</td>
                <td>
                <input type="button" onclick="$(this).parent().append($(this).next('select').clone());" value="添加" />
                <?php if($gcat == null): ?>
                   <select name="god_cat_id[]">
                        <option value="0">-请选择-</option>
                        <?php foreach ($cat as $k => $v): ?>
                            <option value="<?php echo ($v['cat_id']); ?>"><?php echo str_repeat('-',$v['level']*8); echo ($v["cat_name"]); ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                <?php foreach ($gcat as $k1 => $v1): ?>
                    <select name="god_cat_id[]">
                        <option value="">-请选择-</option>
                        <?php foreach ($cat as $k => $v): if($v['cat_id'] == $v1['cat_id']) $select = 'selected="selected"'; else $select = ''; ?>
                            <option <?php echo ($select); ?> value="<?php echo ($v["cat_id"]); ?>"><?php echo str_repeat('-',$v['level']*8); echo ($v["cat_name"]); ?></option>
                        <?php endforeach;?>
                    </select>
                <?php endforeach; ?>
            <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="label">品牌：</td>
                <td>
                    <select name="brand_id">
                        <option value="">-请选择-</option>
                        <?php foreach ($brand as $k => $v): if($v['brand_id'] == $data['brand_id']) $select = 'selected="selected"'; else $select = ''; ?>
                            <option <?php echo ($select); ?> value="<?php echo ($v["brand_id"]); ?>"><?php echo ($v["brand_name"]); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">市场价：</td>
                <td>
                    <input  type="text" name="market_price" value="<?php echo $data['market_price']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">本店价：</td>
                <td>
                    <input  type="text" name="jd_price" value="<?php echo $data['jd_price']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">赠送积分：</td>
                <td>
                    <input  type="text" name="jifen" value="<?php echo $data['jifen']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">赠送经验值：</td>
                <td>
                    <input  type="text" name="jyz" value="<?php echo $data['jyz']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">如果要用积分兑换，需要的积分数：</td>
                <td>
                    <input  type="text" name="jifen_price" value="<?php echo $data['jifen_price']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label"><input <?php if($data['is_promote'] == 1) echo 'checked="checked"'; ?> type="checkbox" name="is_promote" value="1" onclick="if($(this).attr('checked')) $('.promote_price').removeAttr('disabled');else $('.promote_price').attr('disabled','disabled');"  />促销价：</td>
                <td>
                    <input <?php if($data['is_promote'] == 0) echo 'disabled="disabled"'; ?> type="text" name="promote_price"class="promote_price" value="<?php echo ($data["promote_price"]); ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">促销开始时间：</td>
                <td>
                    <input <?php if($data['is_promote'] == 0) echo 'disabled="disabled"'; ?> class="promote_price" id="promote_start_time" type="text" name="promote_start_time"
                    value="<?php if($data['promote_start_time'] != 0) echo date('Y-m-d',$data['promote_start_time']); ?>"/>
                </td>
            </tr>
            <tr>
                <td class="label">促销结束时间：</td>
                <td>
                    <input <?php if($data['is_promote'] == 0) echo 'disabled="disabled"'; ?> class="promote_price"  id="promote_end_time" type="text" name="promote_end_time" value="<?php if($data['promote_end_time'] != 0) echo date('Y-m-d',$data['promote_end_time']); ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">logo原图：</td>
                <td>
                	<input type="file" name="logo" /><br /> 

                	<?php if(!empty($data['logo'])) showImage($data['logo'], 100); ?>                </td>
            </tr>
            <tr>
                <td class="label">是否热卖：</td>
                <td>
                	<input type="radio" name="is_hot" value="1" <?php if($data['is_hot'] == '1') echo 'checked="checked"'; ?> />是 
                	<input type="radio" name="is_hot" value="0" <?php if($data['is_hot'] == '0') echo 'checked="checked"'; ?> />否 
                </td>
            </tr>
            <tr>
                <td class="label">是否新品：</td>
                <td>
                	<input type="radio" name="is_new" value="1" <?php if($data['is_new'] == '1') echo 'checked="checked"'; ?> />是 
                	<input type="radio" name="is_new" value="0" <?php if($data['is_new'] == '0') echo 'checked="checked"'; ?> />否 
                </td>
            </tr>
            <tr>
                <td class="label">是否精品：</td>
                <td>
                	<input type="radio" name="is_best" value="1" <?php if($data['is_best'] == '1') echo 'checked="checked"'; ?> />是 
                	<input type="radio" name="is_best" value="0" <?php if($data['is_best'] == '0') echo 'checked="checked"'; ?> />否 
                </td>
            </tr>
            <tr>
                <td class="label">是否上架：1：上架，0：下架：</td>
                <td>
                	<input type="radio" name="is_on_sale" value="1" <?php if($data['is_on_sale'] == '1') echo 'checked="checked"'; ?> />上架 
                	<input type="radio" name="is_on_sale" value="0" <?php if($data['is_on_sale'] == '0') echo 'checked="checked"'; ?> />下架 
                </td>
            </tr>
            <tr>
                <td class="label">seo优化[搜索引擎【百度、谷歌等】优化]_关键字：</td>
                <td>
                    <input  type="text" name="seo_keyword" value="<?php echo $data['seo_keyword']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">seo优化[搜索引擎【百度、谷歌等】优化]_描述：</td>
                <td>
                    <input  type="text" name="seo_description" value="<?php echo $data['seo_description']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">排序数字：</td>
                <td>
                    <input  type="text" name="sort_num" value="<?php echo $data['sort_num']; ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>

        <table  class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
            <tr>
                <td>
                    <textarea id="goods_desc" name="goods_desc"><?php echo $data['goods_desc']; ?></textarea>
                </td>
            </tr>
        </table>

        <table  class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
            <td style="font-size:18px;font-weight:bold;">会员价格（如果没有填会员价格就按折扣率计算价格，如果填了就按填的价格算，不再打折）</td>
            </tr>
            <?php foreach ($level as $k => $v): ?>
                <tr>
                    <td>
                        <?php echo ($v["level_name"]); ?>(<?php echo $v['rate']/10; ?>折)<input type='text' size="10" name="rate[<?php echo ($v["level_id"]); ?>]" value="<?php echo $price[$v['level_id']]; ?>" />
                    </td> 
                </tr>
            <?php endforeach; ?>
        </table>

<table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
                <tr><td>
                商品类型：<select name="type_id">
                    <option value="">选择类型</option>
                    <?php foreach ($type as $k => $v): if($v['type_id'] == $data['type_id']) $select = 'selected="selected"'; else $select = ''; ?>
                        <option <?php echo ($select); ?> value="<?php echo ($v["type_id"]); ?>"><?php echo ($v["type_name"]); ?></option>
                    <?php endforeach; ?>
                </select>
                </td></tr>
                <tr><td id="attr_container">
                    <?php  $attrId = array(); foreach ($atr as $k => $v): ?>
                    <p>
                        <?php echo $v['attr_name']; ?> ：
                        <?php if($v['attr_type'] == 1): if(in_array($v['attr_id'], $attrId)) $opt = '[-]'; else { $opt = '[+]'; $attrId[] = $v['attr_id']; } ?>
                        <a gaid="<?php echo ($v["goods_a_id"]); ?>" onclick="addnew(this,<?php echo ($v["attr_id"]); ?>);" href="javascript:void(0);"><?php echo ($opt); ?></a>
                        <?php endif; ?>
                        <?php  if(empty($v['attr_value'])) $old_ = ''; else $old_ = 'old_'; if($v['attr_option_values']) { $_arr = explode(',', $v['attr_option_values']); echo '<select name="'.$old_.'ga['.$v['attr_id'].']['.$v['goods_a_id'].']"><option value="">请选择</option>'; foreach ($_arr as $k1 => $v1) { if($v1 == $v['attr_value']) $select = 'selected="selected"'; else $select = ''; echo '<option '.$select.' value="'.$v1.'">'.$v1.'</option>'; } echo '</select>'; } else echo '<input name="'.$old_.'ga['.$v['attr_id'].']['.$v['goods_a_id'].']" type="text" value="'.$v['attr_value'].'" />'; ?>
                        <?php if($v['attr_type'] == 1): ?>
                            ￥ <input name="<?php echo ($old_); ?>ga_pri[<?php echo ($v["attr_id"]); ?>][<?php echo ($v["goods_a_id"]); ?>]" type="text" size="10" value="<?php echo ($v["attr_price"]); ?>" /> 元
                        <?php endif; ?>
                    </p>
                    <?php endforeach; ?>
                </td></tr>
            </table>

        
       <table  class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
            <tr>
                <td>
                    <input onclick="$(this).parent().append('<tr><td><input type=\'file\' name=\'prcs[]\' /></td></tr>');" type='button' value="添加一张图片"/>
                </td>
            </tr>
            <tr>
                <td>
                    <ul class="prcs_url">
                        <?php foreach($prcs as $k => $v):?>
                        <li>
                        <input pic ="<?php echo ($v["prcs_id"]); ?>" class="delm" type='button' value="删除" />
                            <?php showImage($v['prcs_pic'],200,180); ?>
                        </li>
                        <?php endforeach;?>
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
</div>
<script>
$("#promote_start_time").datepicker(); 
$("#promote_end_time").datepicker(); 
UE.getEditor('goods_desc', {
	"initialFrameWidth" : "100%",   // 宽
	"initialFrameHeight" : 600,      // 高
	"maximumWords" : 10000            // 最大可以输入的字符数量
});

$("div#tabbar-div p span").click(function(){
    //获取点击的是第几个按钮
    var i = $(this).index();
    //显示第i个table
    $(".table_content").eq(i).show();
    //点击隐藏第i个table
    $(".table_content").eq(i).siblings().hide();
    //把原来选中的取消选中状态
    $(".tab-front").removeClass("tab-front").addClass("tab-back");
    //切换点击的按钮的样式为选中状态
    $(this).removeClass("tab-back").addClass("tab-front");
 
});

// 当选择类型时执行AJAX取出类型的属性
$("select[name=type_id]").change(function(){
    var type_id = $(this).val();
    if(type_id != "")
    {
        $.ajax({
            type : "GET",
            url : "<?php echo U('ajaxGetAttr','',false); ?>/type_id/"+type_id,
            dataType : 'json',
            success : function (data){
                var html = "";
                $(data).each(function(k,v){
                    html += "<p>";
                    html += v.attr_name + ':';
                    if(v.attr_type == 1)
                        html += "<a onclick='addnew(this,"+v.attr_id+");' href='javascript:void(0);'>[+]</a>";
                    if(v.attr_option_values == "")
                        html += "<input type='text' name='ga["+v.attr_id+"][]' />";
                    else
                    {
                        var _attr = v.attr_option_values.split(',');
                        html += "<select name='ga["+v.attr_id+"][]'>";
                        html += "<option value=''>-请选择-</option>";
                        for (var i = 0; i<_attr.length; i++) {
                            html += "<option value='"+_attr[i]+"'>"+_attr[i]+"</option>";
                        };
                        html += "</select>";
                    }
                    if(v.attr_type == 1)
                        html += "属性价格:￥<input type='text' name='ga_pri["+v.attr_id+"][]' size='8'/>元";
                    html += "</p>";
                });
                $("#attr_container").html(html);
            }
        });
    }else
    $("#attr_container").html("");   
});
 function addnew(a,b)
 {
    // 选中a标签所在的p标签
    var p = $(a).parent();
    // 先获取A标签中的内容
    if($(a).html() == "[+]")
    {
        // 把p克隆一份
        var newP = p.clone();
        // 先取出名称的字符串
        // var oldName = newP.find("select").attr("name");
        // 把名称中的old_去掉
        // var newName = oldName.replace("old_", "");
        
        // 把新的名称设置回去
        newP.find("select").attr("name","ga["+b+"][]");
        // 把属性价格的名称也去掉old_
        // var oldName = newP.find("input").attr("name");
        // var newName = oldName.replace("old_", "");
        newP.find("input").attr("name","ga_pri["+b+"][]");
        // 把克隆出来的P里面的a标签变成-号
        newP.find("a").html("[-]");
        // 放在后面
        p.after(newP);
    }else
    {
        if(confirm("确定要删除吗?"))
        {
            var gaid = $(a).attr('gaid');
        $.get("<?php echo U('ajaxDelattr','',false); ?>/gaid/"+gaid,function(data){
              p.remove();  
        }); 
        }


    }
    
 }
 //删除图片
 $(".delm").click(function(){
    if(confirm("确定要删除吗?"))
    {
     var pic_id = $(this).attr('pic');

    var li = $(this).parent();
    $.ajax({
        type : "GET",
        url : "<?php echo U('ajaxDelImage','',false); ?>/prcs_id/"+pic_id,
        success : function (data)
        {
            li.remove();
        }
    });
    }

 });

 //判断如果现在没有属性就直接触发ajax事件获取属性的信息
 <?php if(empty($atr)): ?>        //事件
$("select[name=type_id]").trigger("change");
<?php endif; ?>
</script>
<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/js/tron.js"></script>