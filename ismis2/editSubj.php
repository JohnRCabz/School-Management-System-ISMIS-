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
        if (isset($_GET['EditID'])) {
            $id = $_GET['EditID'];
        }
        $sql = "SELECT * FROM subjects where id = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            echo '
                <form action="editSubj.php" method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                        <label for="lname">Maximum Num of Students</label>
                        <input type="number" class="form-control" name="max_stud" placeholder="Enter Maximum Qty" value="' . $row['maxpopulation'] . '" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="address">Course Description</label>
                            <input type="text" class="form-control" name="description" placeholder="How to Survive 101" value="' . $row['name'] . '">
                        </div>
                    </div>
                    <input type="hidden" class="form-control" name="EditID"  value="' . $id . '" required>
                    <input type="submit" class="btn btn-success" value="Submit" name="submit" required>          
                </form>
                
            ';
        }
        if (isset($_POST['submit'])) {
            $MaxStud = $_POST['max_stud'];
            $Description = $_POST['description'];
            $id = $_POST['EditID'];

            $sql = "UPDATE subjects SET maxpopulation='$MaxStud',name='$Description' WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                echo "<script language='javascript'>window.location.href='admin.php';</script>";
            }
        }
        ?>
    </div>
</body>

</html>