<?php

require_once("common.php");

/** MANAGE CUSTOMER */

$app->post("/Customer", function () use ($app) {
        global $DB;
        if (isset($_POST['registration']) && !empty($_POST['registration'])) {
            $fname = (isset($_POST['firstname'])) ? $DB->real_escape_string($_POST['firstname']) : "";
            $lname = (isset
            ($_POST['lastname'])) ? $DB->real_escape_string($_POST['lastname']) : "";
            $acc_type = (isset($_POST['acc_type'])) ?
                $_POST['acc_type'] : "r";
            $org = (isset($_POST['org_name'])) ? $DB->real_escape_string($_POST['org_name']) :
                "";
            $mob1 = (isset($_POST['mobile1'])) ? $DB->real_escape_string($_POST['mobile1']) : "";
            $mob2 = (isset
            ($_POST['mobile2'])) ? $DB->real_escape_string($_POST['mobile2']) : "";
            $email = (isset($_POST['email'])) ?    $DB->real_escape_string($_POST['email']) : "";
            $landline = (isset($_POST['landline'])) ? $DB->real_escape_string($_POST['landline']) :"";
            $address = (isset($_POST['address'])) ? $DB->real_escape_string($_POST['address']) : "";
            $pincode = (isset($_POST['pincode'])) ? $DB->real_escape_string($_POST['pincode']) : "";
            $city = (isset($_POST['city'])) ?$DB->real_escape_string($_POST['city']) : "";
            $landmark = (isset($_POST['landmark'])) ? $DB->real_escape_string($_POST['landmark']) : "";
            $location = (isset($_POST['location'])) ? $DB->real_escape_string($_POST['location']) : "";
            $alt_contacts =
                (isset($_POST['alternate_contact'])) ? $DB->real_escape_string($_POST['alternate_contact']) : "";
            $mode_of_com =
                (isset($_POST['communication_type'])) ? $DB->real_escape_string($_POST['communication_type']) : "";
            $referred =
                (isset($_POST['referred_by'])) ? $DB->real_escape_string($_POST['referred_by']) : "";
            $other = (isset($_POST['reffered_other'])) ?
                $_POST['reffered_other'] : "";
            $dob = (isset($_POST['dob'])) ? $DB->real_escape_string($_POST['dob']) :
                "";
            $reference = "";
            if ($referred == "other" || $referred == "exist_cust") {
                $reference = $other;
            } else {
                $reference = $referred;
            }
            if (!empty($dob)) {
                $dob = date("Y-m-d", strtotime($dob));
            }
            $remarks = (isset($_POST['remarks'])) ? $DB->real_escape_string($_POST['remarks']) : "";
            $DB->query("INSERT INTO `" .
                TAB_CUSTOMER . "`(`account_type`, `first_name`, `last_name`, `email`, `password`, `organisation`,
         `mobile`, `alternate_mobile`, `alternate_contact`, `phone`, `dob`, `address`, `landmark`,
         `location`, `pincode`, `city`, `mode_of_contact`, `remarks`, `reference`)
         VALUES('$acc_type','$fname','$lname','$email','123','$org','$mob1','$mob2','$alt_contacts','$landline','$dob','$address',
         '$landmark','$location','$pincode','$city','$mode_of_com','$remarks','$reference')
         ") or ThrowError($DB->error);
            if ($DB->affected_rows > 0) {
                $app->status(201);
                $result = array(
                    "status" => "ok",
                    "result" => "Account created successfully",
                    "customer_id" => $DB->insert_id);
            } else {
                $result = array("status" => "no", "result" =>
                    "Unable to create account. Please try again.");
            }

            $app->response->body(json_encode($result));
        } else {
            ThrowMissing();
        }


    }
);

$app->get("/Customers", function () use ($app) {
        global $DB;
        $qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER . "`");
        if ($qry->
            num_rows > 0
        ) {

            while ($data = $qry->fetch_assoc()) {
                //$data["created_on"]=date("d-m-Y",strtotime($data['created_on']));
                $data["created_on"] = ConvertToIST($data['created_on']);
                $result["data"][] = $data;
            }

            $result['status'] = "ok";
        } else {
            $result = array("status" => "no", "result" =>
                "No such customer found. Try <a href='Search'>searching again</a>");
        }
        $app->response->body(json_encode($result));
    }
);

