<?php 
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller
{
	public function login(){
			if(IS_POST)
			{
				$model = D('Admin');
				// 使用validate方法来指定使用使用模型中的那个数组作为验证规则,默认是使用$_validate
				//  这里把登录的规则和添加修改管理员的规则分成两个，所以这里指定使用那个
				//  自己规定，代表登录说明这个表单是登录的表单
				if($model->validate($model->_login_validate)->create())
				{
					if($model->login() == true)
					{
						redirect(U('Admin/Index/index'));
					}
				}	
				return $this->error($model->getError());
			}

			$this->display();
	}
	//生成验证码图片
	public function chkcode(){
		$config = array(
			'useImgBg' => true,
			'length' => 4,
			);
		$image = new \Think\Verify($config);
		$image->entry();
	}
	//退出
	public function lognot(){
		session('admin_id',null);
		session('admin_name',null);
		redirect('login');
	}
}