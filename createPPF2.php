<?php
session_start();
include 'db_connect.php';

function getIndianCurrency($number)
{
    // $decimal = round($number - ($no = floor($number)), 2) * 100;
    $no = ceil($number);
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    // $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    // return ($Rupees ? 'INR ' . $Rupees . ' only' : '') . $paise;
    return ($Rupees ? 'INR ' . $Rupees . ' only' : '');
}

if (isset($_GET['invoiceId'])) {
    $invoiceDetails = "SELECT * FROM booking_details WHERE BOOKING_ID = " . $_GET['invoiceId'];
    $invoiceResult = mysqli_query($conn, $invoiceDetails);
    while ($row = mysqli_fetch_array($invoiceResult)) {
        $customerName = $row['CUSTOMER'];
        $mobile = $row['MOBILE'];
        $deliveryTo = $row['DELIVERY_TO'];
        $deliveryMobile = $row['DELIVERY_MOBILE'];
        $fromPlace = $row['FROM_PLACE'];
        $fromAddress = $row['FROM_ADDRESS'];
        $toPlace = $row['TO_PLACE'];
        $toAddress = $row['TO_ADDRESS'];
        $quantity = $row['QUANTITY'];
        $paymentType = $row['PAYMENT_TYPE'];
        $transportationCost = $row['TOTAL_AMOUNT'];
        $additionalCost = $row['ADDITIONAL_COST'];
        $goodsValue = $row['GOODS_VALUE'];
        $invoiceNumber = $row['INVOICE_NUMBER'];
        date_default_timezone_set('Asia/Kolkata');
        $date_1 =  date('d-m-Y H:i');
        $curDate = date('Y-m-d', strtotime($date_1));
    }

    $branchPhNoQuery = "SELECT BRANCH_MOBILE FROM branch_details WHERE BRANCH_NAME = '$toPlace'";
    $branchPhNoResult = mysqli_query($conn, $branchPhNoQuery);
    while ($row = mysqli_fetch_array($branchPhNoResult)) {
        $branchPhNo = $row['BRANCH_MOBILE'];
    }
?>

    <!DOCTYPE html>

    <head>
        <title>JP Travels</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
        <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

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
        .red {
            color: red !important;
        }

        .m-1 {
            margin: 1px;
            margin-top: -1em;
        }

        .max-30 {
            max-width: 15em;
        }

        /* .b-r {
            border-right: 1px solid;
        } */

        td {
            color: black !important;
            border-color: black;
            margin-top: 0.5em;
        }

        /* table, th, td {
            border: 1px solid black;
        } */

        /* table.table-bordered {
            border: 1px solid #3d3d3d ! important;
        }

        table.table-bordered>thead>tr>th {
            border: 1px solid #3d3d3d ! important;
        }

        table.table-bordered>tbody>tr>td {
            border: 1px solid #3d3d3d ! important;
            border-bottom: 1px solid #3d3d3d ! important;
        } */

        min-hgt {
            height: 2px;
        }

        /* .table>thead>tr>th {
            padding: 0px !important;
        }

        .table>tbody>tr>td,
        .table>tbody>tr>th,
        .table>tfoot>tr>td,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>thead>tr>th {
            line-height: 1.42857143 !important;
        }

        .table td,
        .table>tbody>tr>td,
        .table>tbody>tr>th,
        .table>tfoot>tr>td,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>thead>tr>th {
            padding: 1px !important;
        } */

        html,
        body {
            font-size: 95% !important;
        }

        button.btn.m-2 {
            margin-top: 0.7em;
        }

        table {
            font-family: 'fangsong';
            font-size: 1.5em
        }
    </style>

    <body>
        <?php include 'header.php'; ?>
        <!-- sidebar menu end-->

        <section id="main-content">
            <section class="wrapper">
                <div class="form-w3layouts">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-success pull-left m-2" onclick="CreatePDFfromHTML(<?php echo "'" . $customerName . "'" ?>)">
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            Export
                        </button>&nbsp;
                        <button type="button" class="btn btn-success pull-left m-2" onclick="printDiv('print-div')" style="margin-left: 5px;">
                            <i class="fa fa-print" aria-hidden="true"></i>
                            Print
                        </button>

                        <button type="button" name="button" class="btn btn-default pull-right m-2" onclick="location.href = 'viewBookingList.php';">
                            <i class="fa fa-backward" aria-hidden="true" style="color: black"></i>
                            Back
                        </button>&nbsp;
                        <button type="button" name="button" id="email-btn" class="btn btn-primary pull-right m-2" style="margin-right: 5px;" data-toggle="modal" data-target="#email-modal">
                            <!-- onclick="sendEmail()" -->
                            <i class="fa fa-envelope-o" aria-hidden="true" style="color: white"></i>
                            Mail
                        </button>&nbsp;
                    </div>
                    <!-- page start-->
                    <div class="row html-content">
                        <div class="col-lg-12">
                            <section class="panel">
                                <!-- <br> -->
                                <div id="print-div">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <!-- <td style="text-align: center; font-size: x-large;"> Invoice </td> -->
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive" style="margin-top: -1em;">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="col-xs-3">
                                                        <div class="col-xs-12 pull-left">
                                                            <span class="photo pull-left" style="margin: 1em;"><img alt="avatar" src="images/JPT1.png"></span>
                                                        </div>
                                                    </td>
                                                    <td class="col-xs-6" style="text-align: center;">
                                                        <div class="col-xs-12">
                                                            <p>
                                                                <b>
                                                                    <span style="font-size: 2em;"><?php echo "JP Travels & Speed Parcel Service"; ?><br></span>
                                                                    <?php echo $fromPlace . '<br>' . (str_replace("\r\n", "<br>", $fromAddress)); ?>
                                                                </b>
                                                            </p></br>
                                                        </div>
                                                    </td>
                                                    <td class="col-xs-3">&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive" style="margin-top: -1em;">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="col-sm-6 b-r">
                                                        <b>Inv.No: </b><?php echo $invoiceNumber; ?></br>
                                                    </td>
                                                    <td class="col-sm-6 b-r">
                                                        <b>Date: </b><?php echo $curDate; ?></br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-sm-6 b-r">
                                                        <!-- <b>From: </b><?php echo $customerName . '<br>' . $mobile; ?></br> -->
                                                        <b>From: </b><?php echo $customerName; ?></br>
                                                    </td>
                                                    <td class="col-sm-6 b-r">
                                                        <!-- <b>To: </b><?php echo $deliveryTo . '<br>' . $deliveryMobile; ?></br> -->
                                                        <b>To: </b><?php echo $deliveryTo; ?></br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-sm-6 b-r">
                                                        <b>Payment: </b><?php echo $paymentType; ?></br>
                                                    </td>
                                                    <td class="col-sm-6 b-r">
                                                        <b>Branch Ph No: </b><?php echo $branchPhNo; ?></br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-sm-6 b-r">
                                                        <b>Quantity: </b><?php echo $quantity; ?></br>
                                                    </td>
                                                    <td class="col-sm-6 b-r">
                                                        <b>App.Val: </b><?php echo $goodsValue; ?></br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-sm-6 b-r">
                                                        <b>Total: </b><?php echo $transportationCost; ?></br>
                                                    </td>
                                                    <td class="col-sm-6 b-r">
                                                        &nbsp;
                                                    </td>
                                                    <!-- <td class="col-sm-6 b-r">
                                                        <b>Add.Cost: </b><?php echo $additionalCost; ?></br>
                                                    </td> -->
                                                </tr>
                                                <tr>
                                                    <td class="col-sm-8 b-r">
                                                        <b>Delivery Branch: </b> <br>
                                                        <?php echo $toPlace . "<br>" . $toAddress; ?></br>
                                                    </td>
                                                    <td class="col-sm-8 b-r">&nbsp;</td>
                                                </tr><!--  END OF 2ST ROW -->
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- <br><br>
                                    <br>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td style="font-size: 0.7em;">
                                                    E&O.E
                                                </td>
                                                <td style="text-align: center; font-size: 0.7em;">
                                                    This Is Computer Generated Invoice
                                                </td>
                                            </tr>
                                        </table>
                                    </div> -->
                                </div>
                            </section>
                        </div>

                        <!-- Modal -->
                        <div id="email-modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-md">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"><i class="fa fa-envelope" aria-hidden="true"></i> Send Email to Customer</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="mailAttachment.php" method="post" enctype="multipart/form-data">
                                            <div class="row" style="margin: 1em">
                                                <!-- <div class="col-sm-11`">
                                                <div class="form-group">
                                                    <label for="usr">To:</label>
                                                    <input type="email" class="form-control" Placeholder="Enter Your Email" name="to" required />
                                                </div>
                                            </div> -->
                                                <input type="hidden" class="form-control" name="custName" id="custName" value="<?php echo $customerName; ?>" />
                                                <input type="hidden" class="form-control" name="for_detail" value="pi" />

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <!-- <label for="usr">Invoice Number:</label> -->
                                                        <input type="hidden" class="form-control" name="invoiceId" id="invoiceId" value="<?php echo $_GET['invoiceId']; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="usr">To:</label>
                                                        <input type="email" class="form-control" name="to" id="to" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="usr">Cc:</label>
                                                        <textarea class="form-control" rows="3" cols="60" name="cc" id="cc"> </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="usr">Subject:</label>
                                                        <input type="text" class="form-control" placeholder="Enter Your Subject" name="subject" id="subject" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="usr"><i class="fa fa-paperclip"></i> Attachment:</label>
                                                        <input id="file-upload" class="form-control" type="file" name="file" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="usr">Mail Content:</label>
                                                        <textarea class="form-control" placeholder="Enter Your Message" rows="5" cols="60" name="message" id="message"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-success pull-right" name="submit"><i class="fa fa-share-square-o" aria-hidden="true"></i> Send Mail</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
            </section>
        </section>
    </body>

    <script>
        var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];
        var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

        $("#email-modal").on("show.bs.modal", function(e) {
            // var toReceipt = <?php echo "" ?>;
            var ccReceipt = "ram.hamel@gmail.com";
            var subject = "JP Travels - INVOICE COPY";
            var message = "Dear sir,\n\n" +
                "Good Day.. " +
                "\n\nPLEASE FIND THE ATTACHMENT OF INVOICE." +
                "\n\nPlease do feel free to revert for any details/clarification. We will be pleased to give the details." +
                "\n\nLooking forward to receive your valuable order at the earliest." +
                "\n\nThanking you and assuring you our best attention at all time." +
                "\n\nOur GST Details: 33MVVPS1642A1ZA" +
                "\n\n\nThanks & Best Regards," +
                // "\nM.SRINIVAS" +
                "\nJP TRAVELS," + 
                "\n9585099110" +
                "\n9585099112"; 
                /* +
                "\n448-B,SRT Complex," +
                "\nSathy Road,Ganapathy," +
                "\nCoimbatore – 641006." +
                "\nTamil Nadu, \nIndia." +
                "\n\nMOBILE : +91-8124821191." +
                "\nEMAIL : salesbkhydraulics@gmail.com"; */
            $("#subject").val(subject);
            $("#message").val(message);
            // $("#to").val(toReceipt);
            // $("#to").val(toReceipt == 'sample@gmail.com' ? '' : toReceipt);
            // $("#cc").val(ccReceipt);
        });

        function inWords(num) {
            if ((num = num.toString()).length > 9) return 'overflow';
            n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
            if (!n) return;
            var str = '';
            str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
            str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
            str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
            str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
            str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
            return str;
        }

        var updateDetails = function(id) {
            var conform = confirm("Sure to create?");
            if (!conform) {
                return;
            }
            //window.location.href='createPPF.php?id='+id; 

        };

        var sendEmail = function() {
            $.ajax({
                type: 'post',
                url: 'mail.php',
                data: {
                    sendMail: 1,
                    message: $('#print-div').html()
                },
                success: function(response) {
                    alert("Mail Sent Successfully!");
                    //   window.location.href = "viewQuotationPDF.php";
                }
            });
        };

        function CreatePDFfromHTML(custName) {
            var HTML_Width = $(".html-content").width();
            var HTML_Height = $(".html-content").height();
            var top_left_margin = 15;
            var PDF_Width = HTML_Width + (top_left_margin * 2);
            var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
            var canvas_image_width = HTML_Width;
            var canvas_image_height = HTML_Height;

            var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

            html2canvas($(".html-content")[0]).then(function(canvas) {
                var imgData = canvas.toDataURL("image/jpeg", 1.0);
                var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
                pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
                for (var i = 1; i <= totalPDFPages; i++) {
                    pdf.addPage(PDF_Width, PDF_Height);
                    pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height * i) + (top_left_margin * 4), canvas_image_width, canvas_image_height);
                }
                pdf.save(custName + ".pdf");
                $("#email-btn").attr("disabled", false);
            });

        }

        var printDiv = function(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        };

        $(document).ready(function() {
            // $(".fa-bars").click();
            setTimeout(function () {
                printDiv('print-div');
            }, 2000);
        });
    </script>

    </html>
<?php
} //end of isset if
?>