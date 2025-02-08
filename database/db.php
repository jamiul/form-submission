<?php
require_once '../config/config.php';

class Database {
    private $config;
    private $connection;

    public function __construct() {
        $this->config = require '../config/config.php';
    }

    public function connect() {
        $this->connection = new mysqli(
            $this->config['db_host'],
            $this->config['db_user'],
            $this->config['db_pass'],
            $this->config['db_name']
        );

        if ($this->connection->connect_error) {
            die("Database connection failed: " . $this->connection->connect_error);
        }

        return $this->connection;
    }

    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
?>
