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
    <form action="addSubj.php" method="POST">
                <div class="form-group">
                    <label for="subjname">Subject Name</label>
                    <input type="text" class="form-control" id="subjname" name="subjname" aria-describedby="emailHelp" placeholder="Enter Subject Name" required>
                </div>
                <div class="form-group">
                    <label for="pop">Maximum Populatiom</label>
                    <input type="text" class="form-control" id="pop" name="pop" aria-describedby="emailHelp" placeholder="Enter Maximum Population" required>
                </div>
                <input type="submit" class="form-group btn btn-success" name="submit" aria-describedby="emailHelp" value="Register">
            </form>
        </div>
    <?php
    if (isset($_POST['submit'])) {
        $subjname = $_POST['subjname'];
        $pop = $_POST['pop'];

        $conn = new mysqli("localhost", "root", "", "crud");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "INSERT INTO subjects (id,name,maxpopulation) VALUES ('','$subjname','$pop')";
        if ($conn->query($sql) === TRUE) {
            echo "<script language='javascript'>window.location.href='admin.php';</script>";
        }
    }
    ?>
</body>

</html>