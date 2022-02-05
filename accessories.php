<?php
session_start();
include 'db_connect.php';

if (isset($_POST['accessories'])) {
    $accessories = $_POST['accessories'];
    $delete = "DELETE FROM `accessories` WHERE ACCESSORY_NAME = '$accessories'";
    mysqli_query($conn, $delete);
    print json_encode("success");
}

if (isset($_POST['submit'])) {
    $accessories = $_POST['accessories'];
    $sql = "INSERT INTO accessories(ACCESSORY_NAME) VALUES('$accessories')";
    $sqlSock = "INSERT INTO accessories_stock(ACCESSORY_NAME, STOCK_VAL) VALUES('$accessories', 0)";
    mysqli_query($conn, $sqlSock);
    if (mysqli_query($conn, $sql)) {
?>
        <script type="text/javascript">
            alert('Data Are Inserted Successfully');
            window.location.href = 'accessories.php';
        </script>

<?php
    } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }
    $conn->close();
}
?>

<!DOCTYPE html>

<head>
    <title>Product Type</title>
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
<script>
    var products = [];

    function validate() {
        let product = $("#accessories").val();
        if (product != "" && product != null) {
            if (products.indexOf(product.toLowerCase()) > -1) {
                alert("Given value alreay added!");
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
                                ACCESSORIES
                            </header>
                            <div class="panel-body">
                                <div class="position-center">
                                    <form action=" " role="form" method="post" onsubmit="return validate()">

                                        <div class="form-group">
                                            <label for="city">Accessory Name</label>
                                            <input type="text" required class="form-control" id="accessories" placeholder="Enter Production Type" name="accessories">
                                        </div>

                                        <button type="submit" name="submit" class="btn btn-info">Submit</button>
                                    </form>
                                </div>

                                <div class="table-responsive" style="padding: 3em;">
                                    <table class="table">
                                        <thead>
                                            <tr style="color:#0c1211" ;>
                                                <th style="color:#0c1211" ;>Accessories</th>
                                                <th style="color:#0c1211" ;>Delete</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $selectCity = 'SELECT DISTINCT(ACCESSORY_NAME) FROM `accessories`';
                                        if ($result = mysqli_query($conn, $selectCity)) {
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                                    <tbody>
                                                        <script>
                                                            products.push("<?php echo strtolower($row['ACCESSORY_NAME']); ?>");
                                                        </script>
                                                        <tr>
                                                            <td style="color:#0c1211" ;><?php echo $row['ACCESSORY_NAME'] ?></td>
                                                            <td>
                                                                <a>
                                                                    <button type="submit" name="submit" name="Delete" onclick="deleteRecords(this)" data-type="<?php echo $row['ACCESSORY_NAME']; ?>" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
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


    </section>

    <!--main content end-->
    </section>

    <script type="text/javascript">
        var deleteRecords = function(deleteButton) {
            debugger;
            let cnf = confirm("Sure to delete!");
            if (cnf) {
                let accessories = $(deleteButton).attr('data-type');
                $.ajax({
                    type: 'post',
                    url: 'accessories.php',
                    data: {
                        accessories: accessories,
                    },
                    success: function(response) {
                        alert('Accessory is deleted Successfully');
                        window.location.reload();
                        //window.location.href = "sales_customer_all.php"
                    }
                });
            }

        }
    </script>

</body>

</html>