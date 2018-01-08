<?php
namespace Admin\Controller;
use Think\Controller;
//后台首页控制器
class IndexController extends Controller{
	public function setPageBtn($title,$btnName,$btnLink){
		$this->assign('title',$title);
		$this->assign('btnName',$btnName);
		$this->assign('btnLink',$btnLink);

	}

	public function __construct(){
		parent::__construct();
		$adminid = session('admin_id');

		if(!$adminid)
			redirect(U('Admin/Login/login'));
		//验证当前管理员是否有权限访问这个页面
		//1.先获取当前管理员将要访问的页面
		$url = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		//查询数据库判断当前管理员有没有访问这个页面的权限
		$where = 'module_name="'.MODULE_NAME.'" AND controller_name="'.CONTROLLER_NAME.'" AND action_name="'.ACTION_NAME.'"';

		// 任何人只要登录就可以进入后台
		if(CONTROLLER_NAME == 'Index')
			return true;

		if($adminid == 1)
		{
			$sql = 'select count(*) hes from jd_privilege where '.$where;
		}else{
			$sql = 'select count(a.role_id) hes from jd_role_privilege a left join jd_privilege b on a.pri_id=b.pri_id left join jd_admin_role c on a.role_id = c.role_id where c.admin_id ='.$adminid.' AND '.$where;
		}
		$db = M();
		$pri = $db->query($sql);
		if($pri[0]['hes'] < 1)
			$this->error('无权限!!!');
	}

	public function index(){

		$this->display();
	}

	public function main(){
		$this->display();
	}

	public function menu(){
		$admin_id = session('admin_id');
		if($admin_id == 1)
			$sql = "select * from jd_privilege";
		else
			$sql ="select b.* from jd_role_privilege a left join jd_privilege b on a.pri_id=b.pri_id left join jd_admin_role c on c.role_id=a.role_id where c.admin_id =".$admin_id;
		
		$model = M();
		$pri = $model->query($sql);

		foreach ($pri as $k => $v) {
			if($v['parent_id'] == 0){
				foreach ($pri as $k2 => $v2) {
					if($v2['parent_id'] == $v['pri_id']){
						$v['che'][] = $v2;
					}
				}
				$pr[]= $v;
			}
		}
		$this->assign('pr',$pr);
		$this->display();
	}

	public function top(){
		$this->display();
	}

}