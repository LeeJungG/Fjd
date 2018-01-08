<?php
namespace Admin\Controller;
use \Admin\Controller\IndexController;
class AdminController extends IndexController 
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Admin/Admin');
    		if($model->create(I('post.'), 1))
    		{
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst?p='.I('get.p')));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}

            $rmodel = D('role');
            $role = $rmodel->select();
            $this->assign('role',$role);
		$this->setPageBtn('添加管理员', '管理员列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function edit()
    {
    	$admin_id = I('get.admin_id');
        $adminid = session('admin_id');
        if($adminid > 1 && $adminid != $admin_id){
            $this->error('无权限修改!');
        }

    	if(IS_POST)
    	{
    		$model = D('Admin/Admin');
    		if($model->create(I('post.'), 2))
    		{
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst', array('p' => I('get.p', 1))));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	$model = M('Admin');
    	$data = $model->find($admin_id);
    	$this->assign('data', $data);

        $ramodel = M('admin_role');
        $arole = $ramodel->field('GROUP_CONCAT(role_id) role_id')->where(array('admin_id' => array('eq',$admin_id)))->find();
        $this->assign('arole',$arole['role_id']);

        $rmodel = D('role');
        $role = $rmodel->select();
        $this->assign('role',$role);
		$this->setPageBtn('修改管理员', '管理员列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Admin/Admin');
    	if($model->delete(I('get.admin_id', 0)) !== FALSE)
    	{
    		$this->success('删除成功！', U('lst', array('p' => I('get.p', 1))));
    		exit;
    	}
    	else 
    	{
    		$this->error($model->getError());
    	}
    }
    public function lst()
    {
    	$model = D('Admin/Admin');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		$this->setPageBtn('管理员列表', '添加管理员', U('add'));
    	$this->display();
    }
    public function ajaxUpdateIsuse(){
        $admin_id =I('get.admin_id');

        if($admin_id == 1){
            return false;
        }

        $amodel = M('admin');
        $info = $amodel->find($admin_id);
        if($info['is_use'] == 1){
            $amodel->where(array('admin_id' => array('eq',$admin_id)))->setField('is_use',0);
            echo 0;
        }else{
            $amodel->where(array('admin_id' => array('eq',$admin_id)))->setField('is_use',1);
            echo 1;
        }
    }
}