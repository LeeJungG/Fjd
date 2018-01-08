<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>*商品列表*</title>
</head>
<body>
<h2>商品列表</h2>
<form >
	<h4>搜索</h4>
	<!-- 因为分页也是用get传参数 所以在搜索时也会一起传过来 这样 要在搜索时重新给分页一个参数使它从首页开始搜索 --><input type="hidden" name="p" value="1">
	商品名称:<input type="text" name="goods_name" value="<?php echo I('get.goods_name'); ?>"><br/>
	价	  格:<input type="text" name="start_price" value="<?php echo I('get.start_price'); ?>">-<input type="text
	" name="end_price" value="<?php echo I('get.end_price'); ?>"><br/>
	状态是否上架:<input type="radio" name="is_on_sale" value="-1"<?php if(I('get.is_on_sale',-1) == -1) echo 'checked="checked"' ?> />全部--
	<input type="radio" name="is_on_sale" value="1" <?php if(I('get.is_on_sale',-1) == 1) echo 'checked="checked"'?> />上架--
	<input type="radio" name="is_on_sale" value="0" <?php if(I('get.is_on_sale',-1) == 0) echo 'checked="checked"' ?>/>下架<br/>
	是否已经删除:<input type="radio" name="is_delete" value="-1" <?php if(I('get.is_delete',-1) == -1) echo 'checked="checked"' ?>/>全部--
	<input type="radio" name="is_delete" value="0" <?php if(I('get.is_delete',-1) == 0) echo 'checked="checked"' ?>/>未删除--
	<input type="radio" name="is_delete" value="1" <?php if(I('get.is_delete',-1) == 1) echo 'checked="checked"' ?>/>已删除<br/><br/>
		<input type="submit" value="搜索">
	<h4>排序方式</h4>
	时间排序:<input onclick="parentNode.submit()" type="radio" name="odbr" value="id_asc" <?php if( I('get.odbr','id_asc') == 'id_asc') echo 'checked="checked"' ?> />S
	<input onclick="parentNode.submit()" type="radio" name="odbr" value="id_desc" <?php if(I('get.odbr') == 'id_desc') echo 'checked="checked"' ?>/>J------
	价格排序:<input onclick="parentNode.submit()" type="radio" name="odbr" value="price_asc" <?php if(I('get.odbr') == 'price_asc') echo 'checked="checked"' ?>/>Js
	<input onclick="parentNode.submit()" type="radio" name="odbr" value="price_desc" <?php if(I('get.odbr') == 'price_desc') echo 'checked="checked"' ?>/>Jj


</form>
<table border="1">
	<tr>
		<td>商品名称</td>
		<td>商品Logo</td>
		<td>商品库存</td>
		<td>商品价格</td>
		<td>商品详情</td>
		<td>状态</td>
		<td>添加时间</td>
	</tr>
<?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$G): $mod = ($i % 2 );++$i;?><tr>
		<td><?php echo ($G['goods_name']); ?></td>
		<td><?php echo ($G['goods_logo']); ?></td>
		<td><?php echo ($G['goods_number']); ?></td>
		<td><?php echo ($G['goods_price']); ?></td>
		<td><?php echo ($G['goods_desc']); ?></td>
		<?php if($G['is_on_sale'] == 1): ?><td>上架</td>
		<?php else: ?>
		<td>下架</td><?php endif; ?>
		<td><?php echo date("Y-m-d H:i:s",$G['addtime']); ?></td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<?php echo ($page); ?>
</body>
</html>