$app->get("/Customer/:id", function ($id) use ($app) {
        global $DB;
        $qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER .
            "`  WHERE `cust_id` = '{$id}'");
        if ($qry->num_rows > 0) {
            $data = $qry->fetch_assoc();
            $result = $data;
            $result['status'] = "ok";
            $originalDate =
                $data['created_on'];
            $dob_raw = $data['dob'];
            if ($dob_raw == "0000-00-00" || $dob_raw == null) {
                $dob_convert = "";
            } else {
                $dob_convert = date("d-m-Y", strtotime($dob_raw));
            }


            $newDate = date("d-m-Y", strtotime($originalDate));
            $result['date'] = $newDate;
            $result['dob'] = $dob_convert;
            $pQry = $DB->query("SELECT * FROM `" .
                TAB_LOCALITY . "` WHERE `pincode`='{$data['pincode']}'");
            $result['landmark_info'] =
                array();
            if ($pQry->num_rows > 0) {
                while ($pInfo = $pQry->fetch_assoc()) {
                    $result['landmark_info'][] = $pInfo['locality_name'];
                }
            } else {
                $result['landmark'][] = " - No Landmark Available - ";
            }

            $acQry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC .
                "` as cust_ac INNER JOIN `" . TAB_AC_TYPE . "` as ac_type, `" . TAB_AC_MAKE .
                "` as make,
                                `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_LOCATION .
                "` as loc WHERE ac_type.`ac_type_id`=cust_ac.`ac_type` AND cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.`cust_id`='{$id}'");
            $result['ac_data'] =
                array();
            if ($acQry->num_rows > 0) {
                $result['ac_data']["status"] = "ok";
                while ($acInfo = $acQry->fetch_assoc()) {
                    $result['ac_data'][] = $acInfo;
                }
            } else {
                $result['ac_data']["status"] = "no";
                $result['ac_data']["result"] =
                    " - No AC Added Yet -";
            }


        } else {
            $result = array("status" => "no", "result" =>
                "No such customer found. Try <a href='Search'>searching again</a>");
        }
        $app->response->body(json_encode($result));
    }
);

$app->put("/Customer/:id", function ($id) use ($app) {
        global $DB;
        $result = array();
        $fname = $DB->real_escape_string($app->request->
        put('fname'));
        $lname = $DB->real_escape_string($app->request->put('lname'));
        $org =
            $DB->real_escape_string($app->request->put('org'));
        $mob1 = $DB->
        real_escape_string($app->request->put('mobile1'));
        $mob2 = $DB->
        real_escape_string($app->request->put('mobile2'));
        $email = $DB->
        real_escape_string($app->request->put('email'));
        $landline = $DB->
        real_escape_string($app->request->put('landline'));
        $address = $DB->
        real_escape_string($app->request->put('address'));
        $pincode = $DB->
        real_escape_string($app->request->put('pincode'));
        $city = $DB->
        real_escape_string($app->request->put('city'));
        $landmark = $DB->
        real_escape_string($app->request->put('landmark'));
        $location = $DB->
        real_escape_string($app->request->put('location'));
        $alt_contacts = $DB->
        real_escape_string($app->request->put('alt_contacts'));
        $mode_of_com = $DB->
        real_escape_string($app->request->put('communication'));
        $remarks = $DB->
        real_escape_string($app->request->put('remarks'));
        $dob = $DB->
        real_escape_string($app->request->put('dob'));
        $newdate = date("Y-m-d",
            strtotime($dob));
        $DB->query("UPDATE `" . TAB_CUSTOMER . "` SET `first_name`='{$fname}',`last_name`='{$lname}',`email`='{$email}',`organisation`='{$org}',`mobile`='{$mob1}',
        `alternate_mobile`='{$mob2}',`alternate_contact`='{$alt_contacts}',`phone`='{$landline}',`dob`='{$newdate}',`address`='{$address}',
        `landmark`='{$landmark}',`location`='{$location}',`pincode`='{$pincode}',`city`='{$city}',`mode_of_contact`='{$mode_of_com}',
         `remarks`='{$remarks}' WHERE `cust_id`='{$id}'");
        if ($DB->
            affected_rows > 0
        ) {
            $result = array("status" => "ok", "result" => "Successfully Updated");
        } else {
            $result = array("status" => "no", "result" => "No Changes Made " . $DB->error);
        }

        $app->response->body(json_encode($result));
    }
);

$app->delete("/Customer/:id", function ($id) use ($app) {
        $result = array("status" => "ok", "result" => "You deleted info for $id");
        $app->
        response->body(json_encode($result));
    }
);


/** MANAGE CUSTOMER AC */

$app->post("/Customer/:id/AC", function ($id) use ($app) {

        global $DB;
        $result = array();
        if ($id > 0) {

            $qry = $app->request->post("row");
            $insert = 0;
            $total = count($qry);
            for ($i = 0; $i < $total; $i++) {
                $ac_type = $DB->real_escape_string($qry[$i]["ac_type"]);
                //$model_no = $DB->real_escape_string($qry[$i]["model_no"]);
                $make = $DB->real_escape_string($qry[$i]["make"]);
                $idu_model_no = $DB->
                real_escape_string($qry[$i]["idu_model_no"]);
                $idu_serial_no = $DB->
                real_escape_string($qry[$i]["idu_serial_no"]);
                $odu_model_no = $DB->
                real_escape_string($qry[$i]["odu_model_no"]);
                $odu_serial_no = $DB->
                real_escape_string($qry[$i]["odu_serial_no"]);
                $location = $DB->
                real_escape_string($qry[$i]["location"]);
                $remarks = $DB->real_escape_string($qry[$i]["remarks"]);
                $capacity = $DB->real_escape_string($qry[$i]["ton"]);
                $DB->query("INSERT INTO `" .
                    TAB_CUSTOMER_AC . "`(`cust_id`,`make`,`ac_type`
            ,`capacity`,`odu_model_no`,`odu_serial_no`,`idu_model_no`,`idu_serial_no`,`ac_location`,`remarks`)
            VALUES('$id','$make','$ac_type','$capacity','$odu_model_no','$odu_serial_no',
            '$idu_model_no','$idu_serial_no','$location','$remarks')");
                if ($DB->
                    affected_rows > 0
                ) {
                    $insert++;
                }

            }
            if ($insert == 0) {
                $result = array("status" => "no", "result" => "Error occurred while adding data");
            } else if ($i == $total) {
                $app->status(201);
                $result = array(
                    "status" => "ok",
                    "result" => "Successfully added",
                    "last_id" => $DB->insert_id);
            } else if ($i > 0 && $i < $total) {
                $result = array("status" => "ok", "result" =>
                    "Data inserted but with some errors");
            }


        } else {
            $result = array("status" => "no", "result" => "Invalid Customer ID Passed");
        }
        $app->response->body(json_encode($result));
    }
);

$app->get("/Customer/:id/AC/:ac_id", function ($id, $ac_id) use ($app) {

        global $DB;
        $acQry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC .
            "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_LOCATION .
            "` as loc WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.`ac_id`='{$ac_id}' AND cust_ac.`cust_id`='{$id}'");
        if ($acQry->num_rows > 0) {
            $result["status"] = "ok";
            $acInfo = $acQry->fetch_assoc();
            $result['data'][] = $acInfo;
        } else {
            $result["status"] = "no";
            $result["result"] = "No Such AC Found";
        }

        $app->response->body(json_encode($result));
    }
);

