<?php
define("DB_HOST", "localhost");
define("DB_USER", "root"); //teamone_user
define("DB_PASS", ""); //crm2014
define("DB_NAME", "team_crm"); //teamone_crm

define("TAB_CUSTOMER", "customer");
define("TAB_TECHNICIAN", "technician");
define("TAB_STAFF", "staff");
define("TAB_BRANCH", "branch");

define("TAB_INSTALL", "installation");
define("TAB_COMPLAINT", "complaint");
define("TAB_AMC", "amc");
define("TAB_ASSIGN", "assignment");
define("TAB_AMC_SERVICE", "amc_service_date");
define("TAB_OTS", "one_time_service");

define("TAB_AC_MAKE", "ac_make");
define("TAB_AC_TYPE", "ac_type");
define("TAB_AC_LOCATION", "ac_location");
define("TAB_CUSTOMER_AC", "customer_ac_details");
define("TAB_AC_TONNAGE", "ac_tonnage");
define("TAB_REFERRED_BY", "referred_by");
define("TAB_PROBLEM_TYPE", "problem_type");


define("TAB_LOCALITY", "locality");

define("SUB_FOLDER", "/team_one/"); // /

define("ROOT_DIR", $_SERVER["DOCUMENT_ROOT"]);
define("INC_DIR", ROOT_DIR . SUB_FOLDER . "include/");
define("VIEW_DIR", ROOT_DIR . SUB_FOLDER . "view/");
define("CONTROLLER_DIR", ROOT_DIR . SUB_FOLDER . "controller/");
define("ASSETS_DIR", ROOT_DIR . SUB_FOLDER . "assets/");
define("IMAGES_DIR", ROOT_DIR . SUB_FOLDER . "assets/images/");

define("SLIM_DIR", ROOT_DIR . SUB_FOLDER . "libs/Slim/");

require_once(CONTROLLER_DIR . "main.php");
require_once(INC_DIR."functions.php");
$DB = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Error on launching database connection");