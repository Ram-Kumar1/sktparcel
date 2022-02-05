<?php
session_start();
include 'db_connect.php';

date_default_timezone_set('Asia/Kolkata');
$firstDay = date('Y-m-01'); // hard-coded '01' for first day
$lastDay = date('Y-m-t');

$whereSql = "";
$userName = $_SESSION['userName'];
$branchName = $_SESSION['admin'];
if (strtolower($userName) == strtolower('admin')) {
	// Nothing
} else {
	$whereSql = " AND TO_PLACE = '$branchName' ";
}

$bookingCount = 0;
$bookingCountSql = "SELECT COUNT(*) AS CNT FROM booking_details WHERE BOOKING_DATE BETWEEN '$firstDay' AND '$lastDay'";
// $bookingCountSql = "SELECT COUNT(*) AS CNT FROM booking_details WHERE BOOKING_DATE BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()";
if (!empty($whereSql)) {
	$bookingCountSql = $bookingCountSql . $whereSql;
}
if ($result = mysqli_query($conn, $bookingCountSql)) {
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_array($result)) {
			$bookingCount = $row['CNT'];
		}
	}
}

$totalAmount = 0;
$totalAmountSql = "SELECT SUM(TOTAL_AMOUNT) AS TOTAL_AMOUNT FROM booking_details WHERE BOOKING_DATE BETWEEN '$firstDay' AND '$lastDay'";
if (empty($whereSql)) {
	// Nothing
} else {
	$totalAmountSql = $totalAmountSql . $whereSql;
}
// echo $bookingCountSql;
if ($result = mysqli_query($conn, $totalAmountSql)) {
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_array($result)) {
			$totalAmount = $row[0];
		}
	}
}

$shipingDetailsSql = "SELECT BD.BOOKING_ID, BD.CUSTOMER, BD.INVOICE_NUMBER, 
						BD.BOOKING_DATE, BD.FROM_PLACE, BD.TO_PLACE, SD.DRIVER_NAME, SD.DRIVER_MOBILE,
						CASE
							WHEN BD.BOOKING_STAUTS = 0 THEN 'Booked/Ready To Ship'
							WHEN BD.BOOKING_STAUTS = 1 THEN 'Ship Inward'
							WHEN BD.BOOKING_STAUTS = 2 THEN 'Delivered'
						END AS BOOKING_STAUTS 
						FROM booking_details BD, shipoutward_details SD
						WHERE 1 = 1
						AND BOOKING_DATE BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()
						AND BD.BOOKING_ID = SD.BOOKING_ID";
if (strtolower($userName) == 'admin') {
} else {
	$shipingDetailsSql = $shipingDetailsSql . " AND FROM_PLACE = '$branchName' ";
}
$shipingDetailsSql = $shipingDetailsSql . " ORDER BY BOOKING_DATE DESC";
?>
<!DOCTYPE html>

<head>
	<title>JP Travels</title>
	<!--Custom CSS for JPT project-->
	<link rel="stylesheet" href="css/jpt-custom.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js"></script>

	<script src="https://cdn.rawgit.com/mkoryak/floatThead/master/dist/jquery.floatThead.min.js"></script>
	<?php
	include './demo.css';
	?>
	<?php
	include './demo.js';
	?>
