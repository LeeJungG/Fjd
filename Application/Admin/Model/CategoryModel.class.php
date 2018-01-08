<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model 
{
	protected $insertFields = array('cat_name','parent_id');
	protected $updateFields = array('cat_id','cat_name','parent_id');
	protected $_validate = array(
		array('cat_name', 'require', '分类名称不能为空！', 1, 'regex', 3),
		array('cat_name', '1,32', '分类名称的值最长不能超过 32 个字符！', 1, 'length', 3),
		array('parent_id', 'require', '上级分类的ID，0：代表顶级不能为空！', 1, 'regex', 3),
		array('parent_id', 'number', '上级分类的ID，0：代表顶级必须是一个整数！', 1, 'regex', 3),
	);
	/************************************* 递归相关方法 *************************************/
	public function getTree()
	{
		$data = $this->select();
		return $this->_reSort($data);
	}
	private function _reSort($data, $parent_id=0, $level=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$v['level'] = $level;
				$ret[] = $v;
				$this->_reSort($data, $v['cat_id'], $level+1, FALSE);
			}
		}
		return $ret;
	}
	public function getChildren($cat_id)
	{
		$data = $this->select();
		return $this->_children($data, $cat_id);
	}
	private function _children($data, $parent_id=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$ret[] = $v['cat_id'];
				$this->_children($data, $v['cat_id'], FALSE);
			}
		}
		return $ret;
	}
	/************************************ 其他方法 ********************************************/
	public function _before_delete($option)
	{
		// 先找出所有的子分类
		$children = $this->getChildren($option['where']['cat_id']);
		// 如果有子分类都删除掉
		if($children)
		{
			$children = implode(',', $children);
			$this->execute("DELETE FROM jd_category WHERE cat_id IN($children)");
		}
	}

	/******************************* 前台:分类 *********************************/
	public function getNavCatData(){
		$data = array();
		 $cat = $this->select();
		 foreach($cat as $k => $v)
		 {
		 	if($v['parent_id'] == 0)
		 	{
		 		foreach ($cat as $k1 => $v1) {
		 			if($v1['parent_id'] == $v['cat_id'])
		 			{
		 				foreach ($cat as $k2 => $v2) {
		 					if($v2['parent_id'] == $v1['cat_id'])
		 					{
		 						$v1['children'][] = $v2;
		 					}
		 				}
		 				$v['children'][] = $v1;
		 			}
		 		}
		 		$data[] = $v;
		 	}
		 }
		 return $data;
	}

public function _before_insert(&$data,$option)
{
	$attrId = I('post.attr_id');
	//循环把没有选择的属性删除
	foreach ($attrId as $k => $v) {
		if(empty($v))
			unset($attrId[$k]);
	}
	if($attrId)
		$data['search_attr_id'] = implode(',',$attrId);
}
public function _before_update(&$data,$option)
{
	$attrId = I('post.attr_id');
	//循环把没有选择的属性删除
	foreach ($attrId as $k => $v) {
		if(empty($v))
			unset($attrId[$k]);
	}
	if($attrId)
		$data['search_attr_id'] = (string)implode(',',$attrId);
}
	
}