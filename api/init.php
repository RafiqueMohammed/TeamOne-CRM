<?php
$app->get('/', function () use ($app) {

    $app->status(401);
    $app->response->body(json_encode(array("status" => "no", "result" => "You are not authenticated")));

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