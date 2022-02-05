<?php
$db_host = 'sg2plzcpnl487147.prod.sin2.secureserver.net';
$db_user = 'jp_remote_db_user';
$db_pass = 'JpParcel@2021';
$db_name = 'jpparcel';

/*$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'jptravels';*/
try {
//    echo "initializing conn";
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
} catch (Exception $exception) {
    echo $exception;
}
?>