<?php
require_once("common.php");

$app->get("/Manage", function () use ($app) {
    global $DB;
    $result = array("status" => "ok");
    $b_qry = $DB->query("SELECT * FROM `" . TAB_AC_MAKE . "` ");
    $t_qry = $DB->query("SELECT * FROM `" . TAB_AC_TONNAGE . "` ");
    $l_qry = $DB->query("SELECT * FROM `" . TAB_AC_LOCATION . "` ");
    $a_qry = $DB->query("SELECT * FROM `" . TAB_AC_TYPE . "` ");
    if ($b_qry->num_rows > 0) {
        while ($info = $b_qry->fetch_assoc()) {
            $result['brand'][] = $info;
        }
        $result['brand']["empty"] = false;
    } else {
        $result['brand']["empty"] = true;
    }

    if ($t_qry->num_rows > 0) {
        while ($info = $t_qry->fetch_assoc()) {
            $result['tonnage'][] = $info;
        }
        $result['tonnage']["empty"] = false;
    } else {
        $result['tonnage']["empty"] = true;
    }

    if ($l_qry->num_rows > 0) {
        while ($info = $l_qry->fetch_assoc()) {
            $result['location'][] = $info;
        }
        $result['location']["empty"] = false;
    } else {
        $result['location']["empty"] = true;
    }
    if ($a_qry->num_rows > 0) {
        while ($info = $a_qry->fetch_assoc()) {
            $result['ac_type'][] = $info;
        }
        $result['ac_type']["empty"] = false;
    } else {
        $result['ac_type']["empty"] = true;
    }
    $app->response->body(json_encode($result));
});
/** Start Add Branch **/

$app->post("/Manage/Branch", function () use ($app) {

    global $DB;
    if (isset($_POST['branch']) && !empty($_POST['branch'])) {
        $branch = trim($_POST['branch']);
        $qry = $DB->query("SELECT * FROM `" . TAB_BRANCH . "` WHERE `branch_name`='$branch' ");

        if ($qry->num_rows > 0) {
            $result = array("status" => "no", "result" => "{$branch} already exist");
        } else {
            $DB->query("INSERT INTO `" . TAB_BRANCH . "`(`branch_name`) VALUES('$branch')");

            if ($DB->affected_rows > 0) {
                $app->status(201);
                $result = array("status" => "ok", "result" => "Successfully added", "last_id" => $DB->insert_id);
            } else {
                $result = array("status" => "no", "result" => "Unable to add <b>{$branch}</b>");
            }

        }
        $app->response->body(json_encode($result));
    } else {
        ThrowMissing();
    }


});


$app->delete("/Manage/Branch/:id", function ($id) use ($app) {
    global $DB;
    $DB->query("DELETE FROM `" . TAB_BRANCH . "`WHERE `branch_id` = '$id'");
    if ($DB->affected_rows > 0) {
        $result = array("status" => "ok", "result" => "Successfully Deleted");
    } else {
        $result = array("status" => "no", "result" => "Unable to delete");
    }
    $app->response->body(json_encode($result));
});
/** End Add Branch **/


/** ------------- AC Problem Type ------------- **/

$app->get("/Manage/Complaints/ProblemType", function () use ($app) {

    global $DB;

    $qry = $DB->query("SELECT * FROM `" . TAB_PROBLEM_TYPE . "` ");

    if ($qry->num_rows > 0) {
        $result["status"] = "ok";
        while ($info = $qry->fetch_assoc()) {
            $result['data'][] = $info;
        }
        $app->response->body(json_encode($result));
    } else {

        ThrowError("No Problem Type Found in Database");
    }


});

$app->post("/Manage/Complaints/ProblemType", function () use ($app) {

    global $DB;
    if (isset($_POST['problem_type']) && !empty($_POST['problem_type'])) {
        $problem_type = trim($_POST['problem_type']);
        $qry = $DB->query("SELECT * FROM `" . TAB_PROBLEM_TYPE . "` WHERE `ac_problem_type`='$problem_type' ");

        if ($qry->num_rows > 0) {
            $result = array("status" => "no", "result" => "{$problem_type} already exist");
        } else {
            $DB->query("INSERT INTO `" . TAB_PROBLEM_TYPE . "`(`ac_problem_type`) VALUES('$problem_type')");

            if ($DB->affected_rows > 0) {
                $app->status(201);
                $result = array("status" => "ok", "result" => "Successfully added", "last_id" => $DB->insert_id);
            } else {
                $result = array("status" => "no", "result" => "Unable to add <b>{$problem_type}</b>");
            }

        }
        $app->response->body(json_encode($result));
    } else {
        ThrowMissing();
    }


});

