<?php

require_once '../database/db.php';

class Submission {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function save($data) {
        // Validate required fields
        if (!$this->validate($data)) {
            return false; // Validation failed
        }

        // Generate a 32-character random salt
        $salt = bin2hex(random_bytes(16));

        // Generate hash key using receipt_id and salt
        $hash_key = hash('sha512', $data['receipt_id'] . $salt);

        // Prepare SQL query
        $stmt = $this->db->prepare("
            INSERT INTO submissions (amount, buyer, receipt_id, items, buyer_email, buyer_ip, note, city, phone, hash_key, salt, entry_at, entry_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            // Log or display the SQL error
            error_log("Prepare failed: " . $this->db->error);
            return false;
        }

        // Bind parameters
        $stmt->bind_param(
            'isssssssssssi',
            $data['amount'],        // Integer
            $data['buyer'],         // String
            $data['receipt_id'],    // String
            $data['items'],         // String
            $data['buyer_email'],   // String
            $data['buyer_ip'],      // String
            $data['note'],          // String
            $data['city'],          // String
            $data['phone'],         // String
            $hash_key,              // String
            $salt,                  // String
            $data['entry_at'],      // String (date)
            $data['entry_by']       // Integer
        );

        // Execute query
        $result = $stmt->execute();

        if (!$result) {
            // Log the error for debugging
            error_log("Execute failed: " . $stmt->error);
        }

        $stmt->close();

        return $result;
    }

    private function validate($data) {
        // Check required fields
        $required_fields = ['amount', 'buyer', 'receipt_id', 'items', 'buyer_email', 'city', 'phone', 'entry_at', 'entry_by'];

        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                error_log("Validation failed: $field is missing or empty.");
                return false;
            }
        }

        // Validate email
        if (!filter_var($data['buyer_email'], FILTER_VALIDATE_EMAIL)) {
            error_log("Validation failed: Invalid email.");
            return false;
        }

        // Validate numeric fields
        if (!is_numeric($data['amount']) || !is_numeric($data['entry_by'])) {
            error_log("Validation failed: Amount or entry_by is not numeric.");
            return false;
        }

        return true;
    }
}

?>
