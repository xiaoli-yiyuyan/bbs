<?php
namespace Iam;

class Cache{
    //缓存类
    public $dir = "cache/";//缓存路径
    public $name;
    public $path;

	public function __construct($dir = '', $name = '')
	{
        if (strlen($dir)) {
            $this->dir = $dir;
        }
        if (strlen($name)) {
            $this->setName($name);
        }
	}

    public function setName($name)
    {

        $this->name = $name;
        $this->path = realpath($this->dir) . DS . $name . ".php"; //设置缓存文件名
    }

    public function set($value)
    { //创建缓存
        $dir = dirname($this->path);
        if (!is_dir($dir)){
            mkdir ($dir,0777,true);
        }
        $file = fopen($this->path, "w");
        $value = var_export($value, true); //数组转换为字符串数组
        $value = "<?php return $value ?>";

        fwrite($file, $value);
        fclose($file);
        return $this;
    }
    public function get($name = '')
    { //查询缓存
        
        if (strlen($name)) {
            $this->setName($name);
        }
        if(!isset($this->cacheData)){
            $this->cacheData = file_exists($this->path) ? include($this->path) : array();
        }
        return $this->cacheData;
    }

    public function save($data, $value = null)
    { //保存修改，没有对应缓存文件则新增
        $this->get();
        isset($value) ? $this->cacheData[$data] = $value : $this->cacheData = array_merge($this->cacheData,$data);
        $this->set($this->cacheData);
        return $this;
    }

    public function remove($name = '')
    {
        if (strlen($name)) {
            $this->setName($name);
        }
        unlink($this->path);
    }
}
?>