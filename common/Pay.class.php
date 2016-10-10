<?php 
namespace Vendor\common;

use Vendor\common\Load;
/**
*	支付
*	测试类于：index.php/Home/PayDemo/demoPayView
*/
class pay
{
	/**
	*	demoview 支付测试页面
	*/
	public static function demoView(){
		$views = include(__DIR__ .'/extenstion/pingppcclient/example-wap/views/demo-pc.html');
		echo $views;
	}
	/**
	*	demoPay	支付测试数据
	*/
	public static function demoPay(){
		$input_data = json_decode(file_get_contents('php://input'), true);
		if (empty($input_data['channel']) || empty($input_data['amount'])) {
			echo 'channel or amount is empty';
			exit();
		}
		return $input_data;
	}
	
	/**
	*	支付执行
	*/
	public static function payRun($config = []){
		include __DIR__ .'/extenstion/pingpay/init.php';//
		$payConfig = Load::load('pay');
		$payConfig = array_merge($payConfig,$config);//合并配置
		//print_r($payConfig);
		// api_key、app_id 请从 [Dashboard](https://dashboard.pingxx.com) 获取
		//$api_key = 'sk_test_ibbTe5jLGCi5rzfH4OqPW9KC';
		//$app_id = 'app_1Gqj58ynP0mHeX1q';

		// 此处为 Content-Type 是 application/json 时获取 POST 参数的示例
		
		$channel = strtolower($payConfig['channel']);
		$amount = $payConfig['amount'];
		$orderNo = $payConfig['order_no'];


		/**
		 * $extra 在使用某些渠道的时候，需要填入相应的参数，其它渠道则是 array()。
		 * 以下 channel 仅为部分示例，未列出的 channel 请查看文档 https://pingxx.com/document/api#api-c-new
		 */
		$extra = array();
		switch ($channel) {
			case 'alipay_wap':
				$extra = array(
					'success_url' =>  $payConfig['successUrl'],
					'cancel_url' => 'http://example.com/cancel'
				);
				break;
			case 'alipay_pc_direct':
				$extra = array(
					'success_url' => $payConfig['successUrl'],
				);
				break;
			case 'bfb_wap':
				$extra = array(
					'result_url' =>  $payConfig['successUrl'],
					'bfb_login' => true
				);
				break;
			case 'upacp_wap':
				$extra = array(
					'result_url' =>  $payConfig['successUrl']
				);
				break;
			case 'wx_pub':
				$extra = array(
					'open_id' => 'openidxxxxxxxxxxxx'
				);
				break;
			case 'wx_pub_qr':
				$extra = array(
					'product_id' => 'Productid'
				);
				break;
			case 'yeepay_wap':
				$extra = array(
					'product_category' => '1',
					'identity_id'=> 'your identity_id',
					'identity_type' => 1,
					'terminal_type' => 1,
					'terminal_id'=>'your terminal_id',
					'user_ua'=>'your user_ua',
					'result_url'=> $payConfig['successUrl']
				);
				break;
			case 'jdpay_wap':
				$extra = array(
					'success_url' =>  $payConfig['successUrl'],
					'fail_url'=> 'http://example.com/fail',
					'token' => 'dsafadsfasdfadsjuyhfnhujkijunhaf'
				);
				break;
		}

		// 设置 API Key
		\Pingpp\Pingpp::setApiKey($payConfig['api_test_key']);
		try {
			$ch = \Pingpp\Charge::create(
				array(
					'subject'   => $payConfig['payObject'],
					'body'      => 'Your Body',
					'amount'    => $amount,
					'order_no'  => $orderNo,
					'currency'  => 'cny',
					'extra'     => $extra,
					'channel'   => $channel,
					'client_ip' => $_SERVER['REMOTE_ADDR'],
					'app'       => array('id' => $payConfig['api_id'])
				)
			);
			echo $ch;
		} catch (\Pingpp\Error\Base $e) {
			// 捕获报错信息
			if ($e->getHttpStatus() != NULL) {
				header('Status: ' . $e->getHttpStatus());
				echo $e->getHttpBody();
			} else {
				echo $e->getMessage();
			}
		}
	}
}