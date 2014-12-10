<?php
/**
 * Created by Rafique
 * Date: 9/19/14
 * Time: 5:13 PM
 */

function generateTicketID($type, $cust_id)
{

    return substr(strtoupper($type), 0, 3) . "-" . $cust_id . "-" . time();
}

function check($array)
{
    if (is_array($array)) {

        for ($i = 0; $i < count($array); $i++) {
            if (empty($array[$i])) {
                return false;
            }
        }
        return true;
    } else {
        return false;
    }
}

function sendSMSNotifictaion($ticket_id, $cust_id)
{
    $phone = getMobileNumber($cust_id);
    if ($phone != 0) {
        //sendSMS

        return true;
    } else {
        return false;
    }
}

function getMobileNumber($cust_id)
{
    global $DB;
    $qry = $DB->query("SELECT `mobile` FROM `" . TAB_CUSTOMER . "` WHERE `cust_id`='$cust_id'");

    if ($qry->num_rows > 0) {
        $phn = $qry->fetch_assoc();
        return $phn['mobile'];
    } else {
        return 0;
    }
}