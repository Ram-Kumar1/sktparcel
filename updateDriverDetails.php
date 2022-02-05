<?php
session_start();
include 'db_connect.php';

if (isset($_POST['submit'])) {
    $name = trim($_POST['driver-name']);
    $mobile = $_POST['mobile'];
    $licence = $_POST['license'];

    $update = "UPDATE driver_details SET 
                  MOBILE = '$mobile', 
                  LICENSE = '$licence' 
              WHERE DRIVER_NAME = '$name'
              ";
    if (isset($conn) && mysqli_query($conn, $update)) {
        ?>
        <script type="text/javascript">
            alert('Data Updated Successfully');
            window.location.href = 'driverView.php';
        </script>
        <?php
    } else {
        echo "Error: " . $update . "" . mysqli_error($conn);
    }
}

if (isset($_GET['driverId']) && !empty($_GET['driverId'])) {
    $driverId = $_GET['driverId'];
    if (isset($conn)) {
        $resultDriverQry = mysqli_query($conn, "SELECT * FROM driver_details WHERE DRIVER_ID = $driverId");
        while ($row = mysqli_fetch_array($resultDriverQry)) {
            $driverNameFromQry = $row['DRIVER_NAME'];
            $driverMobileFromQry = $row['MOBILE'];
            $licenseFromQty = $row['LICENSE'];
        }
    }
//    echo json_encode($row['BRANCH_NAME']);
}
?>

<!DOCTYPE html>
<head>
    <title>JP Travels</title>
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
<body>
<?php include 'header.php'; ?>
<!-- sidebar menu end-->
<section id="main-content">
    <section class="wrapper">
        <div class="form-w3layouts">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Update Driver Details
                        </header>
                        <div class="panel-body">
                            <div class="position-center">
                                <form action=" " role="form" method="post">
                                    <div class="form-group">
                                        <label for="branch-name">Driver Name<span
                                                class="mandatory-field">*</span></label>
                                        <input type="text" required class="form-control" id="driver-name"
                                               placeholder="Enter Name" name="driver-name" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label for="branch-mobile">Mobile<span class="mandatory-field">*</span></label>
                                        <input type="text" required class="form-control" id="mobile"
                                               placeholder="Enter Mobile No" name="mobile"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="branch-alternative-mobile">License</label>
                                        <input type="text" class="form-control" id="license"
                                               placeholder="Enter Employee Mobile" name="license"/>
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#driver-name').val(<?php echo "'" . $driverNameFromQry . "'"; ?>);
        $('#mobile').val(<?php echo "'" . $driverMobileFromQry . "'"; ?>);
        $('#license').val(<?php echo "'" . $licenseFromQty . "'"; ?>);
    });
</script>
</body>

