<?php
session_start();
include 'db_connect.php';

if (isset($_POST['branchOfficeId'])) {
    $branchOfficeId = $_POST['branchOfficeId'];
    echo $delete = "DELETE FROM branch_details WHERE BRANCH_OFFICE_ID = $branchOfficeId";
    if (isset($conn)) {
        mysqli_query($conn, $delete);
        print json_encode("success");
    }
}

date_default_timezone_set('Asia/Kolkata');
$date_1 = date('d-m-Y H:i');
$date = date('Y-m-d', strtotime($date_1));

$sql = "SELECT * FROM branch_details ORDER BY BRANCH_NAME";
?>

<!DOCTYPE html>
<head>
    <title>JP Travels</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
<!--Custom CSS for JPT project-->
<link rel="stylesheet" href="css/jpt-custom.css" type="text/css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    /* FOR TABLE FIXED HEADER */
    .tableFixHead {
        overflow-y: auto;
        max-height: 400px;
    }

    .tableFixHead table {
        border-collapse: collapse;
        width: 100%;
    }

    .tableFixHead th,
    .tableFixHead td {
        padding: 8px 16px;
    }

    .tableFixHead th {
        position: sticky;
        top: 0;
    }

    /* ENDS HERE */
    .filterable {
        margin-top: 15px;
    }

    .filterable .panel-heading .pull-right {
        margin-top: -20px;
    }

    .filterable .filters input[disabled] {
        background-color: transparent;
        border: none;
        cursor: auto;
        box-shadow: none;
        padding: 0;
        height: auto;
    }

    .filterable .filters input[disabled]::-webkit-input-placeholder {
        color: #333;
    }

    .filterable .filters input[disabled]::-moz-placeholder {
        color: #333;
    }

    .filterable .filters input[disabled]:-ms-input-placeholder {
        color: #333;
    }

    .max-30 {
        max-height: 30em;
    }

    .select2-selection__rendered {
        background: #428bca;
        border-bottom: 1px solid #5796cd !important;
        border-color: #428bca;
        color: #0a0a0a !important;
    }

    .select2-selection {
        border: aliceblue !important;
    }

    .select2-results__option {
        background: white;
    }

    select {
        background: #428bca;
        border-bottom: 1px solid #5796cd !important;
        border-color: #428bca;
    }

    option {
        background: white;
    }

</style>

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
                            View Branch Office
                            <button type="button" class="btn btn-primary btn-sm pull-right"
                                    style="margin-top: 0.75em;" onclick="goToAddBranchDetails()">
                                <i class="material-icons">add</i>
                            </button>
                        </header>
                        <br>

                        <?php
                        if (isset($conn) && $result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                        ?>
                        <div class="table-responsive filterable max-30">
                            <table id="data-table" class="table tableFixHead table-striped table-hover">
                                <thead>
                                <tr class="filters" style="color:#0c1211;">
                                    <th class="skip-filter" style="color:#0c1211">S. No</th>
                                    <th style="color:#0c1211">Branch Name</th>
                                    <th style="color:#0c1211">Mobile</th>
                                    <th style="color:#0c1211">Alternative Mobile</th>
                                    <th style="color:#0c1211">Place</th>
                                    <th class="max-30" style="color:#0c1211">Address</th>
                                    <th style="color:#0c1211">User Name</th>
                                    <th style="color:#0c1211">Password</th>
                                    <th style="color:#0c1211; text-align: center;">Edit</th>
                                    <th style="color:#0c1211; text-align: center;">Delete</th>
                                </tr>
                                </thead>
                                <?php
                                $i = 1;
                                while ($row = mysqli_fetch_array($result)) {

                                    ?>
                                    <tbody>
                                    <tr>
                                        <td style="color:#0c1211;"><?php echo $i; ?></td>
                                        <td style="color:#0c1211"><?php echo $row['BRANCH_NAME']; ?></td>
                                        <td style="color:#0c1211"><?php echo $row['BRANCH_MOBILE']; ?></td>
                                        <td style="color:#0c1211"><?php echo $row['ALTERNATIVE_MOBILE']; ?></td>
                                        <td style="color:#0c1211"><?php echo $row['PLACE']; ?></td>
                                        <td style="color:#0c1211"><?php echo $row['ADDRESS']; ?></td>
                                        <td style="color:#0c1211"><?php echo $row['USER_NAME']; ?></td>
                                        <td style="color:#0c1211"><?php echo $row['PASSWORD']; ?></td>
                                        <td style="color:#0c1211; text-align: center;">
                                            <button type="button" data-field="<?php echo $row['BRANCH_OFFICE_ID']; ?>"
                                                    class="btn btn-default is-complete"
                                                    onclick="editDetails(<?php echo $row['BRANCH_OFFICE_ID']; ?>)">
                                                <i class="material-icons" style="color: #0c1211;">create</i>
                                            </button>
                                        </td>
                                        <td style="color:#0c1211; text-align: center;">
                                            <button type="button" data-field="<?php echo $row['BRANCH_OFFICE_ID']; ?>"
                                                    class="btn btn-default is-complete"
                                                    onclick="deleteBranch(<?php echo $row['BRANCH_OFFICE_ID']; ?>)">
                                                <!-- onclick="updateDetails(<?php // echo $row['SAMPLE_PI_ID']; ?>)" -->
                                                <i class="material-icons" style="color: #0c1211;">delete_outline</i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <?php
                                    ++$i;
                                }
                                ?>


                            </table>
                            <?php
                            mysqli_free_result($result);
                            } else {
                                echo "No records found.";
                            }
                            }
                            ?>
                            <br>
                            <br>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="ddtf.js"></script>
<script>
    $(document).ready(function () {
        $("#data-table").ddTableFilter();
        $('select').addClass('w3-select');
        $('select').select2();
    });

    let goToAddBranchDetails = function () {
      window.location.href = "branchOffice.php";
    };

    let editDetails = function (branchOfficeId) {
        window.location.href = 'updateBranchDetails.php?branchOfficeId=' + branchOfficeId;
    };

    var deleteBranch = function (branchOfficeId) {
        let cnf = confirm("⚠️ Sure to delete!");
        if (cnf) {
            $.ajax({
                type: 'post',
                url: 'branchOfficeView.php',
                data: {
                    branchOfficeId: branchOfficeId,
                },
                success: function () {
                    alert('✔️Branch Deleted Successfully!');
                    window.location.reload();
                }
            });
        }
    };
</script>