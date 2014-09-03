<?php
/**
 * Created by Rafique
 * Date: 8/20/14
 * Time: 12:34 PM
 */
require_once("common.php");

/** ***********CUSTOMER ********* */

$app->get("/Assign/Customer",function() use($app){
global $DB;
    $qry=$DB->query("SELECT * FROM `".TAB_CUSTOMER."` as u_cust INNER JOIN (SELECT DISTINCT(`cust_id`) FROM `".TAB_CUSTOMER."` as cust
    INNER JOIN (SELECT DISTINCT (`cust_id`) as com_cust FROM `".TAB_COMPLAINT."`) as c,(SELECT DISTINCT (`cust_id`) as amc_cust FROM `".TAB_AMC."`) as amc,
    (SELECT DISTINCT (`cust_id`) as ots_cust FROM `".TAB_OTS."`) as ots,(SELECT DISTINCT (`cust_id`) as ins_cust
    FROM `".TAB_INSTALL."`) as i  WHERE cust.cust_id in (ots.ots_cust,i.ins_cust,amc.amc_cust,c.com_cust)) as distinct_cust where u_cust.cust_id=distinct_cust.cust_id") or ThrowError($DB->error);
    
    

    $result=array();
    if($qry->num_rows>0){
        $result['status']="ok";
        $result['data']=array();
        while($info=$qry->fetch_assoc()){
            $result['data'][]=$info;
        }
    }else{
        $result['status']="no";
        $result['result']="No Assignment Found";

    }
    $app->response->body(json_encode($result));

});

