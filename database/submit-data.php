<?php

require_once '../models/Submission.php';

$submission = new Submission();

$data = [
    'amount' => 100,
    'buyer' => 'John Doe',
    'receipt_id' => '123456',
    'items' => '["item1", "item2"]',
    'buyer_email' => 'johndoe@example.com',
    'buyer_ip' => '192.168.1.1',
    'note' => 'Test submission',
    'city' => 'New York',
    'phone' => '1234567890',
    'entry_at' => date('Y-m-d'),
    'entry_by' => 1
];

$result = $submission->save($data);

if ($result) {
    echo "Submission saved successfully!";
} else {
    echo "Failed to save submission.";
}

?>
