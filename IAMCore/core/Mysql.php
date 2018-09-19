<?php
namespace Iam;

use PDO;

class Mysql {//数据库操作类基于PDO
    var $pdo;
    var $query;
    var $dataList;
    function __construct($config){//链接数据库
        //$config = config('mysql');
        $this->pdo = new PDO('mysql:host='.$config['host'].';port='.$config['port'].';dbname='.$config['dbname'].';charset=utf8',$config['user'],$config['pass']);
    }

    function prepare($sql){//数据查询
        return $this->pdo->prepare($sql);
    }

    function bindValue($dataArray = array()){//设置参数
        $times = 0;
        if(!empty($dataArray) &&is_array($dataArray)){
            foreach ($dataArray as $key => $value) {
                $this->query->bindValue($key+1,$value);
                $times++;
            }
        }
        return $times;
    }

    function execute($dataArray){//执行SQL
       	$back = $this->query->execute($dataArray);
    	if($this->pdo->errorCode() != '00000'){
			$back = $this->pdo->errorInfo();
		}
		return $back;
    }

    function fetchOne(){
        return $this->query->fetch(PDO::FETCH_ASSOC);
    }

    function count(){
        return $this->query->rowCount();
    }

    function fetchAll(){//返回所有数据
        return $this->query->fetchAll(PDO::FETCH_ASSOC);
    }

    function setFetch($mod){//设置PDO::FETCH
        return $this->pdo->setFetchMode($mod);
    }

    function lastID(){
        return $this->pdo->lastInsertId();
    }

    function query($sql){//执行SQL
//            return $this->pdo->query($sql, $data, true, false);
        if(preg_match("/\?|:/",$sql)<=0){
            return $this->query = $this->pdo->query($sql);
        }else{
            return $this->query = $this->prepare($sql);
        }
    }

    function exec($sql){
    	$back = $this->pdo->exec($sql);
    	if($this->pdo->errorCode() != '00000'){
			$back = $this->pdo->errorInfo();
		}
        return $back;
    }
}
