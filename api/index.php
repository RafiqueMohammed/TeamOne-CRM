<?php
require_once("common.php");

$app->post("/Login",function()use($app){
    global $DB;
    $username=$app->request->post("username",false);
    $password=$app->request->post("password",false);

    if($username!=false&&$password!=false){
$qry=$DB->query("SELECT `staff_id`,`first_name`,`last_name`,`email`,`branch`,`isAdmin` FROM `".TAB_STAFF."` WHERE `email`='$username' AND `password`='$password'");
   if($qry->num_rows==1){
       $result=$qry->fetch_assoc();

       require_once("../controller/class.staff.php");
       $staff=new controller\staff\Staff($DB);
       $data=array();
       $data['AuthID']=$result['staff_id'];
       $data['isAdmin']=$result['isAdmin'];
       $data['Logged']=1;
       $data['Username']=$result['email'];
       $data['FullName']=$result['first_name']." ".$result['last_name'];
       $staff->setStaff($data);

$app->response->body(json_encode(array("status"=>"ok","result"=>"Success")));
   }else{
       ThrowError("Invalid username/password");
   }
    }else{
        ThrowMissing();
    }
});

$app->get("/Stats/Counts",function()use($app){
    global $DB;
    $qry=$DB->query("SELECT count(`com_id`) FROM `".TAB_COMPLAINT."` WHERE `email`='$username' AND `password`='$password'");
    if($qry->num_rows==1) {
    }
    });



$app->run();
