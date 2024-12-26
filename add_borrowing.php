<?php include 'db.php'; ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Borrowing Record</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Container */
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 50px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Title */
        h2 {
            text-align: center;
            font-size: 2rem;
            color: #343a40;
            margin-bottom: 30px;
        }

        /* Button Styling */
        .btn {
            display: inline-block;
            font-weight: 500;
            color: #fff;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            padding: 12px 20px;
            font-size: 1rem;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
            transition: background-color 0.3s, transform 0.2s;
            margin: 5px;
        }

        .btn-success {
            background-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }

        /* Form Inputs */
        .form-control {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ced4da;
            margin-bottom: 20px;
            transition: border-color 0.3s;
            margin-top: 20px;            
            margin-left: 5px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }

        /* Label Styling */
        label {
            font-weight: 600;
            font-size: 18px;
            margin-left: 5px;
            margin-top: 10px;
            display: block;
            color: #495057;
        }

        /* Alert */
        .alert {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin-top: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            font-size: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Add Borrowing Record</h2>
    <a href="borrowings.php" class="btn btn-secondary mb-3">Back to Borrowing List</a>

    <form method="POST" class="mb-3">
        <label for="book_name">Book Name:</label>
        <input type="text" name="book_name" class="form-control mb-2" placeholder="Enter Book Name" required>

        <label for="member_name">Member Name:</label>
        <input type="text" name="member_name" class="form-control mb-2" placeholder="Enter Member Name" required>

        <label for="borrow_date">Borrow Date:</label>
        <input type="date" name="borrow_date" class="form-control mb-2" required>

        <label for="return_date">Return Date:</label>
        <input type="date" name="return_date" class="form-control mb-2">

        <button type="submit" class="btn btn-success">Add Borrowing Record</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $book_name = $_POST['book_name'];
        $member_name = $_POST['member_name'];
        $borrow_date = $_POST['borrow_date'];
        $return_date = $_POST['return_date'] ?: null;
        $fine_amount = 0.00; // Default fine amount is set to zero

        // Retrieve Book ID based on Book Name
        $stmt = $conn->prepare("SELECT Book_id FROM Book WHERE Title = ?");
        $stmt->bind_param('s', $book_name);
        $stmt->execute();
        $book_result = $stmt->get_result();

        // Retrieve Member ID based on Member Name
        $stmt = $conn->prepare("SELECT id FROM Member WHERE name = ?");
        $stmt->bind_param('s', $member_name);
        $stmt->execute();
        $member_result = $stmt->get_result();

        if ($book_result->num_rows > 0 && $member_result->num_rows > 0) {
            $book = $book_result->fetch_assoc();
            $member = $member_result->fetch_assoc();

            $book_id = $book['Book_id'];
            $member_id = $member['id'];

            // Insert into Borrowing table
            $stmt = $conn->prepare("INSERT INTO Borrowing (Book_id, Member_id, Borrow_date, Return_date, fine_amount) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param('iissd', $book_id, $member_id, $borrow_date, $return_date, $fine_amount);

            if ($stmt->execute()) {
                echo '<div class="alert">Borrowing record added successfully!</div>';
            } else {
                echo '<div class="alert" style="background-color: #f8d7da; color: #721c24;">Failed to add borrowing record: ' . $stmt->error . '</div>';
            }
        } else {
            echo '<div class="alert" style="background-color: #f8d7da; color: #721c24;">Invalid Book Name or Member Name. Please check and try again.</div>';
        }
    }
    ?>
</div>
</body> 
</html>
