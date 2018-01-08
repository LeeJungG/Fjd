<?php
function removeXSS($val)
{
	static $obj = null;
	if($obj === null){
		require('./HTMLPurifier/HTMLPurifier.includes.php');
		$config = HTMLPurifier_Config::createDefault();
		$config->set('HTML.TargetBlank',TRUE);
		$obj = new HTMLPurifier($config);
	}
	return $obj->purify($val);
}
//商品上传函数
//1.数据
//1.目录
//1.缩略图大小
function uploadOne($imgName,$dirName,$thumb = array()){
	//上传logo
	if(isset($_FILES[$imgName]) && $_FILES[$imgName]['error'] == 0){
			$lj = C('rootPath');
			$upload = new \Think\Upload(
				array(
					'rootPath' => $lj,
					'exts'	   => C('exts'),
					'maxSize'  => (int) C('maxSize')* 1024 * 1024,
					'savePath' => $dirName.'/',
					)
				);
			$info = $upload->upload(array($imgName =>$_FILES[$imgName]));

			if(!$info){
				return array(
					'ok' => 0,
					'error' => $upload->getError(),
					);
			}else{
				$ret['ok'] = 1;
				$ret['images'][0] = $logoName = $info[$imgName]['savepath'].$info[$imgName]['savename'];
				if($thumb){
					$image = new \Think\Image();
					//循环生成缩略图
					foreach ($thumb as $k => $v) {
						$ret['images'][$k+1] = $info[$imgName]['savepath'].'so_'.$info[$imgName]['savename'];
						$image->open($lj.$logoName);
						$image->thumb($v[0],$v[1])->save($lj.$ret['images'][$k+1]);

					}
				}
				return $ret;
			}
	}
}
//显示图片函数
function showImage($url,$width='',$height=''){
	$img = C('rootPath2').$url;
	if($width){
		$width = "width='$width'";
	}
	if($height){
		$height = "height='$height'";
	}
	echo "<img src='$img' $width $height />";
}

//删除图片函数
function deleteImage ($Image){
	$rn = C('rootPath');
	foreach ($Image as $v) {
		@unlink($rn.$v);
	}
}

//处理多张图片
function ximo($imgName)
{
	foreach ($_FILES[$imgName]['error'] as $key => $value) {
		if($value == 0)
			return true;

	}
	return false;
}
//二维数组排序
function atrank($a,$b)
{
	if($a['attr_id'] == $b['attr_id'])
	{
		return 0;
	}
	return ($a['attr_id'] < $b['attr_id']) ? -1 : 1;
}
//发邮箱函数
function sendMail($to,$title,$content)
{
	require_once('./PHPMailer_v5.1/class.phpmailer.php');
	$mail = new PHPMailer();
	//设置为要发邮件
	$mail->IsSMTP();
	//是否允许发送HTML代码做为邮件的内容
	$mail->IsHTML(TRUE);
	//是否需要身份验证
	$mail->SMTPAuth=TRUE;
	$mail->CharSer='UTF-8';
	/*邮件服务器是的账号是什么*/
	$mail->FROM=C('MAIL_ADDRESS');
	$mail->FromName=C('MAIL_FROM');
	$mail->Host=C('MAIL_SMTP');
	$mail->Username=C('MAIL_LOGINNAME');
	$mail->Password=C('MAIL_PASSWORD');
	//发邮件端口号默认25
	$mail->Port = 25;
	//收件人
	$mail->addAddress($to);
	//邮件标题
	$mail->Subject=$title;
	//邮件内容
	$mail->Body=$content;
	return($mail->Send());
}