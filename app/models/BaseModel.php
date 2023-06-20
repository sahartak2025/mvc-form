<?php

namespace app\models;

use app\components\DB;
use PDO;
use ReflectionClass;
use ReflectionProperty;

abstract class BaseModel
{
    protected static array $columnsList = [];

    protected string $primaryKey = 'id';

    public function __construct()
    {
        if (empty(self::$columnsList[$this->getTable()])) {
            $stmt = $this->getConnection()->query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = '{$this->getTable()}'");
            $columns = $stmt->fetchAll();
            $columns = array_column($columns, 'COLUMN_NAME');
            self::$columnsList[$this->getTable()] = $columns;
        }
        foreach (self::$columnsList[$this->getTable()] as $column) {
            $this->{$column} = null;
        }
    }

    protected function getConnection(): ?PDO
    {
        return DB::getInstance()->getConnection();
    }

    public function save(): bool
    {
        if(!empty($this->{$this->primaryKey})) {
            return $this->update();
        }

        return $this->insert();
    }
    
    public function getAll(array $condition = []): array
    {
        $conn = $this->getConnection();
        $query = "SELECT * FROM {$this->getTable()}";
        $params = [];
        if (!empty($condition)) {
            $query .= ' WHERE';
            foreach ($condition as $key => $value) {
                $query .= ' ' . $key . ' = :' . $key . ' AND';
                $params[':' . $key] = $value;
            }
        }
        
        $stmt = $conn->prepare(trim($query, ' AND'));
        $stmt->execute($params);
        $data = $stmt->fetchAll();
        $result = [];

        foreach ($data as $dbItem) {
            $model = new static();
            $model->load($dbItem);
            $result[] = $model;
        }

        return $result;
    }

    public function update(): bool
    {
        $conn = $this->getConnection();
        $query = "UPDATE {$this->getTable()} SET ";
        $params = [];
        foreach ($this->getColumnsWithoutPrimary() as $columnName) {
            $query .= $columnName . ' = ' . ':' . $columnName . ', ';
            $params [':' . $columnName] = is_string($this->{$columnName}) ? $this->prepareValue($this->{$columnName}) : $this->{$columnName};
        }
        $params [':' . $this->primaryKey] = $this->{$this->primaryKey};
        $query = trim($query, ', ') . ' WHERE ' . $this->primaryKey . ' = :' . $this->primaryKey;
        $stmt = $conn->prepare($query);

        return $stmt->execute($params);
    }

    public function insert(): bool
    {
        $conn = $this->getConnection();
        $insertColumns = implode(',', $this->getColumnsWithoutPrimary());
        $query = "INSERT INTO {$this->getTable()}({$insertColumns}) VALUES(";
        $params = [];
        foreach ($this->getColumnsWithoutPrimary() as $columnName) {
            $query .= ':' . $columnName . ', ';
            $params [':' . $columnName] = is_string($this->{$columnName}) ? $this->prepareValue($this->{$columnName}) : $this->{$columnName};
        }
        $query = trim($query, ', ') . ')';
        $stmt = $conn->prepare($query);

        $success = $stmt->execute($params);
        if ($success) {
            $this->{$this->primaryKey} = $conn->lastInsertId();
        }

        return $success;
    }

    public function load(array $data): void
    {

        foreach ($data as $key => $value) {
            if (!in_array($key, self::$columnsList[$this->getTable()])) {
                throw new \Error('Undefined column');
            }
            $this->{$key} = $value;
        }
    }

    protected function getColumnsWithoutPrimary()
    {
        $columns = self::$columnsList[$this->getTable()];

        return array_filter($columns, function ($item) {
           return $item !== $this->primaryKey;
        });
    }

    protected function prepareValue(string $value): string
    {
        return strip_tags($value);
    }

    abstract public function getTable(): string;
}