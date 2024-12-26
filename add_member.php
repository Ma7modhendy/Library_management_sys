<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member</title>
    <style>
        /* General Reset */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        /* Container */
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 50px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        h2 {
            text-align: center;
            color: #333;
            font-size: 2rem;
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
            margin-top: 20px;            
            margin-left: 5px
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }

        /* Alert Message */
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
    <h2>Add Member</h2>
    <a href="members.php" class="btn btn-secondary mb-3">Back to Manage Members</a>

    <form method="POST" class="mb-3">
        <input type="text" name="name" placeholder="Full Name" required class="form-control">
        <input type="email" name="email" placeholder="Email Address" required class="form-control">
        <input type="text" name="phone_no" placeholder="Phone Number" required class="form-control">
        <input type="date" name="registration_date" required class="form-control">
        <button type="submit" class="btn btn-success">Add Member</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_no = $_POST['phone_no'];
        $registration_date = $_POST['registration_date'];

        $stmt = $conn->prepare("INSERT INTO Member (name, email, phone_no, registration_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $name, $email, $phone_no, $registration_date);
        $stmt->execute();
        echo '<div class="alert">Member added successfully!</div>';
    }
    ?>
</div>
</body>
</html>
