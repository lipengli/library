<?php 
namespace Vendor\qianren;

class qianren
{
	public static $config = [];//存放load进来的配置文件，如果有可以直接返回
    /*
    ** 加载一些其他的配置文件，按需加载配置文件
    */    
    public static function load($configFileName) {
        if (isset(self::$config[$configFileName])) {
            return self::$config[$configFileName];    
        }
        $fileName = __DIR__ . '/config/' . $configFileName . '.php';
        if (file_exists($fileName)) {
            $config = require_once($fileName);
            self::$config[$configFileName] = $config;
            return $config;    
        }
        return [];
    }
}