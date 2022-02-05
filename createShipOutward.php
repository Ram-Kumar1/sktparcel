<?php
session_start();
include 'db_connect.php';

date_default_timezone_set('Asia/Kolkata');
$date_1 = date('d-m-Y H:i');
$date = date('Y-m-d', strtotime($date_1));

$sql = "SELECT BD.BOOKING_DATE, BD.CUSTOMER, BD.INVOICE_NUMBER, BD.FROM_PLACE, BD.TO_PLACE,
        BD.BOOKING_ID, BD.FROM_ADDRESS, BD.TO_ADDRESS, BD.DELIVERY_TO
        FROM booking_details BD
        WHERE BD.BOOKING_STAUTS = 0";
$whereSql = "";
$userName = $_SESSION['userName'];
$branchName = $_SESSION['admin'];
if (strtolower($userName) == strtolower('admin')) {
    // Nothing
} else {
    $whereSql = " AND FROM_PLACE = '$branchName' ";
    $sql = $sql . $whereSql;
}
$sql = $sql . " ORDER BY BOOKING_DATE";
?>

<!DOCTYPE html>

<head>
    <title>JP Travels</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--Custom CSS for JPT project-->
    <link rel="stylesheet" href="css/jpt-custom.css" type="text/css" />
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
    .m-1 {
        margin-top: 1em;
    }

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

    .red {
        color: red !important;
    }

    .max-30 {
        max-height: 30em;
    }

    .gst-0 {
        background: #95e395 !important;
    }

    .gst-1 {
        background: white !important;
    }

    .move-success {
        background: #b7fbb7 !important;
    }

    .w3-select {
        background: white !important;
    }
</style>
<!--For Dropdown Select-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    let driverNameMobileMap = {};
    let invoiceNoToPlaceMap = {};

    let driverNameSelectChanged = function() {
        let selectedVal = $(this).val();
        $('#driver-mobile').val(driverNameMobileMap[selectedVal]);
    };
