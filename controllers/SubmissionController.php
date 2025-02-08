<?php

require_once '../models/Submission.php';

class SubmissionController {
    private $submission;

    public function __construct() {
        $this->submission = new Submission();
    }
    /**
     * Handle form submission.
     */
    public function handleSubmission() {
        file_put_contents('debug.log', print_r($_POST, true));

        // Validate form data
        $errors = $this->validate($_POST);
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['errors' => $errors]);
            return;
        }

        // Process the 'items' field
        $items = $this->processItems($_POST['items']);
        if ($items === false) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid items format.']);
            return;
        }

        // Prepare data for saving
        $data = [
            'amount'       => $_POST['amount'],
            'buyer'        => $_POST['buyer'],
            'receipt_id'   => $_POST['receipt_id'],
            'items'        => $items,
            'buyer_email'  => $_POST['buyer_email'],
            'buyer_ip'     => $_POST['buyer_ip'] ?? $_SERVER['REMOTE_ADDR'], // Use server IP if not provided
            'note'         => $_POST['note'],
            'city'         => $_POST['city'],
            'phone'        => $_POST['phone'],
            'entry_at'     => date('Y-m-d'),
            'entry_by'     => 1, // Example user ID, replace with actual logged-in user ID
        ];

        // Check if the cookie exists
        if (isset($_COOKIE['form_submitted'])) {
            // If the cookie exists, block the submission
            echo "You have already submitted the form. Please try again after 24 hours.";
            exit;
        }

        // Save to the database
        $result = $this->submission->save($data);
        if ($result) {
            setcookie('form_submitted', '1', time() + 86400, "/"); // 24-hour expiration
            http_response_code(200);
            echo json_encode(['message' => 'Submission saved successfully!']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to save submission.']);
        }
    }

    /**
     * Validate form data.
     * @param array $data Form data
     * @return array List of validation errors
     */
    private function validate($data) {
        $errors = [];

        // Example validation rules
        if (empty($data['amount']) || !is_numeric($data['amount'])) {
            $errors[] = 'Amount is required and must be a number.';
        }
        if (empty($data['buyer'])) {
            $errors[] = 'Buyer name is required.';
        }
        if (empty($data['receipt_id'])) {
            $errors[] = 'Receipt ID is required.';
        }
        if (empty($data['buyer_email']) || !filter_var($data['buyer_email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'A valid buyer email is required.';
        }
        if (empty($data['items'])) {
            $errors[] = 'Items are required.';
        }

        return $errors;
    }

    /**
     * Process the 'items' field.
     * @param mixed $items Items data (JSON string or array)
     * @return string|false Comma-separated string of items or false if invalid
     */
    private function processItems($items) {
        // Check if items is already an array
        if (is_array($items)) {
            return implode(',', $items); // Convert array to comma-separated string
        }

        // If it's a JSON string, decode it
        $decoded_items = json_decode($items, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded_items)) {
            return implode(',', $decoded_items);
        }

        // Invalid items format
        return false;
    }
}

// Instantiate and handle submission
$controller = new SubmissionController();
$controller->handleSubmission();

?>
