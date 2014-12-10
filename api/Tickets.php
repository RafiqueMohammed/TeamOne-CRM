<?php
require_once("common.php");


$app->get("/Tickets", function () use ($app) {
    global $DB;

    $assign_qry = $DB->query("SELECT `assign_id`,`ticket_id`, `cust_id`, `type`, `type_id`, `assign_for`, `assign_date`, `remarks` as `ticket_remarks`, `status`, `created_on` as `ticket_created_on` FROM `" . TAB_ASSIGN . "` WHERE `status`='p'");
    if ($assign_qry->num_rows > 0) {
        $output = array();
        while ($assign = $assign_qry->fetch_assoc()) {

            $json_output = array("status" => "ok");
            switch ($assign['type']) {
                case 'amc':

                    $service_date_qry = $DB->query("SELECT * FROM `" . TAB_AMC_SERVICE . "` WHERE `amc_service_id`='{$assign['type_id']}' and  `date`<='DATEADD(NOW(), INTERVAL +1 MONTH)'") or ThrowError($DB->error);
                    $holder = array();
                    if ($service_date_qry->num_rows > 0) {
                        while ($info = $service_date_qry->fetch_assoc()) {
                            $service_amc_id = $info['amc_id'];
                            $service_cust_id = $info['cust_id'];
                            $service_date_data = $info;
                        }

                        $amc_req_qry = $DB->query("SELECT * FROM `" . TAB_AMC . "` WHERE `amc_id`='$service_amc_id' ") or ThrowError($DB->error);

                        while ($info = $amc_req_qry->fetch_assoc()) {
                            $service_ac_id = $info['ac_id'];
                            $amc_req_data = $info;
                        }

                        $holder["assignment_info"] = array_merge($amc_req_data, $service_date_data);
                        $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` as cust INNER JOIN `" . TAB_CUSTOMER_AC . "` as cad,(SELECT ac_type as actype,`ac_type_id` FROM `" . TAB_AC_TYPE . "`) as ac_type,
                (SELECT make_id,make as brand_name FROM `" . TAB_AC_MAKE . "`) as ac_make WHERE cust.`cust_id`='$service_cust_id' and cust.`cust_id` = cad.`cust_id` and cad.`make`=ac_make.`make_id`
                and ac_type.`ac_type_id` = cad.`ac_type`") or ThrowError($DB->error);

                        $holder["info"] = $cust_qry->fetch_assoc();

                        $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id`
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
                    cust_ac.`ac_id`='$service_ac_id'");

                        $holder["ac_info"] = $ac_query->fetch_assoc();

                        $tech_qry = $DB->query("SELECT * FROM `" . TAB_TECHNICIAN . "` WHERE `tech_id`='{$assign['assign_for']}'");
                        $holder["technician_info"] = $tech_qry->fetch_assoc();
                        $output[] = array_merge($assign, $holder);
                    }

                    break;

                    break;
                case 'complaint':
                    $req_qry = $DB->query("SELECT * FROM `" . TAB_COMPLAINT . "` as com INNER JOIN `" . TAB_PROBLEM_TYPE . "` as ptype WHERE com.`problem_type`=ptype.`ac_problem_id` AND com.`com_id`='{$assign['type_id']}'");

                    $req_data = $req_qry->fetch_assoc();
                    $holder = array();
                    $holder["assignment_info"] = $req_data;

                    $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` as cust INNER JOIN `" . TAB_CUSTOMER_AC . "` as cad,(SELECT ac_type as actype,`ac_type_id` FROM `" . TAB_AC_TYPE . "`) as ac_type,
                 (SELECT make_id,make as brand_name FROM `" . TAB_AC_MAKE . "`) as ac_make,`problem_type` as pt,`" . TAB_AC_TONNAGE . "` as ac_ton
                 WHERE cust.`cust_id`='{$req_data['cust_id']}' and cust.`cust_id` = cad.`cust_id` and cad.`make`=ac_make.`make_id`
                 and ac_ton.`tonnage_id`=cad.capacity  and ac_type.`ac_type_id` = cad.`ac_type`
                 and pt.`ac_problem_id`='{$req_data['problem_type']}'") or ThrowError($DB->error);

                    $holder["info"] = $cust_qry->fetch_assoc();

                    $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` 
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND 
                    cust_ac.`ac_id`='{$req_data['ac_id']}'");

                    $holder["ac_info"] = $ac_query->fetch_assoc();

                    $tech_qry = $DB->query("SELECT * FROM `" . TAB_TECHNICIAN . "` WHERE `tech_id`='{$assign['assign_for']}'");
                    $holder["technician_info"] = $tech_qry->fetch_assoc();
                    $output[] = array_merge($assign, $holder);

                    break;

                case 'ots':
                    $req_qry = $DB->query("SELECT * FROM `" . TAB_OTS . "` WHERE `ots_id`='{$assign['type_id']}'");
                    $req_data = $req_qry->fetch_assoc();
                    $holder = array();
                    $holder["assignment_info"] = $req_data;

                    $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                    address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` WHERE `cust_id`='{$req_data['cust_id']}'")
                    or ThrowError($DB->error);

                    $holder["info"] = $cust_qry->fetch_assoc();

                    $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` 
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND 
                    cust_ac.`ac_id`='{$req_data['ac_id']}'");

                    $holder["ac_info"] = $ac_query->fetch_assoc();

                    $tech_qry = $DB->query("SELECT * FROM `" . TAB_TECHNICIAN . "` WHERE `tech_id`='{$assign['assign_for']}'");
                    $holder["technician_info"] = $tech_qry->fetch_assoc();
                    $output[] = array_merge($assign, $holder);

                    break;

                case 'installation':
                    $ins_service_qry = $DB->query("SELECT * FROM `" . TAB_INSTALL_SERVICE . "` WHERE `install_service_id`='{$assign['type_id']}'");
                    $holder = array();
                    if ($ins_service_qry->num_rows > 0) {
                        while ($info = $ins_service_qry->fetch_assoc()) {
                            $install_id = $info['install_id'];
                            $ins_service_cust_id = $info['cust_id'];
                            $ins_service_data = $info;
                        }

                        $installation_req_qry = $DB->query("SELECT * FROM `" . TAB_INSTALL . "` WHERE `install_id`='$install_id' ") or ThrowError($DB->error);

                        while ($info = $installation_req_qry->fetch_assoc()) {
                            $ins_service_ac_id = $info['ac_id'];
                            $installation_data = $info;
                        }

                        $holder["assignment_info"] = array_merge($installation_data, $ins_service_data);
                        $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` as cust INNER JOIN `" . TAB_CUSTOMER_AC . "` as cad,(SELECT ac_type as actype,`ac_type_id` FROM `" . TAB_AC_TYPE . "`) as ac_type,
                (SELECT make_id,make as brand_name FROM `" . TAB_AC_MAKE . "`) as ac_make WHERE cust.`cust_id`='$ins_service_cust_id' and cust.`cust_id` = cad.`cust_id` and cad.`make`=ac_make.`make_id`
                and ac_type.`ac_type_id` = cad.`ac_type`") or ThrowError($DB->error);

                        $holder["info"] = $cust_qry->fetch_assoc();

                        $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id`
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
                    cust_ac.`ac_id`='$ins_service_ac_id'");

                        $holder["ac_info"] = $ac_query->fetch_assoc();

                        $tech_qry = $DB->query("SELECT * FROM `" . TAB_TECHNICIAN . "` WHERE `tech_id`='{$assign['assign_for']}'");
                        $holder["technician_info"] = $tech_qry->fetch_assoc();
                        $output[] = array_merge($assign, $holder);
                    }
                    break;

                case 'ins_service':
                    $ins_service_qry = $DB->query("SELECT * FROM `" . TAB_INSTALL_SERVICE . "` WHERE `install_service_id`='{$assign['type_id']}'");
                    $holder = array();
                    if ($ins_service_qry->num_rows > 0) {
                        while ($info = $ins_service_qry->fetch_assoc()) {
                            $install_id = $info['install_id'];
                            $ins_service_cust_id = $info['cust_id'];
                            $ins_service_data = $info;
                        }

                        $installation_req_qry = $DB->query("SELECT * FROM `" . TAB_INSTALL . "` WHERE `install_id`='$install_id' ") or ThrowError($DB->error);

                        while ($info = $installation_req_qry->fetch_assoc()) {
                            $ins_service_ac_id = $info['ac_id'];
                            $installation_data = $info;
                        }

                        $holder["assignment_info"] = array_merge($installation_data, $ins_service_data);
                        $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` as cust INNER JOIN `" . TAB_CUSTOMER_AC . "` as cad,(SELECT ac_type as actype,`ac_type_id` FROM `" . TAB_AC_TYPE . "`) as ac_type,
                (SELECT make_id,make as brand_name FROM `" . TAB_AC_MAKE . "`) as ac_make WHERE cust.`cust_id`='$ins_service_cust_id' and cust.`cust_id` = cad.`cust_id` and cad.`make`=ac_make.`make_id`
                and ac_type.`ac_type_id` = cad.`ac_type`") or ThrowError($DB->error);

                        $holder["info"] = $cust_qry->fetch_assoc();

                        $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id`
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
                    cust_ac.`ac_id`='$ins_service_ac_id'");

                        $holder["ac_info"] = $ac_query->fetch_assoc();

                        $tech_qry = $DB->query("SELECT * FROM `" . TAB_TECHNICIAN . "` WHERE `tech_id`='{$assign['assign_for']}'");
                        $holder["technician_info"] = $tech_qry->fetch_assoc();
                        $output[] = array_merge($assign, $holder);
                    }

                    break;

            }


        }
        $json_output['data'] = $output;
    } else {
        $json_output = array("status" => "no", "result" => "No Tickets found");
    }


    $app->response->body(json_encode($json_output));
});

