<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <style>
        /* General Reset */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Container */
        .container {
            max-width: 950px;
            margin: 50px auto;
            padding: 50px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        h2 {
            text-align: center;
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
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
            margin-top: 15px;            
            margin-left: 5px; 
            margin-right: 5px; 
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }

        /* Alert Message */
        .alert {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
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
    <h2>Add New Book</h2>
    <a href="books.php" class="btn btn-secondary mb-3">Back to Book List</a>

    <form method="POST" class="mb-3">
        <input type="text" name="title" placeholder="Book Title" required class="form-control">
        <input type="text" name="author" placeholder="Author" required class="form-control">
        <input type="date" name="published_date" class="form-control">
        <button type="submit" class="btn btn-success">Add Book</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $published_date = $_POST['published_date'] ?: null;

        $stmt = $conn->prepare("INSERT INTO Book (Title, Author, Published_date) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $title, $author, $published_date);
        $stmt->execute();
        echo '<div class="alert">Book added successfully!</div>';
    }
    ?>
</div>
</body>
</html>
