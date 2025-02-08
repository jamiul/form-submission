<?php

require_once '../controllers/SubmissionController.php';

// Simulate form submission data
$_POST = [
    'amount' => 100,
    'buyer' => 'John Doe',
    'receipt_id' => '1212',
    'items' => '["item1", "item2"]', // JSON string
    'buyer_email' => 'johndoe@example.com',
    'buyer_ip' => '192.168.1.1',
    'note' => 'Test submission',
    'city' => 'New York',
    'phone' => '1234567890',
];

$controller = new SubmissionController();
$controller->handleSubmission();

?>
