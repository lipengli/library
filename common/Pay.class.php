<?php 
namespace Vendor\common;

use Vendor\common\Load;
/**
*	֧��
*	�������ڣ�index.php/Home/PayDemo/demoPayView
*/
class pay
{
	/**
	*	demoview ֧������ҳ��
	*/
	public static function demoView(){
		$views = include(__DIR__ .'/extenstion/pingppcclient/example-wap/views/demo-pc.html');
		echo $views;
	}
	/**
	*	demoPay	֧����������
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
	*	֧��ִ��
	*/
	public static function payRun($config = []){
		include __DIR__ .'/extenstion/pingpay/init.php';//
		$payConfig = Load::load('pay');
		$payConfig = array_merge($payConfig,$config);//�ϲ�����
		//print_r($payConfig);
		// api_key��app_id ��� [Dashboard](https://dashboard.pingxx.com) ��ȡ
		//$api_key = 'sk_test_ibbTe5jLGCi5rzfH4OqPW9KC';
		//$app_id = 'app_1Gqj58ynP0mHeX1q';

		// �˴�Ϊ Content-Type �� application/json ʱ��ȡ POST ������ʾ��
		
		$channel = strtolower($payConfig['channel']);
		$amount = $payConfig['amount'];
		$orderNo = $payConfig['order_no'];


		/**
		 * $extra ��ʹ��ĳЩ������ʱ����Ҫ������Ӧ�Ĳ����������������� array()��
		 * ���� channel ��Ϊ����ʾ����δ�г��� channel ��鿴�ĵ� https://pingxx.com/document/api#api-c-new
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

		// ���� API Key
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
			// ���񱨴���Ϣ
			if ($e->getHttpStatus() != NULL) {
				header('Status: ' . $e->getHttpStatus());
				echo $e->getHttpBody();
			} else {
				echo $e->getMessage();
			}
		}
	}
}