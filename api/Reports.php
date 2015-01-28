<?php
require_once("common.php");

/******* AMC REPORTS STARTS ***************/

$app->get("/Reports/AMC", function () use ($app) {
    global $DB;
    $qry = $DB->query("SELECT * FROM `" . TAB_AMC . "` ") or ThrowError($DB->error);
    if ($qry->num_rows > 0) {
        $result = array("status" => "ok");
        while ($info = $qry->fetch_assoc()) {
            $info['activation'] = ConvertToIST($info['activation']);
            $info['expiration'] = ConvertToIST($info['expiration']);
            $holder["info"] = $info;
            $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` as cust INNER JOIN `" . TAB_CUSTOMER_AC . "` as cad,(SELECT ac_type as actype,`ac_type_id` FROM `" . TAB_AC_TYPE . "`) as ac_type,
                (SELECT make_id,make as brand_name FROM `" . TAB_AC_MAKE . "`) as ac_make WHERE cust.`cust_id`='{$info['cust_id']}' and cust.`cust_id` = cad.`cust_id` and cad.`make`=ac_make.`make_id`
                and ac_type.`ac_type_id` = cad.`ac_type`") or ThrowError($DB->error);

            $holder["customer_info"] = $cust_qry->fetch_assoc();
            $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id`
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
                    cust_ac.`ac_id`='{$info['ac_id']}'");

            $holder["ac_info"] = $ac_query->fetch_assoc();

            $result["data"][] = $holder;

        }
        $app->response->body(json_encode($result));

    } else {
        ThrowError("No Data found in AMC");
    }

});

$app->post("/Reports/AMC", function () use ($app) {
    global $DB;
    $from_date = $app->request->post("from_date", false);
    $from_date = date("Y-m-d",strtotime($from_date));
    $to_date = $app->request->post("to_date", false);
    $to_date = date("Y-m-d",strtotime($to_date));

    if ($to_date != false && $from_date != false) {

        $qry = $DB->query("SELECT * FROM `" . TAB_AMC . "` WHERE `activation` BETWEEN '$from_date' AND '$to_date' ") or ThrowError($DB->error);
        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $holder["info"] = $info;
                $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` as cust INNER JOIN `" . TAB_CUSTOMER_AC . "` as cad,(SELECT ac_type as actype,`ac_type_id` FROM `" . TAB_AC_TYPE . "`) as ac_type,
                (SELECT make_id,make as brand_name FROM `" . TAB_AC_MAKE . "`) as ac_make WHERE cust.`cust_id`='{$info['cust_id']}' and cust.`cust_id` = cad.`cust_id` and cad.`make`=ac_make.`make_id`
                and ac_type.`ac_type_id` = cad.`ac_type`") or ThrowError($DB->error);

                $holder["customer_info"] = $cust_qry->fetch_assoc();
                $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id`
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
                    cust_ac.`ac_id`='{$info['ac_id']}'");

                $holder["ac_info"] = $ac_query->fetch_assoc();

                $result["data"][] = $holder;

            }
            $app->response->body(json_encode($result));

        } else {
            ThrowError("No Data found between given dates");
        }
    } else {
        ThrowMissing();
    }
});


/************ AMC REPORTS ENDS **********/


/******* COMPLAINTS REPORTS STARTS ***************/

$app->get("/Reports/Complaints", function () use ($app) {
    global $DB;


    $qry = $DB->query("SELECT * FROM `" . TAB_COMPLAINT . "` as com INNER JOIN `" . TAB_PROBLEM_TYPE . "` as pt WHERE com.problem_type=pt.ac_problem_id") or ThrowError($DB->error);
    if ($qry->num_rows > 0) {
        $result = array("status" => "ok");
        while ($info = $qry->fetch_assoc()) {
            $info['preferred_date'] = ConvertToIST($info['preferred_date']);
            $holder["info"] = $info;

            $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` as cust INNER JOIN `" . TAB_CUSTOMER_AC . "` as cad,(SELECT ac_type as actype,`ac_type_id` FROM `" . TAB_AC_TYPE . "`) as ac_type,
                 (SELECT make_id,make as brand_name FROM `" . TAB_AC_MAKE . "`) as ac_make,`problem_type` as pt,`" . TAB_AC_TONNAGE . "` as ac_ton
                 WHERE cust.`cust_id`='{$info['cust_id']}' and cust.`cust_id` = cad.`cust_id` and cad.`make`=ac_make.`make_id`
                 and ac_ton.`tonnage_id`=cad.capacity  and ac_type.`ac_type_id` = cad.`ac_type`
                 and pt.`ac_problem_id`='{$info['problem_type']}'") or ThrowError($DB->error);

            $holder["customer_info"] = $cust_qry->fetch_assoc();
            $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id`
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
                    cust_ac.`ac_id`='{$info['ac_id']}'");

            $holder["ac_info"] = $ac_query->fetch_assoc();

            $result["data"][] = $holder;

        }
        $app->response->body(json_encode($result));

    } else {
        ThrowError("No Data found in AMC");
    }

});

