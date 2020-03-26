<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
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
            die("Connection failed: " . $conn->connect_error);
        }
        $email = $_SESSION['loggedIn'];
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $studid = $row['id'];
        }

        $sql = "SELECT * FROM studentsched WHERE studid = $studid";
        $result = $conn->query($sql);
        if ($result->num_rows >= 0) {
            echo '
        <table class="table">
            <thead>
            <tr>
            <th scope="col">Sunday</th>
            <th scope="col">Monday</th>
            <th scope="col">Tuesday</th>
            <th scope="col">Wednesday</th>
            <th scope="col">Thursday</th>
            <th scope="col">Friday</th>
            <th scope="col">Saturday</th>
            </tr>
        </thead>
        <tbody>
        ';
            while ($row = $result->fetch_assoc()) {
                $schedid = $row['schedid'];
                $sql2 = "SELECT * FROM teachersched WHERE id = $schedid ORDER BY tstart";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $subjid = $row2['subjid'];
                        $hstart = $row2['tstart'] / 100;
                        $mstart = $row2['tstart'] % 100;
                        $hend = $row2['tend'] / 100;
                        $mend = $row2['tend'] % 100;
                        $population = $row2['population'];
                        $day = $row2['day'];
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
                        $sql3 = "SELECT * FROM subjects WHERE id = $subjid";
                        $result3 = $conn->query($sql3);
                        if ($result3->num_rows > 0) {
                            $row3 = $result3->fetch_assoc();
                            $name = $row3['name'];
                        }
                        echo '
                            <tr>';
                        switch ($day) {
                            case '1':
                                echo '
                                    <td><a class="btn btn-info" href="student.php?DeleteID=' . $row['id'] . '">' . $name . '<br> ' . $row2['location'] . ' <i class="fa fa-trash" aria-hidden="true"></i><br>' . (int) $hstart . ':' . $mstart . '' . $dstart . ' - ' . (int) $hend . ':' . $mend . '' . $dend . '</a></td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td></td>                                                    
                                    <td> </td>
                                    ';
                                break;
                            case '2':
                                echo '
                                    <td> </td>
                                    <td><a class="btn btn-warning" href="student.php?DeleteID=' . $row['id'] . '">' . $name . '<br> ' . $row2['location'] . ' <i class="fa fa-trash" aria-hidden="true"></i><br>' . (int) $hstart . ':' . $mstart . '' . $dstart . ' - ' . (int) $hend . ':' . $mend . '' . $dend . '<br></a></td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    ';
                                break;
                            case '3':
                                echo '
                                    <td> </td>
                                    <td> </td>
                                    <td><a class="btn btn-danger" href="student.php?DeleteID=' . $row['id'] . '">' . $name . '<br> ' . $row2['location'] . ' <i class="fa fa-trash" aria-hidden="true"></i><br>' . (int) $hstart . ':' . $mstart . '' . $dstart . ' - ' . (int) $hend . ':' . $mend . '' . $dend . '<br></a></td>                                 
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    ';
                                break;
                            case '4':
                                echo '
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td><a class="btn btn-success" href="student.php?DeleteID=' . $row['id'] . '">' . $name . ' <br> ' . $row2['location'] . ' <i class="fa fa-trash" aria-hidden="true"></i><br>' . (int) $hstart . ':' . $mstart . '' . $dstart . ' - ' . (int) $hend . ':' . $mend . '' . $dend . '<br></a></td>  
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    ';
                                break;
                            case '5':
                                echo '
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td><a class="btn btn-primary" href="student.php?DeleteID=' . $row['id'] . '">' . $name . '<br> ' . $row2['location'] . ' <i class="fa fa-trash" aria-hidden="true"></i><br>' . (int) $hstart . ':' . $mstart . '' . $dstart . ' - ' . (int) $hend . ':' . $mend . '' . $dend . '<br></a></td>                                                 
                                    <td> </td>
                                    <td> </td>                
                                    <hr>';
                                break;
                            case '6':
                                echo '
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td><a class="btn btn-info" href="student.php?DeleteID=' . $row['id'] . '">' . $name . '<br> ' . $row2['location'] . ' <i class="fa fa-trash" aria-hidden="true"></i><br>' . (int) $hstart . ':' . $mstart . '' . $dstart . ' - ' . (int) $hend . ':' . $mend . '' . $dend . '<br></a></td>                                                    
                                    <td> </td>
                                    ';
                                break;
                            case '7':
                                echo '
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>                                                    
                                    <td><a class="btn btn-secondary" href="student.php?DeleteID=' . $row['id'] . '">' . $name . '<br> ' . $row2['location'] . ' <i class="fa fa-trash" aria-hidden="true"></i><br>' . (int) $hstart . ':' . $mstart . '' . $dstart . ' - ' . (int) $hend . ':' . $mend . '' . $dend . '<br></a></td>
                                    ';
                                break;
                        }
                        echo '
                    </tr>   
                    ';
                    }
                }
            }
            echo '
        </tbody>
        </table>
        <br>
        ';
        }
        if (isset($_GET['DeleteID'])) {
            $deleteID = $_GET['DeleteID'];
            $population = $population - 1;

            $sql = "SELECT * FROM studentsched WHERE id = $deleteID";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $schedid = $row['schedid'];
            }
            $sql = "DELETE FROM studentsched WHERE id = $deleteID";
            if ($conn->query($sql) === TRUE) {
                $sql = "UPDATE teachersched SET population=$population WHERE id=$schedid";
                if ($conn->query($sql) === TRUE) {
                    echo "<script language='javascript'>window.location.href='student.php';</script>";
                }
            }
        }
        ?>
    </div>
</body>

</html>