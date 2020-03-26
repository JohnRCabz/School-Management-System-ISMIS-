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
        $conn = new mysqli("localhost", "root", "", "crud");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if (isset($_GET['EditID'])) {
            $EditId = $_GET['EditID'];
        }
        $sql = "SELECT * FROM teachersched WHERE id = '$EditId'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $instructor = $row['instructor'];
            echo '       
            <form action="editsched.php" method="POST" enctype="multipart/form-data"> 
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="address" class="font-weight-bold">Location</label>
                        <input type="text" class="form-control" name="location" value="' . $row['location'] . '">
                    </div>
                <div class="form-group col-md-4">
                        <label for="type" class="font-weight-bold">Day</label>
                        <select id="type" name="day" class="form-control"  required="required">
                            <option value="1">Sunday</option>
                            <option value="2">Monday</option>
                            <option value="3">Tuesday</option>
                            <option value="4">Wednesday</option>
                            <option value="5">Thursday</option>
                            <option value="6">Friday</option>
                            <option value="7">Saturday</option>
                        </select>
                </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-4">
                <label for="status" class="font-weight-bold">Start(Please use military time)</label>
                <input type="text" name="tstart" id="tstart" class="form-control" placeholder="hhmm" required>
            </div>
            <div class="form-group col-md-4">
                <label for="status" class="font-weight-bold">End(Please use military time)</label>
                <input type="text" name="tend" id="tend" class="form-control" placeholder="hhmm" required>
            </div>
            <div class="form-group col-md-8">
            <label for="address" class="font-weight-bold">Instructor</label>
            <select id="type" name="instructor" class="form-control" required="required">
            ';
            $sql2 = "SELECT * from users WHERE type = 'teacher'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
                    echo '
                                    <option value="' . $row2['id'] . '">' . $row2['lname'] . ',' . $row2['fname'] . '</option>
                                  ';
                }
            }

            echo '  
            </select>
        </div>
        </div>
            <input type="hidden" class="form-control" name="id"  value="' . $EditId . '" required>
            <input type="submit" class="btn btn-success" value="Submit" name="submit" required>
        </form>';
        }
        mysqli_close($conn);
        ?>
    </div>
    <?php
    if (isset($_POST['submit'])) {

        $day = $_POST['day'];
        $tstart = $_POST['tstart'];
        $tend = $_POST['tend'];
        $instructor = $_POST['instructor'];
        $location = $_POST['location'];
        $id = $_POST['id'];
        $_SESSION['errors'] = array();
        $conn = new mysqli("localhost", "root", "", "crud");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM teachersched WHERE instructor = '$instructor' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['id'] != $id) {
                    if ($row['day'] == $day) {
                        if ($tstart >= $row['tstart'] && $tstart <= $row['tend']) {
                            array_push($_SESSION['errors'], "tstart");
                        }
                        if ($tend >= $row['tstart'] && $tend <= $row['tend']) {
                            array_push($_SESSION['errors'], "tend");
                        }
                    }
                }
            }
        }
        if (count($_SESSION['errors']) == 0) {
            unset($_SESSION['errors']);

            $sql = "UPDATE teachersched SET day='$day',tstart='$tstart', tend='$tend',instructor='$instructor', location='$location' WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                echo "<script language='javascript'>alert('Schedule successfully updated!');window.location.href='schedule.php';</script>";
            }
        } else {
            echo "<script language='javascript'>alert('Overlapping Schedules!');window.location.href='editsched.php';</script>";
        }
        mysqli_close($conn);
    }
    ?>
</body>

</html>