<?php
  include "db_connect.php";
  $erru = $erra = $erre = $errd = "";

  if(isset($_GET["id"])) {
    $id = $_GET["id"];

    // Fetching data from the database for the given ID
    $sqlselect = mysqli_prepare($conn, "SELECT `id`, `username`, `email`, `age`, `address` FROM `simple` WHERE id = ?");
    mysqli_stmt_bind_param($sqlselect, "i", $id);
    $sqlexecute = mysqli_stmt_execute($sqlselect);
    $result = mysqli_stmt_get_result($sqlselect);

    while($row = mysqli_fetch_assoc($result)) {
      $username = $row['username']; 
      $email = $row['email'];
      $age = $row['age'];
      $address = $row['address'];
    }
  }

  // Handling the form submission
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $age = mysqli_real_escape_string($conn, $_POST["age"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);

    // Form validation
    if(empty($username) || strlen($username) < 5) {
      $erru = "Username must be at least 5 characters long.";
    }
    if(empty($age)) {
      $erra = "Age is required.";
    }
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $erre = "Please enter a valid email address.";
    }
    if(empty($address)) {
      $errd = "Address is required.";
    }

    // If no errors, update the database
    if(empty($erru) && empty($erra) && empty($erre) && empty($errd)) {
      $sqlupdate = mysqli_prepare($conn, "UPDATE `simple` SET `username` = ?, `email` = ?, `age` = ?, `address` = ? WHERE `id` = ?");
      mysqli_stmt_bind_param($sqlupdate, "ssisi", $username, $email, $age, $address, $id);
      $sql_update_execute = mysqli_stmt_execute($sqlupdate);

      if($sql_update_execute) {
        echo "<script>alert('Record updated successfully!');</script>";
        header("Location: read.php");
        exit();
      } else {
        echo "Error: Could not execute the update.";
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update User - Simple CRUD</title>
  <style>
    /* Resetting some default styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Body and General Layout */
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f7fa;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    /* Form Styling */
    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
    }

    input, textarea {
      width: 100%;
      padding: 12px;
      margin-bottom: 10px;
      border-radius: 6px;
      border: 1px solid #ddd;
      font-size: 16px;
    }

    input[type="submit"] {
      background-color: #3498db;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
      background-color: #2980b9;
    }

    /* Error Message Styling */
    span {
      color: red;
      font-size: 14px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      form {
        padding: 15px;
      }

      input, textarea {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Update User Record</h2>

    <form method="post">
      <!-- Username input field -->
      <input type="text" name="username" placeholder="Enter Username" value="<?php echo htmlspecialchars($username); ?>">
      <span><?php echo $erru; ?></span>
      <br>

      <!-- Age input field -->
      <input type="number" name="age" placeholder="Enter Age" value="<?php echo htmlspecialchars($age); ?>">
      <span><?php echo $erra; ?></span>
      <br>

      <!-- Email input field -->
      <input type="text" name="email" placeholder="Enter Email" value="<?php echo htmlspecialchars($email); ?>">
      <span><?php echo $erre; ?></span>
      <br>

      <!-- Address textarea field -->
      <textarea name="address" placeholder="Enter Address" cols="30" rows="10"><?php echo htmlspecialchars($address); ?></textarea>
      <span><?php echo $errd; ?></span>
      <br>

      <!-- Submit button -->
      <input type="submit" value="Update">
    </form>
  </div>

</body>
</html>
