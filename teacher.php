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
            <h5><i class="fa fa-user-circle-o" aria-hidden="true"></i> Teacher</h5>
        </li>
    </ul>
</nav>
<nav class="navbar navbar-expand-lg navbar-warning bg-warning px-5"></nav>
<nav class="navbar navbar-expand-lg navbar-success bg-success px-5">
    <div class="collapse navbar-collapse" id="navContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
                <a href="teacher.php" class="nav-link  text-light">Schedule</a>
            </li>
            <li class="nav-item ">
                <a href="teach.php" class="nav-link  text-light">Subjects taught</a>
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
            $instructor = $row['id'];
        }

        $sql = "SELECT * FROM teachersched WHERE instructor=$instructor ORDER BY tstart";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
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
                        ';
            while ($row = $result->fetch_assoc()) {
                $subjid = $row['subjid'];
                $hstart = $row['tstart'] / 100;
                $mstart = $row['tstart'] % 100;
                $hend = $row['tend'] / 100;
                $mend = $row['tend'] % 100;
                if ($mstart === 00) {
                    $dstart = "0AM";
                } else {
                    $dstart = "AM";
                }
                if ($mend === 00) {
                    $dend = "0AM";
                } else {
                    $dend = "AM";
                }
                if ($hstart > 12) {
                    $hstart = $hstart - 12;
                    if ($mstart === 00) {
                        $dstart = "0PM";
                    } else {
                        $dstart = "PM";
                    }
                }

                if ($hend > 12) {
                    $hend = $hend - 12;
                    if ($mend === 00) {
                        $dend = "0PM";
                    } else {
                        $dend = "PM";
                    }
                }
                $sql2 = "SELECT * FROM subjects WHERE id = $subjid";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    $row2 = $result2->fetch_assoc();
                    $name = $row2['name'];
                }

                echo '<tbody>';
                switch ($row['day']) {
                    case '1':
                        echo '
                                        <td><button type="button" class="btn btn-info">' . $name . '<br> ' . $row['location'] . '<br>' . (int) $hstart . ':' . $mstart . '' . $dstart . ' - ' . (int) $hend . ':' . $mend . '' . $dend . '</button></td>
                                    ';
                        break;
                    case '2':
                        echo '  
                                        <td></td>
                                        <td><button type="button" class="btn btn-warning">' . $name . '<br> ' . $row['location'] . '<br>' . (int) $hstart . ':' . $mstart . '' . $dstart . ' - ' . (int) $hend . ':' . $mend . '' . $dend . '</button></td>                                  
                                    ';
                        break;
                    case '3':
                        echo '
                                        <td> </td>
                                        <td> </td>
                                        <td><button type="button" class="btn btn-danger">' . $name . '<br> ' . $row['location'] . '<br>' . (int) $hstart . ':' . $mstart . '' . $dstart . ' - ' . (int) $hend . ':' . $mend . '' . $dend . '</button></td>                                                     
                                    ';
                        break;
                    case '4':
                        echo '
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td><button type="button" class="btn btn-success">' . $name . '<br> ' . $row['location'] . '<br>' . (int) $hstart . ':' . $mstart . '' . $dstart . ' - ' . (int) $hend . ':' . $mend . '' . $dend . '</button></td>                                                     
                                    ';
                        break;
                    case '5':
                        echo '
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td><button type="button" class="btn btn-primary">' . $name . '<br> ' . $row['location'] . '<br>' . (int) $hstart . ':' . $mstart . '' . $dstart . ' - ' . (int) $hend . ':' . $mend . '' . $dend . '</button></td>                                                     
                                    ';
                        break;
                    case '6':
                        echo '
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td><button type="button" class="btn btn-info">' . $name . '<br> ' . $row['location'] . '<br>' . (int) $hstart . ':' . $mstart . '' . $dstart . ' - ' . (int) $hend . ':' . $mend . '' . $dend . '</button></td>                                                     
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
                                    <td><button type="button" class="btn btn-secondary">' . $name . '<br> ' . $row['location'] . '<br>' . (int) $hstart . ':' . $mstart . '' . $dstart . ' - ' . (int) $hend . ':' . $mend . '' . $dend . '</button></td>                                                     
                                    ';
                        break;
                }


                echo '</tbody>';
            }

            echo '
                  
                    </table>
                    <br>
                  ';
        }
        ?>
    </div>
</body>

</html>