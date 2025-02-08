<?php
require_once 'db.php';

$db = new Database();
$connection = $db->connect();

if ($connection) {
    echo "Database connection successful!";
} else {
    echo "Database connection failed.";
}

$db->close();
?>
