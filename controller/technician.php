<?php
define("TAB_TECHNICIAN", "technician");
define("TAB_STAFF", "staff");
$DB = new mysqli("localhost", "root", "", "team_crm");

$result = "";
if (isset($_POST['fname']) && !empty($_POST['firstname'])) {
    $fname = $_POST['lname'];
    $lname = $_POST['lastname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $branch = $_POST['branch'];
    $address = $_POST['address'];

    $qry = $DB->query("INSERT INTO `" . TAB_TECHNICIAN . "`(`first_name`,`last_name`,`email`,`mobile`,`branch`,`address`)
                 VALUES('$fname','$lname','$email','$mobile','$branch','$address')") or die($DB->error);

    if ($DB->affected_rows > 0) {
        $result = array("status" => "ok", "result" => "Inserted successfully", "last_id" => $DB->insert_id);
    } else {
        $result = array("status" => "no", "result" => "Error occurred while inserting data");
    }
    echo json_encode($result);
}

if (isset($_POST['staff']) && !empty($_POST['staff'])) {
    $result = "";
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $add = $_POST['address'];
    $branch = $_POST['branch'];

    $DB->query("INSERT INTO `" . TAB_STAFF . "`(`first_name`,`last_name`,`mobile`,`email`,`address`,`branch`)
    VALUES('$fname','$lname','$mobile','$email','$add','$branch')");

    if ($DB->affected_rows > 0) {
        $result = array("status" => "ok", "result" => "inserted successfully", "last_id" => $DB->insert_id);
    } else {
        $result = array("status" => "failure", "result" => "please try again");
    }
    echo json_encode($result);
}
?>