<script>
    history.pushState(null, document.title, location.href);
    window.addEventListener('popstate', function (event) {
        history.pushState(null, document.title, location.href);
    });
</script>
<?php
session_start();
include 'db_connect.php';

$_SESSION['admin'] = '';
$_SESSION['userName'] = '';
$_SESSION['place'] = '';

date_default_timezone_set('Asia/Kolkata');
$date_1 = date('d-m-Y H:i');
$date = date('Y-m-d', strtotime($date_1));
$firstDay = date('Y-m-01'); // hard-coded '01' for first day
$lastDay = date('Y-m-t');

$branchName = '';
$userName = '';
$place = '';

if (isset($_POST['signin'])) {
    if (isset($conn)) {
        $userName = $_POST['usr_name'];
        $password = $_POST['pswd'];
        $sql = "select BRANCH_NAME, USER_NAME, PLACE from branch_details where USER_NAME LIKE '$userName' AND PASSWORD LIKE '$password'";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $branchName = $row['BRANCH_NAME'];
                    $userName = $row['USER_NAME'];
                    $place = $row['PLACE'];
                    $_SESSION['admin'] = $branchName;
                    $_SESSION['userName'] = $userName;
                    $_SESSION['place'] = $place;
                }
                header('Location:index.php');
            } else {
                ?>
                <script>
                    alert("❌ Incorrect UserName or Password!");
                </script>
                <?php
            }
        } else {
            ?>
            <script>
                alert("❌ Something went wrong!\n Check the internet  connection!\n If any other issues check with Admin.");
            </script>
            <?php
        }
    }

    $_SESSION['timestamp'] = time();
}
?>
<!DOCTYPE html>

<head>
    <title>JP Travels</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design"/>
    <META Http-Equiv="Cache-Control" Content="no-cache">
    <META Http-Equiv="Pragma" Content="no-cache">
    <META Http-Equiv="Expires" Content="0">
    <?php
    include 'demo.css';
    ?>
    <?php
    include 'demo.js';
    ?>
    <script>
        history.pushState(null, document.title, location.href);
        window.addEventListener('popstate', function (event) {
            history.pushState(null, document.title, location.href);
        });
    </script>
</head>

<script type="text/javascript">
    function preventBack() {
        window.history.forward();
    }

    setTimeout("preventBack()", 0);
    window.onunload = function () {
        null
    };
</script>

<body>
<div class="w3layouts-main">
    <h2>Sign In Now</h2>
    <form action="" method="post">
        <input type="text" class="ggg" name="usr_name" placeholder="User Name" required="" value="">
        <input type="password" class="ggg" name="pswd" placeholder="Password" required="" value="">
        <!--<select class="form-control" id="loginSelect" name="logintype">
            <option value="admin">Admin</option>
            <option value="generalManager">General Manager</option>
            <option value="HR">HR</option>
            <option value="followUp">Follow up</option>
            <option value="salesManager">Sales</option>
            <option value="accountsManager">Accounts</option>
            <option value="purchaseManager">Purchase</option>
            <option value="productionManager">Production</option>
            <option value="marketingManager">Back Office</option>
            <option value="employee">Employee</option>
            <option value="stores">Stores</option>
        </select>-->
        <input type="submit" value="Sign In" name="signin">
    </form>
</div>
</body>

<script>
    //  jQuery(document).ready(function($) {
    //    console.log("Doc Ready..");
    //    history.pushState(null, document.title, location.href);
    //    window.addEventListener('popstate', function(event) {
    //      history.pushState(null, document.title, location.href);
    //    });
    //  });
    //  history.pushState(null, document.title, location.href);
    //  window.addEventListener('popstate', function(event) {
    //    history.pushState(null, document.title, location.href);
    //  });
</script>

</html>