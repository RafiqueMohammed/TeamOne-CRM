<?php
require_once("common.php");

$app->get("/Status/Customers", function () use ($app) {
        global $DB;

        $result=array();
        $result['status']="ok";

        $qry_ots=$DB->query("SELECT * FROM `".TAB_ASSIGN."` as ass INNER JOIN `".TAB_TECHNICIAN."` as tech, `".TAB_OTS."` as ots, `".TAB_CUSTOMER."` as c,
         `".TAB_CUSTOMER_AC."` as cad WHERE ass.`assign_for`=tech.`tech_id` and ots.`ots_id`=ass.`type_id` and c.`cust_id`=ots.`cust_id`
          and ots.`ac_id`=cad.`ac_id` and ass.`type`='ots'");
          if($qry_ots->num_rows > 0){
            while($info1=$qry_ots->fetch_assoc()){
                $result['data']['abc']['ots'][]=$info1;
            }
          }else{
                $result['data']['abc']['ots']['result']="No assignment for OTS";
          }
          
         $qry_install = $DB->query("SELECT * FROM `".TAB_ASSIGN."` as ass INNER JOIN `".TAB_TECHNICIAN."` as tech, `".TAB_INSTALL."` as ins, `".TAB_CUSTOMER."` as c,
          `".TAB_CUSTOMER_AC."` as cad WHERE ass.`assign_for`=tech.`tech_id` and ins.`install_id`=ass.`type_id` and c.`cust_id`=ins.`cust_id`
           and ins.`ac_id`=cad.`ac_id` and ass.`type`='installation'");
          if($qry_install->num_rows > 0){
            while($info2=$qry_ots->fetch_assoc()){
                $result['data']['abc']['installation'][]=$info2;
            }
          }else{
                $result['data']['abc']['installation']['result']="No assignment for OTS";
          }           
         $qry_comp = $DB->query("SELECT * FROM `".TAB_ASSIGN."` as ass INNER JOIN `".TAB_TECHNICIAN."` as tech, `".TAB_COMPLAINT."` as com, `".TAB_CUSTOMER."` as c,
          `".TAB_CUSTOMER_AC."` as cad WHERE ass.`assign_for`=tech.`tech_id` and com.`com_id`=ass.`type_id` and c.`cust_id`=com.`cust_id`
           and com.`ac_id`=cad.`ac_id` and ass.`type`='complaint'");
          if($qry_install->num_rows > 0){
            while($info3=$qry_ots->fetch_assoc()){
                $result['data']['complaint'][]=$info3;
                $result['data']['complaint']['empty']=true;
            }
          }else{
                $result['data']['complaint']['empty']=false;
                $result['data']['complaint']['result']="No assignment for OTS";
          }           
        $app->response->body(json_encode($result));
});

$app->post("/Customer/:cid/OTS/:id", function ($id) use ($app) {
        global $DB;
    }
);

$app->put("/Customer/:cid/OTS/:id", function ($id) use ($app) {
        global $DB;
    }
);

$app->delete("/Customer/:cid/OTS/:id", function ($id) use ($app) {
        global $DB;
    }
);