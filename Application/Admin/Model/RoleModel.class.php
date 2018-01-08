<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model 
{
	protected $insertFields = array('role_name');
	protected $updateFields = array('role_id','role_name');
	protected $_validate = array(
		array('role_name', 'require', '角色名不能为空！', 1, 'regex', 3),
		array('role_name', '1,30', '角色名的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('role_name','','角色名称已经存在!',1,'unique',3),
	);
	public function search($pageSize = 3)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		/*select a.*,GROUP_CONCAT(c.pri_name) pri_name from jd_role a 
		left join jd_role_privilege b on a.role_id = b.role_id 
		left join jd_privilege c on c.pri_id = b.pri_id group by a.role_id*/
		$data['data'] = $this->field('a.*,GROUP_CONCAT(c.pri_name) pri_name')->alias('a')->join('left join jd_role_privilege b on a.role_id = b.role_id 
		left join jd_privilege c on c.pri_id = b.pri_id')->where($where)->group('a.role_id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{

	}
	//添加后
	protected function _after_insert(&$data,$option){
		$priId = I('post.pri_id');
		if($priId)
		{
			$rpmodel = M('role_privilege');
			foreach ($priId as $k => $v) {
				$rpmodel->add(array(
					'pri_id' => $v,
					'role_id' => $data['role_id'],
					));
			}
		}
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
		$rpmodel = M('role_privilege');
		$rpmodel->where(array('role_id' => array('eq',$option['where']['role_id'])))->delete();
		//接收表单重新添加一遍
		$priId = I('post.pri_id');
		if($priId){
			foreach ($priId as $k => $v) {
				$rpmodel->add(array(
					'pri_id' => $v,
					'role_id' => $option['where']['role_id'],
					));
			}
		}
	}	
	// 删除前
	protected function _before_delete($option)
	{
		//先判断是否有管理员属于这个角色-读管理员角色表
		$armodel = M('admin_role');
		$has = $armodel->where(array('role_id' => array('eq',$option['where']['role_id'])))->count();
		if($has > 0 ){
			$this->error = "有管理员属于这个角色";
			return false;
		}

		//把角色所有的权限信息咔嚓了
		$rpmodel = M('role_privilege');
		$rpmodel->where(array('role_id' => array('eq',$option['where']['role_id'])))->delete();
	}
	/************************************ 其他方法 ********************************************/
}