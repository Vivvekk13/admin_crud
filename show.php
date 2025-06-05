<?php


include("connection.php");



session_start();
// $user_role = $_SESSION['role'] ?? 'client';

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $dlt = $conn->prepare("DELETE FROM `notes` WHERE `id` = ?");
  $dlt->bind_param("i", $id);
  $dlt->execute();
  $dlt->close();
  header("location:http://localhost/vivek/show.php");
}



if (isset($_GET['id']) && isset($_GET['status_'])) {
   $id = intval($_GET['id']);  
       $status_ = intval($_GET['status_']);   
  

        if ($status_ === 1 || $status_ === 0) {
        $stmt = $conn->prepare("UPDATE notes SET status_ = ? WHERE id = ?");
        $stmt->bind_param("ii", $status_, $id);
        $stmt->execute();
        $stmt->close();

         
}
}


if (isset($_GET['id']) && isset($_GET['role'])) {
   $id = $_GET['id'];  
       $role = $_GET['role'];   
  

        if ($role == "admin" || $role == "client") {
        $rl = $conn->prepare("UPDATE notes SET role = ? WHERE id = ?");
        $rl->bind_param("si", $role, $id);
        $rl->execute();
        $rl->close();

         
}

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
</head>
<body>
    


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="http://localhost/vivek/todo.php">
      <img src="valethi.webp " width="50" height="50" alt="">
    </a>

    <a class="navbar-brand" href="http://localhost/vivek/todo.php">Valethi Technologies</a>
  </nav>






  <div class="container mt-4">
    <h2>All Employees Details</h2>
    <table class="table table-bordered table-striped">
      <thead class="thead-dark">
        <tr>
          <th>Srno</th>
          <th>Name</th>
          <th>Email/Username</th>
          <th>Mobile Number </th>
          <th>Address</th>
          <th>status</th>
          <th>Date & Time</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `notes` ORDER BY id desc";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
          
           $statusText = ($row['status_'] == 1) ? 'Active' : 'Inactive';
         
echo "<tr>
  <th scope='row'>{$row['id']}</th>
  <td>{$row['Name']}</td>
  <td>{$row['Email']}</td>
  <td>{$row['mobile_number']}</td>
  <td>{$row['address']}</td>
  <td>{$statusText}</td>
    <td>";

if ($row['role'] == 'admin') {
  echo "<a href='update.php?id={$row['id']}' class='btn btn-success btn-sm'>Edit</a> ";
  echo "<a href='?delete={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure?');\">Delete</a>";
} else {
  echo "<span class='text-muted'>No Access</span>";
}

echo "</td>
  <td>{$row['tstamp']}</td>
</tr>";
  }  ?>
      </tbody>
    </table>
  </div>

</body>
</html>