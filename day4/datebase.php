<?php
include_once('config.php');

class Database {
    private $pdo;

    public function __construct($host, $database, $username, $password) {
        $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \PDOException("Connection failed: " . $e->getMessage(), (int)$e->getCode());
        }
    }

    public function insert($tablename, $columns, $values) {
        if (count($columns) !== count($values)) {
            throw new Exception("Number of columns does not match number of values.");
        }

        $placeholders = array_map(fn($col) => ":$col", $columns);
        $sql = "INSERT INTO $tablename (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->pdo->prepare($sql);

        $params = array_combine($placeholders, $values);
        $stmt->execute($params);

        return $this->pdo->lastInsertId();
    }
    public function update($tablename, $columns, $values, $condition) {
        if (count($columns) !== count($values)) {
            throw new Exception("Number of columns does not match number of values.");
        }
    
        $setClause = implode(', ', array_map(fn($col) => "$col = :$col", $columns));
    
        $sql = "UPDATE $tablename SET $setClause WHERE $condition";
        $stmt = $this->pdo->prepare($sql);
    
        $params = array_combine(array_map(fn($col) => ":$col", $columns), $values);
    
        $stmt->execute($params);
    
        return $stmt->rowCount();
    }

    public function delete($tablename, $condition, $params) {
        $sql = "DELETE FROM $tablename WHERE $condition";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function select($tablename, $conditions = [], $fetchAll = true) {
        try {
            $sql = "SELECT * FROM $tablename";
            if (!empty($conditions)) {
                $whereClauses = [];
                foreach ($conditions as $column => $value) {
                    $whereClauses[] = "$column = :$column";
                }
                $sql .= " WHERE " . implode(" AND ", $whereClauses);
            }
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($conditions);
    
            return $fetchAll ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Select error: " . $e->getMessage());
            return false;
        }
    }
}