</head>
<!--For Dropdown Select-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
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


	.notify-w3ls {
		max-height: 500px !important;
		min-height: 500px !important;
		overflow: auto;
	}

	.cus-tbl {
		/* width: 150% !important; */
		min-height: 20em;
	}

	.spi-0 {
		color: red !important;
	}

	.spi-1 {
		color: red !important;
	}

	.spi-2 {
		color: red !important;
	}

	.spi-3 {
		color: limegreen !important;
	}

	.quo-0 {
		color: red !important;
	}

	.quo-1 {
		color: limegreen !important;
	}

	.table-responsive1 {
		width: 156% !important;
	}

	.min-report {
		width: 100%;
		min-height: 350px !important;
		max-height: 350px !important;
		overflow: auto !important;
	}

	td.color-condition.red {
		color: red !important;
	}

	#report-table>tbody>tr:nth-child(1) {
		color: beige;
	}

	.bal-0 {
		color: limegreen !important;
	}

	.greeenYellow {
		color: #49cd06 !important;
	}

	@media (min-width: 1180px) and (max-width: 1280px) {

		/* CSS that should be displayed if width is equal to or less than 800px goes here */
		.cus-tbl {
			width: 150% !important;
			min-height: 20em;
		}
	}

	@media (min-width: 1081px) and (max-width: 1179px) {

		/* CSS that should be displayed if width is equal to or less than 800px goes here */
		.cus-tbl {
			width: 130% !important;
			min-height: 20em;
		}
	}
</style>

