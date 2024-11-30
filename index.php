<?php
  include "db_connect.php";
  $erru = $errp = $erra = $erre = $errd = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $age = mysqli_real_escape_string($conn, $_POST["age"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);

    // FORM VALIDATION
    if (empty($username) || strlen($username) < 5) {
      $erru = "Username must be at least 5 characters.";
    }
    if (empty($password) || strlen($password) < 8) {
      $errp = "Password must be at least 8 characters.";
    }
    if (empty($age)) {
      $erra = "Age is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $erre = "Invalid email format.";
    }
    if (empty($address)) {
      $errd = "Address is required.";
    }

    if (empty($erru) && empty($errp) && empty($erra) && empty($erre) && empty($errd)) {
      $hashed = password_hash($password, PASSWORD_DEFAULT);

      $sqlinsert = mysqli_prepare($conn, "INSERT INTO `simple`(`username`, `password`, `email`, `age`, `address`) VALUES (?, ?, ?, ?, ?)");
      mysqli_stmt_bind_param($sqlinsert, "sssis", $username, $hashed, $email, $age, $address);
      $sql_insert_execute = mysqli_stmt_execute($sqlinsert);
      if ($sql_insert_execute) {
        echo "<script>alert('Insert successfully')</script>";
        header("Location: read.php");
        exit();
      } else {
        echo "Can't execute.";
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simple CRUD</title>
  <style>
    /* Global Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    /* Body and Form Styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f7fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .form-container {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
    }

    .form-container h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    .form-container input,
    .form-container textarea {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 16px;
      color: #333;
      transition: border-color 0.3s;
    }

    .form-container input:focus,
    .form-container textarea:focus {
      border-color: #4CAF50;
      outline: none;
    }

    .form-container textarea {
      resize: vertical;
    }

    .form-container input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      cursor: pointer;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      padding: 14px;
      width: 100%;
    }

    .form-container input[type="submit"]:hover {
      background-color: #45a049;
    }

    .error-message {
      color: red;
      font-size: 12px;
    }

    /* Responsive Design */
    @media (max-width: 600px) {
      .form-container {
        width: 90%;
      }
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Create a New Account</h2>
    <form method="post">
      <input type="text" name="username" placeholder="Enter Username" value="<?php echo isset($username) ? $username : ''; ?>">
      <span class="error-message"><?php echo $erru; ?></span>

      <input type="password" name="password" placeholder="Enter Password">
      <span class="error-message"><?php echo $errp; ?></span>

      <input type="number" name="age" placeholder="Enter Age" value="<?php echo isset($age) ? $age : ''; ?>">
      <span class="error-message"><?php echo $erra; ?></span>

      <input type="text" name="email" placeholder="Enter Email" value="<?php echo isset($email) ? $email : ''; ?>">
      <span class="error-message"><?php echo $erre; ?></span>

      <textarea name="address" placeholder="Enter Address"><?php echo isset($address) ? $address : ''; ?></textarea>
      <span class="error-message"><?php echo $errd; ?></span>

      <input type="submit" value="Submit">
    </form>
  </div>

</body>
</html>
