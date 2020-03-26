<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <title>index</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<nav class="navbar navbar-expand-lg navbar-light px-5">
    <ul class="nav navbar-nav mr-auto">
        <li class="nav-item">
            <img src="th.jpg" alt="HTML5 Icon" width="400" height="70">
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li class="nav-item">
            <h5>User(Not logged in)</h5>
        </li>
    </ul>
</nav>
<nav class="navbar navbar-expand-lg navbar-warning bg-warning px-5"></nav>
<nav class="navbar navbar-expand-lg navbar-success bg-success px-5">
    <div class="collapse navbar-collapse" id="navContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
                <a href="#" class="nav-link  text-light">Login to continue</a>
            </li>
        </ul>
    </div>
</nav>

<body>
  <div class="container w-150 position-relative mx-auto p-5 my-5 bg-light shadow">
    <h2 class="font-weight-bold">MyISMIS</h2>
    <hr>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <div class="form-group">
        <label for="email" class="font-weight-bold">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="password" class="font-weight-bold">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>

      <button type="submit" name="index" class="btn btn-success">Login</button>
      <small>No account? <a href="register.php">Register</a></small>
    </form>
  </div>
  <?php
  session_start();
  if (isset($_POST['index'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conn = new mysqli("localhost", "root", "", "crud");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $encrypt = md5($password);
      if ($encrypt === $row['password']) {
        $_SESSION['loggedIn'] = $_POST['email'];
        if ($row['type'] === 'admin') {
          header("Location: admin.php");
        } else if ($row['type'] === 'teacher') {
          header("Location: teacher.php");
        } else {
          header("Location: student.php");
        }
      } else {
        echo "<div class='alert alert-danger w-50 mx-auto my-4'>You have entered the wrong password!</div>";
      }
    } else {
      echo "<div class='alert alert-danger w-50 mx-auto my-4'>Account does not exist.</div>";
    }
  }
  ?>
</body>

</html>

