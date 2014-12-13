<?php
require_once("common.php");

$app->get("/Search/:str", function ($str) use ($app) {
    global $DB;
    $check = trim(str_replace(array(" ", "-", "+"), "", $str));
    $result=array();
    if (is_numeric($check)) {


        $qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER . "` WHERE `mobile` LIKE '%$check%' "); //OR `alternate_mobile` LIKE '%$str%'

        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $result["data"][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No customer found. Try something else..");
        }


    } else if (preg_match("/place/", $str)) {
        $str=trim(str_replace(array("place"),"",$str));
        $qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER . "` WHERE `location` LIKE '%$str%' "); //OR `alternate_mobile` LIKE '%$str%'

        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $result["data"][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No customer found. Try something else..");
        }
        //$result = array("status" => "ok", "result" => "place search".$str);
    } else if (preg_match("/company/", $str)) {
        $str=trim(str_replace(array("company"),"",$str));
        $qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER . "` WHERE `organisation` LIKE '%$str%' ") or ThrowError($DB->error); //OR `alternate_mobile` LIKE '%$str%'

        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $result["data"][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No customer found. Try something else..");
        }
        //$result = array("status" => "ok", "result" => "company search");
    } else if (preg_match("/name/", $str)) {
        $str=trim(str_replace(array("name"),"",$str));
        $names = explode(" ",$str);
        if(count($names)==2){
            $firstname = $names[0];
            $lastname = $names[1];
            $qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER . "` WHERE (`first_name` LIKE '%$firstname%' or `last_name` LIKE '%$lastname%') ") or ThrowError($DB->error);
            if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $result["data"][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No customer found. Try something else..");
        }
        }else if(count($names)==1){
            $firstname = $lastname = $names[0];
            $qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER . "` WHERE (`first_name` LIKE '%$firstname%' or `last_name` LIKE '%$lastname%') ") or ThrowError($DB->error);
            if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $result["data"][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No customer found. Try something else..");
        }
        }else{
            ThrowError("Please enter a valid name");
        }
         //OR `alternate_mobile` LIKE '%$str%'
        //$result = array("status" => "ok", "result" => "name search");
    } else {

        $qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER . "` WHERE `mobile` LIKE '%$check%' ") or ThrowError($DB->error); //OR `alternate_mobile` LIKE '%$str%'

        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $result["data"][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No customer found. Try something else..");
        }


    }
    $app->response->body(json_encode($result));
});
