<?php
/**
 * Created by Rafique
 * Date: 8/20/14
 * Time: 12:34 PM
 */
require_once("common.php");

/** ***********CUSTOMER ********* */

$app->get("/Assign/Customer", function () use ($app) {
    global $DB;
    $result = array();
    $cust_qry = $DB->query("SELECT `cust_id` as user FROM `" . TAB_CUSTOMER . "`") or ThrowError($DB->error);
    if ($cust_qry->num_rows > 0) {
        $data = array();
        $till = date("Y-m-d", strtotime("+1 month"));
        $cust_holder = array();
        while ($inf = $cust_qry->fetch_assoc()) {
            $isUnAssigned = false;

            $qry = $DB->query("SELECT * FROM `" . TAB_COMPLAINT . "` WHERE `cust_id`={$inf['user']}") or ThrowError($DB->error);
            if ($qry->num_rows > 0) {
                while ($tmp_com = $qry->fetch_assoc()) {

                    $com_qry = $DB->query("SELECT * FROM `" . TAB_ASSIGN . "` as assign WHERE assign.type_id='{$tmp_com['com_id']}' AND assign.type='complaint'") or ThrowError($DB->error);
                    if ($com_qry->num_rows == 0) {
                        $cust_holder[] = $inf['user'];
                        break;
                    }
                }
                continue;
            }

            $qry = $DB->query("SELECT * FROM `" . TAB_OTS . "` WHERE `cust_id`={$inf['user']}") or ThrowError($DB->error);
            if ($qry->num_rows > 0) {
                while ($tmp_com = $qry->fetch_assoc()) {
                    $ots_qry = $DB->query("SELECT * FROM `" . TAB_ASSIGN . "` as assign WHERE assign.type_id={$tmp_com['ots_id']} AND assign.type='ots'") or ThrowError($DB->error);
                    if ($ots_qry->num_rows == 0) {
                        $cust_holder[] = $inf['user'];
                        break;
                    }
                }
                continue;
            }

            $qry = $DB->query("SELECT * FROM `" . TAB_INSTALL_SERVICE . "` WHERE `cust_id`='{$inf['user']}' AND `date`<='$till'") or ThrowError($DB->error);
            if ($qry->num_rows > 0) {
                $e = 0;
                while ($info = $qry->fetch_assoc()) {
                    $ins_qry = $DB->query("SELECT * FROM `" . TAB_ASSIGN . "` as assign
                     WHERE assign.type_id='{$info['install_service_id']}' AND (assign.type='installation' OR assign.type='ins_service')
                       ") or ThrowError($DB->error);
                    if ($ins_qry->num_rows < 1) {
                        $cust_holder[] = $inf['user'];
                        break;
                    }
                }
                if ($e > 0) {
                    //$cust_holder[]=$inf['user'];
                    //continue;
                }
                continue;
            }

            $qry = $DB->query("SELECT * FROM `" . TAB_AMC_SERVICE . "` WHERE `cust_id`='{$inf['user']}'  AND `date`<='$till'") or ThrowError($DB->error);
            if ($qry->num_rows > 0) {
                $e = 0;
                while ($info = $qry->fetch_assoc()) {
                    $amc_qry = $DB->query("SELECT * FROM  `" . TAB_ASSIGN . "` as assign WHERE
                     assign.type_id='{$info['amc_service_id']}' AND assign.type='amc' ") or ThrowError($DB->error);
                    if ($amc_qry->num_rows < 1) {
                        $cust_holder[] = $inf['user'];
                        break;
                    }
                }
                continue;

            }


        }
        if (count($cust_holder) > 0) {

            foreach ($cust_holder as $c_id) {
                $qry = $DB->query("SELECT `cust_id`,account_type,first_name,last_name,email,organisation,mobile,
                address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "`  WHERE `cust_id`='$c_id'
                 ") or ThrowError($DB->error);

                $data[] = $qry->fetch_assoc();
            }

            $result['status'] = "ok";
            $result['result'] = "Successful $till";
            $result['data'] = $data;

        } else {
            $result['status'] = "no";
            $result['result'] = "No data Found $till";
        }

    } else {
        $result['status'] = "no";
        $result['result'] = "No user Found";
    }

    $app->response->body(json_encode($result));

});

$app->get("/Assign/Customer/:id", function ($cust_id) use ($app) {
    global $DB;
    $till = $app->request->get("till_date", date("Y-m-d", strtotime("+1 month")));

    $result = array();
    $result['status'] = "ok";


    $qry = $DB->query("SELECT `cust_id`,`account_type`,`first_name`,`last_name`,`email`,`organisation`,`location`,`mode_of_contact`,`alternate_mobile` FROM `" . TAB_CUSTOMER . "` WHERE `cust_id`='$cust_id'");
    if ($qry->num_rows > 0) {
        while ($info = $qry->fetch_assoc()) {
            $result['data']['customer_info'] = $info;
            $result['data']['customer_info']['empty'] = false;
        }
    } else {
        $result['data']['customer_info']['empty'] = true;
        $result['data']['customer_info']['result'] = "No Customer Found";
    }


    $amc_qry = $DB->query("SELECT * FROM `" . TAB_AMC . "` WHERE `cust_id`='$cust_id' ");

    if ($amc_qry->num_rows > 0) {
        $c = $d = 0; //$c - total data , $d-total data with service date matched if $d is 0 then thr is no data
        while ($info = $amc_qry->fetch_assoc()) {

            $service_qry = $DB->query("SELECT * FROM `" . TAB_AMC_SERVICE . "` WHERE `amc_id`='{$info['amc_id']}'
AND `date` < '$till' AND `amc_service_id` NOT IN (SELECT `type_id` FROM `" . TAB_ASSIGN . "` WHERE `type`='amc')  AND `date`<='DATEADD(NOW(), INTERVAL +1 MONTH)'") or ThrowError($DB->error);

            if ($service_qry->num_rows > 0) {
                $service_info["service_info"] = array();
                while ($get = $service_qry->fetch_assoc()) {
                    $get["date"] = ConvertToIST($get["date"]);
                    $service_info["service_info"][] = $get;
                }
                $ac_qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND cust_ac.`ac_id`='{$info['ac_id']}'");
                $info['created_on'] = ConvertToIST($info['created_on']);
                $info['activation'] = ConvertToIST($info['activation']);
                $info['expiration'] = ConvertToIST($info['expiration']);
                $info['amc_remarks'] = $info["remarks"];
                unset($info["remarks"]);
                $ac_info_tmp = array();
                if ($ac_qry->num_rows > 0) {

                    $ac_info = $ac_qry->fetch_assoc();
                    $d = $d + 1;
                    $ac_info_tmp = array_merge($info, $ac_info);
                }
                $info = array_merge($ac_info_tmp, $service_info);
                $result['data']['amc'][] = $info;

            } else {
                $c = $c + 1;

            }

        }

        if ($d == 0) {
            $result['data']['amc']['empty'] = true;
            $result['data']['amc']['result'] = "No AMC Found";
        } else {
            $result['data']['amc']['empty'] = false;
        }
    } else {
        $result['data']['amc']['empty'] = true;
        $result['data']['amc']['result'] = "No AMC Found ";

    }

    $qry = $DB->query("SELECT * FROM `" . TAB_OTS . "` WHERE `cust_id`='$cust_id' AND `preferred_date` < '$till'
    and `ots_id` NOT IN (SELECT `type_id` FROM `" . TAB_ASSIGN . "` WHERE `type`='ots') ");

    if ($qry->num_rows > 0) {
        while ($info = $qry->fetch_assoc()) {

            $ac_qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND cust_ac.`ac_id`='{$info['ac_id']}'");

            $info['created_on'] = ConvertToIST($info['created_on']);
            $info['preferred_date'] = ConvertToIST($info['preferred_date']);
            if ($ac_qry->num_rows > 0) {
                $ac_info = $ac_qry->fetch_assoc();
                $info = array_merge($info, $ac_info);
            }

            $result['data']['ots'][] = $info;
            $result['data']['ots']['empty'] = false;
        }
    } else {
        $result['data']['ots']['empty'] = true;
        $result['data']['ots']['result'] = "No One TimeService Found";

    }

    /************** INSTALL INNER QUERY **********/


    $install_qry = $DB->query("SELECT * FROM `" . TAB_INSTALL . "` WHERE `cust_id`='$cust_id' ");

    if ($install_qry->num_rows > 0) {
        $d = 0; //$c - total data , $d-total data with service date matched if $d is 0 then thr is no data
        while ($info = $install_qry->fetch_assoc()) {

            $ins_serv_qry = $DB->query("SELECT * FROM `" . TAB_INSTALL_SERVICE . "` WHERE `install_id`='{$info['install_id']}' AND `date`<='$till'") or ThrowError($DB->error);
            if ($ins_serv_qry->num_rows > 0) {

                $service_info["service_info"] = array();
                while ($ins_serv_info = $ins_serv_qry->fetch_assoc()) {
                    $ins_qry = $DB->query("SELECT * FROM `" . TAB_ASSIGN . "` as assign
                     WHERE assign.type_id='{$ins_serv_info['install_service_id']}' AND (assign.type='installation' OR assign.type='ins_service')
                       ") or ThrowError($DB->error);
                    if ($ins_qry->num_rows < 1) {

                        $ins_serv_info["date"] = ConvertToIST($ins_serv_info["date"]);
                        $service_info["service_info"][] = $ins_serv_info;
                        $d++;
                    }
                }

                $ac_qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND cust_ac.`ac_id`='{$info['ac_id']}'");

                $info['created_on'] = ConvertToIST($info['created_on']);
                $info['install_remarks'] = $info["remarks"];
                unset($info["remarks"]);
                $ac_info_tmp = array();
                if ($ac_qry->num_rows > 0) {

                    $ac_info = $ac_qry->fetch_assoc();
                    $d = $d + 1;
                    $ac_info_tmp = array_merge($info, $ac_info);
                }
                $info = array_merge($ac_info_tmp, $service_info);
                $result['data']['installations'][] = $info;

            }

         /*   if ($assign_ins_qry->num_rows == 0) {
                while ($assign_ins_qry_info = $assign_ins_qry->fetch_assoc()) {
                    $service_qry = $DB->query("SELECT * FROM `" . TAB_INSTALL_SERVICE . "` WHERE `install_id`='{$info['install_id']}'
AND `date` < '$till' AND `install_service_id`<>'{$assign_ins_qry_info['type_id']}' ") or ThrowError($DB->error);

                    if ($service_qry->num_rows > 0) {
                        $service_info["service_info"] = array();
                        while ($get = $service_qry->fetch_assoc()) {
                            $get["date"] = ConvertToIST($get["date"]);
                            $service_info["service_info"][] = $get;
                        }
                        $ac_qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND cust_ac.`ac_id`='{$info['ac_id']}'");

                        $info['created_on'] = ConvertToIST($info['created_on']);
                        $info['install_remarks'] = $info["remarks"];
                        unset($info["remarks"]);
                        $ac_info_tmp = array();
                        if ($ac_qry->num_rows > 0) {

                            $ac_info = $ac_qry->fetch_assoc();
                            $d = $d + 1;
                            $ac_info_tmp = array_merge($info, $ac_info);
                        }
                        $info = array_merge($ac_info_tmp, $service_info);
                        $result['data']['installations'][] = $info;

                    }
                }
            }*/


        }

        if ($d == 0) {
            $result['data']['installations']['empty'] = true;
            $result['data']['installations']['result'] = "No Installations Found $d";
        } else {
            $result['data']['installations']['empty'] = false;
        }
    } else {
        $result['data']['installations']['empty'] = true;
        $result['data']['installations']['result'] = "No Installations Found";

    }


    /********** COMPLAINT INNER QUERY ************/

    $qry = $DB->query("SELECT * FROM `" . TAB_COMPLAINT . "` as c INNER JOIN `" . TAB_PROBLEM_TYPE . "`
    as p WHERE c.`cust_id`='$cust_id' AND c.`problem_type`=p.`ac_problem_id`  AND `preferred_date` < '$till' and
    `com_id` NOT IN (SELECT `type_id` FROM `" . TAB_ASSIGN . "` WHERE `type`='complaint')");

    if ($qry->num_rows > 0) {

        while ($info = $qry->fetch_assoc()) {

            $ac_qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc
        WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND cust_ac.`ac_id`='{$info['ac_id']}'");

            $info['created_on'] = ConvertToIST($info['created_on']);
            $info['preferred_date'] = ConvertToIST($info['preferred_date']);

            if ($ac_qry->num_rows > 0) {
                $ac_info = $ac_qry->fetch_assoc();
                $info = array_merge($info, $ac_info);
            }
            $result['data']['complaints'][] = $info;
            $result['data']['complaints']['empty'] = false;
        }
    } else {
        $result['data']['complaints']['empty'] = true;
        $result['data']['complaints']['result'] = "No Complaints Found";

    }


    $app->response->body(json_encode($result));
});


$app->get("/Assign/Customer/:id/AMC", function ($cust_id) use ($app) {
    global $DB;

    $qry = $DB->query("SELECT * FROM `" . TAB_AMC . "` WHERE `cust_id`='$cust_id'");
    $result = array();
    if ($qry->num_rows > 0) {
        $result['status'] = "ok";
        $result['data'] = array();
        while ($info = $qry->fetch_assoc()) {
            $result['data'][] = $info;
        }
    } else {
        $result['status'] = "no";
        $result['result'] = "No Assignment Found";

    }
    $app->response->body(json_encode($result));

});

$app->get("/Assign/Customer/:id/Complaints", function ($cust_id) use ($app) {
    global $DB;

    $qry = $DB->query("SELECT * FROM `" . TAB_COMPLAINT . "` WHERE `cust_id`='$cust_id'");
    $result = array();
    if ($qry->num_rows > 0) {
        $result['status'] = "ok";
        $result['data'] = array();
        while ($info = $qry->fetch_assoc()) {
            $result['data'][] = $info;
        }
    } else {
        $result['status'] = "no";
        $result['result'] = "No Assignment Found";

    }
    $app->response->body(json_encode($result));

});
$app->get("/Assign/Customer/:id/OTS", function ($cust_id) use ($app) {
    global $DB;

    $qry = $DB->query("SELECT * FROM `" . TAB_OTS . "` WHERE `cust_id`='$cust_id'");
    $result = array();
    if ($qry->num_rows > 0) {
        $result['status'] = "ok";
        $result['data'] = array();
        while ($info = $qry->fetch_assoc()) {
            $result['data'][] = $info;
        }
    } else {
        $result['status'] = "no";
        $result['result'] = "No Assignment Found";

    }
    $app->response->body(json_encode($result));

});
$app->get("/Assign/Customer/:id/Installations", function ($cust_id) use ($app) {
    global $DB;

    $qry = $DB->query("SELECT * FROM `" . TAB_INSTALL . "` WHERE `cust_id`='$cust_id'");
    $result = array();
    if ($qry->num_rows > 0) {
        $result['status'] = "ok";
        $result['data'] = array();
        while ($info = $qry->fetch_assoc()) {
            $result['data'][] = $info;
        }
    } else {
        $result['status'] = "no";
        $result['result'] = "No Assignment Found";

    }
    $app->response->body(json_encode($result));

});

/***** Assignment ********/

$app->post("/Assign", function () use ($app) {
    global $DB;

    $type = $app->request->post("type",false);
    $assign_of = $app->request->post("assign_of",false);
    $assign_for = $app->request->post("tech_id",false);
    $assign_date = $app->request->post("assign_date",false);
    $remarks = $app->request->post("assign_remarks","");
    $cust_id = $app->request->post("cust_id",false);
    $ac_id = $app->request->post("ac_id",false);
    $assign_date = ConvertFromIST($assign_date);

    //$type_q = ($type == "ins_service") ? "ins_service" : "installation";
if($type!=false&&$assign_of!=false&&$assign_for!=false&&$assign_date!=false&&$cust_id!=false&&$ac_id!=false&&$assign_date!=false)
{
    $qry = $DB->query("SELECT `ticket_id` FROM `" . TAB_ASSIGN . "` WHERE `type`='$type'
    AND `type_id`='$assign_of' AND `cust_id`='$cust_id' ");
    if ($qry->num_rows > '0') {
        $ticket = "";
        while ($info = $qry->fetch_assoc()) {
            $ticket .= "#" . $info['ticket_id'] . ", ";
        }
        ThrowError("This Ticket is already assigned to a technician. Check Ticket ID : #" . $ticket);
    } else {
        $ticket_id = generateTicketID($type, $cust_id, $assign_of);
        $DB->query("INSERT INTO `" . TAB_ASSIGN . "`(`cust_id`,`ac_id`,`ticket_id`,`type`,`type_id`,`assign_for`,`assign_date`,`remarks`)
                    VALUES('$cust_id','$ac_id','$ticket_id','$type','$assign_of','$assign_for','$assign_date','$remarks')") or ThrowError($DB->error);
        $assign_id = "";
        if ($DB->affected_rows > 0) {
            $assign_id = $DB->insert_id;
            switch ($type) {
                case 'installation':
                    $DB->query("UPDATE `" . TAB_INSTALL . "` SET `preferred_date`='$assign_date' WHERE `install_id`='$assign_of'");
                    break;

                case 'ins_service':
                    $DB->query("UPDATE `" . TAB_INSTALL_SERVICE . "` SET `date`='$assign_date' WHERE `install_service_id`='$assign_of'");
                    break;

                case 'complaint':
                    $DB->query("UPDATE `" . TAB_COMPLAINT . "` SET `preferred_date`='$assign_date' WHERE `com_id`='$assign_of'");
                    break;

                case 'amc':
                    $DB->query("UPDATE `" . TAB_AMC_SERVICE . "` SET `date`='$assign_date' WHERE `amc_service_id`='$assign_of'");
                    break;

                case 'ots':
                    $DB->query("UPDATE `" . TAB_OTS . "` SET `preferred_date`='$assign_date' WHERE `ots_id`='$assign_of'");
                    break;
            }
            /* if ($DB->affected_rows > 0) {
                 $result['status'] = "ok";
                 $result['result'] = "Successfully Added.";
             } else {*/
            $result['status'] = "ok";
            $result['result'] = "Successfully Assigned. Preferred dates unchanged.";
            // }

            $app->status(201);
            if(strtotime($assign_date)>=strtotime(date("Y-m-d"))){
                $res = NotifySMS($assign_id);
            }else{
                $res['success']=false;
                $res['result'][0]="Assigned date was past not upcoming date";
            }
            if ($res['success']) { //Send SMS notification for both technician and customer
                $result['result'] .= "SMS are sent";
            } else {
                $result['result'] .= "SMS are not sent due to : \n ";
                foreach ($res['result'] as $r) {
                    $result['result'] .= $r . "\n";
                }
            }


            $app->response->body(json_encode($result));
        } else {
            ThrowError("Unable to create. Error occurred");
        }
    }
}else{
    ThrowError("Required Field Missing. Please check the parameter");
}


});
