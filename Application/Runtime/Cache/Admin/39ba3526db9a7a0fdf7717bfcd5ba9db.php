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

<!-- 搜索 -->
<div class="form-div search_form_div">
    <form method="GET" name="search_form">
		<p>
			商品名称：
	   		<input type="text" name="goods_name" size="30" value="<?php echo I('get.goods_name'); ?>" />
		</p>
		<p>
			主分类的id：
	   		<input type="text" name="cat_id" size="30" value="<?php echo I('get.cat_id'); ?>" />
		</p>
		<p>
			品牌的id：
	   		<input type="text" name="brand_id" size="30" value="<?php echo I('get.brand_id'); ?>" />
		</p>
		<p>
			本店价：
	   		从 <input id="jd_pricefrom" type="text" name="jd_pricefrom" size="15" value="<?php echo I('get.jd_pricefrom'); ?>" /> 
		    到 <input id="jd_priceto" type="text" name="jd_priceto" size="15" value="<?php echo I('get.jd_priceto'); ?>" />
		</p>
		<p>
			是否热卖：
	   		<input type="text" name="is_hot" size="30" value="<?php echo I('get.is_hot'); ?>" />
		</p>
		<p>
			是否新品：
	   		<input type="text" name="is_new" size="30" value="<?php echo I('get.is_new'); ?>" />
		</p>
		<p>
			是否精品：
	   		<input type="text" name="is_best" size="30" value="<?php echo I('get.is_best'); ?>" />
		</p>
		<p>
			是否上架：1：上架，0：下架：
	   		<input type="text" name="is_on_sale" size="30" value="<?php echo I('get.is_on_sale'); ?>" />
		</p>
		<p>
			商品类型id：
	   		<input type="text" name="type_id" size="30" value="<?php echo I('get.type_id'); ?>" />
		</p>
		<p>
			添加时间：
	   		<input type="text" name="addtime" size="30" value="<?php echo I('get.addtime'); ?>" />
		</p>
		<p><input type="submit" value=" 搜索 " class="button" /></p>
    </form>
</div>
<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th >商品名称</th>
            <th >主分类的id</th>
            <th >品牌的id</th>
            <th >市场价</th>
            <th >本店价</th>


            <th >logo原图</th>
            <th >是否热卖</th>
            <th >是否新品</th>
            <th >是否精品</th>
            <th >是否上架：1：上架，0：下架</th>

            <th >商品类型id</th>
            <th >排序数字</th>
            <th >商品描述</th>
			<th >操作</th>
        </tr>
		<?php foreach ($data as $k => $v): ?>            
			<tr class="tron">
				<td><?php echo $v['goods_name']; ?></td>
				<td><?php echo $v['cat_id']; ?></td>
				<td><?php echo $v['brand_id']; ?></td>
				<td><?php echo $v['market_price']; ?></td>
				<td><?php echo $v['jd_price']; ?></td>


				<td align="center"><?php showImage($v['logo'], 100);?></td>
				<td><?php echo $v['is_hot']; ?></td>
				<td><?php echo $v['is_new']; ?></td>
				<td><?php echo $v['is_best']; ?></td>
				<td><?php echo $v['is_on_sale']; ?></td>

				<td><?php echo $v['type_id']; ?></td>
				<td><?php echo $v['sort_num']; ?></td>
				<td><?php echo $v['goods_desc']; ?></td>
		        <td align="center">
		        	<a href="<?php echo U('restore?goods_id='.$v['goods_id'].'&p='.I('get.p')); ?>" title="复原">复原</a> |
	                <a href="<?php echo U('delete?goods_id='.$v['goods_id'].'&p='.I('get.p')); ?>" onclick="return confirm('确定要删除吗？');" title="删除">删除</a> 
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