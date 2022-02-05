<?php
session_start();
include 'db_connect.php';

$userName = $_SESSION['userName'];

if (isset($_POST['customerId'])) {
    $customerId = $_POST['customerId'];
    $delete = "DELETE FROM customer_details WHERE CUSTOMER_ID = $customerId";
    if (isset($conn)) {
        mysqli_query($conn, $delete);
        print json_encode("success");
    }
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $sql = "INSERT INTO customer_details (CUSTOMER_NAME, MOBILE) VALUES ('$name', $mobile)";
    if (isset($conn) && mysqli_query($conn, $sql)) {
        ?>
        <script type="text/javascript">
            alert('✔️Customer Saved Successfully!');
            window.location.href = 'addCustomer.php';
        </script>
        <?php
    } else {
        if (isset($conn)) {
            echo "Error: " . $sql . "" . mysqli_error($conn);
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
    <link rel="stylesheet" href="css/jpt-custom.css" type="text/css"/>
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
    let goToBooking = function () {
        window.location.href = "newBooking.php";
    };
</script>
<style>
    .hide-btn {
        display: none !important;
    }
</style>
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
                            Add Customer
                            <button type="button" class="btn btn-success btn-sm pull-right"
                                    style="margin-top: 0.75em;" onclick="goToBooking()">
                                <i class="material-icons">library_books</i>
                            </button>
                        </header>
                        <div class="panel-body">
                            <div class="position-center">
                                <form action=" " role="form" method="post" onsubmit="return validate()">
                                    <div class="form-group">
                                        <label for="place">Customer Name<span class="mandatory-field">*</span></label>
                                        <input type="text" required class="form-control" id="name"
                                               placeholder="Enter Place Name" name="name" />
                                    </div>
                                    <div class="form-group">
                                        <label for="place">Customer Mobile<span class="mandatory-field">*</span></label>
                                        <input type="number" required class="form-control" id="mobile"
                                               placeholder="Enter Place Name" name="mobile" />
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-info" style="margin-left: 40%">
                                        💾 Submit
                                    </button>
                                </form>
                            </div>

                            <div class="table-responsive" style="padding: 3em;">
                                <table id="data-table" class="table">
                                    <thead>
                                    <tr style="color:#0c1211">
                                        <th class="skip-filter w3-select" style="color:#0c1211">#</th>
                                        <th class="w3-select" style="color:#0c1211">Customer Name</th>
                                        <th class="w3-select" style="color:#0c1211">Mobile</th>
                                        <th class="skip-filter w3-select hide-btn" style="color:#0c1211">Delete</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    $selectCity = 'SELECT CUSTOMER_NAME, MOBILE, CUSTOMER_ID FROM customer_details ORDER BY 1';
                                    $i = 1;
                                    if ($result = mysqli_query($conn, $selectCity)) {
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                <tbody>
                                                <tr>
                                                    <td style="color:#0c1211"><?php echo $i++; ?></td>
                                                    <td style="color:#0c1211"><?php echo $row['CUSTOMER_NAME'] ?></td>
                                                    <td style="color:#0c1211"><?php echo $row['MOBILE'] ?></td>
                                                    <td class="hide-btn">
                                                        <a>
                                                            <button type="submit" name="submit"
                                                                    onclick="deleteRecords(this)"
                                                                    data-type="<?php echo $row['CUSTOMER_ID']; ?>"
                                                                    class="btn btn-primary"
                                                                    style="max-width: 40px; max-height: 40px;">
                                                                <i class="material-icons" style="margin-left: -5px;">delete_forever</i>
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                </tbody>

                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </table>
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
    $("#data-table").ddTableFilter();
    $('select').addClass('w3-select');
    $('select').select2();

    $(document).ready(function(){
        let userName = <?php echo "'" . $userName . "'"; ?>;
        if (userName.toString().toLowerCase() == "admin") {
            $('.hide-btn').removeClass();
        } 
    });
                                   

    let deleteRecords = function (deleteButton) {
        let cnf = confirm("⚠️ Sure to delete!");
        if (cnf) {
            let customerId = $(deleteButton).attr('data-type');
            $.ajax({
                type: 'post',
                url: 'addCustomer.php',
                data: {
                    customerId: customerId
                },
                success: function () {
                    alert('✔️Customer Deleted Successfully!');
                    window.location.reload();
                }
            });
        }
    }
</script>
</body>
