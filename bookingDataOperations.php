<?php
session_start();
include 'db_connect.php';


// date
date_default_timezone_set('Asia/Kolkata');
$date_1 =  date('d-m-Y H:i');
$date = date('Y-m-d', strtotime($date_1));

if(isset($_POST['isNewBooking'])) {
    $customer = $_POST['customer'];
    $mobile = $_POST['mobile'];
    $deliveryTo = $_POST['deliveryTo'];
    $deliveryMobile = $_POST['deliveryMobile'];
    $fromPlace = $_POST['fromPlace'];
    $fromAddress = $_POST['fromAddress'];
    $toPlace = $_POST['toPlace'];
    $toAddress = $_POST['toAddress'];
    $noOfQty = $_POST['noOfQty'];
    $qtyDescription = empty($_POST['qtyDescription']) ? "" : $_POST['qtyDescription'];
    $paymentType = $_POST['paymentType'];
    $transportationCharge = $_POST['transportationCharge'];
    $loadingCharge = empty($_POST['loadingCharge']) ? 0 : $_POST['loadingCharge'];
    $additionalCharge = empty($_POST['additionalCharge']) ? 0 : $_POST['loadingCharge'];
    $totalAmount = $_POST['totalAmount'];
    $goodsValue = empty($_POST['goodsValue']) ? "" : $_POST['goodsValue'];
    $notes = empty($_POST['notes']) ? "" : $_POST['notes'];

    try {
        if (isset($conn)) {
            $invoiceNumberQry = "UPDATE invoice_number SET INVOICE_NO = (INVOICE_NO + 1)";
            mysqli_query($conn, $invoiceNumberQry);

            $insertQuery = "INSERT INTO `booking_details`
                            (`CUSTOMER`, `MOBILE`, `DELIVERY_TO`, `DELIVERY_MOBILE`, `FROM_PLACE`, `FROM_ADDRESS`,
                             `TO_PLACE`, `TO_ADDRESS`, `QUANTITY`, `QTY_DESCRIPTION`, `PAYMENT_TYPE`, `TOTAL_AMOUNT`,
                             `TRANSPORTATION_COST`, `LOADING_COST`, `ADDITIONAL_COST`, `GOODS_VALUE`, `NOTES`,
                             `INVOICE_NUMBER`, `BOOKING_STAUTS`, `BOOKING_DATE`, `LAST_UPDATE_DATE`)
                            VALUES 
                            ('$customer', '$mobile', '$deliveryTo', '$deliveryMobile', '$fromPlace', '$fromAddress',
                             '$toPlace', '$toAddress', $noOfQty, '$qtyDescription', '$paymentType', $totalAmount, 
                             $transportationCharge, $loadingCharge, $additionalCharge, $goodsValue, '$notes', 
                             (SELECT CONCAT('JP-', INVOICE_NO) FROM invoice_number), 0, '$date', '$date')";
            mysqli_query($conn, $insertQuery);

            $selectQuerySql = 'SELECT MAX(BOOKING_ID) AS BOOKING_ID FROM booking_details';
            if (isset($conn) && $result = mysqli_query($conn, $selectQuerySql)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $bookingId = $row['BOOKING_ID'];
                    }
                }
            }
            print_r($bookingId);
        }
    } catch (Exception $e) {
        print_r("Error Occurred: " . $e);
    }
}

if(isset($_POST['forBookingList'])) {
    $bookingId = $_POST['bookingId'];
    $selectSql = "SELECT * FROM booking_details WHERE BOOKING_ID = $bookingId";
    $bookingDetails = array();
    if (isset($conn) && $result = mysqli_query($conn, $selectSql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $bookingDetails['BOOKING_ID'] = $row['BOOKING_ID'];
                $bookingDetails['CUSTOMER'] = $row['CUSTOMER'];
                $bookingDetails['MOBILE'] = $row['MOBILE'];
                $bookingDetails['DELIVERY_TO'] = $row['DELIVERY_TO'];
                $bookingDetails['DELIVERY_MOBILE'] = $row['DELIVERY_MOBILE'];
                $bookingDetails['FROM_PLACE'] = $row['FROM_PLACE'];
                $bookingDetails['FROM_ADDRESS'] = $row['FROM_ADDRESS'];
                $bookingDetails['TO_PLACE'] = $row['TO_PLACE'];
                $bookingDetails['TO_ADDRESS'] = $row['TO_ADDRESS'];
                $bookingDetails['QUANTITY'] = $row['QUANTITY'];
                $bookingDetails['QTY_DESCRIPTION'] = $row['QTY_DESCRIPTION'];
                $bookingDetails['PAYMENT_TYPE'] = $row['PAYMENT_TYPE'];
                $bookingDetails['TOTAL_AMOUNT'] = $row['TOTAL_AMOUNT'];
                $bookingDetails['TRANSPORTATION_COST'] = $row['TRANSPORTATION_COST'];
                $bookingDetails['LOADING_COST'] = $row['LOADING_COST'];
                $bookingDetails['ADDITIONAL_COST'] = $row['ADDITIONAL_COST'];
                $bookingDetails['GOODS_VALUE'] = $row['GOODS_VALUE'];
                $bookingDetails['NOTES'] = $row['NOTES'];
                $bookingDetails['INVOICE_NUMBER'] = $row['INVOICE_NUMBER'];
                $bookingDetails['BOOKING_STAUTS'] = $row['BOOKING_STAUTS'];
            }
        }
    }
    print_r(json_encode($bookingDetails));
}

