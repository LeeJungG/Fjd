<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
class IndexController extends BaseController {
    public function index(){
    	// 设置页面的标题、关键字、描述，是否展开、CSS信息
    	$this->setPageInfo('首页','关键字','描述',1,array('index'),array('index'));

    	$gmodel = D('Admin/goods');

    	$gpro = $gmodel->getPromoteGoods();
    	$goods2 = $gmodel->getHot();
    	$goods3 = $gmodel->getBest();
    	$goods4 = $gmodel->getNew();
    	
    	$this->assign(array(
    		'gpro' => $gpro,
    		'goods2' => $goods2,
    		'goods3' => $goods3,
    		'goods4' => $goods4,
    		));
		$this->display();
    }
    public function goods(){
    	//获取商品id
    	$goods_id = I('get.goods_id');
    	//获取所有商品的基本信息
    	$gmodel = M('goods');
    	$info = $gmodel->find($goods_id);
    	//获取商品相册
    	$gpmodel = M('goods_prcs');
    	$prcs = $gpmodel->where(array('goods_id'=>array('eq',$goods_id)))->select();
    	//获取属性信息
   			$gamodel = M('goods_attr'); 	
   		//获取可选属性
   		$gaData2=array();
   		$gaDatag = $gamodel->field('a.*,b.attr_name')->alias('a')->JOIN('left join jd_attribute b on a.attr_id=b.attr_id')->where(array('goods_id'=>array('eq',$goods_id),'b.attr_type'=>array('eq',1)))->select();
   			foreach($gaDatag as $k => $v)
   				$gaData2[$v['attr_name']][]=$v;
    	//获取唯一属性
    	$gaData = $gamodel->field('a.*,b.attr_name')->alias('a')->JOIN('left join jd_attribute b on a.attr_id=b.attr_id')->where(array('goods_id'=>array('eq',$goods_id),'b.attr_type'=>array('eq',0)))->select();
    	// echo "<pre>";
    	// var_dump($gaData2);
    	$this->assign(array(
    		'info'=>$info,
    		'prcs'=>$prcs,
    		'gaData1'=>$gaData,
    		'gaData2'=>$gaData2,
    		));
    	$this->setPageInfo('商品详情','详情','详情',0,array('goods','common','jqzoom'),array('goods','jqzoom-core'));
    	$this->display();
    }
    //获取浏览的商品
    public function ajaxGetRecentDisGoods()
    {
    	//从COOKIE中取出最近浏览过的商品的ID
    	$recentDisplay = isset($_COOKIE['recentDisplay']) ? unserialize($_COOKIE['recentDisplay']) : array();
    	if($recentDisplay)
    	{
    		$goodsmodel = M('goods');
    		$recentDisplay_str = implode(',',$recentDisplay);
    		$goods = $goodsmodel->field('goods_id,goods_name,sm_logo')->where(array('goods_id'=>array('in',$recentDisplay)))->order("INSTR(',$recentDisplay_str,',CONCAT(',',goods_id,','))")->select();
    		echo json_encode($goods);
    	}
    }
    public function ajaxGetPrice()
    {
    	//计算会员价格
    	$goods_id = I('get.goods_id');
    	$model = D('Admin/Goods');
    	//最近浏览
    	$recentDisplay = isset($_COOKIE['recentDisplay']) ? unserialize($_COOKIE['recentDisplay']):array();

    	//把商品id放到数组最前面
    	array_unshift($recentDisplay,$goods_id);

    	//去重复
    	$recentDisplay = array_unique($recentDisplay);
    	//如果超过10个就只保留前10个
    	if(count($recentDisplay) > 10)
    		$recentDisplay = array_slice($recentDisplay,0,10);
    	
    	//再把处理好的数组保存回COOKIE中
    		//计算保存时间
    				//天      //一天的秒数
    		$aMonth = 30 * 86400;
    	setcookie('recentDisplay',serialize($recentDisplay),time()+$aMonth,'/','fjd.com');
    	echo $model->getMemberPrice($goods_id);
    }
    public function ajaxGetComment()
    {
    	$ret = array('login'=>0);
    	$mid = session('mem_id');
    	if($mid)
    	{
    		$ret['login'] = 1;
    	}
    	echo json_encode($ret);
    }
}