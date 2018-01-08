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
    <form name="main_form" method="POST" action="/index.php/Admin/Goods/add.html" enctype="multipart/form-data">
      <table class="table_content" cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">商品名称：</td>
                <td>
                    <input size="60" type="text" name="goods_name" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">主分类：</td>
                <td>
                    <select name="cat_id">
                        <option value="0">-请选择-</option>
                        <?php foreach ($cat as $k => $v): ?>
                            <option value="<?php echo ($v['cat_id']); ?>"><?php echo str_repeat('-',$v['level']*8); echo ($v["cat_name"]); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">扩展分类：</td>
                <td>
                <input onclick="$(this).parent().append($(this).next('select').clone());" type='button' value="添加" />
                    <select name="exi_cat_id[]">
                        <option value="0">-请选择-</option>
                        <?php foreach ($cat as $k => $v): ?>
                            <option value="<?php echo ($v['cat_id']); ?>"><?php echo str_repeat('-',$v['level']*8); echo ($v["cat_name"]); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">品牌：</td>
                <td>
                    <select name="brand_id">
                        <option value="0">-请选择-</option>
                        <?php foreach ($brand as $k => $v): ?>
                            <option value="<?php echo ($v['brand_id']); ?>"><?php echo ($v["brand_name"]); ?></option>
                        <?php endforeach; ?>
                     </select>
                </td>
            </tr>
            <tr>
                <td class="label">市场价：</td>
                <td>
                    <input  type="text" name="market_price" value="0.00" />
                </td>
            </tr>
            <tr>
                <td class="label">本店价：</td>
                <td>
                    <input  type="text" name="jd_price" value="0.00" />
                </td>
            </tr>
            <tr>
                <td class="label">赠送积分：</td>
                <td>
                    <input  type="text" name="jifen" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">赠送经验值：</td>
                <td>
                    <input  type="text" name="jyz" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">如果要用积分兑换，需要的积分数：</td>
                <td>
                    <input  type="text" name="jifen_price" value="" />
                </td>
            </tr>
            <tr>
                <td class="label"><input type="checkbox" name="is_promote" value="1" onclick="if($(this).attr('checked')) $('.promote_price').removeAttr('disabled');else $('.promote_price').attr('disabled','disabled');"  />促销价：</td>
                <td>
                    <input disabled="disabled" type="text" name="promote_price"class="promote_price" />
                </td>
            </tr>
            <tr>
                <td class="label">促销开始时间：</td>
                <td>
                    <input class="promote_price" disabled="disabled" id="promote_start_time" type="text" name="promote_start_time"/>
                </td>
            </tr>
            <tr>
                <td class="label">促销结束时间：</td>
                <td>
                    <input class="promote_price" disabled="disabled" id="promote_end_time" type="text" name="promote_end_time" />
                </td>
            </tr>
            <tr>
                <td class="label">logo原图：</td>
                <td>
                	<input type="file" name="logo" /> 
                </td>
            </tr>
            <tr>
                <td class="label">是否热卖：</td>
                <td>
                	<input type="radio" name="is_hot" value="1"  />是 
                	<input type="radio" name="is_hot" value="0" checked="checked" />否 
                </td>
            </tr>
            <tr>
                <td class="label">是否新品：</td>
                <td>
                	<input type="radio" name="is_new" value="1"  />是 
                	<input type="radio" name="is_new" value="0" checked="checked" />否 
                </td>
            </tr>
            <tr>
                <td class="label">是否精品：</td>
                <td>
                	<input type="radio" name="is_best" value="1"  />是 
                	<input type="radio" name="is_best" value="0" checked="checked" />否 
                </td>
            </tr>
            <tr>
                <td class="label">是否上架：1：上架，0：下架：</td>
                <td>
                	<input type="radio" name="is_on_sale" value="1" checked="checked" />上架 
                	<input type="radio" name="is_on_sale" value="0"  />下架 
                </td>
            </tr>
            <tr>
                <td class="label">seo优化[搜索引擎【百度、谷歌等】优化]_关键字：</td>
                <td>
                    <input  size="60" type="text" name="seo_keyword" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">seo优化[搜索引擎【百度、谷歌等】优化]_描述：</td>
                <td>
                    <input size="60" type="text" name="seo_description" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">排序数字：</td>
                <td>
                    <input  type="text" name="sort_num" value="100" />
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
        <!-- 描述 -->
        <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">         <tr>
                <td>
                    <textarea id="goods_desc" name="goods_desc"></textarea>
                </td>   
            </tr>

        </table>
        <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
            <tr>
            <td style="font-size:18px;font-weight:bold;">会员价格（如果没有填会员价格就按折扣率计算价格，如果填了就按填的价格算，不再打折）</td>
            </tr>
            <?php foreach ($level as $k => $v): ?>
                <tr>
                    <td>
                        <?php echo ($v["level_name"]); ?>(<?php echo $v['rate']/10; ?>折)<input type='text' size="10" name="rate[<?php echo ($v["level_id"]); ?>]" />
                    </td> 
                </tr>
            <?php endforeach; ?>
            
        </table>
        <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
            <tr>
                <td>
                <select name="type_id">
                <option value="0">-请选择-</option>
                <?php foreach($type as $k => $v): ?>
                    <option value="<?php echo ($v['type_id']); ?>"><?php echo ($v["type_name"]); ?></option>
                <?php endforeach;?>
                </select>    
                </td>
            </tr>
            <tr>
                <td id="attr_container"></td>
            </tr>
        </table>
        <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
            <tr>
                <td>
                    <input onclick="$(this).parent().append('<tr><td><input type=\'file\' name=\'pics[]\' /></td></tr>');" type='button' value="添加一张图片">    
                </td>
            </tr>
        </table>
    </form>
    </div>
