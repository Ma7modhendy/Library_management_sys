<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <style>
        /* General Reset */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
        }

        /* Container */
        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        h2 {
            text-align: center;
            font-size: 2rem;
            color: #333;
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

        .btn-success { background-color: #28a745; }
        .btn-success:hover { background-color: #218838; }
        .btn-secondary { background-color: #6c757d; }
        .btn-secondary:hover { background-color: #5a6268; }
        .btn-primary { background-color: #007bff; }
        .btn-primary:hover { background-color: #0056b3; }
        .btn-danger { background-color: #dc3545; }
        .btn-danger:hover { background-color: #c82333; }

        /* Table Styling */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th { background-color: #f8f9fa; }
        .table tr:hover { background-color: #f1f1f1; }

        .error { color: red; font-weight: bold; margin-top: 10px; }

        /* Search Input */
        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ced4da;
            margin-bottom: 20px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Manage Books</h2>
    <div class="menu">
        <a href="add_book.php" class="btn btn-success">Add New Book</a>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </div>

    <!-- Search Form -->
    <form method="POST">
        <input type="text" name="search" placeholder="Search by Title" class="form-control">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php
    // Handle Book Deletion with Foreign Key Check
    if (isset($_GET['delete'])) {
        $id = intval($_GET['delete']); // Sanitize input
        
        // Check for related Borrowing records
        $checkBorrowing = $conn->query("SELECT * FROM Borrowing WHERE Book_id = $id");
        
        if ($checkBorrowing->num_rows > 0) {
            echo "<p class='error'>Cannot delete this book because it has active borrowing records. Please return or remove borrowing records first.</p>";
        } else {
            $conn->query("DELETE FROM Book WHERE Book_id = $id");
            header('Location: books.php');
            exit();
        }
    }

    // Handle Search
    $search = '';
    if (isset($_POST['search']) && !empty($_POST['search'])) {
        $search = $_POST['search'];
        $sql = "SELECT * FROM Book WHERE Title LIKE '%$search%'";
    } else {
        $sql = "SELECT * FROM Book";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0): ?>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Published Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['Book_id'] ?></td>
                    <td><?= $row['Title'] ?></td>
                    <td><?= $row['Author'] ?></td>
                    <td><?= $row['Published_date'] ?></td>
                    <td>
                        <a href="?delete=<?= $row['Book_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No books found.</p>
    <?php endif; ?>
</div>
</body>
</html>
