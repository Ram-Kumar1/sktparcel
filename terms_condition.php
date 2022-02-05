<?php
session_start();
include 'db_connect.php';

// if(isset($_POST['CITY_NAME'])){

//   $cityName= $_POST['CITY_NAME'];

//   $delete = "DELETE FROM `city` WHERE CITY_NAME = '$cityName'";
//   mysqli_query($conn,$delete);
//   print json_encode("success");
// }

if (isset($_POST['submit'])) {
    $term = $_POST['term'];
    $termId = $_GET['for'];
    $sql = "UPDATE `term_condition` SET `term`='$term' WHERE `term_id`= '$termId' ";


    if (mysqli_query($conn, $sql)) {
?>
        <script type="text/javascript">
            alert('Data Are Inserted Successfully');
            // location.reload();
            window.location.href = 'terms_condition.php?for=<?php echo $termId; ?>';
        </script>

<?php
    } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }
    $conn->close();
}
if (isset($_POST['bankDetails'])) {
    $term = $_POST['bankDetails'];
    $sql = "UPDATE `term_condition` SET `term`='$term' WHERE `term_id`= 3 ";
    mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>

<head>
    <title>Sunmac</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />

    <?php
    include 'demo.css';
    ?>
    <?php
    include 'demo.js';
    ?>
</head>

<body>
    <?php include 'header.php'; ?>

    <section id="main-content">
        <section class="wrapper">
            <div class="form-w3layouts">
                <!-- page start-->
                <!-- page start-->
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Terms & Conditions
                            </header>
                            <div class="panel-body">
                                <div class="position-center">
                                    <form action=" " role="form" method="post">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <div class="form-group">
                                                    <label for="city">Terms & Conditions</label>
                                                    <textarea class="form-control" rows="5" id="comment" placeholder="Enter Billing Address" name="term"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="submit" name="submit" class="btn btn-info" style="margin-top: 5em;">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <label for="city">Bank Details</label>
                                                <textarea class="form-control" rows="5" placeholder="Enter Billing Address" id="bank-detail" name="bank"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="btn btn-info" type="button" onclick="saveBankDetails()" name="Submit" value="Submit" style="margin-top: 5em;">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="table-responsive" style="padding: 1em;">
                                            <table class="table">
                                                <thead>
                                                    <tr style="color:#0c1211" ;>
                                                        <th style="color:#0c1211" ;>Terms & Conditions</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $for = $_GET['for'];
                                                $selectCity = "SELECT DISTINCT(term) FROM `term_condition` WHERE term_id= $for";
                                                if ($result = mysqli_query($conn, $selectCity)) {
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                            <tbody>
                                                                <tr>
                                                                    <td style="color:#0c1211" ;><?php echo (str_replace("\r\n", "<br>", $row['term'])); ?></td>
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
                                    <div class="col-sm-6">
                                        <div class="table-responsive" style="padding: 1em;">
                                            <table class="table">
                                                <thead>
                                                    <tr style="color:#0c1211" ;>
                                                        <th style="color:#0c1211" ;>Bank Details</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $for = $_GET['for'];
                                                $selectCity = "SELECT DISTINCT(term) FROM `term_condition` WHERE term_id=3";
                                                if ($result = mysqli_query($conn, $selectCity)) {
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                            <tbody>
                                                                <tr>
                                                                    <td style="color:#0c1211" ;><?php echo nl2br($row['term']) //(str_replace("\r\n", "<br>", )); ?></td>
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
                                </div>


                            </div>



                        </section>
                    </div>
                </div>
            </div>
        </section>
    </section>


    </section>

    <!--main content end-->
    </section>

    <script type="text/javascript">
        var saveBankDetails = function() {
            $.ajax({
                type: 'post',
                url: 'terms_condition.php',
                data: {
                    bankDetails: $("#bank-detail").val()
                },
                success: function(response) {
                    alert('Bank Details saved successfully');
                    window.location.reload();
                    //window.location.href = "sales_customer_all.php"
                }
            });
        }
    </script>

</body>

</html>