$app->delete("/Manage/Complaints/ProblemType/:id", function ($id) use ($app) {
    global $DB;
    $DB->query("DELETE FROM `" . TAB_PROBLEM_TYPE . "`WHERE `ac_problem_id` = '$id'");
    if ($DB->affected_rows > 0) {
        $result = array("status" => "ok", "result" => "Successfully Deleted");
    } else {
        $result = array("status" => "no", "result" => "Unable to delete");
    }
    $app->response->body(json_encode($result));
});

/** ------------- AC TYPE ------------- **/

$app->post("/Manage/AC/Type", function () use ($app) {

    global $DB;
    if (isset($_POST['ac_type']) && !empty($_POST['ac_type'])) {
        $ac_type = trim($_POST['ac_type']);
        $qry = $DB->query("SELECT * FROM `" . TAB_AC_TYPE . "` WHERE `ac_type`='$ac_type' ");

        if ($qry->num_rows > 0) {
            $result = array("status" => "no", "result" => "{$ac_type} already exist");
        } else {
            $DB->query("INSERT INTO `" . TAB_AC_TYPE . "`(`ac_type`) VALUES('$ac_type')");

            if ($DB->affected_rows > 0) {
                $app->status(201);
                $result = array("status" => "ok", "result" => "Successfully added", "last_id" => $DB->insert_id);
            } else {
                $result = array("status" => "no", "result" => "Unable to add <b>{$ac_type}</b>");
            }

        }
        $app->response->body(json_encode($result));
    } else {
        ThrowMissing();
    }

});

$app->delete("/Manage/AC/Type/:id", function ($id) use ($app) {
    global $DB;
    $DB->query("Delete FROM `" . TAB_AC_TYPE . "` WHERE `ac_type_id`='$id' ");
    if ($DB->affected_rows > 0) {
        $result = array("status" => "ok", "result" => "Successfully Deleted");
    } else {
        $result = array("status" => "no", "result" => "Unable to delete");

    }
    $app->response->body(json_encode($result));
});

/** ------------- REFERENCE ------------- **/

$app->post("/Manage/Customer/Reference", function () use ($app) {

    global $DB;
    if (isset($_POST['reference']) && !empty($_POST['reference'])) {
        $reference = trim($_POST['reference']);
        $qry = $DB->query("SELECT * FROM `" . TAB_REFERRED_BY . "` WHERE `name`='$reference' ");

        if ($qry->num_rows > 0) {
            $result = array("status" => "no", "result" => "{$reference} already exist");
        } else {
            $DB->query("INSERT INTO `" . TAB_REFERRED_BY . "`(`name`) VALUES('$reference')");

            if ($DB->affected_rows > 0) {
                $app->status(201);
                $result = array("status" => "ok", "result" => "Successfully added", "last_id" => $DB->insert_id);
            } else {
                $result = array("status" => "no", "result" => "Unable to add <b>{$reference}</b>");
            }

        }
        $app->response->body(json_encode($result));
    } else {
        ThrowMissing();
    }


});

$app->get("/Manage/Customer/Reference", function () use ($app) {
    global $DB;
    $qry = $DB->query("SELECT * FROM `" . TAB_REFERRED_BY . "` ");
    if ($qry->num_rows > 0) {
        while ($info = $qry->fetch_assoc()) {
            $result[] = $info;
        }
        $result["status"] = "ok";
    } else {
        $result = array("status" => "no", "result" => "No Data Found in the Database");
    }
    $app->response->body(json_encode($result));
});


