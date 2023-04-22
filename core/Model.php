<?php

namespace Core;

use PDO;
use PDOException;

class Model
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $db_name = DB_NAME;

    private $dbh;
    private $stmt;

    public $tableName = '';
    public $primaryKey = '';

    public function __construct()
    {
        // data source name
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;
        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
    public function getAll()
    {
        $sql = "SELECT * FROM " . $this->tableName;
        $this->query($sql);
        return $this->resultSet($sql);
    }

    public function insert($data)
    {
        $tableName = $this->tableName;

        $tableColumns = '';
        $tableValues = '';
        foreach ($data as $key => $value) {
            $tableColumns .= '' . $key . ', ';
            $tableValues .= ':' . $key . ', ';
        }
        $tableColumns = rtrim($tableColumns, ', ');
        $tableValues = rtrim($tableValues, ', ');

        $sql = "INSERT INTO $tableName ($tableColumns)
        VALUES($tableValues)";
        $this->query($sql);

        foreach ($data as $key => $value) {
            $this->bind(":$key", $value);
        }
        return $this->stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM $this->tableName WHERE $this->primaryKey = :" . $this->primaryKey;
        $this->query($sql);
        $this->bind(":" . $this->primaryKey, $id);
        return $this->single();
    }

    public function update($id, $data)
    {
        $updatedColumns = '';
        foreach ($data as $key => $value) {
            $updatedColumns .= '' . $key . ' = :' . $key . ", ";
        }
        $updatedColumns = rtrim($updatedColumns, ', ');
        $sql = "UPDATE $this->tableName SET $updatedColumns WHERE $this->primaryKey = :" . $this->primaryKey;
        $this->query($sql);

        foreach ($data as $key => $value) {
            $this->bind(":$key", $value);
        }
        $this->bind(":$this->primaryKey", $id);
        return $this->stmt->execute();
    }

    public function getByCondition($where, $like = [] , $orderBy = [], $limit = false, $offset = false)
    {
        $sql = "SELECT * FROM " . $this->tableName ;
        $whereCon = '';
        $likeCon = '';
        $orderByCon = '';
        foreach ($where as $key => $value) {
            if(is_array($value)){
                $inQuery = '';
                foreach($value as $k => $el) {
                    $inQuery .= ':'.$key.$k .',';
                }
                $inQuery = rtrim($inQuery, ',');
                $whereCon .= '' . $key . ' IN ( ' .  $inQuery . ' ) AND ';
            }else{
                $whereCon .= '' . $key . ' = :' . $key . ' AND ';
            }
        }
        $whereCon = rtrim($whereCon, ' AND ');

        foreach ($like as $key => $value) {
            $likeCon .=  $key . ' LIKE :' . $key . ' OR ';
        }
        $likeCon = rtrim($likeCon, ' OR ');

        if ($whereCon != '' &&  $likeCon != '') {
            $sql .=  " WHERE " . $whereCon . ' AND  ( ' . $likeCon .' )';
        }elseif($whereCon != '' || $likeCon != ''){
            $sql .=  " WHERE " . $whereCon .  $likeCon ;
        }

        foreach($orderBy as $key => $value){
            if($value == 'DESC'){
                $orderByCon .= ' ORDER BY ' . $key . ' DESC ' .' , ' ;
            }elseif($value == 'ASC'){
                $orderByCon .= ' ORDER BY ' . $key . ' DESC ' .' ,';
            }
        }
        $orderByCon = rtrim($orderByCon, ' , ');
        if ($orderByCon != '' && $value == 'DESC') {
            $sql .= $orderByCon ;
        }elseif($orderByCon != '' && $value == 'ASC'){
            $sql .=  $orderByCon;
        }
        if ($limit) {
            $sql .= " LIMIT " . $limit;
            if ($offset) {
                $sql .=  " OFFSET " . $offset;
            }
        }
        $this->query($sql);
        foreach ($where as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $id){
                    $this->bind(($key.$k), $id);
                }
            }else{
                $this->bind(":$key", $value);
            }
        }
        foreach ($like as $key => $value) {
            $this->bind(":$key", '%'.$value.'%');
        }

        return $this->resultSet();
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE $this->primaryKey = :" . $this->primaryKey;
        $this->query($sql);
        $this->bind(":" . $this->primaryKey, $id);
        return $this->single();
    }

    public function findOne($params)
    {
        $tableName = $this->tableName;
        $uniqueAttr = '';
        foreach($params as $key => $value){
            $uniqueAttr .= '' .$key. ' = :' . $key . ' AND ';
        }
        $uniqueAttr= rtrim($uniqueAttr, ' AND ');
        $sql = "SELECT * FROM $tableName " . " WHERE " .$uniqueAttr;
        $this->query($sql);
        foreach ($params as $key => $value){
            $this->bind(":$key", $value);       
        }
        return $this->single();
    }

    public function count()
    {
        $this->getAll();
        return $this->rowCount();
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        $this->stmt->execute();
    }

    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
