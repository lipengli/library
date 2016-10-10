<?php 
/**
*	@purpose:阿里大鱼 短信验证
*/
namespace Vendor\common;
use Vendor\common\Load;

class alidayu
{
	/**
	*	短信发送
	*	@num string 手机号码
	*	@option array 参数
	*/
	public static function smsSend($num,$option = []){
		$option = array_merge(['extend'=>'123456','signName'=>'登录验证','param'=>'{"code":"1234","product":"****科技"}','templateCode'=>'SMS_111111'],$option);//合并外置参数
		$alidayuConfig = Load::load('alidayu');//引入配置文件
		include __DIR__ .'/extenstion/alidayu/TopSdk.php';//加载阿里大鱼类
		date_default_timezone_set('Asia/Shanghai'); //设置区域时间
		
		
		$c = new \TopClient;
		$c->appkey = $alidayuConfig['appkey'];
		$c->secretKey = $alidayuConfig['secretKey'];
		$req = new \AlibabaAliqinFcSmsNumSendRequest;
		//如果不懂下面都传的是什么参数，请参考阿里大鱼API文档 https://api.alidayu.com/doc2/apiDetail?spm=a3142.7791109.1.19.9LfKIl&apiId=25450
		$req->setExtend($option['extend']);
		$req->setSmsType("normal");
		$req->setSmsFreeSignName($option['signName']);
		$req->setSmsParam($option['param']);
		$req->setRecNum($num);
		$req->setSmsTemplateCode($option['templateCode']);
		return $c->execute($req);
	}
}