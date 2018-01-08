#��Ŀ���ݿ�
#�������ݿ�
create database if not exists jd character set=utf8;
----------------------------------------------------------------------------------------------------------------------------------
###################### ������Ϣ ##########################
drop table IF EXISTS jd_order;
create table jd_order
(
	order_id mediumint unsigned not null auto_increment comment '����������Ϣid',
	mem_id mediumint unsigned not null comment '��Աid',
	addtime int unsigned not null comment '�µ�ʱ��',
	order_name varchar(30) not null comment '�ջ�������',
	order_province varchar(30) not null comment 'ʡ',
	order_city varchar(30) not null comment '��',
	order_area varchar(30) not null comment '����',
	order_tel varchar(30) not null comment '�ջ��˵绰',
	order_address varchar(30) not null comment '�ջ��˵�ַ',
	order_price decimal(10,2) not null comment '�����ܼ�',
	order_method varchar(30) not null comment '�ջ���ַ',
	order_post_method varchar(30) not null comment '������ʽ',
	order_pay_method varchar(30) not null commnet '֧����ʽ',
	order_pay_status tinyint unsigned not null default '0' comment '֧��״̬, 0:δ֧�� 1:��֧��',
	order_post_status tinyint unsigned not null default '0' comment '����״̬, 0:δ���� 1:�ѷ��� 2:�ѵ���',
	primary key (order_id),
	key mem_id(mem_id)
)engine=InnoDB default charset=utf8 comment '����������Ϣ';
drop table IF EXISTS jd_order_goods;
create table jd_order_goods
(
	order_id mediumint unsigned not null comment '����������Ϣid',
	mem_id mediumint unsigned not null comment '��Աid',
	goods_id mediumint unsigned not null comment '��Ʒid',
	goods_attr_id varchar(30) not null commnet '��Ʒ����id',
	goods_attr_str varchar(150) not null comment '��Ʒ�����ַ���',
	goods_price decimal(10,2) not null comment '��Ʒ�۸�',
	goods_number int unsigned not null comment '��Ʒ���',
	key order_id(order_id),
	key mem_id(mem_id),
	key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '������Ʒ';

########################## ���ﳵ #########################
drop table IF EXISTS jd_cart
create table jd_cart
(
	cart_id mediumint unsigned not null auto_increment comment '���ﳵid',
	goods_id mediumint unsigned not null comment '��Ʒid',
	goods_attr_id varchar(30) not null default '' comment 'ѡ�����Ʒ����id,����ã�����',
	goods_number int unsigned not null comment '��������',
	mem_id mediumint unsigned not null comment '��Աid',
	primary key (cart_id),
	key member_id(member_id)
)engine=MyISAM default charset=utf8 comment '���ﳵ';


########################### ǰ̨���� ##########################
drop table IF EXISTS jd_comment;
create table jd_comment
(
	com_id mediumint unsigned not null auto_increment comment '����id',
	com_tent varchar(1000) not null comment '��������',
	com_star tinyint unsigned not null default 3 comment '����',
	addtime int unsigned not null comment '����ʱ��',
	mem_id mediumint unsigned not null comment '��Աid',
	goods_id mediumint unsigned not null comment '��Ʒid',
	used smallint unsigned not null comment '���õ�����',
	primary key (com_id),
	key goodsid(goods_id)
)engine=MyISAM default charset=utf8 comment '����';
drop table IF EXISTS jd_reply;
create table jd_reply
(
	reply_id smallint unsigned not null auto_increment comment '�ظ�id',
	reply_tent varchar(1000) not null comment '�ظ�����',
	addtime int unsigned not null comment '�ظ�ʱ��',
	com_id mediumint unsigned not null comment '����id',
	mem_id mediumint unsigned not null comment '��Աid',
	primary key (reply_id),
	key com_id(com_id)
)engine=MyISAM default charset=utf8 comment '�ظ�';
drop table IF EXISTS jd_clicked_use;
create table jd_clicked_use
(
	mem_id mediumint unsigned not null comment '��Աid',
	com_id mediumint unsigned not null comment '����id',
	primary key (mem_id,com_id)
)engine=MyISAM default charset=utf8 commnet '�û�����������õ�����';
drop table IF EXISTS jd_impression;
create table jd_impression
(
	im_id mediumint unsigned not null auto_increment comment 'ӡ��id',
	im_name varchar(30) not null comment 'ӡ�����',
	im_count smallint unsigned not null default '1' comment 'ӡ����ֵĴ���',
	goods_id mediumint unsigned not null comment '��Ʒid',
	primary key (im_id),
	key goodsid(goods_id)
)engine=MyISAM default charset=utf8 comment 'ӡ��';
############################ǰ̨��Ա��########################
drop table IF EXISTS jd_member;
create table jd_member
{
	mem_id mediumint unsigned not null auto_increment comment '��Աid',
	mem_email varchar(60) not null comment '��Ա�˺�',
	mem_password char(32) not null comment '�û�����',
	mem_face varchar(150) not null default '' comment '�û�ͷ��',
	mem_email_code char(32) not null default '' comment '�ʼ���֤����֤�룬����Ա��֤ͨ��֮�󣬻�Ѹ��ֶ���գ������������ֶ�Ϊ�վ�������Ա�Ѿ�ͨ��email��֤��',
	openid char(64) not null default '' comment '��Ӧ��qq��openid',
	addtime int unisgned not null comment 'ע��ʱ��',
	jifen int unisgned not null default '0' comment '����',
	jyz int unsigned not null default '0' comment '����ֵ',
	primary key (mem_id)
}engine=MyISAM default charset=utf8 comment '��Ա';
alter table jd_member add jifen int unsigned not null default '0' comment '����';

#��Ʒģ��----��Ʒ��---
DROP TABLE IF EXISTS jd_goods;
CREATE TABLE jd_goods
(
	goods_id mediumint unsigned not null auto_increment,
	goods_name varchar(45) not null comment '��Ʒ����',
	cat_id smallint unsigned not null comment '�������id',
	brand_id smallint unsigned not null comment 'Ʒ�Ƶ�id',
	market_price decimal(10,2) not null default '0.00' comment '�г���',
	jd_price decimal(10,2) not null default '0.00' comment '�����',
	jifen int unsigned not null comment '���ͻ���',
	jyz int unsigned not null comment '���;���ֵ',
	jifen_price int unsigned not null comment '���Ҫ�û��ֶһ�����Ҫ�Ļ�����',
	is_promote tinyint unsigned not null default '0' comment '�Ƿ����',
	promote_price decimal(10,2) not null default '0.00' comment '������',
	promote_start_time int unsigned not null default '0' comment '������ʼʱ��',
	promote_end_time int unsigned not null default '0' comment '��������ʱ��',
	logo varchar(150) not null default '' comment 'logoԭͼ',
	sm_logo varchar(150) not null default '' comment 'logo����ͼ',
	is_hot tinyint unsigned not null default '0' comment '�Ƿ�����',
	is_new tinyint unsigned not null default '0' comment '�Ƿ���Ʒ',
	is_best tinyint unsigned not null default '0' comment '�Ƿ�Ʒ',
	is_on_sale tinyint unsigned not null default '1' comment '�Ƿ��ϼܣ�1���ϼܣ�0���¼�',
	seo_keyword varchar(150) not null default '' comment 'seo�Ż�[�������桾�ٶȡ��ȸ�ȡ��Ż�]_�ؼ���',
	seo_description varchar(150) not null default '' comment 'seo�Ż�[�������桾�ٶȡ��ȸ�ȡ��Ż�]_����',
	type_id mediumint unsigned not null default '0' comment '��Ʒ����id',
	sort_num tinyint unsigned not null default '100' comment '��������',
	is_delete tinyint unsigned not null default '0' comment '�Ƿ�ŵ�����վ��1���ǣ�0����',
	addtime int unsigned not null comment '���ʱ��',
	goods_desc longtext comment '��Ʒ����',
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
)engine=MyISAM default charset=utf8 comment '��Ʒ��';

/************************* ��Ʒ���� *****************/
drop table IF EXISTS jd_category;
create table jd_category(
cat_id smallint unsigned not null auto_increment comment '����id',
cat_name varchar(32) not null comment '��������',
parent_id smallint unsigned not null comment '�ϼ������ID��0��������',
search_attr_id varchar(100) not null default '' comment 'ɸѡѡ����ID�����ID�ö��Ÿ���',
primary key (cat_id)
)engine=MyISAM default charset=utf8 comment '��Ʒ����';

/**************************** �Żݼ۸� *********************************/
drop table IF EXISTS jd_youhui_price;
create table jd_youhui_price(
goods_id smallint unsigned not null auto_increment comment '��Ʒid',
youhui_num int unsigned not null comment '�Ż�����',
youhui_price decimal(10,2) not null comment '�Żݼ۸�',
key goods_id(goods_id)
)engine=MyISAM default charset=utf8 comment '�Żݼ۸�';

/****************************** ��Ʒ��չ���� ***************************/
drop table IF EXISTS jd_goods_cat;
create table jd_goods_cat(
goods_id smallint unsigned not null comment '��Ʒid',
cat_id smallint unsigned not null comment '����id',
key goods(goods_id),
key cat_id(cat_id)
)engine=MyISAM default charset=utf8 comment '��Ʒ��չ�����';

/**************************** ��ƷƷ�� **********************************/
drop table IF EXISTS jd_goods_brand;
create table jd_goods_brand(
brand_id smallint unsigned not null auto_increment comment 'Ʒ��id',
brand_name varchar(45) not null comment 'Ʒ������',
brand_url varchar(150) not null default '' comment 'Ʒ�ƹ���',
brand_logo varchar(150)  not null default '' comment 'Ʒ��logo',
primary key (brand_id)
)engine=MyISAM default charset=utf8 comment '��ƷƷ��';



create table jd_admin(
	admin_id tinyint unsigned not null auto_increment comment '��̨�û�ID',
	admin_name varchar(30) not null comment '�˺�',
	admin_password varchar(32) not null comment '�û�����',
	admin_is_use tinyint unsigned not null default '1' comment '1:����0:����',
	primary key (admin_id)
	)engine=MyISAM default charset=utf8;
insert into jd_admin values (1,'root','a77741921c84e0d3453c81ecd6e7c542',1);

######################  RBAC  #####################
#Ȩ�޹����
create table jd_privilege(
pri_id smallint unsigned not null auto_increment comment 'Ȩ��id',
pri_name varchar(30) not null comment 'Ȩ������',
module_name varchar(10) not null default '' comment 'ģ����',
controller_name varchar(10) not null default '' comment '��������',
action_name varchar(10) not null default '' comment '������',
parent_id smallint unsigned not null default '0' comment '�ϼ�Ȩ�޵�id 0��ʾ����Ȩ��',
primary key (pri_id) 
)engine=MyISAM default charset=utf8 comment 'Ȩ�޹����';

#��ɫȨ�ޱ�
create table jd_role_privilege(
pri_id smallint unsigned not null comment 'Ȩ��id',
role_id smallint unsigned not null comment '��ɫid',
key pri_id(pri_id),
key role_id(role_id)
)engine=MyISAM default charset=utf8 comment '��ɫȨ�ޱ�';

#########################��Զഴ��һ���м��##########################

#��ɫ�����
create table jd_role(
role_id smallint unsigned not null auto_increment comment '��ɫid',
role_name varchar(30) not null comment '��ɫ��',
primary key (role_id)
)engine=MyISAM default charset=utf8 comment '��ɫ�����';

#����Ա��ɫ��
create table jd_admin_role(
role_id tinyint unsigned not null comment '��ɫid',
admin_id smallint unsigned not null comment '����Աid',
key role_id(role_id),
key admin_id(admin_id)
)engine=MyISAM default charset=utf8 comment '����Ա��ɫ��';

#����Ա�����
drop table IF EXISTS jd_admin; 
create table jd_admin(
admin_id tinyint unsigned not null auto_increment comment '����Աid',
admin_name varchar(30) not null comment '�˺�',
admin_password varchar(50) not null comment '����',
is_use tinyint unsigned not null default '1' comment '�Ƿ����� 1:����0:����',
primary key (admin_id)
)engine=MyISAM default charset=utf8 comment '����Ա�����';
insert into jd_admin values(null,'root','a77741921c84e0d3453c81ecd6e7c542',1);


/***********************��Ʒģ���*******************************/
#����һ����Ʒ���͹������Ʒ���Թ���
#һ������ֻ��һ������     һ�����Ϳ����ж������
#һ�� һ�Զ��ϵ. �����һ�Զ�Ĺ�ϵ���ڶ�����ű��һ�����
drop table IF EXISTS jd_type;
create table jd_type(
type_id tinyint unsigned not null auto_increment comment '����id',
type_name varchar(32) not null comment '��������',
primary key (type_id) 
)engine=MyISAM default charset=utf8 comment '��Ʒ����';


#���Ա�
drop table IF EXISTS jd_attribute;
create table jd_attribute(
attr_id int unsigned not null auto_increment comment '����id',
attr_name varchar(32) not null comment '��������',
attr_type tinyint unsigned not null default '0' comment '���Ե�����0:Ψһ 1:��ѡ',
attr_option_values varchar(150) not null default '' comment '���ԵĿ�ѡֵ�������ѡֵ�ã�����',
type_id tinyint unsigned not null comment '���ڵ�����id',
primary key (attr_id),
key type_id(type_id)
)engine=MyISAM default charset=utf8 comment '����';

/***********************��Ա�۸�****************************/
#��Զഴ��һ���м��
drop table IF EXISTS jd_member_level;
create table jd_member_level(
level_id mediumint unsigned not null auto_increment comment '��Ա����id',
level_name varchar(32) not null comment '��������',
bottom_num int unsigned not null comment '��������',
top_num int unsigned not null comment '��������',
rate tinyint unsigned not null default '100' comment '�ۿ��ʣ��԰ٷֱȣ��磺9��=90',
primary key (level_id)
)engine=MyISAM default charset=utf8 comment '��Ա�����';

#��Ա�۸��
drop table IF EXISTS jd_member_price;
create table jd_member_price(
goods_id mediumint unsigned not null comment '��Ʒid',
level_id mediumint unsigned not null comment '��Ա����id',
level_price decimal(10,2) not null comment '�������ļ۸�',
key goods_id(goods_id),
key level_id(level_id)
)engine=MyISAM default charset=utf8 comment '��Ա����۸�';

/******************��Ʒ���********************/
#һ�Զ�
drop table IF EXISTS jd_goods_prcs;
create table jd_goods_prcs(
prcs_id mediumint unisgned not null auto_increment comment '��Ʒ���id',
prcs_pic varchar(150) not null default '' comment 'ͼƬ',
sm_prcs_pic varchar(150) not null default '' comment 'ѹ��ͼ',
goods_id mediumint unsigned not null comment '��Ʒid',
primary key(prcs_id),
key goods_id(goods_id)
)engine=MyISAM default charset=utf8 comment '��Ʒ���';

/***************��Ʒ����***********************/
#��Զ�
drop table IF EXISTS jd_goods_attr;
create table jd_goods_attr(
goods_a_id int not null auto_increment,
goods_id mediumint unsigned not null comment '��Ʒid',
attr_id mediumint unsigned not null comment '����id',
attr_value varchar(150) not null default '' comment '����ֵ',
attr_price decimal(10,2) not null default '0.00' comment '���Եļ۸�',
primary key(goods_a_id),
key goods_id(goods_id),
key attr_id(attr_id)
)engine=MyISAM default charset=utf8 comment '��Ʒ����';

/********************************��Ʒ���**************************/
drop table IF EXISTS jd_goods_number;
create table jd_goods_number(
goods_number_id int unsigned not null  auto_increment comment '��Ʒ���id',
goods_id mediumint unsigned not null comment '��Ʒid',
goods_number int unsigned not null comment '��Ʒ���',
goods_attr_id varchar(150) not null comment '��Ʒ����ID�б�-ע��:�����id�������jd_goods_attr���id,ͨ�����id������֪��ֵ��ʲôҲ����֪��������ʲô������ж��id��Ͼͺ���,�Ÿ�������һ���ַ���,���Ҵ�ʱҪ��id�������,����ǰ̨��ѯ�����ʱҲҪ�Ȱ���Ʒ����id����ƴ���ַ�����ѯ���ݿ�',
primary key goods_number_id,
key goods_id(goods_id),
key goods_attr_id(goods_attr_id)
) engine=InnoDB default charset=utf8 comment '��Ʒ���';