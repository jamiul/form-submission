<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Submission Form</h1>
    <?php
    // Check if the cookie exists
    if (isset($_COOKIE['form_submitted'])) {
        echo "<p style='color: red;'>You have already submitted the form. Please try again after 24 hours.</p>";
    } else {
    ?>
       <form id="submissionForm">
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" required><br>

            <label for="buyer">Buyer:</label>
            <input type="text" id="buyer" name="buyer" maxlength="20" required><br>

            <label for="receipt_id">Receipt ID:</label>
            <input type="text" id="receipt_id" name="receipt_id" required><br>

            <label for="items">Items:</label>
            <input type="text" id="items" name="items">
            <button type="button" id="addItem">Add Item</button>
            <ul id="itemList"></ul><br>

            <label for="buyer_email">Buyer Email:</label>
            <input type="email" id="buyer_email" name="buyer_email" required><br>

            <label for="note">Note:</label>
            <textarea id="note" name="note" maxlength="300"></textarea><br>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" required><br>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required><br>

            <label for="entry_by">Entry By:</label>
            <input type="number" id="entry_by" name="entry_by" required><br>

            <button type="submit">Submit</button>
        </form>
    <?php
    }
    ?>

<script src="js/submission.js"></script>
</body>
</html>
