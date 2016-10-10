<?php 
namespace Vendor\qianren;

class qianren
{
	public static $config = [];//���load�����������ļ�������п���ֱ�ӷ���
    /*
    ** ����һЩ�����������ļ���������������ļ�
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