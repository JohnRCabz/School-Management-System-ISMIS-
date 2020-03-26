<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <h5><i class="fa fa-user-secret" aria-hidden="true"></i> Admin</h5>
        </li>
    </ul>
</nav>

<nav class="navbar navbar-expand-lg navbar-warning bg-warning px-1"></nav>
<nav class="navbar navbar-expand-lg navbar-success bg-success px-5">
    <div class="collapse navbar-collapse" id="navContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
                <a href="admin.php" class="nav-link  text-light">Subjects offered</a>
            </li>
            <li class="nav-item ">
                <a href="schedule.php" class="nav-link  text-light">Schedules for Subjects</a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="nav-item">
                <a href="?logout=true" class="nav-link text-light">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<body>
    <div class="container-fluid w-150 position-relative mx-auto p-5 my-5">
        <?php
        session_start();
        if (!isset($_SESSION['loggedIn'])) {
            header("Location: index.php");
        }
        if (isset($_GET['logout'])) {
            unset($_SESSION['loggedIn']);
            header("Location: index.php");
        }
        $conn = new mysqli("localhost", "root", "", "crud");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM subjects";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo '
            <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Subject</th>
                <th scope="col">Maximum Population</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '
              <tr>
                    <th scope="row">' . $row['id'] . '</th>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['maxpopulation'] . '</td>
                    <td><a class="btn btn-success" href="editSubj.php?EditID=' . $row['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                    <td><a class="btn btn-danger" href="admin.php?DeleteID=' . $row['id'] . '"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
              </tr>
            ';
            }
            echo '
            </tbody>
            </table>
          ';
        } 
        if (isset($_GET['DeleteID'])) {
            $deleteID = $_GET['DeleteID'];

            $sql = "DELETE FROM subjects WHERE id= $deleteID";
            if ($conn->query($sql) === TRUE) {
                echo "<script language='javascript'>window.location.href='admin.php';</script>";
            }
        }
        mysqli_close($conn);
        ?>
        <a href="addSubj.php" class="btn btn-success" role="button">Add Subject</a>
    </div>
</body>

</html>