<?php
return array(
	'tableName' => 'jd_member_level',    // 表名
	'tableCnName' => '会员级别',  // 表的中文名
	'moduleName' => 'Admin',  // 代码生成到的模块
	'digui' => 0,             // 是否无限级（递归）
	'diguiName' => '',        // 递归时用来显示的字段的名字，如cat_name（分类名称）
	'pk' => 'level_id',    // 表中主键字段名称
	'topPriName' => '会员管理',
	/********************* 要生成的模型文件中的代码 ******************************/
	'insertFields' => "array('level_name','bottom_num','top_num','rate')",
	'updateFields' => "array('level_id','level_name','bottom_num','top_num','rate')",
	'validate' => "
		array('level_name', 'require', '级别名称不能为空！', 1, 'regex', 3),
		array('level_name', '1,32', '级别名称的值最长不能超过 32 个字符！', 1, 'length', 3),
		array('bottom_num', 'require', '积分下限不能为空！', 1, 'regex', 3),
		array('bottom_num', 'number', '积分下限必须是一个整数！', 1, 'regex', 3),
		array('top_num', 'require', '积分上限不能为空！', 1, 'regex', 3),
		array('top_num', 'number', '积分上限必须是一个整数！', 1, 'regex', 3),
		array('rate', 'number', '折扣率，以百分比，如：9折=90必须是一个整数！', 2, 'regex', 3),
	",
	/********************** 表中每个字段信息的配置 ****************************/
	'fields' => array(
		'level_name' => array(
			'text' => '级别名称',
			'type' => 'text',
			'default' => '',
		),
		'bottom_num' => array(
			'text' => '积分下限',
			'type' => 'text',
			'default' => '',
		),
		'top_num' => array(
			'text' => '积分上限',
			'type' => 'text',
			'default' => '',
		),
		'rate' => array(
			'text' => '折扣率，以百分比，如：9折=90',
			'type' => 'text',
			'default' => '100',
		),
	),
);