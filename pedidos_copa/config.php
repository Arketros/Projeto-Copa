<?php
date_default_timezone_set('America/Sao_Paulo');

class MySQLiResultCompat {
    private $stmt;
    private $results = [];
    private $index = 0;
    public $num_rows = 0;
    
    public function __construct($stmt) {
        $this->stmt = $stmt;
        if ($stmt->columnCount() > 0) {
            $this->results = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->num_rows = count($this->results);
        }
    }
    
    public function fetch_object() {
        if ($this->index < $this->num_rows) {
            return $this->results[$this->index++];
        }
        return null;
    }
}

class MySQLiCompat {
    private $pdo;
    
    public function __construct() {
        $dbPath = __DIR__ . '/database/database.db';
        $this->pdo = new PDO('sqlite:' . $dbPath);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function query($sql) {
        try {
            $stmt = $this->pdo->query($sql);
            if ($stmt !== false) {
                return new MySQLiResultCompat($stmt);
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}

$conn = new MySQLiCompat();
?>