</div>
<script>
// 点击按钮切换table
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
$("#promote_start_time").datepicker(); 
$("#promote_end_time").datepicker(); 
UE.getEditor('goods_desc', {
	"initialFrameWidth" : "100%",   // 宽
	"initialFrameHeight" : 600,      // 高
	"maximumWords" : 10000            // 最大可以输入的字符数量
});

//当选择类型时执行AJAX取出类型的属性
$("select[name=type_id]").change(function(){
    //获取选中的类型id
    var type_id = $(this).val();

    if(type_id != 0)
    {
        $.ajax({
            type : "GET",
            url : "<?php echo U('ajaxGetAttr','',false);?>/type_id/"+type_id,
            dataType : "json",
            success : function(data){
                var html = "";
                //循环服务器返回的属性的json数据
                $(data).each(function(k,v){
                    html += "<p>";
                    html += v.attr_name + ":";
                    //1.如果属性是可选就有一个+号
                    //2.如果属性有可选值就是一个下拉列表
                    //3.如果属性是唯一就生成一个text
                    if(v.attr_type == 1)
                        html += "<a onclick='addnew(this);' href='javascript:void(0);'>[+]</a>";

                    //判断是否有可选值
                    if(v.attr_option_values == ""){
                        html += "<input type='text' name='ga["+v.attr_id+"][]' />";
                    }
                    else
                    {

                        //先把可选值转化成数组
                        var _attr = v.attr_option_values.split(",");
                        html += "<select name='ga["+v.attr_id+"][]'>";
                        html += "<option value=''>请选择</option>";
                        //循环每个可选值构造option
                        for(var i=0; i<_attr.length; i++)
                        {
                            html +="<option value='"+_attr[i]+"'>"+_attr[i]+"</option>";
                        }
                        html +="</select>";
                    }
                    if(v.attr_type == 1)
                        html +="属性价格:￥<input size='8' name='attr_price["+v.attr_id+"][]' type='text' />元";
                    html += "</p>";

                });
                $("#attr_container").html(html);
                
            }
        });
    }
    else
        $("#attr_container").html("");
});

function addnew(a){
    //选中a标签所在的p标签
    var p = $(a).parent();
    //需要判断 选获取a标签的内容
    if($(a).html() == "[+]")
    {
        //把p克隆一份
        var newp = p.clone();
        //把克隆出来的p里面的a标签变成 - 号
        newp.find("a").html("[-]");
        //放在后面
        p.after(newp);
    }else
    p.remove();
}
</script>
<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/js/tron.js"></script>