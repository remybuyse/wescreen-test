<?php

class CommonModels
{
    public $table;
    public $primaryKey;
    public $cache;

    public function __construct() {
        $this->cache = new Cache();
    }

    public function pdoConnectUtf8() {
        try{
            $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USERNAME, DB_PWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        } catch (Exception $ex) {
            echo 'Erreur PDO : '. $ex->getMessage();
            die();
        }
        return $pdo;
    }

    public function insert($table, $datas, $id=false){
        $pdo = $this->pdoConnectUtf8();

        $query = "INSERT INTO " . $table . " (";
        $totalDatas = count($datas);
        $i = 1;
        foreach($datas as $key=>$value)
        {
            $query .= "`" . $key . "`";
            if($i < $totalDatas) $query .= ",";
            $i++;
        }
        $query .= ") VALUES (";
        $i = 1;
        foreach($datas as $key=>$value)
        {
            $query .= $pdo->quote($value);
            if($i < $totalDatas) $query .= ",";
            $i++;
        }
        $query .= ");";

        $result = $pdo->prepare($query);
        
        if($id){
            $result->execute();
            return $pdo->lastInsertId();
        } else {
            return $result->execute();
        }        
    }
    public function update($table, $datas, $where = null){
        $pdo = $this->pdoConnectUtf8();

        $query = "UPDATE " . $table . " SET";
        $totalDatas = count($datas);
        $i = 1;
        foreach($datas as $key=>$value){
            $query .= " `" . $key . "` = ". $pdo->quote($value);
            if($i < $totalDatas) $query .= ",";
            $i++;
        }
        if(isset($where) && !empty($where))
        {
            $query .= " WHERE " . $where;
        }
        $query .= ";";

        $result = $pdo->prepare($query);

        return $result->execute();
    }
}

