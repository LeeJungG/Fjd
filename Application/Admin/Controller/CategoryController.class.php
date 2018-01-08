<?php
namespace Admin\Controller;
use \Admin\Controller\IndexController;
class CategoryController extends IndexController 
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Admin/Category');
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
		$parentModel = D('Admin/Category');
		$parentData = $parentModel->getTree();
		$this->assign('parentData', $parentData);

        //获取所有类型
        $tModel = M('type');
        $type = $tModel->select();
        $this->assign('type',$type);

		$this->setPageBtn('添加商品分类', '商品分类列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function edit()
    {
    	$cat_id = I('get.cat_id');
    	if(IS_POST)
    	{
    		$model = D('Admin/Category');
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
    	$model = M('Category');
    	$data = $model->find($cat_id);
    	$this->assign('data', $data);
		$parentModel = D('Admin/Category');
		$parentData = $parentModel->getTree();
		$children = $parentModel->getChildren($cat_id);
		$this->assign(array(
			'parentData' => $parentData,
			'children' => $children,
		));
        //取出所有类型
        $tModel = M('type');
        $typeM = $tModel->select();
        $this->assign('typeM',$typeM);

       
        if($data['search_attr_id'])
        {
             $attrModel = M('attribute');
            $searchAttrData = $attrModel->field('attr_id,attr_name,type_id')->where(array('attr_id'=>array('in',$data['search_attr_id'])))->select();
            $this->assign('searchAttrData',$searchAttrData);
        }
        

		$this->setPageBtn('修改商品分类', '商品分类列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Admin/Category');
    	if($model->delete(I('get.cat_id', 0)) !== FALSE)
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
    	$model = D('Admin/Category');
		$data = $model->getTree();
    	$this->assign(array(
    		'data' => $data,
    	));

		$this->setPageBtn('商品分类列表', '添加商品分类', U('add'));
    	$this->display();
    }
}