$app->delete("/Manage/Customer/Reference/:id", function ($id) use ($app) {
    global $DB;
    $DB->query("Delete FROM `" . TAB_REFERRED_BY . "` WHERE `referred_id`='$id' ");
    if ($DB->affected_rows > 0) {
        $result = array("status" => "ok", "result" => "Successfully Deleted");
    } else {
        $result = array("status" => "no", "result" => "Unable to delete");

    }
    $app->response->body(json_encode($result));
});

/** ------------- AC LOCATION --------------- */

$app->post("/Manage/AC/location", function () use ($app) {

    global $DB;
    if (isset($_POST['location']) && !empty($_POST['location'])) {
        $location = trim($_POST['location']);
        $qry = $DB->query("SELECT * FROM `" . TAB_AC_LOCATION . "` WHERE `location`='$location' ");

        if ($qry->num_rows > 0) {
            $result = array("status" => "no", "result" => "{$location} already exist");
        } else {
            $DB->query("INSERT INTO `" . TAB_AC_LOCATION . "`(`location`) VALUES('$location')");

            if ($DB->affected_rows > 0) {
                $app->status(201);
                $result = array("status" => "ok", "result" => "Successfully added", "last_id" => $DB->insert_id);
            } else {
                $result = array("status" => "no", "result" => "Unable to add <b>{$location}</b>");
            }

        }
        $app->response->body(json_encode($result));
    } else {
        ThrowMissing();
    }


});

$app->get("/Manage/AC/location/:id", function ($id) use ($app) {
    global $DB;
    $qry = $DB->query("SELECT `tonnage` FROM `" . TAB_AC_TONNAGE . "` WHERE `id`='$id' ");
    if ($qry->num_rows > 0) {
        $result = array("status" => "ok");
        $info = $qry->fetch_assoc();
        $result[] = $info;
    } else {
        $result = array("status" => "no", "result" => "No Data Found in the Database");
    }
    $app->response->body(json_encode($result));
});

$app->get("/Manage/AC/location", function () use ($app) {
    global $DB;
    $qry = $DB->query("SELECT `tonnage` FROM `" . TAB_AC_TONNAGE . "` ");
    if ($qry->num_rows > 0) {
        while ($info = $qry->fetch_assoc()) {
            $result[] = $info;
        }
        $result["status"] = "ok";
    } else {
        $result = array("status" => "no", "result" => "No Data Found in the Database");
    }
    $app->response->body(json_encode($result));
});


$app->delete("/Manage/AC/location/:id", function ($id) use ($app) {
    global $DB;
    $DB->query("Delete FROM `" . TAB_AC_LOCATION . "` WHERE `ac_location_id`='$id' ");
    if ($DB->affected_rows > 0) {
        $result = array("status" => "ok", "result" => "Successfully Deleted");
    } else {
        $result = array("status" => "no", "result" => "Unable to delete");

    }
    $app->response->body(json_encode($result));
});

/** ------------- TONNAGE --------------- */

$app->post("/Manage/AC/Tonnage", function () use ($app) {

    global $DB;
    if (isset($_POST['tonnage']) && !empty($_POST['tonnage'])) {
        $tonnage = trim($_POST['tonnage']);
        $qry = $DB->query("SELECT * FROM `" . TAB_AC_TONNAGE . "` WHERE `tonnage`='$tonnage' ");

        if ($qry->num_rows > 0) {
            $result = array("status" => "no", "result" => "{$tonnage} ton already exist");
        } else {
            $DB->query("INSERT INTO `" . TAB_AC_TONNAGE . "`(`tonnage`) VALUES('$tonnage')");

            if ($DB->affected_rows > 0) {
                $app->status(201);
                $result = array("status" => "ok", "result" => "Successfully added", "last_id" => $DB->insert_id);
            } else {
                $result = array("status" => "no", "result" => "Unable to add into database ");
            }

        }
        $app->response->body(json_encode($result));
    } else {
        ThrowMissing();
    }


});

$app->get("/Manage/AC/Tonnage", function () use ($app) {

        global $DB;
        $qry = $DB->query("SELECT * FROM `" . TAB_AC_TONNAGE . "` ");

        if ($qry->num_rows > 0) {
            while ($info = $qry->fetch_assoc()) {
                $result[] = $info;
            }
            $result["status"] = "ok";
        } else {
            $result = array("status" => "no", "result" => "No Data Found in the Database");
        }
        $app->response->body(json_encode($result));
    }
);


