<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model 
{
	protected $insertFields = array('admin_name','admin_password','admin_password2','is_use','chkcode');
	protected $updateFields = array('admin_id','admin_name','admin_password','role_id','is_use');
	protected $_validate = array(
		array('admin_name', 'require', '用户名不能为空！', 1, 'regex', 3),
		array('admin_name','','用户名已存在',1,'unique',3),
		array('admin_name', '1,30', '账号的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('admin_password', 'require', '密码不能为空！', 1, 'regex', 1),
		array('admin_password', '1,50', '密码的值最长不能超过 50 个字符！', 1, 'length', 1),
		array('admin_password2','admin_password','两次密码输入不一致',1,'confirm',1),
		array('is_use', 'number', '是否启用 1:启用0:禁用必须是一个整数！', 2, 'regex', 3),
	);

		//表单验证规则
	public $_login_validate = array(
		array('admin_name','require','用户名不能为空',1),
		array('admin_password','require','密码不能为空',1),
		array('chkcode','require','验证码不能为空',1),
		array('chkcode','chk_chkcode','验证码不正确',1,'callback'),
		);

	public function chk_chkcode($code){
		$verify =new \Think\Verify();
		return $verify->check($code);
	}

	//调用此方法来完成用户验证
	public function login(){
		//获取表单
		$admin_name = $this->admin_name;
		$admin_password = $this->admin_password;

		//先验证用户名
		$infot = $this->where(
			array('admin_name' => array('eq',$admin_name))
			)->find();
		if($infot){
			//再验证是否启用
			if($infot['is_use'] == 1){
				//再验证密码
				if($infot['admin_password'] == md5($admin_password.C('MD5_KEY'))){
					//成功把用户名 id 存session里
					session('admin_id',$infot['admin_id']);
					session('admin_name',$infot['admin_name']);
					return true;
				}else{
					$this->error = '密码错误!!!';
					return false;
				}
			}else{
				$this->error = '用户账号未启用!!!';
				return false;
			}
		}else{
			$this->error = '用户名不存在!!!';
			return false;
		}


	}

	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($admin_name = I('get.admin_name'))
			$where['admin_name'] = array('like', "%$admin_name%");
		$is_use = I('get.is_use');
		if($is_use != '' && $is_use != '-1')
			$where['is_use'] = array('eq', $is_use);
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')->where($where)->group('a.admin_id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
		$data['admin_password'] = md5($data['admin_password'].C('MD5_KEY'));
	}
	protected function _after_insert($data,$option)
	{
		$role_id=I('post.role_id');
		if($role_id){
			$armodel = M('admin_role');
			foreach ($role_id as $k => $v) {
				$armodel->add(array(
					'role_id' => $v,
					'admin_id' => $data['admin_id'],
					));
			}
		}
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
		if($option['where']['admin_id'] == 1)
			$data['is_use'] = 1;
		

		$role_id = I('post.role_id');

		$armodel = M('admin_role');
		$armodel->where(array('admin_id' => array('eq',$option['where']['admin_id'])))->delete();
		if($role_id)
		{	
			foreach ($role_id as $v) {
				$armodel->add(array(
					'role_id' => $v,
				'admin_id' => $option['where']['admin_id'],
				));				
			}


		}

		if(empty($data['admin_password']))
			unset($data['admin_password']);
		else
			$data['admin_password'] = md5($data['admin_password'].C('MD5_KEY'));
	}
	// 删除前
	protected function _before_delete($option)
	{
		if($option['where']['admin_id'] == 1){
			$this->error = '超级管理员不能被删除!';
			return false;
		}
		$armodel = M('admin_role');
		$armodel->where(array('admin_id' => array('eq',$option['where']['admin_id'])))->delete();
	}
	/************************************ 其他方法 ********************************************/
}