if (isset($_POST['moveToShipOutward'])) {
    $bookingId = $_POST['bookingId'];
    $driverName = $_POST['driverName'];
    $driverMobile = $_POST['driverMobile'];
    $vechile = $_POST['vechile'];
    try {
        echo $updateQuery = "UPDATE booking_details SET BOOKING_STAUTS = 1, LAST_UPDATE_DATE = '$date' WHERE BOOKING_ID = $bookingId";
        if (isset($conn)) {
            mysqli_query($conn, $updateQuery);
            echo $updateDriverDetailsQry = "INSERT INTO `shipoutward_details`
                                        (`BOOKING_ID`, `DRIVER_NAME`, `DRIVER_MOBILE`, `VECHILE`) 
                                        VALUES 
                                        ($bookingId, '$driverName', '$driverMobile', '$vechile')";
            echo $updateDriverDetailsQry = "INSERT INTO shipoutward_details (`BOOKING_ID`, `DRIVER_NAME`, `DRIVER_MOBILE`, `VECHILE`)
                                            SELECT * FROM (SELECT $bookingId, '$driverName', '$driverMobile', '$vechile') AS tmp
                                            WHERE NOT EXISTS (
                                                SELECT BOOKING_ID FROM shipoutward_details WHERE BOOKING_ID = '$bookingId'
                                            ) LIMIT 1";
            mysqli_query($conn, $updateDriverDetailsQry);
            print_r("Success");
        }
    } catch (Exception $e) {
        print_r("Error: " .$e);
    }
}

if (isset($_POST['revertShipOutward'])) {
    $bookingId = $_POST['bookingId'];
    try {
        echo $updateQuery = "UPDATE booking_details SET BOOKING_STAUTS = 0 WHERE BOOKING_ID = $bookingId";
        if (isset($conn)) {
            mysqli_query($conn, $updateQuery);
            echo $deleteDriverDetailsQry = "DELETE FROM `shipoutward_details` WHERE `BOOKING_ID` = $bookingId";
            mysqli_query($conn, $deleteDriverDetailsQry);
            print_r("Success");
        }
    } catch (Exception $e) {
        print_r("Error: " .$e);
    }
}

if (isset($_POST['moveToShipInward'])) {
    $bookingId = $_POST['bookingId'];
    try {
        echo $updateQuery = "UPDATE booking_details SET BOOKING_STAUTS = 2, LAST_UPDATE_DATE = '$date' WHERE BOOKING_ID = $bookingId";
        if (isset($conn)) {
            mysqli_query($conn, $updateQuery);
            print_r("Success");
        }
    } catch (Exception $e) {
        print_r("Error: " .$e);
    }
}

if (isset($_POST['revertShipinward'])) {
    $bookingId = $_POST['bookingId'];
    try {
        echo $updateQuery = "UPDATE booking_details SET BOOKING_STAUTS = 1 WHERE BOOKING_ID = $bookingId";
        if (isset($conn)) {
            mysqli_query($conn, $updateQuery);
            print_r("Success");
        }
    } catch (Exception $e) {
        print_r("Error: " .$e);
    }
}

if (isset($_POST['newCustomerName'])) {
    $newCustomerName = $_POST['newCustomerName'];
//    $insertQuery = "INSERT INTO customer_details (CUSTOMER_NAME) VALUES ('$newCustomerName')";
    $insertQuery = "INSERT INTO customer_details (CUSTOMER_NAME)
                    SELECT * FROM (SELECT '$newCustomerName') AS tmp
                    WHERE NOT EXISTS (
                        SELECT CUSTOMER_NAME FROM customer_details WHERE CUSTOMER_NAME = '$newCustomerName'
                    ) LIMIT 1";
    mysqli_query($conn, $insertQuery);
    echo "inserted";
}

if (isset($_POST['updateMobileNumber'])) {
    $customerName = $_POST['customerName'];
    $mobileNumber = $_POST['mobileNumber'];
    $updateQuery = "UPDATE customer_details 
                    SET MOBILE = $mobileNumber
                    WHERE MOBILE IS NULL
                    AND CUSTOMER_NAME = '$customerName'
                    ";
    mysqli_query($conn, $updateQuery);
}