$app->get("/Manage/AC/Tonnage/:id", function ($id) use ($app) {

    global $DB;
    $qry = $DB->query("SELECT * FROM `" . TAB_AC_TONNAGE . "` WHERE `tonnage_id`='$id' ");
    if ($qry->num_rows > 0) {
        $result = array("status" => "ok");
        $info = $qry->fetch_assoc();
        $result[] = $info;
    } else {
        $result = array("status" => "no", "result" => "No Data Found in the Database");
    }
    $app->response->body(json_encode($result));
});

$app->put("/Manage/AC/Tonnage/:id", function ($id) use ($app) {
    $req = $app->request;
    if ($req->put("tonnage") && !empty($id)) {
        $name = $req->put("tonnage");
        global $DB;
        $DB->query("UPDATE `" . TAB_AC_TONNAGE . "` SET `tonnage`='$name' WHERE `tonnage_id`='$id' ");
        if ($DB->affected_rows > 0) {
            $result = array("status" => "ok", "result" => "Successfully Updated");
        } else {
            $result = array("status" => "no", "result" => "Unable to update into database");

        }
        $app->response->body(json_encode($result));
    } else {
        ThrowMissing();
    }

});

$app->delete("/Manage/AC/Tonnage/:id", function ($id) use ($app) {
    global $DB;
    $DB->query("Delete FROM `" . TAB_AC_TONNAGE . "` WHERE `tonnage_id`='$id' ");
    if ($DB->affected_rows > 0) {
        $result = array("status" => "ok", "result" => "Successfully Deleted");
    } else {
        $result = array("status" => "no", "result" => "Unable to delete");
    }
    $app->response->body(json_encode($result));
});

/** ------------- MAKE  --------------- */

$app->post("/Manage/AC/Make", function () use ($app) {

    global $DB;
    if (isset($_POST['brand_name']) && !empty($_POST['brand_name'])) {
        $brand_name = ucfirst(trim($_POST['brand_name']));

        $qry = $DB->query("SELECT * FROM `" . TAB_AC_MAKE . "` WHERE `make`='$brand_name' ");

        if ($qry->num_rows > 0) {
            $result = array("status" => "no", "result" => "{$brand_name} already exist");
        } else {

            $DB->query("INSERT INTO `" . TAB_AC_MAKE . "`(`make`) VALUES('$brand_name')");

            if ($DB->affected_rows > 0) {
                $app->status(201);
                $result = array("status" => "ok", "result" => "{$brand_name} successfully added", "last_id" => $DB->insert_id);
            } else {
                $result = array("status" => "no", "result" => "Unable to add <b>{$brand_name}</b>");
            }
        }
        $app->response->body(json_encode($result));
    } else {
        ThrowMissing();
    }


});

$app->get("/Manage/AC/Make", function () use ($app) {

        global $DB;
        $qry = $DB->query("SELECT `make_id`,`make` FROM `" . TAB_AC_MAKE . "` ");

        if ($qry->num_rows > 0) {
            while ($info = $qry->fetch_assoc()) {
                $result[] = $info;
            }
            $result["status"] = "ok";
        } else {

            $result = array("status" => "no", "result" => "No Data Found in the Database");

        }

        $app->response->body(json_encode($result));
    }
);


$app->get("/Manage/AC/Make/:id", function ($id) use ($app) {

    global $DB;
    $qry = $DB->query("SELECT * FROM `" . TAB_AC_MAKE . "` WHERE `make_id`='$id' ");
    if ($qry->num_rows > 0) {
        $result = array("status" => "ok");
        $info = $qry->fetch_assoc();
        $result[] = $info;
        $app->response->body(json_encode($result));
    } else {
        ThrowError("No Data Found in the Database");
    }


});

