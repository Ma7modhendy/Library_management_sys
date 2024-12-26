<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e9ecef;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 2rem;
            margin-bottom: 40px;
            color: #495057;
            text-align: center;
            font-weight: 600;
        }
        .menu {
            display: flex;
            justify-content: space-around;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }
        .btn {
            font-weight: 500;
            color: #fff;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            background-color: #007bff;
            border: 1px solid transparent;
            padding: 12px 25px;
            font-size: 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
            transition: background-color 0.3s, transform 0.2s;
            flex-grow: 1;
            max-width: 250px;
            margin-bottom: 15px;
        }
        .btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .btn:active {
            background-color: #004085;
            transform: translateY(2px);
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
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
    <h2>Library Management</h2>
    <div class="menu">
        <a href="books.php" class="btn btn-secondary" aria-label="Manage Books">Manage Books</a>
        <a href="members.php" class="btn btn-secondary" aria-label="Manage Members">Manage Members</a>
        <a href="borrowings.php" class="btn btn-secondary" aria-label="Manage Borrowings">Manage Borrowings</a>
    </div>
</div>
</body>
</html>