$app->get("/Assign/Customer/:id",function($cust_id) use($app){
    global $DB;
    $till=$app->request->get("till_date",date("Y-m-d",strtotime("+1 month")));

    $result=array();
    $result['status']="ok";

    $qry=$DB->query("SELECT `cust_id`,`account_type`,`first_name`,`last_name`,`email`,`organisation`,`location`,`mode_of_contact`,`alternate_mobile` FROM `".TAB_CUSTOMER."` WHERE `cust_id`='$cust_id'");
    if($qry->num_rows>0){
        while($info=$qry->fetch_assoc()){
            $result['data']['customer_info']=$info;
            $result['data']['customer_info']['empty']=false;
        }
    }else{
        $result['data']['customer_info']['empty']=true;
        $result['data']['customer_info']['result']="No Customer Found";
    }

    $amc_qry=$DB->query("SELECT * FROM `".TAB_AMC."` WHERE `cust_id`='$cust_id' ");
    if($amc_qry->num_rows > 0){
        $c=$d=0; //$c - total data , $d-total data with service date matched if $d is 0 then thr is no data
        while($info=$amc_qry->fetch_assoc()){

$service_qry=$DB->query("SELECT * FROM `".TAB_AMC_SERVICE."` WHERE `amc_id`='{$info['amc_id']}'
AND `date` < '$till' AND `amc_service_id` NOT IN (SELECT `type_id` FROM `".TAB_ASSIGN."` WHERE `type`='amc') ");

if($service_qry->num_rows>0){

    while($get=$service_qry->fetch_assoc()){
        $ac_info["service_info"][]=$get;

    $ac_qry=$DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND cust_ac.`ac_id`='{$info['ac_id']}'");
    $info['created_on']=ConvertToIST($info['created_on']);
    if($ac_qry->num_rows>0){
        $ac_info=$ac_qry->fetch_assoc();
$d=$d+1;
             $info=array_merge($info,$ac_info);
    }
    $result['data']['amc'][]=$info;
    }
}else{
  $c=$c+1;

}

        }

        if($d == 0){
            $result['data']['amc']['empty']=true;
            $result['data']['amc']['result']="No AMC Found";
        }else{
            $result['data']['amc']['empty']=false;
        }
    }else{
        $result['data']['amc']['empty']=true;
        $result['data']['amc']['result']="No AMC Found ";

    }

    $qry=$DB->query("SELECT * FROM `".TAB_OTS."` WHERE `cust_id`='$cust_id' AND `preferred_date` < '$till' ");

    if($qry->num_rows>0){
        while($info=$qry->fetch_assoc()){

            $ac_qry=$DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND cust_ac.`ac_id`='{$info['ac_id']}'");

            $info['created_on']=ConvertToIST($info['created_on']);
            if($ac_qry->num_rows>0){
                $ac_info=$ac_qry->fetch_assoc();
                $info=array_merge($info,$ac_info);
            }

            $result['data']['ots'][]=$info;
            $result['data']['ots']['empty']=false;
        }
    }else{
        $result['data']['ots']['empty']=true;
        $result['data']['ots']['result']="No One TimeService Found";

    }

    $qry=$DB->query("SELECT `install_id`, `cust_id`, `ac_id`, `install_type`, `preferred_date`, `no_of_service`,
    `remarks` as install_remarks, `enabled`, `created_on` FROM `".TAB_INSTALL."` WHERE `cust_id`='$cust_id'  AND `preferred_date` < '$till'");

    if($qry->num_rows>0){
        while($info=$qry->fetch_assoc()){

            $ac_qry=$DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND cust_ac.`ac_id`='{$info['ac_id']}'");

            $info['created_on']=ConvertToIST($info['created_on']);
            $info['preferred_date']=ConvertToIST($info['preferred_date']);
            if($ac_qry->num_rows>0){
                $ac_info=$ac_qry->fetch_assoc();
                $info=array_merge($info,$ac_info);
            }
            $result['data']['installations'][]=$info;
            $result['data']['installations']['empty']=false;
        }
    }else{
        $result['data']['installations']['empty']=true;
        $result['data']['installations']['result']="No Installations Found";

    }

    $qry=$DB->query("SELECT * FROM `".TAB_COMPLAINT."` as c INNER JOIN `".TAB_PROBLEM_TYPE."` as p WHERE c.`cust_id`='$cust_id' AND c.`problem_type`=p.`ac_problem_id`  AND `preferred_date` < '$till'");

    if($qry->num_rows>0){

        while($info=$qry->fetch_assoc()){

           $ac_qry=$DB->query("SELECT * FROM `" . TAB_CUSTOMER_AC . "` as cust_ac INNER JOIN `" . TAB_AC_MAKE . "` as make,
        `" . TAB_AC_TONNAGE . "` as ton,`" . TAB_AC_TYPE . "` as type,`" . TAB_AC_LOCATION . "` as loc WHERE cust_ac.`make`=make.`make_id` AND loc.ac_location_id=cust_ac.ac_location
        AND ton.tonnage_id=cust_ac.capacity AND cust_ac.ac_type=type.ac_type_id AND cust_ac.`ac_id`='{$info['ac_id']}'");

            $info['created_on']=ConvertToIST($info['created_on']);
            $info['preferred_date']=ConvertToIST($info['preferred_date']);
            
            if($ac_qry->num_rows>0){
                $ac_info=$ac_qry->fetch_assoc();
                $info=array_merge($info,$ac_info);
            }
            $result['data']['complaints'][]=$info;
            $result['data']['complaints']['empty']=false;
        }
    }else{
        $result['data']['complaints']['empty']=true;
        $result['data']['complaints']['result']="No Complaints Found";

    }



    $app->response->body(json_encode($result));
});


$app->get("/Assign/Customer/:id/AMC",function($cust_id) use($app){
    global $DB;

    $qry=$DB->query("SELECT * FROM `".TAB_AMC."` WHERE `cust_id`='$cust_id'");
    $result=array();
    if($qry->num_rows>0){
        $result['status']="ok";
        $result['data']=array();
        while($info=$qry->fetch_assoc()){
            $result['data'][]=$info;
        }
    }else{
        $result['status']="no";
        $result['result']="No Assignment Found";

    }
    $app->response->body(json_encode($result));

});

$app->get("/Assign/Customer/:id/Complaints",function($cust_id) use($app){
    global $DB;

    $qry=$DB->query("SELECT * FROM `".TAB_COMPLAINT."` WHERE `cust_id`='$cust_id'");
    $result=array();
    if($qry->num_rows>0){
        $result['status']="ok";
        $result['data']=array();
        while($info=$qry->fetch_assoc()){
            $result['data'][]=$info;
        }
    }else{
        $result['status']="no";
        $result['result']="No Assignment Found";

    }
    $app->response->body(json_encode($result));

});
$app->get("/Assign/Customer/:id/OTS",function($cust_id) use($app){
    global $DB;

    $qry=$DB->query("SELECT * FROM `".TAB_OTS."` WHERE `cust_id`='$cust_id'");
    $result=array();
    if($qry->num_rows>0){
        $result['status']="ok";
        $result['data']=array();
        while($info=$qry->fetch_assoc()){
            $result['data'][]=$info;
        }
    }else{
        $result['status']="no";
        $result['result']="No Assignment Found";

    }
    $app->response->body(json_encode($result));

});
$app->get("/Assign/Customer/:id/Installations",function($cust_id) use($app){
    global $DB;

    $qry=$DB->query("SELECT * FROM `".TAB_INSTALL."` WHERE `cust_id`='$cust_id'");
    $result=array();
    if($qry->num_rows>0){
        $result['status']="ok";
        $result['data']=array();
        while($info=$qry->fetch_assoc()){
            $result['data'][]=$info;
        }
    }else{
        $result['status']="no";
        $result['result']="No Assignment Found";

    }
    $app->response->body(json_encode($result));

});

/***** Assignment ********/

$app->post("/Assign",function() use($app){
    global $DB;

    $type = $app->request->post("type");
    $assign_of = $app->request->post("assign_of");
    $assign_for = $app->request->post("assign_for");
    $assign_date = $app->request->post("assign_date");
    $remarks = $app->request->post("assign_remarks");
    $assign_date = ConvertFromIST($assign_date);
    
    $qry=$DB->query("INSERT INTO `".TAB_ASSIGN."`(`type`,`type_id`,`assign_for`,`assign_date`,`remarks`)
                    VALUES('$type','$assign_of','$assign_for','$assign_date','$remarks')") or ThrowError($DB->error);
                    
                    if($DB->affected_rows > 0){
                    $result['status'] = "ok";
                    $result['result'] = "Successfully Added";
                    $app->status(201);                        
                    }else{
                    ThrowError("Unable to create. Error occurred");                        
                    }
         $app->response->body(json_encode($result));       
});


/*************************/
