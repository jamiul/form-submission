<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Submission Report</h1>
    <form method="GET" action="">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date">

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date">

        <label for="user_id">User ID (Entry By):</label>
        <input type="text" id="user_id" name="user_id">

        <button type="submit">Filter</button>
    </form>

    <hr>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Buyer</th>
                <th>Receipt ID</th>
                <th>Items</th>
                <th>Buyer Email</th>
                <th>Buyer IP</th>
                <th>Note</th>
                <th>City</th>
                <th>Phone</th>
                <th>Entry Date</th>
                <th>Entry By</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Connect to the database
            $mysqli = new mysqli("localhost", "root", "", "form_db");

            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            // Build query with filters
            $query = "SELECT * FROM submissions WHERE 1=1";
            $params = [];
            $types = "";

            if (!empty($_GET['start_date'])) {
                $query .= " AND entry_at >= ?";
                $params[] = $_GET['start_date'];
                $types .= "s";
            }

            if (!empty($_GET['end_date'])) {
                $query .= " AND entry_at <= ?";
                $params[] = $_GET['end_date'];
                $types .= "s";
            }

            if (!empty($_GET['user_id'])) {
                $query .= " AND entry_by = ?";
                $params[] = $_GET['user_id'];
                $types .= "i";
            }

            $stmt = $mysqli->prepare($query);

            if ($params) {
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            // Display the results
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "<td>" . $row['buyer'] . "</td>";
                    echo "<td>" . $row['receipt_id'] . "</td>";
                    echo "<td>" . $row['items'] . "</td>";
                    echo "<td>" . $row['buyer_email'] . "</td>";
                    echo "<td>" . $row['buyer_ip'] . "</td>";
                    echo "<td>" . $row['note'] . "</td>";
                    echo "<td>" . $row['city'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['entry_at'] . "</td>";
                    echo "<td>" . $row['entry_by'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='13'>No records found</td></tr>";
            }

            $stmt->close();
            $mysqli->close();
            ?>
        </tbody>
    </table>
</body>
</html>