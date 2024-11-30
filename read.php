<?php
  include "db_connect.php";

  $sql_read = "SELECT `id`, `username`, `password`, `email`, `age`, `address` FROM `simple`";
  $sql_query = mysqli_query($conn, $sql_read);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simple CRUD - View Records</title>
  <style>
    /* Global Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Body and General Styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f7fa;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    .container {
      width: 90%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    /* Table Styling */
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
      font-size: 16px;
      text-align: left;
    }

    .data-table th,
    .data-table td {
      padding: 12px;
      border: 1px solid #ddd;
    }

    .data-table th {
      background-color: #4CAF50;
      color: white;
    }

    .data-table tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .data-table tr:hover {
      background-color: #f1f1f1;
    }

    /* Button Styling */
    .btn {
      padding: 8px 15px;
      margin: 0 5px;
      border-radius: 4px;
      text-decoration: none;
      color: white;
      font-weight: bold;
    }

    .delete-btn {
      background-color: #e74c3c;
    }

    .delete-btn:hover {
      background-color: #c0392b;
    }

    .update-btn {
      background-color: #3498db;
    }

    .update-btn:hover {
      background-color: #2980b9;
    }

    .add {
      padding: 10px 8px;
      border: 1px solid #000;
      cursor:pointer;
      border-radious: 10px
      font-weight: 600;
      background-color: blue;
      color: white;
      text-decoration: none;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .data-table th, .data-table td {
        padding: 10px;
      }

      .data-table {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>View User Records</h2>
    <a href="index.php" class="add">Add More Data</a>
    <?php
      if (mysqli_num_rows($sql_query) > 0) {
        echo "<table class='data-table'>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Age</th>
                  <th>Address</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>";
      
        while ($rows = mysqli_fetch_assoc($sql_query)) {
          echo "<tr>
                  <td>{$rows['id']}</td>
                  <td>{$rows['username']}</td>
                  <td>{$rows['email']}</td>
                  <td>{$rows['age']}</td>
                  <td>{$rows['address']}</td>
                  <td>
                    <a class='btn delete-btn' href='delete.php?id={$rows['id']}' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                    <a class='btn update-btn' href='update.php?id={$rows['id']}' onclick='return confirm(\"Are you sure you want to update this record?\");'>Update</a>
                  </td>
                </tr>";
        }
        
        echo "</tbody></table>";
      } else {
        echo "<p>No records found.</p>";
      }
    ?>
  </div>

</body>
</html>