</script>

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
                                Booking List
                                <button type="button" class="btn btn-danger btn-sm pull-right" style="margin-top: 1em;" onclick="window.location.reload();">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </button>
                            </header>
                            <br>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="customer-mobile">Vehicle<span class="mandatory-field">*</span></label>
                                        <input type="text" required class="form-control" id="customer-mobile" placeholder="Enter Mobile No" name="customer-mobile" />
                                    </div>
                                </div>
                                <!-- <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="customer-mobile">Place
                                                    <span class="mandatory-field">*</span>
                                                </label> <br>
                                                <select class="form-control" id="place" name="place" onchange="branchSelectChanged(this)">
                                                    <option value="">-- SELECT BRANCH --</option>
                                                    <?php
                                                    $selectCity = "SELECT BRANCH_NAME FROM branch_details ORDER BY 1";
                                                    if ($result = mysqli_query($conn, $selectCity)) {
                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                                <option value="<?php echo $row['BRANCH_NAME'] ?>"><?php echo $row['BRANCH_NAME'] ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="customer-mobile">Driver Name
                                                    <span class="mandatory-field">*</span>
                                                </label><br>
                                                <select class="form-control" id="driver-name" name="driver-name" onchange="driverNameSelectChanged(this)">
                                                    <option value="">-- SELECT DRIVER --</option>
                                                    <?php
                                                    $selectCity = "SELECT DRIVER_NAME, MOBILE FROM driver_details ORDER BY 1";
                                                    if ($result = mysqli_query($conn, $selectCity)) {
                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                                <option value="<?php echo $row['DRIVER_NAME'] ?>"><?php echo $row['DRIVER_NAME'] ?></option>
                                                                <script>
                                                                    driverNameMobileMap[<?php echo "'" . $row['DRIVER_NAME'] . "'"; ?>] = <?php echo "'" . $row['MOBILE'] . "'"; ?>
                                                                </script>
                                                    <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="customer-mobile">Driver Mobile <span class="mandatory-field">*</span></label>
                                        <input type="number" required class="form-control" id="driver-mobile" placeholder="Mobile No" name="driver-mobile" />
                                    </div>
                                </div>
                            </div>

                            <?php
                            if (isset($conn) && $result = mysqli_query($conn, $sql)) {
                                if (mysqli_num_rows($result) > 0) {
                            ?>
                                    <div class="table-responsive filterable max-30">
                                        <button type="button" class="btn btn-default btn-xs pull-right" onclick="updateAllValues()">
                                           Check All <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                        </button>
                                        <table class="table tableFixHead table-striped table-hover" id="data-table">
                                            <thead>
                                                <tr class="filters" style="color:#0c1211;">
                                                    <th class='skip-filter' style="color:#0c1211">#</th>
                                                    <th class='skip-filter' style="color:#0c1211; text-align: center;">Invoice&nbsp;No</th>
                                                    <th class='skip-filter' style="color:#0c1211">Customer</th>
                                                    <th class='skip-filter' style="color:#0c1211">Delivery</th>
                                                    <th class='skip-filter' style="color:#0c1211">From</th>
                                                    <th class='skip-filter' style="color:#0c1211">From&nbsp;Address</th>
                                                    <th id='to-place' style="color:#0c1211">To</th>
                                                    <th class='skip-filter' style="color:#0c1211">To&nbsp;Address</th>
                                                    <th class='skip-filter' class='skip-filter' style="color:#0c1211">Date</th>
                                                    <th style="color:#0c1211">ShipOut</th>
                                                    <th style="color:#0c1211">Cancel</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $i = 1;
                                            $invoiceNoToPlaceMap = array();
                                            while ($row = mysqli_fetch_array($result)) {
                                                $invoiceNoToPlaceMap[$row['BOOKING_ID']] = $row['TO_PLACE'];
                                            ?>
                                                <tbody>
                                                    <tr class="invoice-id-<?php echo $row['BOOKING_ID']; ?>">
                                                        <td style="color:#0c1211;">
                                                            <?php echo $i; ?>
                                                        </td>
                                                        <td class="max-30" style="color:#0c1211">
                                                            <a data-toggle="modal" class="booking-id" id="booking-id-<?php echo $row['BOOKING_ID']; ?>" href="">
                                                                <?php echo explode("-", $row['INVOICE_NUMBER'])[0] . "-" . str_pad(explode("-", $row['INVOICE_NUMBER'])[1], 3, '0', STR_PAD_LEFT); ?>
                                                            </a>
                                                        </td>
                                                        <td style="color:#0c1211"><?php echo $row['CUSTOMER']; ?></td>
                                                        <td style="color:#0c1211"><?php echo $row['DELIVERY_TO']; ?></td>
                                                        <td style="color:#0c1211"><?php echo $row['FROM_PLACE']; ?></td>
                                                        <td style="color:#0c1211"><?php echo $row['FROM_ADDRESS']; ?></td>
                                                        <td style="color:#0c1211"><?php echo $row['TO_PLACE']; ?></td>
                                                        <td style="color:#0c1211"><?php echo $row['TO_ADDRESS']; ?></td>
                                                        <td style="color:#0c1211"><?php echo $row['BOOKING_DATE']; ?></td>
                                                        <td class="max-30" style="color:#0c1211">
                                                            <a data-toggle="modal" onclick="updateToShipOut(<?php echo $row['BOOKING_ID']; ?>)" id="move-booking-id-<?php echo $row['BOOKING_ID']; ?>" data-booking-id="<?php echo $row['BOOKING_ID']; ?>" data-to-place="<?php echo $row['TO_PLACE'] ?>" href="">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                        <td class="max-30" style="color:#0c1211">
                                                            <a data-toggle="modal" onclick="updateToShipOutCancel(<?php echo $row['BOOKING_ID']; ?>)" id="move-booking-id-<?php echo $row['BOOKING_ID']; ?>" data-booking-id="<?php echo $row['BOOKING_ID']; ?>" href="">
                                                                <i class="fa fa-times" aria-hidden="true"></i>
                                                            </a>
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
                                    echo "No records matching your query were found.";
                                }
                            }
                                ?>
                                <script>
                                    invoiceNoToPlaceMap = <?php print_r(json_encode($invoiceNoToPlaceMap)); ?>;
                                </script>
                                <br><br>
                                    </div>
                        </section>
                    </div>
                </div>
                <!-- Trigger the modal with a button -->
                <div style="display: none;">
                    <button type="button" class="btn btn-info btn-lg" id="hsn-btn" data-toggle="modal" data-target="#hsn-model">Open Modal
                    </button>
                    <input type="text" id="invoiceIdToCreate" />
                </div>
                <!-- Modal -->
                <div id="details-model" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Booking Details</h4>
                            </div>
                            <div class="modal-body">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="invoice-no">Invoice No</label>
                                        <input type="text" class="form-control" id="invoice-no" name="invoice-no" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="invoice-no">Status </label>
                                        <input type="text" class="form-control" id="invoice-status" name="invoice-status" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customer">Customer</label>
                                        <input type="text" class="form-control" id="customer" name="customer" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customer">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customer">Delivery To</label>
                                        <input type="text" class="form-control" id="delivery-to" name="delivery-to" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customer">Delivery Mobile</label>
                                        <input type="text" class="form-control" id="delivery-mobile" name="delivery-mobile" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customer">From</label>
                                        <input type="text" class="form-control" id="from" name="from" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customer">From Address</label>
                                        <input type="text" class="form-control" id="from-address" name="from-address" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customer">To</label>
                                        <input type="text" class="form-control" id="to" name="to" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customer">To Address</label>
                                        <input type="text" class="form-control" id="to-address" name="to-address" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customer">Quantity</label>
                                        <input type="text" class="form-control" id="quantity" name="quantity" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customer">Quantity Description</label>
                                        <input type="text" class="form-control" id="quantity-desc" name="quantity-desc" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total-amount">Transportation Amount</label>
                                        <input type="number" class="form-control" id="transportation-amount" name="transportation-amount" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total-amount">Loading Amount</label>
                                        <input type="number" class="form-control" id="loading-amount" name="loading-amount" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total-amount">Additional Amount</label>
                                        <input type="number" class="form-control" id="additional-amount" name="additional-amount" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total-amount">Total Amount</label>
                                        <input type="number" class="form-control" id="total-amount" name="total-amount" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total-amount">Goods Value</label>
                                        <input type="text" class="form-control" id="goods-value" name="goods-value" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total-amount">Notes</label>
                                        <input type="text" class="form-control" id="notes" name="notes" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <!--                            <button type="button" class="btn btn-success" onclick="createPdf()">Create PDF</button>-->
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</body>
<script src="ddtf.js"></script>

<script>
    var createPdf = function(invoiceId) {
        window.location.href = 'createPPF2.php?invoiceId=' + invoiceId;
    };

    function getKeyByValue(object, value) {
        // return Object.keys(object).find(key => object[key] === value);
        var resArr = [];
        for (var key in object) {
            if (object.hasOwnProperty(key) && object[key] === value) {
                resArr.push(key);
            }
        }
        return resArr;
    }

    let updateAllValues = function() {
        let toPlace = decodeURI($('.select2-hidden-accessible').val());
        if (toPlace.includes('-all-')) {
            alert('❌ Please choose To Place before submitting!');
            return false;
        } else {
            let invoiceNoArr = getKeyByValue(invoiceNoToPlaceMap, toPlace);
            console.log(invoiceNoArr);
            for (let i = 0; i < invoiceNoArr.length; i++) {
                updateToShipOut(invoiceNoArr[i]);
            }
        }
    };

    let updateToShipOutCancel = function(bookingId) {
        $.ajax({
            url: 'bookingDataOperations.php',
            type: 'post',
            data: {
                revertShipOutward: 1,
                bookingId: bookingId
            },
            success: function(response) {
                if (response.toString().includes("Success")) {
                    $('.invoice-id-' + bookingId).removeClass("move-success");
                }
            }
        });
    };

    let updateToShipOut = function(bookingId) {
        console.log(bookingId);
        let vehicle = $('#customer-mobile').val();
        if (vehicle === undefined || vehicle === null || vehicle === "") {
            alert("❌ Vehicle No is mandatory!")
            return false;
        }
        /* let place = $('place').val();
        if (place === undefined || place === null || place === "") {
            alert("❌ Place is mandatory!")
            return false;
        } */
        let driverName = $('#driver-name').val();
        if (driverName === undefined || driverName === null || driverName === "") {
            alert("❌ Driver Name is mandatory!")
            return false;
        }
        let driverMobile = $('#driver-mobile').val();
        if (driverMobile === undefined || driverMobile === null || driverMobile === "") {
            alert("❌ Driver Mobile No is mandatory!")
            return false;
        }
        let tdId = $("#invoice-id-" + bookingId);
        $.ajax({
            url: 'bookingDataOperations.php',
            type: 'post',
            data: {
                moveToShipOutward: 1,
                bookingId: bookingId,
                driverName: driverName,
                driverMobile: driverMobile,
                vechile: vehicle
            },
            success: function(response) {
                if (response.toString().includes("Success")) {
                    $('.invoice-id-' + bookingId).addClass("move-success");
                }
            }
        });
    };

    $('.booking-id').click(function() {
        var id = this.id;
        var splitid = id.split('-');
        var bookingId = splitid[2];
        // AJAX request
        $.ajax({
            url: 'bookingDataOperations.php',
            type: 'post',
            data: {
                forBookingList: 1,
                bookingId: bookingId
            },
            success: function(response) {
                // Add response in Modal body
                let res = JSON.parse(response);
                $('#invoice-no').val(res['INVOICE_NUMBER'])
                $('#invoice-status').val(res['BOOKING_STAUTS'])
                $('#customer').val(res['CUSTOMER'])
                $('#mobile').val(res['MOBILE'])
                $('#delivery-to').val(res['DELIVERY_TO'])
                $('#delivery-mobile').val(res['DELIVERY_MOBILE'])
                $('#from').val(res['FROM_PLACE'])
                $('#from-address').val(res['FROM_ADDRESS'])
                $('#to').val(res['TO_PLACE'])
                $('#to-address').val(res['TO_ADDRESS'])
                $('#quantity').val(res['QUANTITY'])
                $('#quantity-desc').val(res['QTY_DESCRIPTION'])
                $('#transportation-amount').val(res['TRANSPORTATION_COST'])
                $('#loading-amount').val(res['LOADING_COST'])
                $('#additional-amount').val(res['ADDITIONAL_COST'])
                $('#total-amount').val(res['TOTAL_AMOUNT'])
                $('#goods-value').val(res['GOODS_VALUE'])
                $('#notes').val(res['NOTES'])
                // Display Modal
                $('#details-model').modal('show');
            }
        });
        $('#details-model').modal('show');
    });

    var updateDetails = function(id) {
        var conform = confirm("Sure to create?");
        if (!conform) {
            return;
        } else {
            $("#invoiceIdToCreate").val('');
            $("#invoiceIdToCreate").val(id);
            $("#hsn-btn").click();
        }

    };

    $("#data-table").ddTableFilter();
    $('select').addClass('w3-select');
    $('select').select2();
    /*    $("#place").select2('destroy'); */
    $("#driver-name").select2('destroy');
</script>

</html>