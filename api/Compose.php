<?php

require_once("common.php");
/**
 * Created by Rafique
 * Date: 8/5/14
 * Time: 6:08 PM
 */
$app->post("/Compose/SMS/Single", function () use ($app) {
    global $DB;
    $to = $app->request->post("to", false);
    $msg = $app->request->post("msg", false);
    if ($to && $msg) {
        $response = SendSMS($to, $msg);
        if (!$response['success']) {
            ThrowError("Error occured while sending message");
        } else {
            $result = array("status" => "ok", "result" => "Message Sent Successfully");
        }
    } else {
        ThrowMissing();
    }
    $app->response->body(json_encode($result));
});

$app->post("/Compose/SMS/Multiple", function () use ($app) {
    global $DB;
    $msg = $app->request->post("msg", false);
    if ($msg != false) {
        $failed = array();
        $qry = $DB->query("SELECT `mobile` FROM `" . TAB_CUSTOMER . "` WHERE `mobile`='9920727342'");
        if ($qry->num_rows > 0) {
            while ($data = $qry->fetch_assoc()) {
                $response = SendSMS($data['mobile'], $msg);
                if (!$response['success']) {
                    $failed[] = array("mobile" => $response['mobile'], "result" => $response['result']);
                }
            }
        } else {
            ThrowError("No mobile number found");
        }
    } else {
        ThrowMissing();
    }

    $result = array("status" => "ok", "result" => "Message Sent Successfully", "failed" => $failed);
    $app->response->body(json_encode($result));
});
$app->post("/Compose/Mail/Single", function () use ($app) {
    global $DB;
    $to = $app->request->post("to", false);
    $msg = $app->request->post("msg", false);
    $result = array("status" => "ok", "result" => "Message Sent Successfully");
    $app->response->body(json_encode($result));
});

$app->post("/Compose/Mail/Multiple", function () use ($app) {
    global $DB;
    $msg = $app->request->post("msg", false);
    $result = array("status" => "ok", "result" => "Message Sent Successfully");
    $app->response->body(json_encode($result));
});
?>