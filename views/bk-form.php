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

    <div id="response"></div>

    <script>
        $(document).ready(function () {
            // Add item to the list
            $('#addItem').click(function () {
                const item = $('#items').val();
                if (item) {
                    $('#itemList').append('<li>' + item + '</li>');
                    $('#items').val('');
                }
            });

            // Prepend 880 to phone number
            $('#phone').blur(function () {
                let phone = $(this).val();
                phone = phone.replace(/[^\d]/g, ''); // Remove all non-numeric characters
                if (!phone.startsWith('880')) {
                    phone = '880' + phone;
                }
                $(this).val(phone);
            });


            // Form submission
            $('#submissionForm').submit(function (e) {
                e.preventDefault();

                // Serialize form data
                const formData = $(this).serializeArray();

                // Remove the default `items` field if it exists
                const filteredData = formData.filter(field => field.name !== 'items');

                // Add the `items` field with the JSON array value
                filteredData.push({
                    name: 'items',
                    value: JSON.stringify(
                        $('#itemList li').map(function () {
                            return $(this).text();
                        }).get()
                    )
                });

                // Send AJAX request
                $.ajax({
                    url: '../controllers/SubmissionController.php',
                    // url: '../database/test-sub-controller.php',
                    type: 'POST',
                    data: JSON.stringify(filteredData),
                    contentType: 'application/json',
                    dataType: "json",
                    encode: true,
                    success: function (response) {
                        console.log(filteredData);
                        $('#response').html(response);  // Display response
                        $('#submissionForm')[0].reset();  // Reset the form
                    },
                    error: function (xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });

            });

        });
    </script>
</body>
</html>
