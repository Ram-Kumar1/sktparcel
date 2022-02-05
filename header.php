<?php

if (!empty($_SESSION['userName'])) {
    // Nothing
} else {
    ?>
    <script>
        alert("You had been logged out!\n Kindly re-login again :)")
        window.location.replace("admin_login.php");
    </script>
    <?php
}
?>

<section id="container">
    <!--header start-->
    <header class="header fixed-top clearfix">
        <!--logo start-->
        <div class="brand">
            <a href="index.php" class="logo" style="margin-left: 35%;">
                JP 🚐
            </a>
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars"></div>
            </div>
        </div>
        <!--logo end-->
        <div class="nav notify-row" id="top_menu">

        </div>
        <div class="top-nav clearfix">
            <!--search & user info start-->
            <ul id="logout-lst" class="nav pull-right top-menu">
                <!-- user login dropdown start-->
                <li class="dropdown for-marketing">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
<!--                        <img style="margin: 4px;" alt="" src="images/JPT.png">-->
                        <img style="margin: 4px;" alt="" src="http://jpparcel.com/images/JPT.PNG">
                        <span id="user-type" class="username">&nbsp;</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <li id="change-password"
                            ><a href="changePassword.php">
                                <i class="fa fa-unlock-alt"></i> Change Password</a>
                            </li>
                        <li class="for-marketing"><a href="logout.php">
                            <i class="fa fa-key"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
                <!-- user login dropdown end -->
            </ul>
            <!--search & user info end-->
        </div>
        </div>
    </header>
    <!--header end-->
    <!--sidebar start-->
    <aside>
        <div id="sidebar" class="nav-collapse" style="display: none;">
            <!-- sidebar menu start-->
            <div class="leftside-navigation">
                <ul class="sidebar-menu" id="nav-accordion">
                    <li class="sub-menu for-marketing" id="admin-list">
                        <a href="javascript:;">
                            <i class="fa fa-user-plus"></i>
                            <span>Admin</span>
                        </a>
                        <ul class="sub">
                            <li class="sub-menu">
                                <a href="javascript:;">
                                    <i class="fa fa-bullhorn"></i>
                                    <span>Office Setup</span>
                                </a>
                                <ul class="sub">
                                    <li><a href="placeEntry.php">Place</a></li>
                                    <li><a href="branchOffice.php">Branch Office</a></li>
                                    <li><a href="branchOfficeView.php">Branch Office View</a></li>
                                    <li><a href="addDriver.php">Add Driver</a></li>
                                    <li><a href="driverView.php">Driver View</a></li>
                                </ul>
                            </li>
                            <!-- sales setup -->
                            <li class="sub-menu">
                                <a href="javascript:;">
                                    <i class="fa fa-bullhorn"></i>
                                    <span>Sales Setup</span>
                                </a>
                                <ul class="sub">
                                    <li><a href="addCustomer.php">Add Customer</a></li>
                                    <!--<li><a href="billing_address.php">Billing Address</a></li>
                                    <li><a href="gst.php">GST</a></li>
                                    <li><a href="hsn.php">HSN</a></li>
                                    <li><a href="terms_condition.php?for=1">Terms and Conditions</a></li>-->
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="sub-menu for-marketing" id="production-list">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Booking</span>
                        </a>
                        <ul class="sub">
                            <!-- <li><a href="productionTeam_SPI.php">PPI</a></li>
                                <li><a href="production_flow.php">Daily Process</a></li>
                                <li><a href="machineStock.php">Machine Stock</a></li>
                                <li class="for-marketing"><a href="currentSteelStock.php">Current Steel Status</a></li>
                                <li><a href="steelStockReport.php">CSS Report</a></li>
                                 -->
                            <!-- <li><a href="productionTeam_SPI.php">PPI</a></li> -->
                            <li><a href="newBooking.php">New Booking</a></li>
                            <li><a href="viewBookingList.php">Booking List</a></li>
                            <li><a href="createShipOutward.php">Create Ship Outward</a></li>
                            <li><a href="viewShipOutward.php">View Ship Outward</a></li>
                            <li><a href="shipInward.php">Ship Inward</a></li>
                            <li><a href="production_Flow_report.php">Report</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->
</section>
<script type="text/javascript">
    $(document).ready(function () {
        $(".fa-bars").click();
        let userType = <?php echo "'" . $_SESSION['admin'] . "'"; ?>;
        console.log('userType: ' + userType);
        let userName = <?php echo "'" . $_SESSION['userName'] . "'"; ?>;
        $('#user-type').text(userName.toString().toUpperCase());
        if (userName == "admin") {
            $("#admin-list").show();
            $("#production-list").show();
        } else {
            $("#admin-list").hide();
            $("#production-list").show();
        }
        $("#sidebar").show();
    });
</script>