$app->post("/Reports/Complaints", function () use ($app) {
    global $DB;
    $from_date = $app->request->post("from_date", false);
    $from_date = date("Y-m-d",strtotime($from_date));
    $to_date = $app->request->post("to_date", false);
    $to_date = date("Y-m-d",strtotime($to_date));

    if ($to_date != false && $from_date != false) {

        $qry = $DB->query("SELECT * FROM `" . TAB_COMPLAINT . "` as c INNER JOIN `".TAB_PROBLEM_TYPE."` as p WHERE p.`ac_problem_id`=c.`problem_type` AND c.`created_on` BETWEEN '$from_date' AND '$to_date' ") or ThrowError($DB->error);
        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $holder["info"] = $info;

                $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` as cust INNER JOIN `" . TAB_CUSTOMER_AC . "` as cad,(SELECT ac_type as actype,`ac_type_id` FROM `" . TAB_AC_TYPE . "`) as ac_type,
                 (SELECT make_id,make as brand_name FROM `" . TAB_AC_MAKE . "`) as ac_make,`problem_type` as pt,`" . TAB_AC_TONNAGE . "` as ac_ton
                 WHERE cust.`cust_id`='{$info['cust_id']}' and cust.`cust_id` = cad.`cust_id` and cad.`make`=ac_make.`make_id`
                 and ac_ton.`tonnage_id`=cad.capacity  and ac_type.`ac_type_id` = cad.`ac_type`
                 and pt.`ac_problem_id`='{$info['problem_type']}'") or ThrowError($DB->error);

                $holder["customer_info"] = $cust_qry->fetch_assoc();
                $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id`
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
                    cust_ac.`ac_id`='{$info['ac_id']}'");
                $holder["ac_info"] = $ac_query->fetch_assoc();

                $result["data"][] = $holder;

            }
            $app->response->body(json_encode($result));

        } else {
            ThrowError("No Data found in AMC");
        }
    } else {
        ThrowMissing();
    }
});


/************ COMPLAINTS REPORTS ENDS **********/


/******* OTS REPORTS STARTS ***************/

$app->get("/Reports/OTS", function () use ($app) {
    global $DB;


    $qry = $DB->query("SELECT * FROM `" . TAB_OTS . "` ") or ThrowError($DB->error);
    if ($qry->num_rows > 0) {
        $result = array("status" => "ok");
        while ($info = $qry->fetch_assoc()) {
            $holder["info"] = $info;

            $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                    address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` WHERE `cust_id`='{$info['cust_id']}'")
            or ThrowError($DB->error);

            $holder["customer_info"] = $cust_qry->fetch_assoc();


            $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id`
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
                    cust_ac.`ac_id`='{$info['ac_id']}'");

            $holder["ac_info"] = $ac_query->fetch_assoc();

            $result["data"][] = $holder;

        }
        $app->response->body(json_encode($result));

    } else {
        ThrowError("No Data found in AMC");
    }

});

$app->post("/Reports/OTS", function () use ($app) {
    global $DB;
    $from_date = $app->request->post("from_date", false);
    $from_date = date("Y-m-d",strtotime($from_date));
    $to_date = $app->request->post("to_date", false);
    $to_date = date("Y-m-d",strtotime($to_date));

    if ($to_date != false && $from_date != false) {

        $qry = $DB->query("SELECT * FROM `" . TAB_OTS . "` WHERE `created_on` BETWEEN '$from_date' AND '$to_date' ") or ThrowError($DB->error);
        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $holder["info"] = $info;
    
                $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                        address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` WHERE `cust_id`='{$info['cust_id']}'")
                or ThrowError($DB->error);
    
                $holder["customer_info"] = $cust_qry->fetch_assoc();
    
    
                $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id`
                        AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
                        cust_ac.`ac_id`='{$info['ac_id']}'");
    
                $holder["ac_info"] = $ac_query->fetch_assoc();
    
                $result["data"][] = $holder;
    
            }
            $app->response->body(json_encode($result));
    
        } else {
            ThrowError("No Data found in AMC");
        }
    } else {
        ThrowMissing();
    }
});

/************ OTS REPORTS ENDS **********/

/******* INSTALLATION REPORTS STARTS ***************/

