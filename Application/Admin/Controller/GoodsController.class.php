<?php
namespace Admin\Controller;
use \Admin\Controller\IndexController;
class GoodsController extends IndexController 
{
    public function add()
    {


    	if(IS_POST)
    	{
    		$model = D('Admin/Goods');
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

        $tmodel = M("type");
        $type = $tmodel->select();
        $this->assign('type',$type);

        //获取品牌
        $brmodel = M("goods_brand");
        $brand = $brmodel->select();
        $this->assign('brand',$brand);

        //获取分类
        $cmodel = D("category");
        $cat = $cmodel->getTree();
        $this->assign('cat',$cat);

        //获取会员
        $mmodel = M("member_level");
        $level = $mmodel->select();
        $this->assign('level',$level);

		$this->setPageBtn('添加商品', '商品列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function edit()
    {
    	$goods_id = I('get.goods_id');
    	if(IS_POST)
    	{
    		$model = D('Admin/Goods');
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
        //获取所有的分类 
        $cmodel = D('category');
        $cat = $cmodel->getTree();
        $this->assign('cat',$cat);

        //获取扩展分类
        $gcmodel = M('goods_cat');
        $gcat = $gcmodel->field('cat_id')->where(array('goods_id' => array('eq',$goods_id)))->select();
        $this->assign('gcat',$gcat);
        // echo "<pre>";
        // var_dump($gcat);
        //获取所有品牌
        $gbmodel = M('goods_brand');
        $brand = $gbmodel->select();
        $this->assign('brand',$brand);

        //获取会员
        $mlmodel = M('member_level');
        $level = $mlmodel->select();
        $this->assign('level',$level);

        //会员价格
        $mpmodel = M('member_price');
        $price = $mpmodel->field('level_id,level_price')->where(array('goods_id' => array('eq',$goods_id)))->select();
       

        foreach ($price as $k => $v) {
            $mpri[$v['level_id']] = $v['level_price'];
        }
        $this->assign('price',$mpri);

        //获取类型
        $tmodel = M('type');
        $type = $tmodel->select();
        $this->assign('type',$type);

        $model = M('Goods');
        $data = $model->find($goods_id);
        $this->assign('data', $data);
        //取出当前商品的属性数据
        $gamodel = M('goods_attr');
        $atr = $gamodel->field('a.*,b.attr_name,b.attr_type,b.attr_option_values')->alias('a')->join('LEFT JOIN jd_attribute b ON a.attr_id=b.attr_id')->where(array('a.goods_id'=>array('eq',$goods_id)))->order('a.attr_id ASC')->select();
            $mp = array();
        foreach ($atr as $k => $v) {
            $mp[] = $v['attr_id'];
        }

        $atid = array_unique($mp);

        $abmodel = M('attribute');
        $ab = $abmodel->where(array('type_id' => array('eq',$data['type_id']),'attr_id' => array('not in',$atid)))->select();
        if($ab)
        {
             $atr = array_merge($atr,$ab);
            usort($atr,'atrank');
        }

        $this->assign('atr',$atr);
        // echo "<pre>";
        // var_dump($atr);

        //获取图片
        $gpmodel = M('goods_prcs');
        $prcs = $gpmodel->where(array('goods_id' => array('eq',$goods_id)))->select();
        $this->assign('prcs',$prcs);
        // echo "<pre>";
        // print_r($prcs);

		$this->setPageBtn('修改商品', '商品列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Admin/Goods');
    	if($model->delete(I('get.goods_id', 0)) !== FALSE)
    	{
    		$this->success('删除成功！', U('recyclelst', array('p' => I('get.p', 1))));
    		exit;
    	}
    	else 
    	{
    		$this->error($model->getError());
    	}
    }
    public function lst()
    {
    	$model = D('Admin/Goods');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));


		$this->setPageBtn('商品列表', '添加商品', U('add'));
    	$this->display();
    }
    //库存
    public function goods_number(){
        // echo "<pre>";
        // var_dump($_POST);

            $goodsid = I('get.goods_id');
            if(IS_POST)
            {
                $attrid = I('post.attr_id');
                $number = I('post.goods_number');
                $gnmodel = M('goods_number');
                $gnmodel->where(array('goods_id'=>array('eq',$goodsid)))->delete();
                $blt = count($attrid)/count($number);
                $_i = 0;
                foreach ($number as $k => $v) {
                    $_arr = array();
                    for($i=0; $i<$blt;$i++)
                    {
                        $_arr[] = $attrid[$_i];
                        $_i++;
                    }
                    sort($_arr);
                    $_att = implode(',',$_arr);

                    $info = $gnmodel->add(array(
                        'goods_id' => $goodsid,
                        'goods_number' => $v,
                        'goods_attr_id' => $_att,
                        ));
                }
                if($info)
                    $this->success('添加成功!',U('lst'));
                exit;
                
            }
        //select attr_id from jd_goods_attr where goods_id=$goods_id group by attr_id having count(*) > 1
            $goods_id = I('get.goods_id');
        $sql = "select a.*,b.attr_name from jd_goods_attr a LEFT JOIN jd_attribute b on a.attr_id=b.attr_id where a.attr_id in (select attr_id from jd_goods_attr where goods_id=$goods_id group by attr_id having count(*) > 1) and a.goods_id=$goods_id";
        $model = M(); 
        $number = $model->query($sql);
            $num = array();
            foreach ($number as $k => $v) {
                $num[$v['attr_id']][] = $v;
            }
            $gnmodel = M('goods_number');
            $nul = $gnmodel->where(array('goods_id'=>array('eq',$goodsid)))->select();
            $this->assign('nul',$nul);
        // echo "<pre>";
        // var_dump($nul);
        $this->assign('number',$num);
        $this->setPageBtn('库存','商品列表',U('lst'));
        $this->display();
    }
    //回收站
    public function recyclelst(){
        $model = D('Admin/Goods');
        $data = $model->search(8,1);
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
            ));
        $this->setPageBtn('回收站','商品列表',U('lst'));
        $this->display();
    }
    //放入回收站
    public function recycle(){
        $gid = I('get.goods_id');
        $gmodel = M('goods');
        $gmodel->where(array('goods_id'=>array('eq',$gid)))->setField('is_delete',1);
        $this->success('操作成功!',U('lst',array('p'=>array('eq',1))));
    }
    //还原商品
    public function restore(){
        $gid = I('get.goods_id');
        $gmodel = M('goods');
        $gmodel->where(array('goods_id'=>array('eq',$gid)))->setField('is_delete',0);
        $this->success('操作成功!',U('recyclelst',array('p'=>array('eq',1))));
    }

    //查询分类
    public function ajaxGetAttr(){
        $type_id = I('get.type_id');

        $amodel = M('attribute');
        $attrData = $amodel->where(array('type_id'=>array('eq',$type_id)))->select();

        echo json_encode($attrData);
    }
    //删除图片
    public function ajaxDelImage(){
        $prcs_id = I('get.prcs_id');
        $gpmodel = M('goods_prcs');
        $pic = $gpmodel->field('prcs_pic,sm_prcs_pic')->find($prcs_id);
        deleteImage($pic);
        $gpmodel->delete($prcs_id);    
        
    }
    //ajax删除属性
    public function ajaxDelattr(){
        $gaid = I('get.gaid');
        $gamodel = M('goods_attr');
        $gamodel->delete($gaid);
    }
}