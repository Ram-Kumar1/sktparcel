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
                                ('$branchName', $branchMobile, '$branchAlternativeMobile', '$branchAddress', '$place', '$userName', '$password')
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
    let branchNameArr = <?php echo json_encode($branchNameArr); ?>;
    let customerNameMobileMap = {};
    let branchAndPlaceMap = {};

    let customerNameSelectChanged = function (select) {
        let selectVal = $(select).val();
        $("#customer-mobile").val(customerNameMobileMap[selectVal]);
    };

    let branchSelectChanged = function (select, textAreaId) {
        let selectedVal = $(select).val();
        $('#' + textAreaId).val(branchAndPlaceMap[selectedVal]);
        if (textAreaId.toString().startsWith("to-")) {
            let fromBranch = $("#from-branch-place").val();
            if (fromBranch === "") {
                alert("❌ Please choose from address first!");
                $("#to-branch-place").val('').trigger('change');
                $("#" + textAreaId).val('');
                return false;
            } else if (fromBranch === selectedVal) {
                alert("❌ From Branch & To Branch can't be same!");
                $("#to-branch-place").val('').trigger('change');
                $("#" + textAreaId).val('');
                return false;
            }
        }
    };

    let parseCost = function (inputId) {
        let resultVal = $(inputId).val();
        return isNaN(parseInt(resultVal)) ? 0 : parseInt(resultVal);
    };

    let chargeChange = function () {
        let transportationCharge = parseCost('#transportation-amount');
        let loadingCharge = parseCost('#loading-amount');
        let additionalCharge = parseCost('#additional-amount');
        let totalAmount = transportationCharge + loadingCharge + additionalCharge;
        $('#total-amount').val(totalAmount);
    };

    let goToAddCustomer = function () {
        window.location.href = "addCustomer.php";
    };

    function validate() {
        let branchNewName = $('#branch-name').val();
        if (branchNewName !== "" && branchNewName != null) {
            if (branchNameArr.indexOf(branchNewName.trim().toLowerCase()) > -1) {
                alert("❌ Given Branch Name already added!");
                $('#branchNewName').val('');
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
                            BOOK NEW
                            <button type="button" class="btn btn-success btn-sm pull-right"
                                    style="margin-top: 0.75em;" onclick="goToAddCustomer()">
                                <i class="material-icons">add</i>
                            </button>
                        </header>
                        <div class="panel-body">
                            <div> <!--class="position-center"-->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="branch-place">Customer<span
                                                        class="mandatory-field">*</span></label><br>
                                            <select class="form-control" id="customer-name" name="customer-name"
                                                    onchange="customerNameSelectChanged(this)" required>
                                                <option value="">-- SELECT CUSTOMER --</option>
                                                <?php
                                                $selectCity = "SELECT CUSTOMER_ID, TRIM(CUSTOMER_NAME) AS CUSTOMER_NAME, MOBILE FROM customer_details ORDER BY 2";
                                                if ($result = mysqli_query($conn, $selectCity)) {
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            ?>
                                                            <option value="<?php echo $row['CUSTOMER_NAME'] ?>"><?php echo $row['CUSTOMER_NAME'] ?></option>
                                                            <script>
                                                                customerNameMobileMap[<?php echo "'" . $row['CUSTOMER_NAME'] . "'"; ?>] = <?php echo "'" . $row['MOBILE'] . "'"; ?>
                                                            </script>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="customer-mobile">Mobile<span
                                                        class="mandatory-field">*</span></label>
                                            <input type="number" required class="form-control" id="customer-mobile"
                                                   placeholder="Enter Mobile No" name="customer-mobile"
                                                   onchange="mobileNoChanged(this)"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="delivery-to">Delivery To<span
                                                        class="mandatory-field">*</span></label>
                                            <input type="text" required class="form-control" id="delivery-to"
                                                   placeholder="Enter Delivery Info" name="delivery-to"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="customer-mobile">Delivery Mobile<span
                                                        class="mandatory-field">*</span></label>
                                            <input type="number" required class="form-control" id="delivery-mobile"
                                                   placeholder="Enter Mobile No" name="delivery-mobile"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="branch-place">From<span class="mandatory-field">*</span></label><br>
                                            <select class="form-control" id="from-branch-place" name="from-branch-place"
                                                    onchange="branchSelectChanged(this, 'from-branch-address')"
                                                    required>
                                                <option value=''>-- SELECT FROM PLACE --</option>
                                                <?php
                                                $selectCity = "SELECT PLACE, BRANCH_NAME, ADDRESS FROM branch_details";
                                                $userName = $_SESSION['userName'];
                                                $branchName = $_SESSION['admin'];
                                                if (strtolower($userName) == strtolower("admin")) {
                                                    // Do Nothing
                                                } else {
                                                    $selectCity = $selectCity . " WHERE BRANCH_NAME = '$branchName'";
                                                }
                                                $selectCity = $selectCity . '  ORDER BY BRANCH_NAME';
                                                if ($result = mysqli_query($conn, $selectCity)) {
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            ?>
                                                            <option value="<?php echo $row['BRANCH_NAME'] ?>"><?php echo $row['BRANCH_NAME'] ?></option>
                                                            <script>
                                                                branchAndPlaceMap[<?php echo "'" . $row['BRANCH_NAME'] . "'"; ?>] = <?php echo "'" . str_replace('"', '', json_encode($row['ADDRESS'])) . "'"; ?>
                                                            </script>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                   <!-- <?php echo $selectCity; ?> -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="branch-place">To<span
                                                        class="mandatory-field">*</span></label><br>
                                            <select class="form-control" id="to-branch-place" name="to-branch-place"
                                                    onchange="branchSelectChanged(this, 'to-branch-address')" required>
                                                <option value="">-- SELECT DELIVERY PLACE --</option>
                                                <?php
                                                $selectCity = "SELECT PLACE, BRANCH_NAME, ADDRESS FROM branch_details ORDER BY BRANCH_NAME";
                                                if ($result = mysqli_query($conn, $selectCity)) {
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            ?>
                                                            <option value="<?php echo $row['BRANCH_NAME'] ?>"><?php echo $row['BRANCH_NAME'] ?></option>
                                                            <script>
                                                                branchAndPlaceMap[<?php echo "'" . $row['BRANCH_NAME'] . "'"; ?>] = <?php echo "'" . str_replace('"', '', json_encode($row['ADDRESS'])) . "'"; ?>
                                                            </script>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="from-branch-address">From Branch Address<span
                                                        class="mandatory-field">*</span></label>
                                            <textarea required class="form-control" id="from-branch-address" rows="4"
                                                      readonly
                                                      placeholder="From Branch Address"
                                                      name="from-branch-address"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="to-branch-address">To Branch Address
                                                <span class="mandatory-field">*</span></label>
                                            <textarea required class="form-control" id="to-branch-address" rows="4"
                                                      readonly
                                                      placeholder="To Branch Address"
                                                      name="to-branch-address"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="quantity-no">No. Of Qty.<span
                                                        class="mandatory-field">*</span></label>
                                            <input type="number" required class="form-control" id="quantity-no"
                                                   placeholder="Enter Name" name="quantity-no"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="quantity-description">Quantity Dec</label>
                                                <!--<span class="mandatory-field">*</span></label>-->
                                                <textarea required class="form-control" id="quantity-description"
                                                          rows="2"
                                                          name="quantity-description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="payment-type">Payment Type<span class="mandatory-field">*</span></label><br>
                                            <select class="form-control" id="payment-type" name="to-branch-place"
                                                    required>
                                                <option value="">-- SELECT PAYMENT --</option>
                                                <option value="PAID">Paid</option>
                                                <!-- <option value="AMOUNT">Amount</option> -->
                                                <option value="TO_PAY">To Pay</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="total-amount">Total Amount</label>
                                            <input type="number" class="form-control" id="total-amount"
                                                   name="total-amount" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="transportation-amount">Transportation Charge</label>
                                            <input type="number" class="form-control" id="transportation-amount"
                                                   name="transportation-amount" onchange="chargeChange()"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="loading-amount">Loading Charge</label>
                                            <input type="number" class="form-control" id="loading-amount"
                                                   name="loading-amount" onchange="chargeChange()"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="additional-amount">Additional Charge</label>
                                            <input type="number" class="form-control" id="additional-amount"
                                                   name="additional-amount" onchange="chargeChange()"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="goods-value">Value Of Goods<span
                                                    class="mandatory-field">*</span></label>
                                        <input type="number" class="form-control" id="goods-value" name="goods-value"/>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="notes">Notes</label>
                                            <textarea required class="form-control" id="notes" rows="2"
                                                      name="notes"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-info" style="margin-left: 45%"
                                    onclick="saveData()">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                <!--💾-->
                                Submit
                            </button>
                        </div>
                    </section>
                </div>
            </div>
    </section>
</section>
<!--main content end-->
<script src="ddtf.js"></script>
<script type="text/javascript">
    $('select').select2();
    // $('select').select2({dropdownAutoWidth: true});
    $("#customer-name").select2({
        tags: true
    }).on('select2:close', function (){
        let element = this;
        let newName = $.trim(element.value);
        if (newName !== '') {
            $.ajax({
                type: 'post',
                url: 'bookingDataOperations.php',
                data: {
                    newCustomerName: newName
                },
                success: function (response) {
                    if (response === "inserted") {
                        element.append('<option value="' + newName + '">' + newName + '</option>');
                        element.value = newName;
                    }
                }
            });
        }
    });

    let mobileNoChanged = function (input) {
      let inputVal = $(input).val();
      let customerName = $('#customer-name').val();
      if (customerName !== undefined && customerName !== null && customerName !== "") {
          if (inputVal !== undefined && inputVal !== null && inputVal !== "") {
              $.ajax({
                  type: 'post',
                  url: 'bookingDataOperations.php',
                  data: {
                      updateMobileNumber: 1,
                      customerName: customerName,
                      mobileNumber: inputVal
                  },
                  success: function (response) {

                  }
              })
          }
      }
    };

    let goToAddBranchDetails = function () {
        window.location.href = "branchOfficeView.php";
    };

    let validateAndFromData = function () {
        let resObj = {};
        let canInsert = true;
        let customer = $('#customer-name').val();
        if (customer === undefined || customer === null || customer === "") {
            canInsert = false;
            alert("❌ Customer Name is mandatory!");
            return null;
        }
        let mobile = $('#customer-mobile').val();
        if (mobile === undefined || mobile === null || mobile === "") {
            canInsert = false;
            alert("❌ Customer mobile is mandatory!");
            return null;
        }
        let deliveryTo = $('#delivery-to').val();
        if (deliveryTo === undefined || deliveryTo === null || deliveryTo === "") {
            canInsert = false;
            alert("❌ Delivery To is mandatory!");
            return null;
        }
        let deliveryMobile = $('#delivery-mobile').val();
        if (deliveryMobile === undefined || deliveryMobile === null || deliveryMobile === "") {
            canInsert = false;
            alert("❌ Delivery Mobile is mandatory!");
            return null;
        }
        let fromPlace = $('#from-branch-place').val();
        let fromAddress = $('#from-branch-address').val();
        if (fromPlace === undefined || fromPlace === null || fromPlace === "") {
            canInsert = false;
            alert("❌ From Place is mandatory!");
            return null;
        }
        let toPlace = $('#to-branch-place').val();
        let toAddress = $('#to-branch-address').val();
        if (toPlace === undefined || toPlace === null || toPlace === "") {
            canInsert = false;
            alert("❌ To Place is mandatory!");
            return null;
        }
        let noOfQty = $('#quantity-no').val();
        let qtyDescription = $('#quantity-description').val();
        if (noOfQty === undefined || noOfQty === null || noOfQty === "") {
            canInsert = false;
            alert("❌ Quantity is mandatory!");
            return null;
        }
        let paymentType = $('#payment-type').val();
        if (paymentType === undefined || paymentType === null || paymentType === "") {
            canInsert = false;
            alert("❌ Payment Type is mandatory!");
            return null;
        }
        let transportationCharge = $('#transportation-amount').val();
        if (transportationCharge === undefined || transportationCharge === null || transportationCharge === "") {
            canInsert = false;
            alert("❌ Transportation is mandatory!");
            return null;
        }
        let loadingCharge = $('#loading-amount').val();
        let additionalCharge = $('#additional-amount').val();
        let totalAmount = $('#total-amount').val();
        let goodsValue = $('#goods-value').val();
        if (goodsValue === undefined || goodsValue === null || goodsValue === "") {
            canInsert = false;
            alert("❌ Value Of Goods is mandatory!");
            return null;
        }
        let notes = $('#notes').val();
        if (canInsert === true) {
            resObj['customer'] = customer;
            resObj['mobile'] = mobile;
            resObj['deliveryTo'] = deliveryTo;
            resObj['deliveryMobile'] = deliveryMobile;
            resObj['fromPlace'] = fromPlace;
            resObj['fromAddress'] = fromAddress;
            resObj['toPlace'] = toPlace;
            resObj['toAddress'] = toAddress;
            resObj['noOfQty'] = noOfQty;
            resObj['qtyDescription'] = qtyDescription;
            resObj['paymentType'] = paymentType;
            resObj['transportationCharge'] = transportationCharge;
            resObj['loadingCharge'] = loadingCharge;
            resObj['additionalCharge'] = additionalCharge;
            resObj['totalAmount'] = totalAmount;
            resObj['goodsValue'] = goodsValue;
            resObj['notes'] = notes;
            return resObj;
        }
        return null;
    };

    let saveData = function () {
        let cnf = confirm("✨ Sure to save!");
        if (cnf) {
            let validateAndGetValues = validateAndFromData();
            if (validateAndGetValues) {
                $.ajax({
                    type: 'post',
                    url: 'bookingDataOperations.php',
                    data: {
                        isNewBooking: 1,
                        customer: validateAndGetValues['customer'],
                        mobile: validateAndGetValues['mobile'],
                        deliveryTo: validateAndGetValues['deliveryTo'],
                        deliveryMobile: validateAndGetValues['deliveryMobile'],
                        fromPlace: validateAndGetValues['fromPlace'],
                        fromAddress: validateAndGetValues['fromAddress'],
                        toPlace: validateAndGetValues['toPlace'],
                        toAddress: validateAndGetValues['toAddress'],
                        noOfQty: validateAndGetValues['noOfQty'],
                        qtyDescription: validateAndGetValues['qtyDescription'],
                        paymentType: validateAndGetValues['paymentType'],
                        transportationCharge: validateAndGetValues['transportationCharge'],
                        loadingCharge: validateAndGetValues['loadingCharge'],
                        additionalCharge: validateAndGetValues['additionalCharge'],
                        totalAmount: validateAndGetValues['totalAmount'],
                        goodsValue: validateAndGetValues['goodsValue'],
                        notes: validateAndGetValues['notes']
                    },
                    success: function (responce) {
                        console.log(responce);
                        if(responce.toString().includes("Error")) {
                            alert("❌️Some error occurred. Please try again!");
                            window.location.reload();
                        } else {
                            alert("✔️Booked Successfully!");
                            window.location.href = "createPPF2.php?invoiceId=" + responce;
                        } 
                    }
                });
            }
        } else {
            return false;
        }
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
