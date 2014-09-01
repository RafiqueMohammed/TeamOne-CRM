<?php
require_once("common.php");

$app->get("/Search/:str",function($str) use($app){
global $DB;
    $check=trim(str_replace(array(" ","-","+"),"",$str));
    if(is_numeric($check)){

$qry=$DB->query("SELECT * FROM `".TAB_CUSTOMER."` WHERE `mobile`='$str' "); //OR `alternate_mobile` LIKE '%$str%'

        if($qry->num_rows>0){
            $result = array("status" => "ok");
            while($info=$qry->fetch_assoc()){
                $result["data"][]=$info;
            }
        }else{
            $result = array("status" => "no", "result" => "No customer found. Try something else..");
        }


    }else if(strpos("place",$str)){
        $result = array("status" => "ok", "result" => "String search");
    }else if(strpos("company",$str)){
        $result = array("status" => "ok", "result" => "String search");
    }else if(strpos("name",$str)){
        $result = array("status" => "ok", "result" => "String search");
    }else{

$qry=$DB->query("SELECT * FROM `".TAB_CUSTOMER."` WHERE `organisation` LIKE '%$str%' "); //OR `alternate_mobile` LIKE '%$str%'

        if($qry->num_rows>0){
            $result = array("status" => "ok");
            while($info=$qry->fetch_assoc()){
                $result["data"][]=$info;
            }
        }else{
            $result = array("status" => "no", "result" => "No customer found. Try something else..2");
        }


    }
$app->response->body(json_encode($result));
});
