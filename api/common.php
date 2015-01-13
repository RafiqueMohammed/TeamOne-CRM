<?php
session_start();
ob_start();
date_default_timezone_set("Asia/Kolkata");
require_once("../include/config.php");

require_once(SLIM_DIR . "Slim.php");
require_once('cfg/functions.php');
/**
 * Created by  Rafique
 * Date: 6/21/14
 * Time: 1:18 PM
 */

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->response['Content-Type'] = 'application/json';

$app->get('/', function () use ($app) {

    $app->status(401);
    $app->response->body(json_encode(array("status" => "no", "result" => "Invalid Request Made")));

});


$app->notFound(function () use ($app) {
    $app->halt(404, json_encode(array("status" => "no", "result" => "No Request Found")));
});


$app->hook('slim.before', function () use ($app) {
    global $DB;
    if ($DB->connect_error) {

        $app->halt(503, json_encode(array("status" => "no", "result" => "#SD500 Database server is down. We will be back soon. Inconvenience are regretted")));
    }


});
$app->hook("slim.before.router", function () use ($app) {
    if (strpos($app->request()->getPathInfo(), "/Manage") === 0) {
        require_once('Manage.php');
    } else if (strpos($app->request()->getPathInfo(), "/Customer") === 0) {
        require_once('Customer.php');
    } else if (strpos($app->request()->getPathInfo(), "/Search") === 0) {
        require_once('Search.php');
    } else if (strpos($app->request()->getPathInfo(), "/Technicians") === 0) {
        require_once('Technicians.php');
    } else if (strpos($app->request()->getPathInfo(), "/Staff") === 0) {
        require_once('Staff.php');
    } else if (strpos($app->request()->getPathInfo(), "/Assign") === 0) {
        require_once('Assign.php');
    } else if (strpos($app->request()->getPathInfo(), "/Tickets") === 0) {
        require_once('Tickets.php');
    } else if (strpos($app->request()->getPathInfo(), "/Reports") === 0) {
        require_once('Reports.php');
    } else if (strpos($app->request()->getPathInfo(), "/LinkedAccount") === 0) {
        require_once('LinkedAccount.php');
    } else if (strpos($app->request()->getPathInfo(), "/Compose") === 0) {
        require_once('Compose.php');
    } else {
        require_once('index.php');  // default routes
    }
});

function ThrowError($msg)
{
    global $app;
    $app->halt(200, json_encode(array("status" => "no", "result" => $msg)));
}

function ThrowMissing()
{
    global $app;
    $app->halt(200, json_encode(array("status" => "no", "result" => "Missing Required Field")));
}

function ThrowInvalid()
{
    global $app;
    $app->halt(200, json_encode(array("status" => "no", "result" => "Invalid Request")));
}






