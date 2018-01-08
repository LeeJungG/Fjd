<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model 
{
	protected $insertFields = array('goods_name','cat_id','brand_id','market_price','jd_price','jifen','jyz','jifen_price','is_promote','promote_price','promote_start_time','promote_end_time','is_hot','is_new','is_best','is_on_sale','seo_keyword','seo_description','type_id','sort_num','is_delete','goods_desc');
	protected $updateFields = array('goods_id','goods_name','cat_id','brand_id','market_price','jd_price','jifen','jyz','jifen_price','is_promote','promote_price','promote_start_time','promote_end_time','is_hot','is_new','is_best','is_on_sale','seo_keyword','seo_description','type_id','sort_num','is_delete','goods_desc');
	protected $_validate = array(
		array('goods_name', 'require', '商品名称不能为空！', 1, 'regex', 3),
		array('goods_name', '1,45', '商品名称的值最长不能超过 45 个字符！', 1, 'length', 3),
		array('cat_id', 'require', '主分类不能为空！', 1, 'regex', 3),
		array('brand_id', 'require', '品牌不能为空！', 1, 'regex', 3),
		array('market_price', 'currency', '市场价必须是货币格式！', 2, 'regex', 3),
		array('jd_price', 'currency', '本店价必须是货币格式！', 2, 'regex', 3),
		array('jifen', 'require', '赠送积分不能为空！', 1, 'regex', 3),
		array('jifen', 'number', '赠送积分必须是一个整数！', 1, 'regex', 3),
		array('jyz', 'require', '赠送经验值不能为空！', 1, 'regex', 3),
		array('jyz', 'number', '赠送经验值必须是一个整数！', 1, 'regex', 3),
		array('jifen_price', 'require', '如果要用积分兑换，需要的积分数不能为空！', 1, 'regex', 3),
		array('jifen_price', 'number', '如果要用积分兑换，需要的积分数必须是一个整数！', 1, 'regex', 3),
		array('is_promote', 'number', '是否促销必须是一个整数！', 2, 'regex', 3),
		array('promote_price', 'currency', '促销价必须是货币格式！', 2, 'regex', 3),

		array('is_hot', 'number', '是否热卖必须是一个整数！', 2, 'regex', 3),
		array('is_new', 'number', '是否新品必须是一个整数！', 2, 'regex', 3),
		array('is_best', 'number', '是否精品必须是一个整数！', 2, 'regex', 3),
		array('is_on_sale', 'number', '是否上架：1：上架，0：下架必须是一个整数！', 2, 'regex', 3),
		array('seo_keyword', '1,150', 'seo优化[搜索引擎【百度、谷歌等】优化]_关键字的值最长不能超过 150 个字符！', 2, 'length', 3),
		array('seo_description', '1,150', 'seo优化[搜索引擎【百度、谷歌等】优化]_描述的值最长不能超过 150 个字符！', 2, 'length', 3),
		array('type_id', 'number', '商品类型id必须是一个整数！', 2, 'regex', 3),
		array('sort_num', 'number', '排序数字必须是一个整数！', 2, 'regex', 3),
		array('is_delete', 'number', '是否放到回收站：1：是，0：否必须是一个整数！', 2, 'regex', 3),
	);
	public function search($pageSize = 8 ,$isDelete = 0)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		$where['is_delete'] = array('eq',$isDelete);
		if($goods_name = I('get.goods_name'))
			$where['goods_name'] = array('like', "%$goods_name%");
		if($cat_id = I('get.cat_id'))
			$where['cat_id'] = array('eq', $cat_id);
		if($brand_id = I('get.brand_id'))
			$where['brand_id'] = array('eq', $brand_id);
		$jd_pricefrom = I('get.jd_pricefrom');
		$jd_priceto = I('get.jd_priceto');
		if($jd_pricefrom && $jd_priceto)
			$where['jd_price'] = array('between', array($jd_pricefrom, $jd_priceto));
		elseif($jd_pricefrom)
			$where['jd_price'] = array('egt', $jd_pricefrom);
		elseif($jd_priceto)
			$where['jd_price'] = array('elt', $jd_priceto);
		if($is_hot = I('get.is_hot'))
			$where['is_hot'] = array('eq', $is_hot);
		if($is_new = I('get.is_new'))
			$where['is_new'] = array('eq', $is_new);
		if($is_best = I('get.is_best'))
			$where['is_best'] = array('eq', $is_best);
		if($is_on_sale = I('get.is_on_sale'))
			$where['is_on_sale'] = array('eq', $is_on_sale);
		if($type_id = I('get.type_id'))
			$where['type_id'] = array('eq', $type_id);
		if($addtime = I('get.addtime'))
			$where['addtime'] = array('eq', $addtime);
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->field('a.*,IFNULL(SUM(b.goods_number),0) ber')->alias('a')->join('left join jd_goods_number b on a.goods_id=b.goods_id')->where($where)->group('a.goods_id')->limit($page->firstRow.','.$page->listRows)->select();
		// echo "<pre>";
		// var_dump($data);
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
		//获取当前时间存储
		$data['addtime'] = time();

		//把促销时间转时间戳
		if($data['is_promote'] == 1)
		{
			$data['promote_start_time'] = strtotime($_POST['promote_start_time']);
			$data['promote_end_time'] = strtotime($_POST['promote_end_time']);
		}

		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			$ret = uploadOne('logo', 'Admin', array(
				array(150, 150, 2),
			));
			if($ret['ok'] == 1)
			{
				$data['logo'] = $ret['images'][0];
				$data['sm_logo'] = $ret['images'][1];
			}
			else 
			{
				$this->error = $ret['error'];
				return FALSE;
			}
		}
	}

	protected function _after_insert($data,$option)
	{
		/************** 处理扩展分类 *************/
		$cat_id = I('exi_cat_id');
		if($cat_id)
		{
				$gcmodel = M('goods_cat');
			foreach ($cat_id as $k => $v) {
				if($v == 0)
					continue;
				$gcmodel->add(
					array(
					'goods_id' => $data['goods_id'],
					'cat_id' => $v,
					));
			}
		}
		/************ 处理会员价格 ***********/
		$rate = I('rate');
		if($rate)
		{
			$mepmodel = M('member_price');
			foreach ($rate as $k => $v) {
				if(empty($v))
					continue;
				$mepmodel->add(array(
					'goods_id' => $data['goods_id'],
					'level_id' => $k,
					'level_price' => $v,
					));
			}
		}

		/********** 处理属性 *******/
		$ga = I('ga');
		$attr_pr = I('attr_price');
		if($ga)
		{
			$gamodel = M('goods_attr');
			foreach ($ga as $k => $v) {
				foreach ($v as $k1 => $v1) {
					if(empty($v1))
						continue;
					$price = isset($attr_pr[$k][$k1]) ? $attr_pr[$k][$k1] :'';
					$gamodel->add(array(
						'goods_id' => $data['goods_id'],
						'attr_id' => $k,
						'attr_value' => $v1,
						'attr_price' => $price ,
						));
				}
			}
		}

		/********* 处理上传图片 *********/
		if(ximo('pics'))
		{
			$gpmodel = M('goods_prcs');
			foreach ($_FILES['pics']['name'] as $k => $v) {
				if($_FILES['pics']['size'][$k] == 0)
					continue;
				$images[] = array(
					'name' => $v,
					'type' => $_FILES['pics']['type'][$k],
					'tmp_name' => $_FILES['pics']['tmp_name'][$k],
					'error' => $_FILES['pics']['error'][$k],
					'size' => $_FILES['pics']['size'][$k],
					);
			}
			$_FILES = $images;

			foreach ($_FILES as $k => $v) {
				$mst = uploadOne($k,'Goods',array(array(150,150)));
				if($mst['ok'] == 1)
				{
					$gpmodel->add(array(
						'prcs_pic' => $mst['images'][0],
						'sm_prcs_pic' => $mst['images'][1],
						'goods_id' => $data['goods_id'],
						));
				}
			}
		}

	}

	// 修改前
	protected function _before_update(&$data, $option)
	{

		// 判断商品类型是否更改
		if(I('post.type_id') != I('post.oltype_id'))
		{
			$gamodel = M('goods_attr');
			$gamodel->where(array('goods_id'=>array('eq',$option['where']['goods_id'])))->delete();
		}
		if(!isset($_POST['is_promote']))
			$data['is_promote'] = 0;
		else
		{
			$data['promote_start_time'] = strtotime($_POST['promote_start_time']);
			$data['promote_end_time'] = strtotime($_POST['promote_end_time']);
		}
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			$ret = uploadOne('logo', 'Admin', array(
				array(150, 150, 2),
			));
			if($ret['ok'] == 1)
			{
				$data['logo'] = $ret['images'][0];
				$data['sm_logo'] = $ret['images'][1];
			}
			else 
			{
				$this->error = $ret['error'];
				return FALSE;
			}
			deleteImage(array(
				I('post.old_logo'),
				I('post.old_sm_logo'),
	
			));
		}

		//处理扩展分类
		$gci = I('POST.god_cat_id');
			$gcmodel = M('goods_cat');
			$info = $gcmodel->where(array('goods_id'=>array('eq',$option['where']['goods_id'])))->delete();
				foreach ($gci as $k => $v) {
					if(empty($v))
						continue;
					$gcmodel->add(array(
						'goods_id' => $option['where']['goods_id'],
						'cat_id' => $v,
						));
				}

		//处理商品会员价格
			$rae = I('POST.rate');
			$mpmodel = M('member_price');
			$info = $mpmodel->where(array('goods_id'=>array('eq',$option['where']['goods_id'])))->delete();
			if($info)
			{
				foreach($rae as $k => $v)
				{
					if(empty($v))
						continue;
					$mpmodel->add(array(
						'goods_id' => $option['where']['goods_id'],
						'level_id' => $k,
						 'level_price' => $v,
						));
				}
			}
	//处理图片
		if(ximo('prcs'))
		{
			$gpmodel = M('goods_prcs');
			foreach ($_FILES['prcs']['name'] as $k => $v) {
				if($_FILES['prcs']['size'][$k] == 0)
					continue;
				$prcs[] = array(
					'name' => $v,
					'type' => $_FILES['prcs']['type'][$k],
					'tmp_name' => $_FILES['prcs']['tmp_name'][$k],
					'error' => $_FILES['prcs']['error'][$k],
					'size' => $_FILES['prcs']['size'][$k]
					);
			}
		}
		$_FILES = $prcs;
		
		foreach ($prcs as $k => $v) {
			$fil = uploadOne($k,'Goods',array(array(150,150)));

			if($fil['ok'] == 1)
			{
				$gpmodel->add(array(
					'prcs_pic' => $fil['images'][0],
					'sm_prcs_pic' => $fil['images'][1],
					'goods_id' => $option['where']['goods_id'],
				));				
			}

		}
		//处理新添加的属性
		$ga = I('post.ga');
		$ga_pri = I('post.ga_pri');
		$gamodel = M('goods_attr');

		// echo "<pre>";
		// var_dump($ga);
		// // var_dump($old_ga);
		// exit;
		if($ga)
		{
			foreach ($ga as $k => $v)
			{
				foreach ($v as $k1 => $v1)
				{
					if(empty($v1))
						continue ;
					$price = isset($ga_pri[$k][$k1]) ? $ga_pri[$k][$k1] : '';
					$gamodel->add(array(
						'goods_id' => $option['where']['goods_id'],
						'attr_id' => $k,
						'attr_value' => $v1,
						'attr_price' => $price,
					));
				}
			}
		}

		//处理旧的属性

				$old_ga = I('post.old_ga');
		$old_ga_pri = I('post.old_ga_pri');
			foreach ($old_ga as $k => $v) {
				foreach ($v as $k1 => $v1) {
					if($v1 == "")
					{
						$gamodel->where(array('goods_a_id'=>array('eq',$k1)))->delete();
					}
					$oldfile = array('attr_value' => $v1);
					if(isset($old_ga_pri[$k]))
					$oldfile['attr_price'] = $old_ga_pri[$k][$k1];
						$gamodel->where(array('goods_a_id'=>array('eq',$k1)))->save($oldfile);
					
				}
			}

	}
	// 删除前
	protected function _before_delete($option)
	{
		/***************** 删除其他信息 ****************/
			//删除分类
			$gcmodel = M('goods_cat');
			$gcmodel->where(array('goods_id'=>array('eq',$option['where']['goods_id'])))->delete();
			//删除商品会员价格
			$mpmodel = M('member_price');
			$mpmodel->where(array('goods_id'=>array('eq',$option['where']['goods_id'])))->delete();
			//删除属性
			$gamodel = M('goods_attr');
			$gamodel->where(array('goods_id'=>array('eq',$option['where']['goods_id'])))->delete();
			//删除库存
			$gamodel = M('goods_number');
			$gamodel->where(array('goods_id'=>array('eq',$option['where']['goods_id'])))->delete();
			//删除相册
			$gprcsmodel = M('goods_prcs');
			$prcs = $gprcsmodel->field('prcs_pic,sm_prcs_pic')->where(array('goods_id'=>array('eq',$option['where']['goods_id'])))->select();
			foreach ($prcs as $v) {
				deleteImage($v);
			}
			$gprcsmodel->where(array('goods_id'=>array('eq',$option['where']['goods_id'])))->delete();
		/******************删除商品图片**********************/
		if(is_array($option['where']['goods_id']))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
		$images = $this->field('logo,sm_logo')->find($option['where']['goods_id']);
		deleteImage($images);
	}
	/************************************ 其他方法 ********************************************/
	//疯狂抢购
	public function getPromoteGoods($limit = 5)
	{
		$time = time();
		return $this->field('goods_id,goods_name,promote_price,sm_logo')->where(array(
			'is_promote' => array('eq',1),
			'promote_start_time' => array('elt',$time),
			'promote_end_time' => array('egt',$time),
			'is_delete' => array('eq',0),
			'is_on_sale' => array('eq',1),
			))->limit($limit)->order('sort_num ASC')->select();
	}
	//热卖商品
	public function getHot($limit = 5)
	{
		
		return $this->field('goods_id,goods_name,jd_price,sm_logo')->where(array(
			'is_hot' => array('eq',1),
			'is_delete' => array('eq',0),
			'is_on_sale' => array('eq',1),
			))->limit($limit)->order('sort_num ASC')->select();
	}
	//推荐商品
	public function getBest($limit = 5)
	{
		
		return $this->field('goods_id,goods_name,jd_price,sm_logo')->where(array(
			'is_Best' => array('eq',1),
			'is_delete' => array('eq',0),
			'is_on_sale' => array('eq',1),
			))->limit($limit)->order('sort_num ASC')->select();
	}
	//新品上架
		public function getNew($limit = 5)
	{
		
		return $this->field('goods_id,goods_name,jd_price,sm_logo')->where(array(
			'is_new' => array('eq',1),
			'is_delete' => array('eq',0),
			'is_on_sale' => array('eq',1),
			))->limit($limit)->order('sort_num ASC')->select();
	}

	//计算会员价格
	public function getMemberPrice($goods_id)
	{
		//判断是否在促销期间
		$tim = time();
		$info = $this->field('jd_price,is_promote,promote_price,promote_start_time,promote_end_time')->find($goods_id);
		if($info['is_promote'] == 1 && ($info['promote_start_time'] <= $tim && $info['promote_end_time'] > $tim))
			return $info['promote_price'];

		//判断是否有登录
		$mem_id = session('mem_id');
		if(!$mem_id)
		{

			return $info['jd_price'];
		}else{
			$model = M('member_price');
			$meber = $model->where(array('goods_id'=>array('eq',$goods_id),'level_id'=>array('eq',session('level_id'))))->find();
			if($meber)
				return $meber['level_price'];
			else
				return session('rate')*$info['jd_price'] ;
			
		}
	}
	public function gattrbutr($attr_id)
	{
		if($attr_id)
		{
			$sql = 'select group_concat(CONCAT(b.attr_name,":",a.attr_value) SEPARATOR "<br/>") avn from jd_goods_attr a left join jd_attribute b on b.attr_id=a.attr_id where a.goods_a_id in ('.$attr_id.')';
			$a = $this->query($sql);
			return $a[0]["avn"];
		}else
		return "";
	}
	public function search_goods()
	{
		/***************** 搜索 ****************/
		$where = array(
			'a.is_on_sale' => array('eq', 1),
			'a.is_delete' => array('eq', 0),
		);
		//如果传了分类ID
		$catid = I('get.cid');
		if($catid)
		{
			$gcmodel = M('goods_cat');
			$extgoodsid = $gcmodel->field('GROUP_CONCAT(DISTINCT goods_id) goods_id')->where(array('cat_id'=>array('eq',$catid)))->find();
			if($extgoodsid['goods_id'])
				$extgoodsid ="OR a.goods_id IN({$extgoodsid['goods_id']})";
			else
				$extgoodsid = '';
			$where['a.cat_id'] = array('exp',"=$catid $extgoodsid");
		}
		//价格搜索
		$spir = I('get.priceT');
		if($spir)
		{
			$spir = explode('-',$spir);
			$where['a.jd_price'] = array('between',array($spir[0],$spir[1]));
		}
		//属性的搜索
		$sa = I('get.search_attr');
		if($sa)
		{
			$gamodel = M('goods_attr');
			$sa = explode('.',$sa);
			//保存每个满足的属性
			$_attrGoodsId = array();
			//先定义一个数组：第一个满足条件的属性ID
			$_att1 = null;

			foreach ($sa as $k => $v) {
				if($v != '0')
				{
					$_v = explode('-',$v);
					$_attrGoodsId =	$gamodel->field('GROUP_CONCAT(goods_id) goods_id')->where(array(
						'attr_id' => $_v[1],
						'attr_value' => $_v[0],
						))->find();

					$_attrGoodsId = $_attrGoodsId['goods_id'];
					if($_att1 === null)
					{
						$_att1 = explode(',',$_attrGoodsId);

					}else{

						//如果$_att1不为空，保存的就是上一次满足条件的商品ID，那么就和这一次取交集
						$_attrGoodsId = explode(',',$_attrGoodsId);
						$_att1 = array_intersect($_att1,$_attrGoodsId);
						if(empty($_att1))
							break;
					}
				}
				

			}
			if($_att1)
				$where['a.goods_id'] = array('in',$_att1);
			else
				$where['a.goods_id'] = array('eq','qAq');
		}
		/****************** 排序 *******************/
		$orderBy = 'xl'; //排序字段
		$orderWay = 'DESC'; //排序方式
		$ob = I('get.ob');
		$ow = I('get.ow');
		if($ob && in_array($ob,array('xl','a.jd_price','pl','addtime')))
		{
			$orderBy = $ob;
			if($ob == 'a.jd_price' && $ow && in_array($ow,array('asc','desc')))
			{
				$orderWay = $ow;
			}
		}

		/******************* 翻页 ***********************/
		//取出总的记录数
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count,24);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();

		/*************************** 取商品 ******************************/
	$data['data'] = $this->field('a.goods_id,a.goods_name,a.sm_logo,a.jd_price,IFNULL(SUM(b.goods_number),0) xl,(select count(com_id) from jd_comment c where c.goods_id=a.goods_id) pl')->alias('a')->join('left join jd_order_goods b on(a.goods_id=b.goods_id and b.order_id in(select order_id from jd_order where order_pay_status=1))')->where($where)->group('a.goods_id')->order("$orderBy $orderWay")->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
}