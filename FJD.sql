#项目数据库
#创建数据库
create database if not exists jd character set=utf8;
----------------------------------------------------------------------------------------------------------------------------------
###################### 订单信息 ##########################
drop table IF EXISTS jd_order;
create table jd_order
(
	order_id mediumint unsigned not null auto_increment comment '订单基本信息id',
	mem_id mediumint unsigned not null comment '会员id',
	addtime int unsigned not null comment '下单时间',
	order_name varchar(30) not null comment '收货人姓名',
	order_province varchar(30) not null comment '省',
	order_city varchar(30) not null comment '市',
	order_area varchar(30) not null comment '地区',
	order_tel varchar(30) not null comment '收货人电话',
	order_address varchar(30) not null comment '收货人地址',
	order_price decimal(10,2) not null comment '订单总价',
	order_method varchar(30) not null comment '收货地址',
	order_post_method varchar(30) not null comment '发货方式',
	order_pay_method varchar(30) not null commnet '支付方式',
	order_pay_status tinyint unsigned not null default '0' comment '支付状态, 0:未支付 1:已支付',
	order_post_status tinyint unsigned not null default '0' comment '发货状态, 0:未发货 1:已发货 2:已到货',
	primary key (order_id),
	key mem_id(mem_id)
)engine=InnoDB default charset=utf8 comment '订单基本信息';
drop table IF EXISTS jd_order_goods;
create table jd_order_goods
(
	order_id mediumint unsigned not null comment '订单基本信息id',
	mem_id mediumint unsigned not null comment '会员id',
	goods_id mediumint unsigned not null comment '商品id',
	goods_attr_id varchar(30) not null commnet '商品属性id',
	goods_attr_str varchar(150) not null comment '商品属性字符串',
	goods_price decimal(10,2) not null comment '商品价格',
	goods_number int unsigned not null comment '商品库存',
	key order_id(order_id),
	key mem_id(mem_id),
	key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '订单商品';

########################## 购物车 #########################
drop table IF EXISTS jd_cart
create table jd_cart
(
	cart_id mediumint unsigned not null auto_increment comment '购物车id',
	goods_id mediumint unsigned not null comment '商品id',
	goods_attr_id varchar(30) not null default '' comment '选择的商品属性id,多个用，隔开',
	goods_number int unsigned not null comment '购买数量',
	mem_id mediumint unsigned not null comment '会员id',
	primary key (cart_id),
	key member_id(member_id)
)engine=MyISAM default charset=utf8 comment '购物车';


########################### 前台评论 ##########################
drop table IF EXISTS jd_comment;
create table jd_comment
(
	com_id mediumint unsigned not null auto_increment comment '评论id',
	com_tent varchar(1000) not null comment '评论内容',
	com_star tinyint unsigned not null default 3 comment '评分',
	addtime int unsigned not null comment '评论时间',
	mem_id mediumint unsigned not null comment '会员id',
	goods_id mediumint unsigned not null comment '商品id',
	used smallint unsigned not null comment '有用的数量',
	primary key (com_id),
	key goodsid(goods_id)
)engine=MyISAM default charset=utf8 comment '评论';
drop table IF EXISTS jd_reply;
create table jd_reply
(
	reply_id smallint unsigned not null auto_increment comment '回复id',
	reply_tent varchar(1000) not null comment '回复内容',
	addtime int unsigned not null comment '回复时间',
	com_id mediumint unsigned not null comment '评论id',
	mem_id mediumint unsigned not null comment '会员id',
	primary key (reply_id),
	key com_id(com_id)
)engine=MyISAM default charset=utf8 comment '回复';
drop table IF EXISTS jd_clicked_use;
create table jd_clicked_use
(
	mem_id mediumint unsigned not null comment '会员id',
	com_id mediumint unsigned not null comment '评论id',
	primary key (mem_id,com_id)
)engine=MyISAM default charset=utf8 commnet '用户点击过的有用的评论';
drop table IF EXISTS jd_impression;
create table jd_impression
(
	im_id mediumint unsigned not null auto_increment comment '印象id',
	im_name varchar(30) not null comment '印象标题',
	im_count smallint unsigned not null default '1' comment '印象出现的次数',
	goods_id mediumint unsigned not null comment '商品id',
	primary key (im_id),
	key goodsid(goods_id)
)engine=MyISAM default charset=utf8 comment '印象';
############################前台会员表########################
drop table IF EXISTS jd_member;
create table jd_member
{
	mem_id mediumint unsigned not null auto_increment comment '会员id',
	mem_email varchar(60) not null comment '会员账号',
	mem_password char(32) not null comment '用户密码',
	mem_face varchar(150) not null default '' comment '用户头像',
	mem_email_code char(32) not null default '' comment '邮件验证的验证码，当会员验证通过之后，会把个字段清空，所以如果这个字段为空就声明会员已经通过email验证了',
	openid char(64) not null default '' comment '对应的qq的openid',
	addtime int unisgned not null comment '注册时间',
	jifen int unisgned not null default '0' comment '积分',
	jyz int unsigned not null default '0' comment '经验值',
	primary key (mem_id)
}engine=MyISAM default charset=utf8 comment '会员';
alter table jd_member add jifen int unsigned not null default '0' comment '积分';

#商品模块----商品表---
DROP TABLE IF EXISTS jd_goods;
CREATE TABLE jd_goods
(
	goods_id mediumint unsigned not null auto_increment,
	goods_name varchar(45) not null comment '商品名称',
	cat_id smallint unsigned not null comment '主分类的id',
	brand_id smallint unsigned not null comment '品牌的id',
	market_price decimal(10,2) not null default '0.00' comment '市场价',
	jd_price decimal(10,2) not null default '0.00' comment '本店价',
	jifen int unsigned not null comment '赠送积分',
	jyz int unsigned not null comment '赠送经验值',
	jifen_price int unsigned not null comment '如果要用积分兑换，需要的积分数',
	is_promote tinyint unsigned not null default '0' comment '是否促销',
	promote_price decimal(10,2) not null default '0.00' comment '促销价',
	promote_start_time int unsigned not null default '0' comment '促销开始时间',
	promote_end_time int unsigned not null default '0' comment '促销结束时间',
	logo varchar(150) not null default '' comment 'logo原图',
	sm_logo varchar(150) not null default '' comment 'logo缩略图',
	is_hot tinyint unsigned not null default '0' comment '是否热卖',
	is_new tinyint unsigned not null default '0' comment '是否新品',
	is_best tinyint unsigned not null default '0' comment '是否精品',
	is_on_sale tinyint unsigned not null default '1' comment '是否上架：1：上架，0：下架',
	seo_keyword varchar(150) not null default '' comment 'seo优化[搜索引擎【百度、谷歌等】优化]_关键字',
	seo_description varchar(150) not null default '' comment 'seo优化[搜索引擎【百度、谷歌等】优化]_描述',
	type_id mediumint unsigned not null default '0' comment '商品类型id',
	sort_num tinyint unsigned not null default '100' comment '排序数字',
	is_delete tinyint unsigned not null default '0' comment '是否放到回收站：1：是，0：否',
	addtime int unsigned not null comment '添加时间',
	goods_desc longtext comment '商品描述',
	primary key (goods_id),
	key jd_price(jd_price),
	key cat_id(cat_id),
	key brand_id(brand_id),
	key is_on_sale(is_on_sale),
	key is_hot(is_hot),
	key is_new(is_new),
	key is_best(is_best),
	key is_delete(is_delete),
	key sort_num(sort_num),
	key promote_start_time(promote_start_time),
	key promote_end_time(promote_end_time),
	key addtime(addtime)
)engine=MyISAM default charset=utf8 comment '商品表';

/************************* 商品分类 *****************/
drop table IF EXISTS jd_category;
create table jd_category(
cat_id smallint unsigned not null auto_increment comment '分类id',
cat_name varchar(32) not null comment '分类名称',
parent_id smallint unsigned not null comment '上级分类的ID，0：代表顶级',
search_attr_id varchar(100) not null default '' comment '筛选选属性ID，多个ID用逗号隔开',
primary key (cat_id)
)engine=MyISAM default charset=utf8 comment '商品分类';

/**************************** 优惠价格 *********************************/
drop table IF EXISTS jd_youhui_price;
create table jd_youhui_price(
goods_id smallint unsigned not null auto_increment comment '商品id',
youhui_num int unsigned not null comment '优惠数量',
youhui_price decimal(10,2) not null comment '优惠价格',
key goods_id(goods_id)
)engine=MyISAM default charset=utf8 comment '优惠价格';

/****************************** 商品扩展分类 ***************************/
drop table IF EXISTS jd_goods_cat;
create table jd_goods_cat(
goods_id smallint unsigned not null comment '商品id',
cat_id smallint unsigned not null comment '分类id',
key goods(goods_id),
key cat_id(cat_id)
)engine=MyISAM default charset=utf8 comment '商品扩展分类表';

/**************************** 商品品牌 **********************************/
drop table IF EXISTS jd_goods_brand;
create table jd_goods_brand(
brand_id smallint unsigned not null auto_increment comment '品牌id',
brand_name varchar(45) not null comment '品牌名称',
brand_url varchar(150) not null default '' comment '品牌官网',
brand_logo varchar(150)  not null default '' comment '品牌logo',
primary key (brand_id)
)engine=MyISAM default charset=utf8 comment '商品品牌';



create table jd_admin(
	admin_id tinyint unsigned not null auto_increment comment '后台用户ID',
	admin_name varchar(30) not null comment '账号',
	admin_password varchar(32) not null comment '用户密码',
	admin_is_use tinyint unsigned not null default '1' comment '1:启用0:禁用',
	primary key (admin_id)
	)engine=MyISAM default charset=utf8;
insert into jd_admin values (1,'root','a77741921c84e0d3453c81ecd6e7c542',1);

######################  RBAC  #####################
#权限管理表
create table jd_privilege(
pri_id smallint unsigned not null auto_increment comment '权限id',
pri_name varchar(30) not null comment '权限名称',
module_name varchar(10) not null default '' comment '模块名',
controller_name varchar(10) not null default '' comment '控制器名',
action_name varchar(10) not null default '' comment '动作名',
parent_id smallint unsigned not null default '0' comment '上级权限的id 0表示顶级权限',
primary key (pri_id) 
)engine=MyISAM default charset=utf8 comment '权限管理表';

#角色权限表
create table jd_role_privilege(
pri_id smallint unsigned not null comment '权限id',
role_id smallint unsigned not null comment '角色id',
key pri_id(pri_id),
key role_id(role_id)
)engine=MyISAM default charset=utf8 comment '角色权限表';

#########################多对多创建一个中间表##########################

#角色管理表
create table jd_role(
role_id smallint unsigned not null auto_increment comment '角色id',
role_name varchar(30) not null comment '角色名',
primary key (role_id)
)engine=MyISAM default charset=utf8 comment '角色管理表';

#管理员角色表
create table jd_admin_role(
role_id tinyint unsigned not null comment '角色id',
admin_id smallint unsigned not null comment '管理员id',
key role_id(role_id),
key admin_id(admin_id)
)engine=MyISAM default charset=utf8 comment '管理员角色表';

#管理员管理表
drop table IF EXISTS jd_admin; 
create table jd_admin(
admin_id tinyint unsigned not null auto_increment comment '管理员id',
admin_name varchar(30) not null comment '账号',
admin_password varchar(50) not null comment '密码',
is_use tinyint unsigned not null default '1' comment '是否启用 1:启用0:禁用',
primary key (admin_id)
)engine=MyISAM default charset=utf8 comment '管理员管理表';
insert into jd_admin values(null,'root','a77741921c84e0d3453c81ecd6e7c542',1);


/***********************商品模块表*******************************/
#功能一，商品类型管理和商品属性管理
#一个属性只有一个类型     一个类型可以有多个属性
#一个 一对多关系. 如果是一对多的关系，在多的那张表键一个外键
drop table IF EXISTS jd_type;
create table jd_type(
type_id tinyint unsigned not null auto_increment comment '类型id',
type_name varchar(32) not null comment '类型名称',
primary key (type_id) 
)engine=MyISAM default charset=utf8 comment '商品类型';


#属性表
drop table IF EXISTS jd_attribute;
create table jd_attribute(
attr_id int unsigned not null auto_increment comment '属性id',
attr_name varchar(32) not null comment '属性名称',
attr_type tinyint unsigned not null default '0' comment '属性的类型0:唯一 1:可选',
attr_option_values varchar(150) not null default '' comment '属性的可选值，多个可选值用，隔开',
type_id tinyint unsigned not null comment '所在的类型id',
primary key (attr_id),
key type_id(type_id)
)engine=MyISAM default charset=utf8 comment '属性';

/***********************会员价格****************************/
#多对多创建一个中间表
drop table IF EXISTS jd_member_level;
create table jd_member_level(
level_id mediumint unsigned not null auto_increment comment '会员级别id',
level_name varchar(32) not null comment '级别名称',
bottom_num int unsigned not null comment '积分下限',
top_num int unsigned not null comment '积分上限',
rate tinyint unsigned not null default '100' comment '折扣率，以百分比，如：9折=90',
primary key (level_id)
)engine=MyISAM default charset=utf8 comment '会员级别表';

#会员价格表
drop table IF EXISTS jd_member_price;
create table jd_member_price(
goods_id mediumint unsigned not null comment '商品id',
level_id mediumint unsigned not null comment '会员级别id',
level_price decimal(10,2) not null comment '这个级别的价格',
key goods_id(goods_id),
key level_id(level_id)
)engine=MyISAM default charset=utf8 comment '会员级别价格';

/******************商品相册********************/
#一对多
drop table IF EXISTS jd_goods_prcs;
create table jd_goods_prcs(
prcs_id mediumint unisgned not null auto_increment comment '商品相册id',
prcs_pic varchar(150) not null default '' comment '图片',
sm_prcs_pic varchar(150) not null default '' comment '压缩图',
goods_id mediumint unsigned not null comment '商品id',
primary key(prcs_id),
key goods_id(goods_id)
)engine=MyISAM default charset=utf8 comment '商品相册';

/***************商品属性***********************/
#多对多
drop table IF EXISTS jd_goods_attr;
create table jd_goods_attr(
goods_a_id int not null auto_increment,
goods_id mediumint unsigned not null comment '商品id',
attr_id mediumint unsigned not null comment '属性id',
attr_value varchar(150) not null default '' comment '属性值',
attr_price decimal(10,2) not null default '0.00' comment '属性的价格',
primary key(goods_a_id),
key goods_id(goods_id),
key attr_id(attr_id)
)engine=MyISAM default charset=utf8 comment '商品属性';

/********************************商品库存**************************/
drop table IF EXISTS jd_goods_number;
create table jd_goods_number(
goods_number_id int unsigned not null  auto_increment comment '商品库存id',
goods_id mediumint unsigned not null comment '商品id',
goods_number int unsigned not null comment '商品库存',
goods_attr_id varchar(150) not null comment '商品属性ID列表-注释:这里的id保存的是jd_goods_attr表的id,通过这个id即可以知道值是什么也可以知道属性是什么，如果有多个id组合就好用,号隔开保存一个字符串,并且存时要按id的升序存,将来前台查询库存量时也要先把商品属性id升序拼成字符串查询数据库',
primary key goods_number_id,
key goods_id(goods_id),
key goods_attr_id(goods_attr_id)
) engine=InnoDB default charset=utf8 comment '商品库存';