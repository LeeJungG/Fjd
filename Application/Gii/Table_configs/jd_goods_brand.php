<?php
return array(
	'tableName' => 'jd_goods_brand',    // 表名
	'tableCnName' => '商品品牌',  // 表的中文名
	'moduleName' => 'Admin',  // 代码生成到的模块
	'digui' => 0,             // 是否无限级（递归）
	'diguiName' => '',        // 递归时用来显示的字段的名字，如cat_name（分类名称）
	'pk' => 'brand_id',    // 表中主键字段名称
	'topPriName' => '商品管理',
	/********************* 要生成的模型文件中的代码 ******************************/
	'insertFields' => "array('brand_name','brand_url')",
	'updateFields' => "array('brand_id','brand_name','brand_url')",
	'validate' => "
		array('brand_name', 'require', '品牌名称不能为空！', 1, 'regex', 3),
		array('brand_name', '1,45', '品牌名称的值最长不能超过 45 个字符！', 1, 'length', 3),
		array('brand_url', '1,150', '品牌官网的值最长不能超过 150 个字符！', 2, 'length', 3),
	",
	/********************** 表中每个字段信息的配置 ****************************/
	'fields' => array(
		'brand_name' => array(
			'text' => '品牌名称',
			'type' => 'text',
			'default' => '',
		),
		'brand_url' => array(
			'text' => '品牌官网',
			'type' => 'text',
			'default' => '',
		),
		'brand_logo' => array(
			'text' => '品牌logo',
			'type' => 'file',
			'save_fields' => array('brand_logo'),
			'default' => '',
		),
	),
	/**************** 搜索字段的配置 **********************/
	'search' => array(
		array('brand_name', 'normal', '', 'like', '品牌名称'),
	),
);