$app->put("/Customer/:id/AC/:ac_id", function ($id, $ac_id) use ($app) {
        global $DB;
        $result = array();
        $result = array("status" => "ok", "result" =>
            "You updated AC $id info for $ac_id");
        $app->response->body(json_encode($result));
    }
);

$app->delete("/Customer/:id/AC/:ac_id", function ($id, $ac_id) use ($app) {
        global $DB;
        $result = array();
        $DB->query("DELETE FROM `" . TAB_CUSTOMER_AC .
            "` WHERE `ac_id`='$ac_id' and `cust_id`='$id'");
        if ($DB->affected_rows > 0) {
            $result = array("status" => "ok", "result" => "You deleted AC $id info for $ac_id");
        } else {
            $result = array("status" => "no", "result" => "Product Not found");
        }


        $app->response->body(json_encode($result));
    }
);

/** View Customer Info  ***/

$app->get("/Customer/:id/AC", function ($id) use ($app) {
        global $DB;
        $result = array();
        $qry = $DB->query("SELECT * FROM `" .
            TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" .
            TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND cust_ac.`cust_id`='{$id}'");
        if ($qry->num_rows > 0) {

            $result['status'] = "ok";
            while ($data = $qry->fetch_assoc()) {
                $result["data"][] = $data;
            }
        } else {
            $result = array("status" => 'no', "result" =>
                "No AC has been added yet for this customer. ");
        }
        $app->response->body(json_encode($result));
    }
);


/** ************ INSTALLATION ************ */

$app->get("/Customer/Installations", function ($cid) use ($app) {
        global $DB;
        $qry = $DB->query("SELECT * FROM `" . TAB_INSTALL .
            "` WHERE `enabled`='1'");
        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $result['data'][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No Installation added yet");
        }
        $app->response->body(json_encode($result));
    }
);

$app->get("/Customer/:cid/Installations", function ($cid) use ($app) {
        global $DB;
        $qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cad
    INNER JOIN (SELECT `install_id`, `cust_id` , `ac_id` as ins_ac_id, `install_type`, `preferred_date`, `no_of_service`, `remarks` as install_remarks, `enabled`, `created_on` FROM `" .
            TAB_INSTALL . "`) as install
,(SELECT ac_type as actype,`ac_type_id` FROM `" . TAB_AC_TYPE . "`) as ac_type ,
(SELECT make_id,make as brand_name FROM `" . TAB_AC_MAKE . "`) as ac_make,`" .
            TAB_AC_LOCATION . "` as acloc,`" . TAB_AC_TONNAGE . "` as ac_ton
WHERE install.`cust_id`='$cid' and install.`ins_ac_id` = cad.`ac_id` and cad.`make`=ac_make.`make_id`
 and acloc.`ac_location_id`=cad.`ac_location`  and ac_type.`ac_type_id` = cad.`ac_type` and ac_ton.`tonnage_id`=cad.capacity and install.`enabled`='1' ") or
        ThrowError($DB->error);
        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $info['preferred_date'] = ConvertToIST($info['preferred_date']);
                $info['created_on'] =
                    ConvertToIST($info['created_on']);
                $result['data'][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No Installation added yet");
        }
        $app->response->body(json_encode($result));
    }
);

$app->post("/Customer/:cid/Installations", function ($cid) use ($app) {
        global $DB;
        if ($cid > 0) {
            $ac_id = $app->request->post("ac_id");
            $ins_type = $app->request->post("ins_type");
            $no_of_service = $app->request->post("no_of_service");
            $ins_date = $app->
            request->post("ins_date");
            $ins_date = date("Y-m-d", strtotime($ins_date));
            $remarks =
                $app->request->post("remarks");
            if (!empty($ac_id) && !empty($ins_type) && !
                empty($no_of_service) && !empty($ins_date)
            ) {
                $qry = $DB->query("SELECT `install_id` FROM `" . TAB_INSTALL .
                    "` WHERE `cust_id`='$cid' AND `ac_id`='$ac_id'") or ThrowError($DB->error);
                if ($qry->
                    num_rows > 0
                ) {
                    ThrowError("This customer has already requested this AC for installation");
                } else {

                    $DB->query("INSERT INTO `" . TAB_INSTALL .
                        "`(`cust_id`, `ac_id`, `install_type`, `preferred_date`, `no_of_service`,`remarks`)
                    VALUES('$cid','$ac_id','$ins_type','$ins_date','$no_of_service','$remarks')") or
                    ThrowError($DB->error);

                    if ($DB->affected_rows > 0) {
                        $result['status'] = "ok";
                        $result['result'] = "Successfully Added";
                        $app->status(201);

                        $last = $DB->insert_id;
                        $DB->query("INSERT INTO `" . TAB_INSTALL_SERVICE .
                            "` (`cust_id`,`type`,`install_id`,`date`) VALUES ('$cid','installation','$last','$ins_date')");

                        $service_dates = getServiceDates("installation", $no_of_service, $ins_date);
                        for ($s = 0; $s < count($service_dates); $s++) {
                            $DB->query("INSERT INTO `" . TAB_INSTALL_SERVICE .
                                "` (`cust_id`,`type`,`install_id`,`date`) VALUES ('$cid','ins_service','$last','$service_dates[$s]')");
                        }

                        $app->response->body(json_encode($result));
                    } else {
                        ThrowError("Unable to create. Error occurred");
                    }
                }
            } else {
                ThrowMissing();
            }
        } else {
            ThrowError("Invalid Customer!");
        }
    }
);

$app->get("/Customer/:cid/Installations/:id", function ($cid, $id) use ($app) {
        global $DB;
        $qry = $DB->query("SELECT * FROM `" . TAB_INSTALL .
            "` WHERE `cust_id`='$cid' AND `install_id`='$id' AND `enabled`='1'") or
        ThrowError($DB->error);
        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $result['data'][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No Installation added yet");
        }
        $app->response->body(json_encode($result));
    }
);

$app->put("/Customer/:cid/Installations/:id", function ($cid, $id) use ($app) {
        global $DB;
    }
);

$app->delete("/Customer/:cid/Installations/:id", function ($cid, $id) use ($app) {
        global $DB;
        $DB->query("DELETE FROM `" . TAB_INSTALL . "` WHERE `cust_id`='$cid' and `install_id`='$id'") or
        ThrowError($DB->error);
        if ($DB->affected_rows > 0) {
            $result = array("status" => "ok", "result" => "You deleted AC ");
        } else {
            $result = array("status" => "no", "result" =>
                "Unable to delete. Please try again");
        }

        $app->response->body(json_encode($result));
    }
);

/** ************ AMC ************ */

$app->get("/Customer/AMC", function ($cid) use ($app) {
        global $DB;
    }
);
$app->get("/Customer/:cid/AMC", function ($cid) use ($app) {
        global $DB;
        $qry = $DB->query("SELECT * FROM `" . TAB_AMC . "` WHERE `cust_id`='$cid'");
        if ($qry->num_rows > 0) {
//$result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {

                $q = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC .
                    "` as cust_ac INNER JOIN `" . TAB_AC_TYPE . "` as ac_type, `" . TAB_AC_MAKE .
                    "` as make,
                                            `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_LOCATION .
                    "` as loc WHERE ac_type.`ac_type_id`=cust_ac.`ac_type` AND cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.`ac_id`='{$info['ac_id']}'") or
                ThrowError($DB->error);
                if ($q->num_rows > 0) {
                    $data = $q->fetch_assoc();
                    $info['activation'] = ConvertToIST($info['activation']);
                    $info['expiration'] = ConvertToIST($info['expiration']);
                    $data = array_merge($data,
                        $info);
                    $result['data'][] = $data;
                    $result['status'] = "ok";
                } else {
                    $result['status'] = "no";
                    $result['data'][] = "AC NOT FOUND FOR {$info['ac_id']}";
                }


            }
        } else {
            $result = array("status" => "no", "result" => "No AMC added yet");
        }
        $app->response->body(json_encode($result));
    }
);
$app->post("/Customer/:cid/AMC", function ($cid) use ($app) {
        global $DB;
        $result = array();
        if ($cid > 0) {

            $qry = $app->request->post("row");
            $insert = 0;
            $total = count($qry);
            for ($i = 0; $i < $total; $i++) {
                $cid = $DB->real_escape_string($qry[$i]["cust_id"]);
                $ac_id = $DB->
                real_escape_string($qry[$i]["ac_id"]);
                $amc_type = $DB->real_escape_string($qry[$i]["service_type"]);
                $dry = $DB->real_escape_string($qry[$i]["dry_service"]);
                $wet = $DB->
                real_escape_string($qry[$i]["wet_service"]);
                $no_of_service = $dry + $wet;
//$activation =$DB->real_escape_string($qry[$i]["amc_datepicker"]);
                $activation = ConvertFromIST($DB->real_escape_string($qry[$i]["amc_datepicker"]));
                $expiration = date('Y-m-d', strtotime('+364 day', strtotime($activation)));
                $remarks = $DB->real_escape_string($qry[$i]["amc_remarks"]);
                $DB->
                query("INSERT INTO `" . TAB_AMC .
                    "`(`cust_id`,`ac_id`,`amc_type`,`dry`,`wet`,`no_of_service`,`activation`,`expiration`,`remarks`)
            VALUES('$cid','$ac_id','$amc_type','$dry','$wet','$no_of_service','$activation','$expiration','$remarks')");
                if ($DB->affected_rows > 0) {
                    $insert++;
                }
                $last = $DB->insert_id;
                $service_dates = getServiceDates("amc", $no_of_service, $activation);
                for ($s = 0; $s < count($service_dates); $s++) {
                    $DB->query("INSERT INTO `" . TAB_AMC_SERVICE .
                        "` (`cust_id`,`amc_id`,`date`) VALUES ('$cid','$last','$service_dates[$s]')");
                }


            }
            if ($insert == 0) {
                $result = array("status" => "no", "result" => "Error occurred while adding data");
            } else if ($i == $total) {
                $app->status(201);
                $result = array(
                    "status" => "ok",
                    "result" => "Successfully added",
                    "last_id" => $DB->insert_id);
            } else if ($i > 0 && $i < $total) {
                $result = array("status" => "ok", "result" =>
                    "Data inserted but with some errors");
            }


        } else {
            $result = array("status" => "no", "result" => "Invalid Customer ID Passed");
        }
        $app->response->body(json_encode($result));
    }
);
$app->get("/Customer/:cid/AMC/:id", function ($cid, $id) use ($app) {
        global $DB;
        $qry = $DB->query("SELECT * FROM `" . TAB_AMC . "` WHERE `cust_id`='$cid' AND `amc_id`='$id' AND `enabled`='1'") or
        ThrowError($DB->error);
        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $result['data'][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No AMC added yet");
        }
        $app->response->body(json_encode($result));
    }
);
$app->put("/Customer/:cid/AMC/:id", function ($cid, $id) use ($app) {
        global $DB;
    }
);
$app->delete("/Customer/:cid/AMC/:id", function ($cid, $id) {
        global $DB;
        $DB->query("DELETE FROM `" . TAB_AMC . "` WHERE `cust_id`='$cid' and `amc_id`='$id'");
        if ($DB->affected_rows > 0) {
            $result = array("status" => "ok", "result" => "You deleted AMC ");
        } else {
            $result = array("status" => "no", "result" =>
                "Unable to delete. Please try again");
        }
    }
);

/** ************ OTS ************ */

$app->get("/Customer/OTS", function ($cid) use ($app) {
        global $DB;
        $qry = $DB->query("SELECT * FROM `" . TAB_OTS .
            "` WHERE `enabled`='1'");
        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $result['data'][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No OTS added yet");
        }
        $app->response->body(json_encode($result));
    }
);
$app->get("/Customer/:cid/OTS", function ($cid) use ($app) {
        global $DB;
        $qry = $DB->query("SELECT * FROM `" . TAB_OTS .
            "` as ots,(SELECT ac_type as actype,`ac_type_id` FROM `" . TAB_AC_TYPE .
            "`) as ac_type ,
                        (SELECT make_id,make as brand_name FROM `" . TAB_AC_MAKE .
            "`) as ac_make,`" . TAB_AC_LOCATION . "` as acloc INNER JOIN `" .
            TAB_CUSTOMER_AC . "` as cad,`" . TAB_AC_TONNAGE . "` as ac_ton
WHERE ots.`cust_id`='$cid' and ots.`ac_id` = cad.`ac_id` and cad.`make`=ac_make.`make_id`
 and acloc.`ac_location_id`=cad.`ac_location`  and ac_type.`ac_type_id` = cad.`ac_type` and ac_ton.`tonnage_id`=cad.capacity and ots.`enabled`='1'");
        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $info['created_on'] = ConvertToIST($info['created_on']);
                $result['data'][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No OTS added for this customer");
        }

        $app->response->body(json_encode($result));
    }
);
$app->post("/Customer/:cid/OTS", function ($cid) use ($app) {

        global $DB;
        $ac_id = $DB->real_escape_string($app->request->post("ac_id"));
        $service_type =
            $DB->real_escape_string($app->request->post("service_type"));
        $date = $DB->
        real_escape_string($app->request->post("p_date"));
        $date = ConvertFromIST($date);
        $desc = $DB->real_escape_string($app->request->post("desc"));
        if ($ac_id > 0 &&
            $service_type != ""
        ) {

            $DB->query("INSERT INTO `" . TAB_OTS .
                "`(`cust_id`,`ac_id`,`service_type`,`description`,`preferred_date`)
         VALUES('$cid','$ac_id','$service_type','$desc','$date')") or ThrowError
            ($DB->error);
            if ($DB->affected_rows > 0) {
                $result['status'] = "ok";
                $result['result'] = "Successfully added";
                $app->
                status(201);
                $app->response->body(json_encode($result));
            } else {
                ThrowError("Unable to add. Error occurred");
            }
        } else {
            ThrowMissing();
        }
    }
);


$app->get("/Customer/:cid/OTS/:id", function ($cid, $id) use ($app) {
        global $DB;
        $qry = $DB->query("SELECT * FROM `" . TAB_OTS . "` WHERE `cust_id`='$cid' AND `ots_id`='$id' AND `enabled`='1'");
        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $result['data'][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No such OTS found");
        }
        $app->response->body(json_encode($result));
    }
);
$app->put("/Customer/:cid/OTS/:id", function ($cid, $id) use ($app) {
        global $DB;
    }
);
$app->delete("/Customer/:cid/OTS/:id", function ($cid, $id) use ($app) {
        global $DB;
        $DB->query("DELETE FROM `" . TAB_OTS . "` WHERE `cust_id`='$cid' and `ots_id`='$id'") or
        ThrowError($DB->error);
        if ($DB->affected_rows > 0) {
            $result = array("status" => "ok", "result" => "You deleted OTS ");
        } else {
            $result = array("status" => "no", "result" =>
                "Unable to delete. Please try again");
        }
        $app->response->body(json_encode($result));
    }
);


$app->put("/Customer/:cid/Installation/Service", function ($id) use ($app) {
    global $DB;
    $result = array();
    if ($id > 0) {
        $qry = $app->request->put("row");
        $insert = 0;
        $total = count($qry);
        for ($i = 0; $i < $total; $i++) {
            $date = $DB->real_escape_string($qry[$i]["date"]);
            $date = ConvertFromIST($date);
            $remarks = $DB->real_escape_string($qry[$i]["remarks"]);
            $service_id = $DB->real_escape_string($qry[$i]["service_id"]);
            $DB->query("UPDATE `" . TAB_INSTALL_SERVICE . "` SET `date`='$date',`remarks`='$remarks' WHERE `install_service_id`='$service_id'");
            if ($DB->affected_rows > 0) {
                $insert++;
            }
        }
        if ($insert == 0) {
            $result = array("status" => "no", "result" => "Error occurred while adding data");
        } else if ($i == $total) {
            $app->status(201);
            $result = array("status" => "ok", "result" =>
                "Successfully added");
        } else if ($i > 0 && $i < $total) {
            $result = array("status" => "ok", "result" =>
                "Data inserted but with some errors");
        }

    } else {
        $result = array("status" => "no", "result" => "Invalid Customer ID Passed");
    }
    $app->response->body(json_encode($result));
});

$app->put("/Customer/:cid/AMC_Service", function ($id) use ($app) {
    global $DB;
    $result = array();
    if ($id > 0) {
        $qry = $app->request->put("row");
        $insert = 0;
        $total = count($qry);
        for ($i = 0; $i < $total; $i++) {
            $date = $DB->real_escape_string($qry[$i]["date"]);
            $date = ConvertFromIST($date);
            $remarks = $DB->real_escape_string($qry[$i]["remarks"]);
            $service_id = $DB->real_escape_string($qry[$i]["service_id"]);
            $DB->query("UPDATE `" . TAB_AMC_SERVICE . "` SET `date`='$date',`remarks`='$remarks' WHERE `amc_service_id`='$service_id'") or ThrowError($DB->error);
            if ($DB->affected_rows > 0) {
                $insert++;
            }
        }
        if ($insert == 0) {
            $result = array("status" => "no", "result" => "Error occurred while adding data");
        } else if ($i == $total) {
            $app->status(201);
            $result = array("status" => "ok", "result" =>
                "Successfully added");
        } else if ($i > 0 && $i < $total) {
            $result = array("status" => "ok", "result" =>
                "Data inserted but with some errors");
        }

    } else {
        $result = array("status" => "no", "result" => "Invalid Customer ID Passed");
    }
    $app->response->body(json_encode($result));
});
/** ************ COMPLAINTS ************ */

$app->get("/Customer/Complaints", function ($cid) use ($app) {
        global $DB;
        $qry = $DB->query("SELECT * FROM `" . TAB_COMPLAINT .
            "` WHERE `enabled`='1'");
        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $result['data'][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "No Complaints added yet");
        }
        $app->response->body(json_encode($result));
    }
);
$app->get("/Customer/:cid/Complaints", function ($cid) use ($app) {
        global $DB;
        $qry = $DB->query("SELECT * FROM `" . TAB_COMPLAINT .
            "`as complaint,(SELECT ac_type as actype,`ac_type_id` FROM `" . TAB_AC_TYPE .
            "`) as ac_type ,
                        (SELECT make_id,make as brand_name FROM `" . TAB_AC_MAKE .
            "`) as ac_make,`" . TAB_AC_LOCATION .
            "` as acloc,`problem_type` as pt INNER JOIN `" . TAB_CUSTOMER_AC . "` as cad,`" .
            TAB_AC_TONNAGE . "` as ac_ton
WHERE complaint.`cust_id`='$cid' and complaint.`ac_id` = cad.`ac_id` and cad.`make`=ac_make.`make_id` and ac_ton.`tonnage_id`=cad.capacity
 and acloc.`ac_location_id`=cad.`ac_location`  and ac_type.`ac_type_id` = cad.`ac_type` and complaint.`enabled`='1' and pt.`ac_problem_id`=complaint.`problem_type`");
        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
                $info['created_on'] = ConvertToIST($info['created_on']);
                $result['data'][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" =>
                "No Complaints added for this customer");
        }
        $app->response->body(json_encode($result));
    }
);
$app->post("/Customer/:cid/Complaints", function ($cid) use ($app) {
        global $DB;
        if ($cid > 0) {
            $ac_id = $app->request->post("ac_id");
            $problem_type = $app->request->post("problem_type");
            $problem_desc = $app->request->post("problem_desc");
            $date = $app->request->
            post("p_date");
            $date = ConvertFromIST($date);
            if (!empty($ac_id) && !empty($problem_type)) {

                $qry = $DB->query("SELECT `com_id` FROM `" . TAB_COMPLAINT .
                    "` WHERE `cust_id`='$cid' AND `ac_id`='$ac_id'") or ThrowError($DB->error);
                if ($qry->
                    num_rows > 0
                ) {
                    ThrowError("Complaint already registered for this AC");
                } else {
                    $DB->query("INSERT INTO `" . TAB_COMPLAINT .
                        "`(`cust_id`, `ac_id`,`problem_type`, `problem_desc`,`preferred_date`)
        VALUES('$cid','$ac_id','$problem_type','$problem_desc','$date')") or
                    ThrowError($DB->error);
                    if ($DB->affected_rows > 0) {
                        $result['status'] = "ok";
                        $result['result'] = "Successfully Added";
                        $app->
                        status(201);
                        $app->response->body(json_encode($result));
                    } else {
                        ThrowError("Unable to create. Error occurred");
                    }
                }
            } else {
                ThrowMissing();
            }
        } else {
            ThrowError("Invalid Customer!");
        }
    }
);
$app->get("/Customer/:cid/Complaints/:id", function ($cid, $id) use ($app) {
        global $DB;
    }
);
$app->put("/Customer/:cid/Complaints/:id", function ($cid, $id) use ($app) {
        global $DB;
    }
);
$app->delete("/Customer/:cid/Complaints/:id", function ($cid, $id) use ($app) {
        global $DB; //$DB->query("UPDATE `".TAB_COMPLAINT."` SET `enabled`='2'  WHERE `cust_id`='$cid' and `com_id`='$id'") or ThrowError($DB->error);
        $DB->query("DELETE  FROM `" . TAB_COMPLAINT . "` WHERE `cust_id`='$cid' and `com_id`='$id'");
        if ($DB->affected_rows > 0) {
            $result = array("status" => "ok", "result" => "You deleted Complaint ");
        } else {
            $result = array("status" => "no", "result" =>
                "Unable to delete. Please try again");
        }
        $app->response->body(json_encode($result));
    }
);

/** **********PENDING AC*************/

$app->get("/Customer/:cid/AC/Pending/All", function ($cid) use ($app) {
        global $DB;
        $result = array("status" => "ok");
        $ins_qry = $DB->query("SELECT * FROM `" .
            TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" .
            TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
cust_ac.ac_id NOT IN(SELECT ac_id FROM  `installation` as ins WHERE ins.cust_id='{$cid}' ) 
AND cust_ac.`cust_id`='{$cid}' ");
        if ($ins_qry->num_rows > 0) {
            $result["data"]["installations"]["empty"] = false;
            while ($info = $ins_qry->
            fetch_assoc()) {
                $result["data"]["installations"][] = $info;
            }
        } else {
            $result["data"]["installations"]["empty"] = true;
        }
        $ins_qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC .
            "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" .
            TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
cust_ac.ac_id NOT IN(SELECT ac_id FROM  `installation` as ins WHERE ins.cust_id='{$cid}' ) 
AND cust_ac.`cust_id`='{$cid}' ");
        if ($ins_qry->num_rows > 0) {
            $result["data"]["installations"]["empty"] = false;
            while ($info = $ins_qry->
            fetch_assoc()) {
                $result["data"]["installations"][] = $info;
            }
        } else {
            $result["data"]["installations"]["empty"] = true;
        }


        $ins_qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC .
            "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" .
            TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
cust_ac.ac_id NOT IN(SELECT ac_id FROM  `" . TAB_INSTALL .
            "` as ins WHERE ins.cust_id='{$cid}' )
AND cust_ac.`cust_id`='{$cid}' ");
        if ($ins_qry->num_rows > 0) {
            $result["data"]["installations"]["empty"] = false;
            while ($info = $ins_qry->
            fetch_assoc()) {
                $result["data"]["installations"][] = $info;
            }
        } else {
            $result["data"]["installations"]["empty"] = true;
        }

        /*
        $amc_qry = $DB->query("SELECT * FROM `" .
        TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" .
        TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND
        cust_ac.ac_id NOT IN(SELECT ac_id FROM  `amc` as ins WHERE ins.cust_id='{$cid}' )
        AND cust_ac.`cust_id`='{$cid}' "); if ($ins_qry->num_rows > 0)
        {
        $result["data"]["installations"]["empty"] = false; while ($info = $ins_qry->fetch_assoc())
        {
        $result["data"]["installations"][] = $info; }
        }
        else
        {
        $result["data"]["installations"]["empty"] = true;
        }*/

        $app->response->body(json_encode($result));
    }
);

$app->get("/Customer/:cid/Service/:id/:type", function ($cid, $id, $type) use ($app) {
        global $DB;
        if ($type == "amc") {
            $qry = $DB->query("SELECT * FROM `" . TAB_AMC_SERVICE . "` WHERE `cust_id`='$cid' and `amc_id`='$id'");
        } else if ($type == "install") {
            $qry = $DB->query("SELECT * FROM `" . TAB_INSTALL_SERVICE . "` WHERE `cust_id`='$cid' and `install_id`='$id'");
        }
        if ($qry->num_rows > 0) {

            while ($info = $qry->fetch_assoc()) {
                $info['date'] = ConvertToIST($info['date']);
                $result['data'][] = $info;
            }
            $result['status'] = "ok";
        } else {
            $result['status'] = "no";
            $result['result'] = "No Service date found";
        }
        $app->response->body(json_encode($result));
    }
);


/********** UNINSTALLED AC ***************/


$app->get("/Customer/:cid/Uninstalled", function ($cid) use ($app) {
        global $DB;


    $check_ac=$DB->query("SELECT * FROM `".TAB_CUSTOMER_AC."` as cust
        WHERE cust.`cust_id`='{$cid}' AND cust.ac_id NOT IN (SELECT `ac_id` as ac FROM `".TAB_INSTALL."` where `cust_id`='{$cid}')") or  ThrowError($DB->error);
    if($check_ac->num_rows>0) {
        $qry = $DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cad
    INNER JOIN (SELECT ac_type as actype,`ac_type_id` FROM `" . TAB_AC_TYPE . "`) as ac_type ,
(SELECT make_id,make as brand_name FROM `" . TAB_AC_MAKE . "`) as ac_make,`" .
            TAB_AC_LOCATION . "` as acloc,`" . TAB_AC_TONNAGE . "` as ac_ton
WHERE  cad.cust_id='$cid'  and cad.`make`=ac_make.`make_id`
 and acloc.`ac_location_id`=cad.`ac_location`  and ac_type.`ac_type_id` = cad.`ac_type` and ac_ton.`tonnage_id`=cad.capacity  ") or
        ThrowError($DB->error);
        if ($qry->num_rows > 0) {
            $result = array("status" => "ok");
            while ($info = $qry->fetch_assoc()) {
             /*   $status_qry=$DB->query("SELECT `install_service_id` FROM `".TAB_INSTALL_SERVICE."` as ins_service INNER JOIN
                (select `assign_id` FROM `".TAB_ASSIGN."` WHERE `type`='installation' AND `cust_id`='$cid') as assign WHERE ins_service.`cust_id`='$cid'
                AND assign.`assign_id`=ins_service.`install_service_id`") or ThrowError($DB->error);
                if($status_qry->num_rows>0)*/
                $result['data'][] = $info;
            }
        } else {
            $result = array("status" => "no", "result" => "All AC Added for the installation");
        }
    }else{
        $result = array("status" => "no", "result" => "No AC Available for installation ");
    }
        $app->response->body(json_encode($result));
    }
);
