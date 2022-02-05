<?php
session_start();
include 'db_connect.php';

$branchNameQry = "SELECT DISTINCT LOWER(BRANCH_NAME) AS BRANCH_NAME FROM branch_details ORDER BY 1";
$branchNameArr = array();
if (isset($conn) && $result = mysqli_query($conn, $branchNameQry)) {
    if (mysqli_num_rows($result) > 0) {
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $branchNameArr[$i] = $row['BRANCH_NAME'];
            $i = $i + 1;
        }
    }
}

$userNameQry = "SELECT DISTINCT LOWER(USER_NAME) AS USER_NAME FROM branch_details ORDER BY 1";
$userNameArr = array();
if (isset($conn) && $result = mysqli_query($conn, $userNameQry)) {
    if (mysqli_num_rows($result) > 0) {
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $userNameArr[$i] = $row['USER_NAME'];
            $i = $i + 1;
        }
    }
}

if (isset($_POST['submit'])) {
    $branchName = trim($_POST['branch-name']);
    $branchMobile = $_POST['branch-mobile'];
    $branchAlternativeMobile = $_POST['branch-alternative-mobile'];
    $branchAlternativeMobile = empty($branchAlternativeMobile) ? "" : trim($branchAlternativeMobile);
    $branchAddress = trim($_POST['branch-address']);
    $place = trim($_POST['branch-place']);
    $userName = trim($_POST['user-name']);
    $password = $_POST['password'];

    $branchOfficeInsertQuery = "INSERT INTO `branch_details`
                                (`BRANCH_NAME`, `BRANCH_MOBILE`, `ALTERNATIVE_MOBILE`, `ADDRESS`,`PLACE`, `USER_NAME`, `PASSWORD`)
                                VALUES
                                ('$branchName', '$branchMobile', '$branchAlternativeMobile', '$branchAddress', '$place', '$userName', '$password')
                                ";
    if (isset($conn) && mysqli_query($conn, $branchOfficeInsertQuery)) {
        ?>
        <script type="text/javascript">
            alert('✔️Branch Details Saved Successfully!');
            window.location.href = 'branchOffice.php';
        </script>
        <?php
    } else {
        if (isset($conn)) {
            echo "Error: " . $branchOfficeInsertQuery . "" . mysqli_error($conn);
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

<script>
    let branchNameArr = <?php echo json_encode($branchNameArr); ?>;
    let userNameArr = <?php echo json_encode($userNameArr); ?>;

    function validate() {
        let branchNewName = $('#branch-name').val();
        if (branchNewName !== "" && branchNewName != null) {
            if (branchNameArr.indexOf(branchNewName.trim().toLowerCase()) > -1) {
                alert("❌ Given Branch Name already added!");
                $('#branch-name').val('');
                return false;
            }
        }

        let userName = $('#user-nam').val();
        if (userName !== "" && userName != null) {
            if (userNameArr.indexOf(userName.trim().toLowerCase()) > -1) {
                alert("❌ User Name already exisits!");
                $('#user-name').val('');
                return false;
            }
        }
        return true;
    }
</script>

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
                            Add Branch
                            <button type="button" class="btn btn-success btn-sm pull-right"
                                    style="margin-top: 0.75em;" onclick="goToAddBranchDetails()">
                                <i class="material-icons">remove_red_eye</i>
                            </button>
                        </header>
                        <div class="panel-body">
                            <div class="position-center">
                                <form action=" " role="form" method="post" onsubmit="return validate()">
                                    <div class="form-group">
                                        <label for="branch-name">Branch Name<span class="mandatory-field">*</span></label>
                                        <input type="text" required class="form-control" id="branch-name"
                                               placeholder="Enter Name" name="branch-name" onchange="validate()" />
                                    </div>
                                    <div class="form-group">
                                        <label for="branch-mobile">Mobile<span class="mandatory-field">*</span></label>
                                        <input type="number" required class="form-control" id="branch-mobile"
                                               placeholder="Enter Employee Mobile No" name="branch-mobile" />
                                    </div>
                                    <div class="form-group">
                                        <label for="branch-alternative-mobile">Alternative Mobile</label>
                                        <input type="number" class="form-control" id="branch-alternative-mobile"
                                               placeholder="Enter Employee Mobile" name="branch-alternative-mobile" />
                                    </div>
                                    <div class="form-group">
                                        <label for="branch-address">Address<span class="mandatory-field">*</span></label>
                                        <textarea required class="form-control" id="branch-address" rows="4"
                                               placeholder="Enter Employee Address" name="branch-address"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="branch-place">Place<span class="mandatory-field">*</span></label><br>
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
                                               placeholder="Enter User Name" name="user-name" />
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password<span class="mandatory-field">*</span></label>
                                        <input type="text" class="form-control" id="password" required
                                               placeholder="Enter Password" name="password" />
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

<script src="ddtf.js"></script>
<script type="text/javascript">
    $('select').select2();

    let goToAddBranchDetails = function () {
        window.location.href = "branchOfficeView.php";
    };

    let deleteRecords = function (deleteButton) {
        let cnf = confirm("⚠️ Sure to delete!");
        if (cnf) {
            let city = $(deleteButton).attr('data-type');
            $.ajax({
                type: 'post',
                url: 'placeEntry.php',
                data: {
                    city: city,
                },
                success: function () {
                    alert('✔️Place (' + city + ') Deleted Successfully!');
                    window.location.reload();
                }
            });
        }
    }
</script>
</body>
