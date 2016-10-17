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
class Url
{
	private $SCHEME = 'scheme';//http
	private $HOST = 'host';//����
	private $USER = 'user';//��¼�û���
	private $PASS = 'pass';//��¼����
	private $PATH = 'path';//·��
	private $QUERY = 'query';//����
	private $FRAGMENT = 'fragment';//ê�����
	private $DIRNAME = 'dirname';//Ŀ¼
	private $BASENAME = 'basename';//�ļ���������׺
	private $EXTENSION = 'extension';//��׺
	private $FILENAME = 'filename';//�ļ�����������׺
	
	/**
	*	Usage:			��ȡ��ǰurl
	*	@return string	���ص�ǰurl
	*/
	public function getUrl(){
		return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
	
	/**
	*	Usage:			����url
	*	$param string $url ��Ҫ������url
	*	$param string $option ��Ҫ���صĲ��� 
	*					����Ϊ��SCHEME HOST USER PASS PATH QUERY FRAGMENT��������Ľ�������ο������
	*	@return string | bool 	
	*/
	public function parseUrl( $url , $option = 'Hs'){
		$option = strtoupper($option);
		//�̽���
		if(!isset($this->$option)){
			$option = $this->parseShort($option);
		}
		//��������ڱ������򷵻�false
		if(!isset($this->$option)){
			return false;
		}
		
		return parse_url( $url )[$this->$option];
	}
	
	/**
	*	Usage:			����url·��
	*	@param string $url ��Ҫ������url
	*	@param string $option ��Ҫ����ֵ�Ĳ���
	*					����Ϊ��DIRNAME BASENAME EXTENSION FILENAME��������Ľ�������ο������		
	*	@return $string | bool
	*/
	public function parseUrlPath( $url , $option = 'ext'){		
		//�̽���
		if(!isset($this->$option)){
			$option = $this->parseShort($option);
		}
		//��������ڱ������򷵻�false
		if(!isset($this->$option)){
			return false;
		}
		
		$urlPath = $this->parseUrl( $url , 'path' );
		return pathinfo( $urlPath )[$this->$option];
	}
	
	/**
	*	Usage:			����ȥ��http://
	*	@param string $url ��Ҫ������url
	*	@param string $option ���ص�ǰ׺ Ĭ�ϣ�http://
	*	@return $string 
	*/
	public function parseUrlHttp( $url , $pre = '' ){
		if(empty( $url )){
			return false;
		}
		$arrUrlParam = ['host'=>'','path'=>'','query'=>'','fragment'=>'','port'=>'','scheme'=>''];
		$arrUrl = array_merge( $arrUrlParam , parse_url( $url ));

		//�Ƿ���http(scheme)
		if(!empty($arrUrl['scheme'])){
			$pre = $arrUrl['scheme'].'://';
		}else{
			$pre = 'http://';
		}
		//�Ƿ��в���
		if(!empty($arrUrl['query'])){
			$query = '?'.$arrUrl['query'];
		}else{
			$query = '';
		}
		//�Ƿ���ê��fragment
		if(!empty($arrUrl['fragment'])){
			$fragment = '#'.$arrUrl['fragment'];
		}else{
			$fragment = '';
		}
		
		return $pre.$arrUrl['host'].$arrUrl['port'].$arrUrl['path'].$query.$fragment;
	}
	
	/**
	*	Usage:			�����̲���
	*	@param string $shortLabel ��Ҫ�����Ķ̲���
	*	@return string 
	*/
	private function parseShort( $shortLabel ){
		$shortLabel = strtoupper($shortLabel);
		$short = [
			'S'=>'SCHEME',//http
			'H'=>'HOST',//����
			'U'=>'USER',//��¼�û���
			'PS'=>'PASS',//��¼����
			'PT'=>'PATH',//·��
			'Q'=>'QUERY',//����
			'PARAM'=>'QUERY',//����
			'F'=>'FRAGMENT',//ê�����
			'MAODIAN'=>'FRAGMENT',//ê�����
			'D'=>'DIRNAME',//Ŀ¼
			'DIR'=>'DIRNAME',//Ŀ¼
			'B'=>'BASENAME',//�ļ���������׺
			'E'=>'EXTENSION',//��׺
			'EXT'=>'EXTENSION',//��׺
			'HZ'=>'EXTENSION',//��׺
			'HOUZUI'=>'EXTENSION',//��׺
			'F'=>'FILENAME',//�ļ����� ������׺
		];
		return isset($short[$shortLabel])?$short[$shortLabel]:$shortLabel;
	}
	
	
}