$app->put("/Manage/AC/Make/:id", function ($id) use ($app) {
    $req = $app->request;
    if ($req->put("name") && !empty($id)) {
        $name = $req->put("name");
        global $DB;
        $DB->query("UPDATE `" . TAB_AC_MAKE . "` SET `make`='$name' WHERE `make_id`='$id' ");
        if ($DB->affected_rows > 0) {
            $result = array("status" => "ok", "result" => "Successfully Updated");
            $app->response->body(json_encode($result));
        } else {
            ThrowError("Unable to update into database");
        }

    } else {
        ThrowMissing();
    }


});

$app->delete("/Manage/AC/Make/:id", function ($id) use ($app) {
    global $DB;
    $DB->query("Delete FROM `" . TAB_AC_MAKE . "` WHERE `make_id`='$id' ");
    if ($DB->affected_rows > 0) {
        $result = array("status" => "ok", "result" => "Successfully Deleted");
    } else {
        $result = array("status" => "no", "result" => "Unable to delete");

    }
    $app->response->body(json_encode($result));
});

/** PINCODE  */

$app->get("/Manage/pincode/:pin", function ($pin) use ($app) {
    global $DB;
    $qry = $DB->query("SELECT * FROM `" . TAB_LOCALITY . "` WHERE `pincode` = '{$pin}'");
    $result = array();
    if ($qry->num_rows > 0) {

        $result['status'] = "ok";

        while ($data = $qry->fetch_assoc()) {
            $result[] = array("loc_id" => $data['locality_id'], "locality" => $data['locality_name'], "city" => $data['city']);
        }

    } else {
        $result['status'] = "no";
        $result['result'] = "No Such Pincode found";
    }
    $app->response->body(json_encode($result));

});

$app->get("/Manage/pincode/", function () use ($app) {
    global $DB;
    $qry = $DB->query("SELECT * FROM `" . TAB_LOCALITY . "`");
    $result = array();
    if ($qry->num_rows > 0) {

        $result['status'] = "ok";
        while ($info = $qry->fetch_assoc()) {
            $result['data'][] = $info;
        }
    } else {
        $result['status'] = "no";
        $result['result'] = "No Such Pincode found";
    }
    $app->response->body(json_encode($result));

});

/** Pincode **/

$app->get("/Manage/pin/:pincode", function ($pincode) use ($app) {
    global $DB;
    $qry = $DB->query("SELECT * FROM `" . TAB_LOCALITY . "` WHERE `pincode`='$pincode'");
    $result = array();
    if ($qry->num_rows > 0) {

        $result['status'] = "ok";
        while ($info = $qry->fetch_assoc()) {
            $result['data'][] = $info;
        }
    } else {
        $result['status'] = "no";
        $result['result'] = "No Such Pincode found";
    }
    $app->response->body(json_encode($result));

});

$app->post("/Manage/pin/", function () use ($app) {
    global $DB;
    if (isset($_POST['pincode']) && isset($_POST['landmark']) && !empty($_POST['pincode']) && !empty($_POST['pincode'])) {
        $pincode = $_POST['pincode'];
        $landmark = $_POST['landmark'];
        $qry = $DB->query("SELECT * FROM `" . TAB_LOCALITY . "` WHERE `pincode`='$pincode' and `locality_name`='$landmark'");
        if ($qry->num_rows > 0) {
            $result['status'] = "no";
            $result['result'] = "Landmark already added in masters";
        } else {
            $DB->query("INSERT INTO `" . TAB_LOCALITY . "`(`pincode`,`locality_name`) VALUES('$pincode','$landmark')");
            if ($DB->affected_rows > 0) {
                $result['status'] = "ok";
                $result['result'] = $DB->insert_id;
            } else {
                ThrowError("Unable to update into database");
            }
        }
    } else {
        $result['status'] = "no";
        $result['result'] = "Please provide the required fields";
    }
    $app->response->body(json_encode($result));
});

$app->delete("/Manage/pin/:id", function ($id) use ($app) {
    global $DB;
    $DB->query("Delete FROM `" . TAB_LOCALITY . "` WHERE `locality_id`='$id' ");
    if ($DB->affected_rows > 0) {
        $result = array("status" => "ok", "result" => "Successfully Deleted");
    } else {
        $result = array("status" => "no", "result" => "Unable to delete");

    }
    $app->response->body(json_encode($result));
});