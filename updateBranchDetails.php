<?php
session_start();
include 'db_connect.php';

if (isset($_POST['submit'])) {
    $branchName = trim($_POST['branch-name']);
    $branchMobile = $_POST['branch-mobile'];
    $branchAlternativeMobile = $_POST['branch-alternative-mobile'];
    $branchAlternativeMobile = empty($branchAlternativeMobile) ? "" : trim($branchAlternativeMobile);
    $branchAddress = trim($_POST['branch-address']);
    $place = trim($_POST['branch-place']);
    $userName = trim($_POST['user-name']);
    $password = $_POST['password'];
    $update = "UPDATE branch_details SET 
                  ADDRESS = '$branchAddress', 
                  BRANCH_MOBILE = '$branchMobile', 
                  ALTERNATIVE_MOBILE = '$branchAlternativeMobile',
                  PLACE = '$place',
                  USER_NAME = '$userName',
                  PASSWORD = '$password'
              WHERE BRANCH_NAME = '$branchName'
              ";
    if (isset($conn) && mysqli_query($conn, $update)) {
        ?>
        <script type="text/javascript">
            alert('Data Updated Successfully');
            window.location.href = 'branchOfficeView.php';
        </script>
        <?php
    } else {
        echo "Error: " . $update . "" . mysqli_error($conn);
    }
}

if (isset($_GET['branchOfficeId']) && !empty($_GET['branchOfficeId'])) {
    $branchOfficeId = $_GET['branchOfficeId'];
    if (isset($conn)) {
        $resultBranchOfficeQry = mysqli_query($conn, "SELECT * FROM branch_details WHERE BRANCH_OFFICE_ID = $branchOfficeId");
        while ($row = mysqli_fetch_array($resultBranchOfficeQry)) {
            $branchNameFromQry = $row['BRANCH_NAME'];
            $branchMobileFromQry = $row['BRANCH_MOBILE'];
            $branchAlternativeMobileFromQry = $row['ALTERNATIVE_MOBILE'];
            $addressFromQry = $row['ADDRESS'];
            $placeFromQry = $row['PLACE'];
            $userNameFromQry = $row['USER_NAME'];
            $passwordFromQry = $row['PASSWORD'];
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
                            Branch Office Update
                        </header>
                        <div class="panel-body">
                            <div class="position-center">
                                <form action=" " role="form" method="post" onsubmit="return validate()">
                                    <div class="form-group">
                                        <label for="branch-name">Branch Name<span
                                                    class="mandatory-field">*</span></label>
                                        <input type="text" required class="form-control" id="branch-name"
                                               placeholder="Enter Name" name="branch-name" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <label for="branch-mobile">Mobile<span class="mandatory-field">*</span></label>
                                        <input type="text" required class="form-control" id="branch-mobile"
                                               placeholder="Enter Employee Mobile No" name="branch-mobile"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="branch-alternative-mobile">Alternative Mobile</label>
                                        <input type="text" class="form-control" id="branch-alternative-mobile"
                                               placeholder="Enter Employee Mobile" name="branch-alternative-mobile"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="branch-address">Address<span
                                                    class="mandatory-field">*</span></label>
                                        <textarea required class="form-control" id="branch-address" rows="4"
                                                  placeholder="Enter Employee Address" name="branch-address"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="branch-place">Place<span
                                                    class="mandatory-field">*</span></label><br>
                                        <select class="form-control" id="branch-place" name="branch-place" required>
                                            <option value="">-- SELECT PLACE --</option>
                                            <?php
                                            $selectCity = "SELECT DISTINCT CITY_NAME FROM city ORDER BY 1";
                                            if ($result = mysqli_query($conn, $selectCity)) {
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                        <option value="<?php echo $row['CITY_NAME'] ?>"><?php echo $row['CITY_NAME'] ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="user-name">User Name<span class="mandatory-field">*</span></label>
                                        <input type="text" class="form-control" id="user-name" required
                                               placeholder="Enter User Name" name="user-name"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password<span class="mandatory-field">*</span></label>
                                        <input type="text" class="form-control" id="password" required
                                               placeholder="Enter Password" name="password"/>
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
        $('#branch-name').val(<?php echo "'" . $branchNameFromQry . "'"; ?>);
        $('#branch-mobile').val(<?php echo "'" . $branchMobileFromQry . "'"; ?>);
        $('#branch-alternative-mobile').val(<?php echo "'" . $branchAlternativeMobileFromQry . "'"; ?>);
        $('#branch-address').val(<?php echo "'" . str_replace('"', '', json_encode($addressFromQry)) . "'"; ?>);
        $('#branch-place').val(<?php echo "'" . $placeFromQry . "'"; ?>);
        $('#user-name').val(<?php echo "'" . $userNameFromQry . "'"; ?>);
        $('#password').val(<?php echo "'" . $passwordFromQry . "'"; ?>);
    });
</script>
</body>

