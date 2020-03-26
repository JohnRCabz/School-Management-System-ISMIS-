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
                <a href="index.php" class="nav-link text-light">Logout</a>
            </li>
        </ul>
    </div>
</nav>


<body>
    <div class="container-fluid w-150 position-relative mx-auto p-5 my-5">
        <?php
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
                if ($result2->num_rows > 0) {
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
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
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
                        <td><a class="btn btn-success" href="editsched.php?EditID=' . $row2['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                        <td><a class="btn btn-danger" href="schedule.php?DeleteID=' . $row2['id'] . '"><i class="fa fa-trash" aria-hidden="true"></i></a></td>      
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

        if (isset($_GET['DeleteID'])) {
            $DeleteID = $_GET['DeleteID'];

            $sql = "DELETE FROM teachersched WHERE id=$DeleteID";
            if ($conn->query($sql) === TRUE) {

                echo "<script language='javascript'>window.location.href='schedule.php';</script>";
            }
        }
        ?>
        <a href="addsched.php" class="btn btn-success" role="button">Add Schedule</a>
    </div>
</body>

</html>