<?php
session_start();
include 'db_connect.php';

if (isset($_POST['submit'])) {
    $driverName = trim($_POST['driver-name']);
    $mobile = $_POST['driver-mobile'];
    $mobile = empty($mobile) ? 0 : $mobile;
    $license = $_POST['license'];
    $license = empty($license) ? "" : trim($license);

    $driverDetailsInsertQuery = "INSERT INTO `driver_details`
                                (`DRIVER_NAME`, `MOBILE`, `LICENSE`)
                                VALUES 
                                ('$driverName',$mobile, '$license')
                                ";
    if (isset($conn) && mysqli_query($conn, $driverDetailsInsertQuery)) {
        ?>
        <script type="text/javascript">
            alert('✔️Driver Details Saved Successfully!');
            window.location.href = 'addDriver.php';
        </script>
        <?php
    } else {
        if (isset($conn)) {
            echo "Error: " . $driverDetailsInsertQuery . "" . mysqli_error($conn);
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<head>
    <title>JP Travels</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!--Custom CSS for JPT project-->
    <!--    <link rel="stylesheet" href="css/jpt-custom.css" type="text/css"/>-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design"/>
    <?php
    include 'demo.css';
    ?>
    <?php
    include 'demo.js';
    ?>
</head>
<!--For Dropdown Select-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<body>
<?php include 'header.php'; ?>
<section id="main-content">
    <section class="wrapper">
        <div class="form-w3layouts">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add Driver
                        </header>
                        <div class="panel-body">
                            <div class="position-center">
                                <form action=" " role="form" method="post" onsubmit="return validate()">
                                    <div class="form-group">
                                        <label for="driver-name">Driver Name<span class="mandatory-field">*</span></label>
                                        <input type="text" required class="form-control" id="driver-name"
                                               placeholder="Enter Name" name="driver-name" />
                                    </div>
                                    <div class="form-group">
                                        <label for="driver-mobile">Mobile</label>
                                        <input type="number" class="form-control" id="driver-mobile"
                                               placeholder="Enter Mobile No" name="driver-mobile" />
                                    </div>
                                    <div class="form-group">
                                        <label for="license">License</label>
                                        <input type="text" class="form-control" id="license"
                                               placeholder="Enter Licensee No" name="license" />
                                    </div>
                                    <div class="form-group">
                                        <label for="branch-place">Photo</label><br>
                                        <input type="file" class="form-control" id="photo" name="photo" />
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-info" style="margin-left: 40%">
                                        💾 Submit
                                    </button>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</section>
<!--main content end-->
</body>