$app->get("/Tickets/:tid", function ($tid) use ($app) {
    global $DB;
});

$app->get("/Tickets/Customer/:cid", function ($cid) use ($app) {
    global $DB;

    $assign_qry = $DB->query("SELECT `assign_id`,`ticket_id`, `cust_id`, `type`, `type_id`, `assign_for`, `assign_date`, `remarks` as `ticket_remarks`, `status`, `created_on` as `ticket_created_on` FROM `" . TAB_ASSIGN . "` WHERE `status`='p' and `cust_id`='$cid'");
    if ($assign_qry->num_rows > 0) {
        $output = array();
        while ($assign = $assign_qry->fetch_assoc()) {

            $json_output = array("status" => "ok");
            switch ($assign['type']) {
                case 'amc':
                    $req_qry = $DB->query("SELECT * FROM `" . TAB_AMC . "` as amc INNER JOIN `" . TAB_AMC_SERVICE . "` as service WHERE amc.`cust_id`='{$assign['cust_id']}' AND service.`amc_service_id`='{$assign['type_id']}' ") or ThrowError($DB->error);

                    $req_data = $req_qry->fetch_assoc();
                    $holder = array();
                    $holder["assignment_info"] = $req_data;


                    $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` as cust INNER JOIN `" . TAB_CUSTOMER_AC . "` as cad,(SELECT ac_type as actype,`ac_type_id` FROM `" . TAB_AC_TYPE . "`) as ac_type,
                (SELECT make_id,make as brand_name FROM `" . TAB_AC_MAKE . "`) as ac_make WHERE cust.`cust_id`='{$req_data['cust_id']}' and cust.`cust_id` = cad.`cust_id` and cad.`make`=ac_make.`make_id`
                and ac_type.`ac_type_id` = cad.`ac_type`") or ThrowError($DB->error);

                    $holder["info"] = $cust_qry->fetch_assoc();

                    $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` 
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND 
                    cust_ac.`ac_id`='{$req_data['ac_id']}'");

                    $holder["ac_info"] = $ac_query->fetch_assoc();

                    $tech_qry = $DB->query("SELECT * FROM `" . TAB_TECHNICIAN . "` WHERE `tech_id`='{$assign['assign_for']}'");
                    $holder["technician_info"] = $tech_qry->fetch_assoc();
                    $output[] = array_merge($assign, $holder);
                    break;

                    break;
                case 'complaint':
                    $req_qry = $DB->query("SELECT * FROM `" . TAB_COMPLAINT . "` as com INNER JOIN `" . TAB_PROBLEM_TYPE . "` as ptype WHERE com.`problem_type`=ptype.`ac_problem_id` AND com.`com_id`='{$assign['type_id']}'");

                    $req_data = $req_qry->fetch_assoc();
                    $holder = array();
                    $holder["assignment_info"] = $req_data;

                    $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` as cust INNER JOIN `" . TAB_CUSTOMER_AC . "` as cad,(SELECT ac_type as actype,`ac_type_id` FROM `" . TAB_AC_TYPE . "`) as ac_type,
                 (SELECT make_id,make as brand_name FROM `" . TAB_AC_MAKE . "`) as ac_make,`problem_type` as pt,`" . TAB_AC_TONNAGE . "` as ac_ton
                 WHERE cust.`cust_id`='{$req_data['cust_id']}' and cust.`cust_id` = cad.`cust_id` and cad.`make`=ac_make.`make_id`
                 and ac_ton.`tonnage_id`=cad.capacity  and ac_type.`ac_type_id` = cad.`ac_type`
                 and pt.`ac_problem_id`='{$req_data['problem_type']}'") or ThrowError($DB->error);

                    $holder["info"] = $cust_qry->fetch_assoc();

                    $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` 
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND 
                    cust_ac.`ac_id`='{$req_data['ac_id']}'");

                    $holder["ac_info"] = $ac_query->fetch_assoc();

                    $tech_qry = $DB->query("SELECT * FROM `" . TAB_TECHNICIAN . "` WHERE `tech_id`='{$assign['assign_for']}'");
                    $holder["technician_info"] = $tech_qry->fetch_assoc();
                    $output[] = array_merge($assign, $holder);

                    break;

                case 'ots':
                    $req_qry = $DB->query("SELECT * FROM `" . TAB_OTS . "` WHERE `ots_id`='{$assign['type_id']}'");
                    $req_data = $req_qry->fetch_assoc();
                    $holder = array();
                    $holder["assignment_info"] = $req_data;

                    $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                    address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` WHERE `cust_id`='{$req_data['cust_id']}'")
                    or ThrowError($DB->error);

                    $holder["info"] = $cust_qry->fetch_assoc();

                    $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` 
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND 
                    cust_ac.`ac_id`='{$req_data['ac_id']}'");

                    $holder["ac_info"] = $ac_query->fetch_assoc();

                    $tech_qry = $DB->query("SELECT * FROM `" . TAB_TECHNICIAN . "` WHERE `tech_id`='{$assign['assign_for']}'");
                    $holder["technician_info"] = $tech_qry->fetch_assoc();
                    $output[] = array_merge($assign, $holder);

                    break;

                case 'installation':

                    $req_qry = $DB->query("SELECT * FROM `" . TAB_INSTALL . "` as install INNER JOIN `" . TAB_INSTALL_SERVICE . "` as ins_service WHERE ins_service.`install_service_id`='{$assign['type_id']}' AND install.`install_id`=ins_service.`install_id`") or ThrowError($DB->error);

                    $req_data = $req_qry->fetch_assoc();
                    $holder = array();
                    $holder["assignment_info"] = $req_data;

                    $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "`  WHERE `cust_id`='{$req_data['cust_id']}'
                 ") or ThrowError($DB->error);

                    $holder["info"] = $cust_qry->fetch_assoc();

                    $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` 
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND 
                    cust_ac.`ac_id`='{$req_data['ac_id']}'");

                    $holder["ac_info"] = $ac_query->fetch_assoc();

                    $tech_qry = $DB->query("SELECT * FROM `" . TAB_TECHNICIAN . "` WHERE `tech_id`='{$assign['assign_for']}'");
                    $holder["technician_info"] = $tech_qry->fetch_assoc();
                    $output[] = array_merge($assign, $holder);
                    break;

            }


        }
        $json_output['data'] = $output;
    } else {
        $json_output = array("status" => "no", "result" => "No Tickets found");
    }


    $app->response->body(json_encode($json_output));

});

$app->put("/Tickets/:aid/Close", function ($aid) use ($app) {
    global $DB;
    if ($DB->query("SELECT `assign_id` FROM `" . TAB_ASSIGN . "` WHERE `assign_id`='$aid'")->num_rows > 0) {
        $DB->query("UPDATE `" . TAB_ASSIGN . "` SET `status`='c' WHERE `assign_id`='$aid'") or ThrowError($DB->error);
        if ($DB->affected_rows > 0) {
            $result['status'] = "ok";
            $result['result'] = "Successfully Closed";
        } else {
            $result['status'] = "no";
            $result['result'] = "No Changes Made";
        }
    } else {
        $result['status'] = "no";
        $result['result'] = "Given Ticket Not Found";
    }

    $app->response->body(json_encode($result));
});

$app->put("/Tickets/:aid/Reassign", function ($aid) use ($app) {
    global $DB;

    $assign_for = $DB->real_escape_string($app->request->put("technician"));
    $assign_date = $DB->real_escape_string($app->request->put("date"));
    $assign_date = ConvertFromIST($assign_date);
    $remarks = $DB->real_escape_string($app->request->put("remarks"));

    if ($DB->query("SELECT `assign_id` FROM `" . TAB_ASSIGN . "` WHERE `assign_id`='$aid'")->num_rows > 0) {
        $DB->query("UPDATE `" . TAB_ASSIGN . "` SET `assign_for`='$assign_for',`assign_date`='$assign_date',
         `remarks`='$remarks' WHERE `assign_id`='$aid'") or ThrowError($DB->error);
        if ($DB->affected_rows > 0) {
            $result['status'] = "ok";
            $result['result'] = "Successfully Reassigned";
        } else {
            $result['status'] = "no";
            $result['result'] = "No Changes Made";
        }
    } else {
        $result['status'] = "no";
        $result['result'] = "Given Ticket Not Found";
    }

    $app->response->body(json_encode($result));
});

$app->put("", function () use ($app) {
    global $DB;
});