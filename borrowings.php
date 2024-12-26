<?php
ob_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Borrowing Records</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            color: #333;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            font-weight: 500;
            color: #fff;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
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

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ced4da;
            margin-bottom: 20px;
        }

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

        .table tr:hover { background-color: #f1f1f1; }
    </style>
</head>
<body>
<div class="container">
    <h2>Borrowing Records</h2>
    <div class="menu">
        <a href="add_borrowing.php" class="btn btn-success">Add New Borrowing</a>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </div>

    <form method="POST">
        <input type="text" name="search" placeholder="Search by Book Title or Member Name" class="form-control">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php
    $search = $_POST['search'] ?? '';
    $sql = "SELECT Borrowing.Borrow_id, Book.Title, Member.name, Borrowing.Borrow_date, Borrowing.Return_date, Borrowing.fine_amount, Borrowing.fine_paid 
            FROM Borrowing
            JOIN Book ON Borrowing.Book_id = Book.Book_id
            JOIN Member ON Borrowing.Member_id = Member.id
            WHERE Book.Title LIKE '%$search%' OR Member.name LIKE '%$search%'
            ORDER BY Borrowing.Borrow_id ASC"; // Sorts by Borrow_id in ascending order

    $result = $conn->query($sql);
    ?>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Book Title</th>
            <th>Member Name</th>
            <th>Borrow Date</th>
            <th>Return Date</th>
            <th>Fine Amount</th>
            <th>Fine Paid</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['Borrow_id'] ?></td>
                <td><?= $row['Title'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['Borrow_date'] ?></td>
                <td><?= $row['Return_date'] ?></td>
                <td><?= $row['fine_amount'] ?></td>
                <td><?= $row['fine_paid'] ? 'Yes' : 'No' ?></td>
                <td>
                    <a href="?modify=<?= $row['Borrow_id'] ?>" class="btn btn-primary btn-sm">Modify</a>
                    <a href="?delete=<?= $row['Borrow_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <?php
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $conn->query("DELETE FROM Borrowing WHERE Borrow_id = $id");
        header('Location: borrowings.php');
    }

    if (isset($_GET['modify'])) {
        $id = $_GET['modify'];
        $record = $conn->query("SELECT * FROM Borrowing WHERE Borrow_id = $id")->fetch_assoc();
    ?>
    <h3>Modify Record</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $record['Borrow_id'] ?>">
        <label>Borrow Date:</label>
        <input type="date" name="Borrow_date" value="<?= $record['Borrow_date'] ?>" class="form-control">
        <label>Fine Amount:</label>
        <input type="text" name="fine_amount" value="<?= $record['fine_amount'] ?>" class="form-control">
        <label>Fine Paid:</label>
        <select name="fine_paid" class="form-control">
            <option value="1" <?= $record['fine_paid'] ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= !$record['fine_paid'] ? 'selected' : '' ?>>No</option>
        </select>
        <button type="submit" name="update" class="btn btn-success">Update</button>
    </form>
    <?php }

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $borrow_date = $_POST['Borrow_date'];
        $fine_amount = $_POST['fine_amount'];
        $fine_paid = $_POST['fine_paid'];
        $conn->query("UPDATE Borrowing SET Borrow_date='$borrow_date', fine_amount='$fine_amount', fine_paid='$fine_paid' WHERE Borrow_id=$id");
        header('Location: borrowings.php');
    }
    ?>
</div>
</body>
</html>
