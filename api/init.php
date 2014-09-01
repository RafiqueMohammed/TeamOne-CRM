<?php
$app->get('/', function () use ($app) {

    $app->status(401);
    $app->response->body(json_encode(array("status" => "no", "result" => "You are not authenticated")));

});


$app->notFound(function () use ($app) {
    $app->halt(404, json_encode(array("status" => "no", "result" => "No Request Found")));
});


$app->get('/test', function () {
    $ar = array("health" => array("#FFCCBB", "#55CCBB", "#2211FF"), "relationship" => array("#1FFCBB", "#F9CCBB", "#992BCC"),
        "finance" => array("#FFCC00", "#559922", "#929b9C"));
    global $app;
    $app->response->body(json_encode($ar));
});


$app->hook('slim.before', function () use ($app) {
    global $DB;
    if ($DB->connect_error) {

        $app->halt(503, json_encode(array("status" => "no", "result" => "#SD500 Database server is down. We will be back soon. Inconvenience are regretted")));
    }
});