$app->get("/Reports/Installation", function () use ($app) {
    global $DB;


    $qry = $DB->query("SELECT * FROM `" . TAB_INSTALL . "` ") or ThrowError($DB->error);
    if ($qry->num_rows > 0) {
        $result = array("status" => "ok");
        while ($info = $qry->fetch_assoc()) {
            $info['preferred_date'] = ConvertToIST($info['preferred_date']);
            $holder["info"] = $info;

            $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                    address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` WHERE `cust_id`='{$info['cust_id']}'")
            or ThrowError($DB->error);

            $holder["customer_info"] = $cust_qry->fetch_assoc();


            $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                    `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id`
                    AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
                    cust_ac.`ac_id`='{$info['ac_id']}'");

            $holder["ac_info"] = $ac_query->fetch_assoc();

            $result["data"][] = $holder;

        }
        $app->response->body(json_encode($result));

    } else {
        ThrowError("No Data found in AMC");
    }

});

$app->post("/Reports/Installation", function () use ($app) {
    global $DB;
    $from_date = $app->request->post("from_date", false);
    $from_date = date("Y-m-d",strtotime($from_date));
    $to_date = $app->request->post("to_date", false);
    $to_date = date("Y-m-d",strtotime($to_date));

    if ($to_date != false && $from_date != false) {

        $qry = $DB->query("SELECT * FROM `" . TAB_INSTALL . "` WHERE `created_on` BETWEEN '{$from_date}' AND '{$to_date}' ") or ThrowError($DB->error);
        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $info['preferred_date'] = ConvertToIST($info['preferred_date']);
                $holder["info"] = $info;
    
                $cust_qry = $DB->query("SELECT account_type,first_name,last_name,email,organisation,mobile,
                        address,landmark,location as customer_location,pincode,city,mode_of_contact FROM `" . TAB_CUSTOMER . "` WHERE `cust_id`='{$info['cust_id']}'")
                or ThrowError($DB->error);
    
                $holder["customer_info"] = $cust_qry->fetch_assoc();
    
    
                $ac_query = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
                        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id`
                        AND loc.ac_location_id=cust_ac.ac_location AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
                        cust_ac.`ac_id`='{$info['ac_id']}'");
    
                $holder["ac_info"] = $ac_query->fetch_assoc();
    
                $result["data"][] = $holder;
    
            }
            $app->response->body(json_encode($result));
    
        } else {
            ThrowError("No Data found in AMC");
        }
    } else {
        ThrowMissing();
    }
});

/************ INSTALLATION REPORTS ENDS **********/

/************ CUSTOMERS REPORTS STARTS **********/

$app->post("/Reports/Customers", function () use ($app) {
    global $DB;
    $from_date = $app->request->post("from_date", false);
    $from_date = date("Y-m-d",strtotime($from_date));
    $to_date = $app->request->post("to_date", false);
    $to_date = date("Y-m-d",strtotime($to_date));

    if ($to_date != false && $from_date != false) {

        header('Content-Type: application/json');
        $qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER . "` WHERE `created_on` BETWEEN '{$from_date}' AND '{$to_date}'") or ThrowError($DB->error);
        if ($qry->num_rows > 0) {
            while ($data = $qry->fetch_assoc()) {
                //$data["created_on"]=date("d-m-Y",strtotime($data['created_on']));
                $data["created_on"] = ConvertToIST($data['created_on']);
                $result["data"][] = $data;
            }
            $result['status'] = "ok";
        } else {
            $result = array("status" => "no", "result" =>"No customers found."."SELECT * FROM `" . TAB_CUSTOMER . "` WHERE `created_on` BETWEEN '{$from_date}' AND '{$to_date}'");
        }
    } else {
        ThrowMissing();
    }
    $app->response->body(json_encode($result));
});

/************ CUSTOMERS REPORTS ENDS **********/

/************ TECHNICIAN REPORTS STARTS **********/

$app->get("/Reports/Technicians", function () use ($app) {
    global $DB;
    $qry = $DB->query("SELECT * FROM `" . TAB_TECHNICIAN . "` as tech INNER JOIN `" . TAB_BRANCH . "` as b WHERE tech.branch=b.branch_id AND tech.`enabled`='1'");
    $result = array();
    if ($qry->num_rows > 0) {
        $result['status'] = "ok";
        while ($info = $qry->fetch_assoc()) {
            $result['data'][] = $info;
        }

        $q = $DB->query("SELECT * FROM `" . TAB_BRANCH . "`");
        if ($q->num_rows > 0) {
            while ($info = $q->fetch_assoc()) {
                $result['branch_list'][] = $info;
            }
            $result['branch_list']['empty'] = false;
        } else {
            $result['branch_list']['empty'] = true;
        }

    } else {
        ThrowError("No Technician Found");
    }

    $app->response->body(json_encode($result));
});

/************ TECHNICIAN REPORTS ENDS **********/