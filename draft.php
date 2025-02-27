<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transparent Table</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('https://images.unsplash.com/photo-1557682250-33bd709cbe85?q=80&w=1470');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 800px;
        }

        .glass-table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .glass-table th {
            background-color: rgba(255, 255, 255, 0.3);
            color: #333;
            font-weight: 600;
            text-align: left;
            padding: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-table td {
            padding: 12px 16px;
            color: #333;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-table tr:last-child td {
            border-bottom: none;
        }

        .glass-table tr:hover td {
            background-color: rgba(255, 255, 255, 0.4);
            transition: background-color 0.3s ease;
        }

        @media (max-width: 600px) {
            .glass-table th, 
            .glass-table td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <table class="glass-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Sample data array
                $users = [
                    ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'status' => 'Active'],
                    ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'status' => 'Inactive'],
                    ['id' => 3, 'name' => 'Robert Johnson', 'email' => 'robert@example.com', 'status' => 'Active'],
                    ['id' => 4, 'name' => 'Emily Davis', 'email' => 'emily@example.com', 'status' => 'Pending'],
                    ['id' => 5, 'name' => 'Michael Wilson', 'email' => 'michael@example.com', 'status' => 'Active'],
                ];

                // Generate table rows
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>{$user['id']}</td>";
                    echo "<td>{$user['name']}</td>";
                    echo "<td>{$user['email']}</td>";
                    echo "<td>{$user['status']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

