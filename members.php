<?php
include 'db.php';
ob_start(); // Prevent header errors

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members</title>
    <style>
        /* General Reset */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        /* Container */
        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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

        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }

        /* Table Styling */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }

        /* Input and Search Styling */
        .form-control {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ced4da;
            margin-bottom: 20px;
            margin-top: 20px;            
            margin-left: 5px;            
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }

        .error {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .menu {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Manage Members</h2>
    <div class="menu">
        <a href="add_member.php" class="btn btn-success mb-3">Add New Member</a>
        <a href="index.php" class="btn btn-secondary mb-3">Back</a>
    </div>

    <!-- Search Form -->
    <form method="post" class="mb-3">
        <input type="text" name="search" placeholder="Search by Name" class="form-control">
        <button type="submit" class="btn btn-primary mt-2">Search</button>
    </form>

    <?php
    // Handle Member Deletion
    if (isset($_GET['delete'])) {
        $id = intval($_GET['delete']); // Sanitize input
        
        // Check for related Borrowing records
        $checkBorrowing = $conn->query("SELECT * FROM Borrowing WHERE Member_id = $id");
        
        if ($checkBorrowing->num_rows > 0) {
            echo "<p class='error'>Cannot delete this member because they have active borrowing records. Please remove their borrowing records first.</p>";
        } else {
            $conn->query("DELETE FROM Member WHERE id = $id");
            header('Location: members.php');
            exit();
        }
    }

    // Handle Search
    $search = '';
    if (isset($_POST['search']) && !empty($_POST['search'])) {
        $search = $_POST['search'];
        $sql = "SELECT * FROM Member WHERE name LIKE '%$search%'";
    } else {
        $sql = "SELECT * FROM Member";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0): ?>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Registration Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['phone_no'] ?></td>
                    <td><?= $row['registration_date'] ?></td>
                    <td>
                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No members found.</p>
    <?php endif; ?>
</div>
</body>
</html>
