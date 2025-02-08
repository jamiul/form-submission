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
            type: 'POST',
            data: filteredData,
            success: function (response) {
                console.log(response);
            },
            error: function (xhr) {
                console.error('Error:', xhr.status, xhr.statusText);
                console.error('Response Text:', xhr.responseText);
            }
        });
    });

});