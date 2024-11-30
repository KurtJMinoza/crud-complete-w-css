<?php
  include "db_connect.php";
  
  if(isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    $sql_delete = mysqli_prepare($conn, "DELETE FROM `simple` WHERE id = ?");
    mysqli_stmt_bind_param($sql_delete, "i", $id);
    $sqldel_execute = mysqli_stmt_execute($sql_delete);
    if($sqldel_execute) {
      echo "<script>alert('Delete Successfully!')</script>";
      header("Location: read.php");
      exit();
    }
  }

  mysqli_close($conn);

?>