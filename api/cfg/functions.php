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

function NotifySMS($assign_id)
{
    $res=array();
    $error=0;
    global $DB;
    if($assign_id==""){
        $res['success']=false;
        $res['result'][]="Assign ID is empty";
        return $res;
    }else{

        $qry=$DB->query("SELECT `assign_for`,`cust_id`,`assign_date` FROM `".TAB_ASSIGN."` WHERE `assign_id`='$assign_id'");

        if($qry->num_rows>0){
            $assign=$qry->fetch_assoc();
            $tech_id=$assign['assign_for'];
            $cust_id=$assign['cust_id'];
            $assign_date=$assign['assign_date'];

            $cust_qry=$DB->query("SELECT `first_name`,`last_name`,`mobile`,`address`,`landmark`,`location` FROM `".TAB_CUSTOMER."` WHERE `cust_id`='$cust_id' ");
            if($cust_qry->num_rows==1){
                $data=$cust_qry->fetch_assoc();
            }else{
                $res['success']=false;
                $res['result'][]="Invalid customer ID ";
                return $res;
            }

            $tech_qry=$DB->query("SELECT `first_name`,`last_name`,`mobile` FROM `".TAB_TECHNICIAN."` WHERE `tech_id`='$tech_id' ");
            if($tech_qry->num_rows==1){
                $tech_data=$tech_qry->fetch_assoc();
            }else{
                $res['success']=false;
                $res['result'][]="Invalid Technician";
                return $res;
            }
        }else{
            $res['success']=false;
            $res['result'][]="No Assignment found";
            return $res;
        }
    }


    $tech_phone = $tech_data['mobile'];
    $cust_phone = $data['mobile'];
    if ($tech_phone !=""&&$tech_phone!=0&&!count($tech_phone)<10) {
        //sendSMS

            $to=str_ireplace(array("+91"," ","-"),"",$tech_phone);
            $msg="SERVICE CALL :
            Person Name : {FULLNAME} Mobile : {PHONE} Location : {LOCATION} Address : {ADDRESS} Landmark : {LANDMARK} ON : {DATE_TIME}";

            $msg=str_ireplace("{FULLNAME}",$data['first_name']." ".$data['last_name'],$msg);
            $msg=str_ireplace("{PHONE}",$data['mobile'],$msg);
            $msg=str_ireplace("{DATE_TIME}",date("d-m-Y",strtotime($assign_date)),$msg);
            $msg=str_ireplace("{ADDRESS}",$data['address'],$msg);
            $msg=str_ireplace("{LANDMARK}",$data['landmark'],$msg);
            $msg=str_ireplace("{LOCATION}",$data['location'],$msg);
            $msg=urlencode($msg);

            $url="http://slogin.ovmedia.in/API/WebSMS/Http/v1.0a/index.php?username=teamone&password=12345&sender=TEAMAC&to=$to&message=$msg&reqid=1&format=json&route_id=22";

            $curl=curl_init($url);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
            curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,20);

            $result=curl_exec($curl);

            $response=json_decode($result,true);
            if(isset($response['msg_id'])&&!empty($response['msg_id'])){

            }else{
                $error++;
                $res['result'][]="SMS failed to send to the Technician";
            }


    } else {
        $error++;
        $res['result'][]="Invalid Technician Mobile Number";
    }

    if ($cust_phone !=""&&$cust_phone!=0&&!count($cust_phone)<10) {
        //sendSMS

            $to=str_ireplace(array("+91"," ","-"),"",$cust_phone);
            $msg="Your AC service call assigned to {TECH_NAME} ({MOBILE}) and he will attend the same in next 48 hours. Thank You.";

            $msg=str_ireplace("{TECH_NAME}",$tech_data['first_name']." ".$tech_data['last_name'],$msg);
            $msg=str_ireplace("{MOBILE}",$tech_data['mobile'],$msg);
            $msg=urlencode($msg);

            $url="http://slogin.ovmedia.in/API/WebSMS/Http/v1.0a/index.php?username=teamone&password=12345&sender=TEAMAC&to=$to&message=$msg&reqid=1&format=json&route_id=22";

            $curl=curl_init($url);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
            curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,20);

            $result=curl_exec($curl);

            $response=json_decode($result,true);
            if(isset($response['msg_id'])&&!empty($response['msg_id'])){

            }else{
                $res['result'][]="SMS failed to send to the Customer";
                $error++;
            }


    } else {
        $res['result'][]="Invalid Technician Mobile Number";
        $error++;
    }


if($error==0){
    $res['success']=true;
    return $res;
}else{
    $res['success']=false;
    $res['result'][]="Invalid Technician Mobile Number";
    return $res;
}

}


function getMobileNumber($id,$ofCustomer=true)
{
    if($ofCustomer){
        //customer
        global $DB;
        $qry = $DB->query("SELECT `mobile` FROM `" . TAB_CUSTOMER . "` WHERE `cust_id`='$id'");

        if ($qry->num_rows > 0) {
            $phn = $qry->fetch_assoc();
            return $phn['mobile'];
        } else {
            return 0;
        }
    }else{
        //technician
        global $DB;
        $qry = $DB->query("SELECT `mobile` FROM `" . TAB_TECHNICIAN . "` WHERE `tech_id`='$id'");

        if ($qry->num_rows > 0) {
            $phn = $qry->fetch_assoc();
            return $phn['mobile'];
        } else {
            return 0;
        }
    }

}