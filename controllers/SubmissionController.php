<?php

class SubmissionController {
    public function handleSubmission() {
        // Debug incoming data
        file_put_contents('debug.log', print_r($_POST, true));

        // Simulate processing
        $response = [
            'success' => true,
            'message' => 'Data processed successfully',
        ];

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

// Instantiate and handle submission
$controller = new SubmissionController();
$controller->handleSubmission();
?>
