<?php
require_once("common.php");

$app->get("/LinkedAccount/:cid", function ($cid) use ($app) {
    global $DB;
    $result = array();
    $qry = $DB->query("SELECT `organisation`,`mobile`,`first_name`,`last_name`,`account_type` FROM `" . TAB_CUSTOMER . "` WHERE `cust_id` = '$cid' ") or ThrowError($DB->error);

    if ($qry->num_rows > 0) {
        $cust_data = $qry->fetch_assoc();
        if ($cust_data['account_type'] == 'c') {
            $search_qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER . "`
WHERE `cust_id`<>'$cid' AND (`organisation` LIKE '%{$cust_data['organisation']}%' OR `mobile` = '{$cust_data['mobile']}'
OR (`first_name` LIKE '%{$cust_data['first_name']}%' AND `last_name` LIKE '%{$cust_data['last_name']}%')) ") or ThrowError($DB->error);
        } else {
            $search_qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER . "`
WHERE `cust_id`<>'$cid' AND (`mobile` = '{$cust_data['mobile']}'
OR (`first_name` LIKE '%{$cust_data['first_name']}%' AND `last_name` LIKE '%{$cust_data['last_name']}%'))") or ThrowError($DB->error . " 2");
        }
        if ($search_qry->num_rows > 0) {
            $result["status"] = "ok";
            while ($info = $search_qry->fetch_assoc()) {
                $result["data"][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No Possible Account Found");
        }


    } else {
        $result = array("status" => "no", "result" => "Invalid Customer");
    }

    $app->response->body(json_encode($result));
});
