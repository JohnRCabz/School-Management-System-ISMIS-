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
                <a href="#" class="nav-link  text-light">Register an account!</a>
            </li>
        </ul>
    </div>
</nav>

<body>
  <div class="container w-150 position-relative mx-auto p-5 my-5 bg-light shadow">
  <h2>REGISTER</h2>
            <form action="register.php" method="POST">
                <div class="form-group">
                    <label for="fname">First Name</label>
                    <input type="text" class="form-control" id="fname" name="fname" aria-describedby="emailHelp" placeholder="Enter you First Name" required>
                </div>
                <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" class="form-control" id="lname" name="lname" aria-describedby="emailHelp" placeholder="Enter your Last Name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter your Email Address" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password1" aria-describedby="emailHelp" placeholder="Enter your Password" required>
                </div>
                <div class="form-group">
                    <label for="password">Confirm Password</label>
                    <input type="password" class="form-control" id="password" name="password2" aria-describedby="emailHelp" placeholder="Confirm you password" required>
                </div>
                <div class="form-group">
                    <label for="type">Select</label>
                    <select class="form-control" id="exampleSelect1" name="type">
                        <option>teacher</option>
                        <option>student</option>
                    </select>
                </div>
                <input type="submit" class="form-group btn btn-success" name="submit" aria-describedby="emailHelp" value="Register">
  </div>

    <?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "crud";

    $errors = array();

    if (isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        $type = $_POST['type'];

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if ($password1 != $password2) {
            array_push($errors, "The two passwords do not match");
        }

        $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            if ($user['email'] === $email) {
                array_push($errors, "Email already exists");
            }
        }
        if (count($errors) == 0) {
            $password = md5($password1);

            $sql = "INSERT INTO users (id,fname,lname,email,type,password) VALUES('','$fname','$lname','$email','$type','$password')";

            if (mysqli_query($conn, $sql) == TRUE) {
                echo "<script language='javascript'>alert('Successfully registered');window.location.href='index.php';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        } else {
            foreach ($errors as $value) {
                echo $value . "<br>";
            }
        }
    }
    ?>
</body>

</html>