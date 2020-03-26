<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>offeredsubject</title>
    <link rel="stylesheet" href="./styles/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
            <h5><i class="fa fa-user-circle-o" aria-hidden="true"></i> Student</h5>
        </li>
    </ul>
</nav>
<nav class="navbar navbar-expand-lg navbar-warning bg-warning px-5"></nav>
<nav class="navbar navbar-expand-lg navbar-success bg-success px-5">
    <div class="collapse navbar-collapse" id="navContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
                <a href="student.php" class="nav-link  text-light">Schedule</a>
            </li>
            <li class="nav-item ">
                <a href="offeredsubject.php" class="nav-link  text-light">Subjects Offered</a>
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
        <h1>Schedule for this semester:</h1>
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
            die("Connection failed:" . $conn->connect_error);
        }
        $sql = "SELECT * FROM subjects";
        $result = $conn->query($sql);
        if ($result->num_rows >= 0) {
            while ($row = $result->fetch_assoc()) {
                $subjid = $row['id'];
                $name = $row['name'];
                $sql2 = "SELECT * from teachersched WHERE subjid = $subjid";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows >= 0) {
                    echo '
                    <h4>' . $name . '</h4>
                    <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Day</th>
                        <th scope="col">Start</th>
                        <th scope="col">End</th>
                        <th scope="col">Location</th>
                        <th scope="col">Instructor</th>
                        <th scope="col">Enroll</th> 
                      </tr>
                    </thead>
                    ';
                    while ($row2 = $result2->fetch_assoc()) {
                        $instructor = $row2['instructor'];
                        $hstart = $row2['tstart'] / 100;
                        $mstart = $row2['tstart'] % 100;
                        $hend = $row2['tend'] / 100;
                        $mend = $row2['tend'] % 100;
                        if($mstart === 00){
                            $dstart = "0AM";
                        }else{
                            $dstart = "AM";  
                        }
                        if($mend === 00){
                            $dend = "0AM";
                        }else{
                            $dend = "AM";  
                        }        
                        if ($hstart > 12) {
                            $hstart = $hstart - 12;
                            if($mstart === 00){
                                $dstart = "0PM";
                            }else{
                                $dstart = "PM";  
                            }          
                        }

                        if ($hend > 12) {
                            $hend = $hend - 12;
                            if($mend === 00){
                                $dend = "0PM";
                            }else{
                                $dend = "PM";  
                            } 
                        }
                        echo '
                         <tbody>
                         <th scope="row">';
                        switch ($row2['day']) {
                            case '1':
                                echo 'Sunday';
                                break;
                            case '2':
                                echo 'Monday';
                                break;
                            case '3':
                                echo 'Tuesday';
                                break;
                            case '4':
                                echo 'Wednesday';
                                break;
                            case '5':
                                echo 'Thursday';
                                break;
                            case '6':
                                echo 'Friday';
                                break;
                            case '7':
                                echo 'Saturday';
                                break;
                        }
                        echo '</th>
                         <td>' . (int) $hstart . ':' . $mstart . '' . $dstart . '</td>
                         <td>' . (int) $hend . ':' . $mend . '' . $dend . '</td>
                         <td>' . $row2['location'] . '</td>
                        
                         ';
                        $sql3 = "SELECT * FROM users WHERE id=$instructor";
                        $result3 = $conn->query($sql3);
                        if ($result3->num_rows > 0) {
                            $row3 = $result3->fetch_assoc();

                            echo '
                              <td>' . $row3['lname'] . ',' . $row3['fname'] . '</td>
                              
                           ';
                        }
                        echo '
                         <td><a class="btn btn-success" href="offeredsubject.php?AddID=' . $row2['id'] . '"><i class="fa fa-plus-square" aria-hidden="true"></i></a></td>
                      
                         </tbody>
                         ';
                    }
                }
                echo '
                  
                  </table>
                  <br>
                ';
            }
        }
        if (isset($_GET['AddID'])) {
            $id = $_GET['AddID'];
            $email = $_SESSION['loggedIn'];
            $_SESSION['errors'] = array();
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $studid = $row['id'];
            }
            $sql = "SELECT * FROM teachersched WHERE id = $id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $population = $row['population'];
                $subjid = $row['subjid'];
                $timeStart = $row['tstart'];
                $timeEnd = $row['tend'];
                $day = $row['day'];
            }
            $sql = "SELECT * FROM subjects WHERE id = $subjid";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $maxpop = $row['maxpopulation'];
            }
            if ($population < $maxpop) {
                $sql = "SELECT * FROM studentsched WHERE studid=$studid";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $schedid = $row['schedid'];
                        $sql2 = "SELECT * FROM teachersched WHERE id = $schedid";
                        $result2 = $conn->query($sql2);
                        if ($result2->num_rows > 0) {
                            while ($row2 = $result2->fetch_assoc()) {
                                if ($row2['day'] == $day) {
                                    if ($timeStart >= $row2['tstart'] && $timeStart <= $row2['tend']) {
                                        array_push($_SESSION['errors'], "tstart");
                                    }

                                    if ($timeEnd >= $row2['tstart'] && $timeEnd <= $row2['tend']) {
                                        array_push($_SESSION['errors'], "tend");
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                array_push($_SESSION['errors'], "Subject Schedule is currently full.");
            }
            if (count($_SESSION['errors']) == 0) {
                unset($_SESSION['errors']);
                $population = $population + 1;
                $sql = "INSERT INTO studentsched (id,schedid,studid) VALUES('','$id','$studid')";
                if ($conn->query($sql) === TRUE) {
                    $sql = "UPDATE teachersched SET population='$population' WHERE id=$id";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script language='javascript'>alert('Successfully enrolled!');window.location.href='student.php';</script>";
                    }
                }
            } else {
                echo "<script language='javascript'>alert('Overlapping Schedules!');window.location.href='offeredsubject.php';</script>";
            }
        }
        ?>
    </div>
</body>

</html>