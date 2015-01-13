<?php
session_start();
ob_start();
date_default_timezone_set("Asia/Kolkata");
require_once("include/config.php");
require_once("controller/class.staff.php");
$staff = new controller\staff\Staff($DB);

$staff->mustLogin();

$staffInfo = $staff->getSessionStaff();

