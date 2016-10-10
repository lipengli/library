<?php 
// +----------------------------------------------------------------------
// | ��װ���õ����
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Author: lip 
// +----------------------------------------------------------------------
class common
{
	/**
	*	Usage:			��ȡαip
	*	@return string	����һ���ٵ�ip
	*/
	public function getFalseIp(){
		$ip_long = array(
			array('607649792', '608174079'), //36.56.0.0-36.63.255.255
			array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
			array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
			array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
			array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
			array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
			array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
			array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
			array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
			array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
		);
		$rand_key = mt_rand(0, 9);
		$ip= long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
		return $ip;
	}
	
	/**
	*	Usage:		   		��ȡ�ִ�
	*	@param $string 		��Ҫ��ȡ���ִ�
	*	@param $length 		��Ҫ��ȡ�ĳ���
	*	@param $suffix		��ȡ��׷�ӵ�չʾ��
	*	@param $encoding 	��ȡ���ִ��ı���
	*	@return string 		����һ����ȡ���ִ� 
	*/
	public function truncate($string, $length, $suffix = '...', $encoding = null)
    {
        if (mb_strlen($string, $encoding ?:  'utf-8') > $length) {
            return trim(mb_substr($string, 0, $length, $encoding ?:  'utf-8')) . $suffix;
        } else {
            return $string;
        }
    }
	
	/**
	*	Usage:		   ͨ�����ݿ��޸�
	*	@param $table  ���������ݿ�
	*	@param $field  �������ֶ�
	*	@param $value  �ֶ�Ҫ�����ֵ
	*	@param $where  ɸѡ����
	*	@return bool   ����״̬���ɹ�����true��ʧ�ܷ���false
	*	E.g. :	$table = user,$file = 'name',$value = 'qinz',$where = ',name = lip';
	*			��user���е�name = 'lip'�ļ�¼����Ϊname = 'qinz'��
	*
	*	Ver : 1.0.0	
	*/
	public function updateFieldInfo($table,$field,$value,$where){
		$sql = "UPDATE ". $table ." SET ". $field ." = '". $value ."'";
		if(empty($where)){
			$sql .= " WHERE ".$where;
		}
		if($this->query($sql)){
			return true;
		}
		return false;
		
	}
	
	/**
	*	Usage:	�����ִ�Сд��in_arrayʵ��
	*	@return ���� bool �ҵ��򷵻� TRUE�����򷵻� FALSE��
	*/
	function in_array_case($value,$array){
		return in_array(strtolower($value),array_map('strtolower',$array));
	}
	
	/**
	 * Usage:				����HTTP״̬
	 * @param integer $code ״̬��
	 * @return void
	 */
	function send_http_status($code) {
		static $_status = array(
				// Informational 1xx
				100 => 'Continue',
				101 => 'Switching Protocols',
				// Success 2xx
				200 => 'OK',
				201 => 'Created',
				202 => 'Accepted',
				203 => 'Non-Authoritative Information',
				204 => 'No Content',
				205 => 'Reset Content',
				206 => 'Partial Content',
				// Redirection 3xx
				300 => 'Multiple Choices',
				301 => 'Moved Permanently',
				302 => 'Moved Temporarily ',  // 1.1
				303 => 'See Other',
				304 => 'Not Modified',
				305 => 'Use Proxy',
				// 306 is deprecated but reserved
				307 => 'Temporary Redirect',
				// Client Error 4xx
				400 => 'Bad Request',
				401 => 'Unauthorized',
				402 => 'Payment Required',
				403 => 'Forbidden',
				404 => 'Not Found',
				405 => 'Method Not Allowed',
				406 => 'Not Acceptable',
				407 => 'Proxy Authentication Required',
				408 => 'Request Timeout',
				409 => 'Conflict',
				410 => 'Gone',
				411 => 'Length Required',
				412 => 'Precondition Failed',
				413 => 'Request Entity Too Large',
				414 => 'Request-URI Too Long',
				415 => 'Unsupported Media Type',
				416 => 'Requested Range Not Satisfiable',
				417 => 'Expectation Failed',
				// Server Error 5xx
				500 => 'Internal Server Error',
				501 => 'Not Implemented',
				502 => 'Bad Gateway',
				503 => 'Service Unavailable',
				504 => 'Gateway Timeout',
				505 => 'HTTP Version Not Supported',
				509 => 'Bandwidth Limit Exceeded'
		);
		if(isset($_status[$code])) {
			header('HTTP/1.1 '.$code.' '.$_status[$code]);
			// ȷ��FastCGIģʽ������
			header('Status:'.$code.' '.$_status[$code]);
		}
	}
}