<body>


	<?php include 'header.php'; ?>
	<!--main content start-->

	<section id="main-content">
		<section class="wrapper">
			<!-- //market-->
			<div class="market-updates">
				<div class="col-md-6 market-update-gd" id="quotation-col">
					<div class="market-update-block clr-block-2">
						<div class="col-md-4 market-update-right">
							<i class="fa fa-eye"> </i>
						</div>
						<div class="col-md-8 market-update-left">
							<h4>Booking</h4>
							<h3><?php echo $bookingCount; ?></h3>
							<p>No of parcels <br>booked this month</p>
						</div>
						<div class="clearfix"> </div>
					</div>
				</div>

				<div class="col-md-6 market-update-gd" id="invoice-col">
					<div class="market-update-block clr-block-4">
						<div class="col-md-4 market-update-right">
							<i class="fa fa-inr" aria-hidden="true" style="font-size: 3em; color: aliceblue;">
							</i>
						</div>
						<div class="col-md-8 market-update-left">
							<h4>Amount</h4>
							<h3><?php echo $totalAmount; ?></h3>
							<p>Total Revenue <br>generated this month</p>
						</div>
						<div class="clearfix"> </div>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
			<!-- BOOKING STATUS	-->
			<div class="row" id="accounts-row">
				<div class="panel-body">
					<div class="col-md-12 w3ls-graph">
						<!--agileinfo-grap-->
						<div class="agileinfo-grap">
							<div class="agileits-box">
								<header class="agileits-box-header clearfix">
									<h3>Booking Details</h3>
									<div class="toolbar">

									</div>
								</header>
								<div class="agileits-box-body clearfix">
									<?php
									if ($result = mysqli_query($conn, $shipingDetailsSql)) {
										if (mysqli_num_rows($result) > 0) {
									?>
											<div class="table-responsive" style="max-height: 25em;">
												<table id="data-table" class="table tableFixHead table-striped">
													<thead>
														<tr style="color:#0c1211" ;>
															<th style="color:#0c1211" ;>S.No</th>
															<th style="color:#0c1211" ;>Invoice No</th>
															<th style="color:#0c1211" ;>Date</th>
															<th style="color:#0c1211" ;>Customer Name</th>
															<th style="color:#0c1211" ;>From&nbsp;Branch</th>
															<th style="color:#0c1211" ;>To&nbsp;Branch</th>
															<th style="color:#0c1211" ;>Driver</th>
															<th style="color:#0c1211" ;>Driver&nbsp;Mobile</th>
															<th style="color:#0c1211" ;>Status</th>
														</tr>
													</thead>
													<?php
													$i = 0;
													while ($row = mysqli_fetch_array($result)) {
														$i++;
													?>
														<tbody>
															<tr id="account-id-<?php echo $row['BOOKING_ID']; ?>">
																<td style="color:#0c1211" ;>
																	<?php echo $i; ?>
																</td>
																<td style="color:#0c1211" ; id="custName-<?php echo $row['BOOKING_ID']; ?>">
																	<a data-toggle="modal" class="refNo-info" id="refNo-<?php echo $row['BOOKING_ID']; ?>" href="">
																		<?php echo $row['INVOICE_NUMBER'] ?>
																	</a>
																</td>
																<td style="color:#0c1211" ;><?php echo $row['BOOKING_DATE'] ?></td>
																<td style="color:#0c1211" ;><?php echo $row['CUSTOMER'] ?></td>
																<td style="color:#0c1211" ;><?php echo $row['FROM_PLACE'] ?></td>
																<td style="color:#0c1211" ;><?php echo $row['TO_PLACE'] ?></td>
																<td style="color:#0c1211" ;><?php echo $row['DRIVER_NAME'] ?></td>
																<td style="color:#0c1211" ;><?php echo $row['DRIVER_MOBILE'] ?></td>
																<td style="color:#0c1211" ;><?php echo $row['BOOKING_STAUTS'] ?></td>
															</tr>
														</tbody>
													<?php
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
											</div>
								</div>
							</div>
						</div>
						<!--//agileinfo-grap-->
					</div>
				</div>
			</div>
			<div class="clearfix"> </div>
		</section>
		<!-- footer -->
		<div class="footer">
			<div class="wthree-copyright">
				<p>© JP Travels</a></p>
			</div>
		</div>
		<!-- / footer -->
	</section>
	<!--main content end-->
	</section>

	<script src="ddtf.js"></script>
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
	<!-- morris JavaScript -->
	<script>
		var buildTable = function(sizeArray) {
			var columns = addAllColumnHeaders(sizeArray);
			for (var i = 0; i < sizeArray.length; i++) {
				var row$ = $('<tr/>');
				for (var colIndex = 0; colIndex < columns.length; colIndex++) {
					var cellValue = sizeArray[i][columns[colIndex]];

					if (cellValue == null) {
						cellValue = "";
					}

					row$.append($('<td/>').html(cellValue));
				}
				$("#report-table").append(row$);
			}
		}

		var addAllColumnHeaders = function(sizeArray) {
			var columnSet = [];
			var headerTr$ = $('<tr/>');

			for (var i = 0; i < sizeArray.length; i++) {
				var rowHash = sizeArray[i];
				for (var key in rowHash) {
					if ($.inArray(key, columnSet) == -1) {
						columnSet.push(key);
						headerTr$.append($('<th/>').html(key));
					}
				}
			}

			$("#report-table").append(headerTr$);
			return columnSet;
		};

		$(document).ready(function() {
			let userType = <?php echo "'" . $_SESSION['admin'] . "'"; ?>;
			console.log('userType: ' + userType);
			let userName = <?php echo "'" . $_SESSION['admin'] . "'"; ?>;

			$("#data-table").ddTableFilter();
			$('select').addClass('w3-select');
			$('select').select2();

			$('.refNo-info').click(function() {
				var id = this.id;
				var splitid = id.split('-');
				var samplePiId = splitid[1];
				// AJAX request
				$.ajax({
					url: 'account_transaction.php',
					type: 'post',
					data: {
						samplePiId: samplePiId
					},
					success: function(response) {
						// Add response in Modal body
						$("#modal-title").html('');
						$("#report-table tr").detach();
						let res = JSON.parse(response);
						console.log(res[1]);
						res = res[0][0];
						$("#modal-title-refNo").html(res["REFERENCE_NO"]);

						$("#customer-name").val(res["CUSTOMER_NAME"]);
						$("#customer-mobile").val(res["MOBILE"]);
						$("#customer-date").val(res["DATE"]);
						$("#customer-productAmount").val(res["PRODUCT_AMOUNT"]);
						$("#customer-gstAmount").val(res["GST_AMOUNT"]);
						$("#customer-total").val(res["TOTAL_AMOUNT"]);
						$("#customer-advance").val(res["ADVANCE"]);
						$("#customer-balance").val(res["BALANCE"]);

						// Display Modal
						$('#refNo-modal').modal('show');
					}
				});
			});

			$('.transaction-info').click(function() {
				var id = this.id;
				var splitid = id.split('-');
				var userid = splitid[1];

				// AJAX request
				$.ajax({
					url: 'account_transaction.php',
					type: 'post',
					data: {
						userid: userid
					},
					success: function(response) {
						// Add response in Modal body
						$("#modal-title").html('');
						$("#report-table tr").detach();
						let res = JSON.parse(response);
						$("#modal-title").html($("#custName-" + res[1]).text());
						console.log(res[1]);
						buildTable(res[0]);

						// Display Modal
						$('#myModal').modal('show');
					}
				});
			});

			$('.color-condition').each(function() {
				var $this = $(this);
				var value = $this.text().trim();
				if (value == "Pending") {
					$(this).children().removeClass("fa-check").addClass("fa-times");
					$this.addClass('red');
				} else {

				}
				console.log(value);
			});


			//BOX BUTTON SHOW AND CLOSE
			jQuery('.small-graph-box').hover(function() {
				jQuery(this).find('.box-button').fadeIn('fast');
			}, function() {
				jQuery(this).find('.box-button').fadeOut('fast');
			});
			jQuery('.small-graph-box .box-close').click(function() {
				jQuery(this).closest('.small-graph-box').fadeOut(200);
				return false;
			});

			//CHARTS
			function gd(year, day, month) {
				return new Date(year, month - 1, day).getTime();
			}

			graphArea2 = Morris.Area({
				element: 'hero-area',
				padding: 10,
				behaveLikeLine: true,
				gridEnabled: false,
				gridLineColor: '#dddddd',
				axes: true,
				resize: true,
				smooth: true,
				pointSize: 0,
				lineWidth: 0,
				fillOpacity: 0.85,
				data: [{
						period: '2015 Q1',
						iphone: 2668,
						ipad: null,
						itouch: 2649
					},
					{
						period: '2015 Q2',
						iphone: 15780,
						ipad: 13799,
						itouch: 12051
					},
					{
						period: '2015 Q3',
						iphone: 12920,
						ipad: 10975,
						itouch: 9910
					},
					{
						period: '2015 Q4',
						iphone: 8770,
						ipad: 6600,
						itouch: 6695
					},
					{
						period: '2016 Q1',
						iphone: 10820,
						ipad: 10924,
						itouch: 12300
					},
					{
						period: '2016 Q2',
						iphone: 9680,
						ipad: 9010,
						itouch: 7891
					},
					{
						period: '2016 Q3',
						iphone: 4830,
						ipad: 3805,
						itouch: 1598
					},
					{
						period: '2016 Q4',
						iphone: 15083,
						ipad: 8977,
						itouch: 5185
					},
					{
						period: '2017 Q1',
						iphone: 10697,
						ipad: 4470,
						itouch: 2038
					},

				],
				lineColors: ['#eb6f6f', '#926383', '#eb6f6f'],
				xkey: 'period',
				redraw: true,
				ykeys: ['iphone', 'ipad', 'itouch'],
				labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
				pointSize: 2,
				hideHover: 'auto',
				resize: true
			});
		});
	</script>
	<!-- calendar -->
	<script type="text/javascript" src="js/monthly.js"></script>
	<script type="text/javascript">
		var deleteQuotation = function(span) {
			if ($(span).hasClass("quo-0")) {
				return false;
			} else {
				console.log("quotationId: ", span);
				$.ajax({
					type: 'post',
					url: 'index_backend.php',
					data: {
						quotationId: $(span).attr("data-quoId")
					},
					success: function(response) {
						$("#quotation-" + $(span).attr("data-quoId")).hide();
					}
				});
			}

		};

		$(window).load(function() {
			// var $table = $('table.max-10');
			// $table.floatThead();

			$('#mycalendar').monthly({
				mode: 'event',

			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

			switch (window.location.protocol) {
				case 'http:':
				case 'https:':
					// running on a server, should be good.
					break;
				case 'file:':
					alert('Just a heads-up, events will not work when run locally.');
			}

		});
	</script>
	<!-- //calendar -->
</body>

</html>