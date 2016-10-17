<?php 
// +----------------------------------------------------------------------
// | 封装常用的类库
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
	private $HOST = 'host';//域名
	private $USER = 'user';//登录用户名
	private $PASS = 'pass';//登录密码
	private $PATH = 'path';//路径
	private $QUERY = 'query';//参数
	private $FRAGMENT = 'fragment';//锚点参数
	private $DIRNAME = 'dirname';//目录
	private $BASENAME = 'basename';//文件名，带后缀
	private $EXTENSION = 'extension';//后缀
	private $FILENAME = 'filename';//文件名，不带后缀
	
	/**
	*	Usage:			获取当前url
	*	@return string	返回当前url
	*/
	public function getUrl(){
		return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
	
	/**
	*	Usage:			解析url
	*	$param string $url 需要解析的url
	*	$param string $option 需要返回的参数 
	*					可以为：SCHEME HOST USER PASS PATH QUERY FRAGMENT具体参数的解析，请参考类变量
	*	@return string | bool 	
	*/
	public function parseUrl( $url , $option = 'Hs'){
		$option = strtoupper($option);
		//短解析
		if(!isset($this->$option)){
			$option = $this->parseShort($option);
		}
		//如果不存在变量，则返回false
		if(!isset($this->$option)){
			return false;
		}
		
		return parse_url( $url )[$this->$option];
	}
	
	/**
	*	Usage:			解析url路径
	*	@param string $url 需要解析的url
	*	@param string $option 需要返回值的参数
	*					可以为：DIRNAME BASENAME EXTENSION FILENAME具体参数的解析，请参考类变量		
	*	@return $string | bool
	*/
	public function parseUrlPath( $url , $option = 'ext'){		
		//短解析
		if(!isset($this->$option)){
			$option = $this->parseShort($option);
		}
		//如果不存在变量，则返回false
		if(!isset($this->$option)){
			return false;
		}
		
		$urlPath = $this->parseUrl( $url , 'path' );
		return pathinfo( $urlPath )[$this->$option];
	}
	
	/**
	*	Usage:			解析去除http://
	*	@param string $url 需要解析的url
	*	@param string $option 返回的前缀 默认：http://
	*	@return $string 
	*/
	public function parseUrlHttp( $url , $pre = '' ){
		if(empty( $url )){
			return false;
		}
		$arrUrlParam = ['host'=>'','path'=>'','query'=>'','fragment'=>'','port'=>'','scheme'=>''];
		$arrUrl = array_merge( $arrUrlParam , parse_url( $url ));

		//是否有http(scheme)
		if(!empty($arrUrl['scheme'])){
			$pre = $arrUrl['scheme'].'://';
		}else{
			$pre = 'http://';
		}
		//是否有参数
		if(!empty($arrUrl['query'])){
			$query = '?'.$arrUrl['query'];
		}else{
			$query = '';
		}
		//是否有锚点fragment
		if(!empty($arrUrl['fragment'])){
			$fragment = '#'.$arrUrl['fragment'];
		}else{
			$fragment = '';
		}
		
		return $pre.$arrUrl['host'].$arrUrl['port'].$arrUrl['path'].$query.$fragment;
	}
	
	/**
	*	Usage:			解析短参数
	*	@param string $shortLabel 需要解析的短参数
	*	@return string 
	*/
	private function parseShort( $shortLabel ){
		$shortLabel = strtoupper($shortLabel);
		$short = [
			'S'=>'SCHEME',//http
			'H'=>'HOST',//域名
			'U'=>'USER',//登录用户名
			'PS'=>'PASS',//登录密码
			'PT'=>'PATH',//路径
			'Q'=>'QUERY',//参数
			'PARAM'=>'QUERY',//参数
			'F'=>'FRAGMENT',//锚点参数
			'MAODIAN'=>'FRAGMENT',//锚点参数
			'D'=>'DIRNAME',//目录
			'DIR'=>'DIRNAME',//目录
			'B'=>'BASENAME',//文件名，带后缀
			'E'=>'EXTENSION',//后缀
			'EXT'=>'EXTENSION',//后缀
			'HZ'=>'EXTENSION',//后缀
			'HOUZUI'=>'EXTENSION',//后缀
			'F'=>'FILENAME',//文件名称 不带后缀
		];
		return isset($short[$shortLabel])?$short[$shortLabel]:$shortLabel;
	}
	
	
}