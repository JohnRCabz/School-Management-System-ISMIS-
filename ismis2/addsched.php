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
    <?php
    session_start();
    if (!isset($_SESSION['loggedIn'])) {
        header("Location: index.php");
    }
    if (isset($_GET['logout'])) {
        unset($_SESSION['loggedIn']);
        header("Location: index.php");
    }
    if (isset($_POST['submit'])) {
        $subjid = $_POST['subjid'];
        $day = $_POST['day'];
        $tstart = $_POST['tstart'];
        $tend = $_POST['tend'];
        $instructor = $_POST['instructor'];
        $location = $_POST['location'];
        $_SESSION['errors'] = array();

        $conn = new mysqli("localhost", "root", "", "crud");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM teachersched WHERE instructor = '$instructor' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
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

        if (count($_SESSION['errors']) == 0) {
            unset($_SESSION['errors']);
            $sql = "INSERT INTO teachersched (id,subjid,day,tstart,tend,instructor,location) VALUES ('','$subjid','$day','$tstart','$tend','$instructor','$location')";
            if ($conn->query($sql) === TRUE) {
                echo "<script language='javascript'>window.location.href='schedule.php';</script>";
            }
        } else {
            echo "<script language='javascript'>alert('Overlapping Schedule!');window.location.href='addsched.php';</script>";
        }
        mysqli_close($conn);
    }
    ?>
    <div class="container-fluid w-150 position-relative mx-auto p-5 my-5">
        <form action="addsched.php" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="subjid" class="font-weight-bold">Choose A Subject</label>
                    <select id="status" name="subjid" class="form-control" required="required">
                        <option selected>Subject</option>
                        <?php
                        $conn = new mysqli("localhost", "root", "", "crud");
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $sql = "SELECT * FROM subjects";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '
                                        <option value="' . $row['id'] . '">' . $row['name'] . '</option>
                                        ';
                            }
                        }

                        mysqli_close($conn);
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="location" class="font-weight-bold">Location</label>
                    <input type="text" class="form-control" name="location" placeholder="TC" required="required">
                </div>
                <div class="form-group col-md-4">
                    <label for="status" class="font-weight-bold">Day</label>
                    <select id="status" name="day" class="form-control" required="required">
                        <option selected>Day</option>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
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
                <select id="status" name="instructor" class="form-control" required="required">
                    <?php
                    $conn = new mysqli("localhost", "root", "", "crud");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM users WHERE type = 'teacher'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '
                                        <option value="' . $row['id'] . '">' . $row['lname'] . ',' . $row['fname'] . '</option>
                                        ';
                        }
                    }

                    mysqli_close($conn);
                    ?>
                </select>
            </div>
            </div>
            <input type="submit" class="btn btn-success" value="Submit" name="submit" required>
        </form>
    </div>
</body>

</html>