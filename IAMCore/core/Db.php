<?php
namespace Iam;

use Iam\Config;
use Iam\Mysql;

class Db
{
    private static $init = false;
    public static $db;
    private static $model = [];

    private $tableName; //表名
    private $field = "*"; //字段名
    private $where = []; //条件
    private $data = [];//数据
    private $fill = [];//填充数据

    public function __construct($config = [])
    {//链接数据库
        self::init();
    }

    public static function init()
    {
        if(!self::$init){
            if (empty($config)) {
                $config = Config::set(include APP_PATH . 'datebase' . EXT); //设置并返回配置
            }
            self::$db = new Mysql($config);
            self::$init = true;
        }
    }

    //Db::table('user')->where()->select();
    public static function table($name){//设置表名
        // if (isset(self::$model[$name])) {
        //     return self::$model[$name];
        // }

        $db = new Db(); //实例化新对象
        $db->setTable($name); //设置操作的模型
        self::$model[$name] = $db; //缓存到静态变量
        return $db;
    }

    public function setTable($name)
    {//设置表名
        $this->tableName = "`{$name}`";
    }

    public function field($field)
    {//设置字段名
        if (is_array($field)) {
            $field = '`' . implode('`,`', $field) . '`';
        }
    	$this->field = $field;
        return $this;
    }

    public function select($min = null,$max = null){//查询 $min,$max 用于LIMIT 查询
    	$this->_select($min,$max);
    	return self::$db->fetchAll();
    }

    public function reset()
    {

    }

    private function _select($min = null,$max = null){//查询实现

    	$sql = "SELECT $this->field FROM $this->tableName";
        $sql .= $this->parseWhere();

        if(isset($this->order)) $sql .= " ORDER BY $this->order"; //排序
        if(isset($min) && isset($max)) $sql .= " LIMIT $min,$max";
    	$this->fill($sql);
    }
    public function find($id = null,$value = null){ //查询单条数据
        if($value !== null){
            $this->where($id,$value);
        }else if($id !== null){
            $this->where("id",$id);
        }
    	$this->_select(0,1);
    	return self::$db->fetchOne();
    }
    public function data($data,$value = null){//设置操作数据
        if($value){
            $this->data = array();
            $this->data[$data] = $value;
        }else{
            $this->data = $data;
        }
        return $this;
    }

    public function where($data,$value = null){ //设置查询条件
        if (is_string($value)) {
            $this->where = [$data => $value];
        } else if (is_array($value)) {
            $this->whereStr = $data;
            $this->fill = $value;
        } else if (is_array($data)) {
            $this->where = $data;
        } else {
            $this->whereStr = $data;
        }
        return $this;
    }

    private function getWhere(){ //获取查询条件
        if(!isset($this->whereStr)){
            if(!empty($this->where) && is_array($this->where)){
                // $where = array_keys($this->where);
                // $this->fill = array();
                // $this->fill = array_values($this->where);

        // print_r("\n");
        // print_r($where);
                foreach ($this->where as $key => $value) {
                    $where[] = "`$key` = :$key";
                    $this->fill[":$key"] = $value;
                }
                $this->where = [];
                $this->whereStr = join(" AND ",$where);
            }
        }
        if (!empty($this->whereStr)) {
            $this->whereStr = '';
            return " WHERE $this->whereStr";
        }
    }

    private function parseWhere() //解析条件语句
    {
        if (!empty($this->where)) {
            foreach ($this->where as $key => $value) {
                $where[] = "`{$key}` = :{$key}";
                $this->fill[":{$key}"] = $value;
            }
            $this->whereStr = join(" AND ", $where);
        }

        if (!empty($this->whereStr)) {
            return " WHERE {$this->whereStr}";
        }
    }

    // where([
    //     'username' => ['>', '15'],
    //     'id' => ['=', '15'],
    // ]);
    //where('username=%d and id=%d')->fill([])->select();
    public function order($sql){
        if (is_array($sql)) {
            $order = [];
            foreach ($sql as $key => $value) {
                $order[] = '`' . $key . '`'. ' ' . $value;
            }
            $sql = implode(',', $order);
        }
        $this->order = $sql;
        return $this;
    }

    private function parseParams($data)
    {
        $where = $this->whereStr;
        preg_replace_callback('/%d/', function($matches) {
            print_r($matches);
        }, $this->whereStr);
        // preg_match_all('/%d/', $this->whereStr, $matches);
        // print_r($matches[0]);
        die();
    }

    private function fill($sql){ //充填参数
        self::$db->query($sql);
        if(!empty($this->fill)){
            $result = self::$db->execute($this->fill);
            $this->fill = [];
            $this->where = [];
            $this->whereStr = '';
            return $result;
        }
    }

    public function update($data,$value = null){//更新
        if($data) $this->data($data,$value);
        $sql = "UPDATE $this->tableName SET ".$this->parseSet().$this->parseWhere();
        return $this->fill($sql);
    }

    private function parseSet(){//格式化UPATE SET数据
        $dataValue = array();

        foreach ($this->data as $key => $value) {
            $firstStr = substr($key, 0,1);
            if($firstStr == "+" || $firstStr == "-"){
                $key = substr($key, 1);
                $dataValue[] = "`$key`=`$key`$firstStr:$key";
            }else{
                $dataValue[] = "`$key`=:$key";
            }
            $this->fill[":$key"] = $value;
        }
        return join(",",$dataValue);
    }

    private function getData(){//格式化INSERT INTO数据
        $dataValue = array();
        $dataKey = array();
        if(!isset($this->fill)) $this->fill = array();
        foreach ($this->data as $key => $value) {
            // $firstStr = substr($key, 0,1);
            // $key = substr($key, 1);
            $dataValue[] = ":$key";
            $dataKey[] = "`$key`";
            $this->fill[":$key"] = $value;
        }
        $dataKey = array_values($dataKey);
        return "(".join(",",$dataKey).") VALUES (".join(",",$dataValue).")";
    }

    public function add($data,$value = null){ //插入数据
        if($data) $this->data($data,$value);
        $sql = "INSERT INTO $this->tableName ".$this->getData();
        if ($this->fill($sql)) {
            return self::$db->pdo->lastInsertId();
        }
    }

    public function remove(){
        $sql = "DELETE FROM $this->tableName ".$this->parseWhere();
        return $this->fill($sql);
    }

    public static function query($sql, $data = [])
    {
        self::init();
        self::$db->query($sql);
        self::$db->execute($data);
        return self::$db->fetchAll();
    }
}
