<?php

require_once("common.php");
/**
 * Created by Rafique
 * Date: 8/5/14
 * Time: 6:08 PM
 */

$app->get('/Staff',function() use($app){
   global $DB;
    $qry=$DB->query("SELECT * FROM `".TAB_STAFF."` as staff INNER JOIN `".TAB_BRANCH."` as b WHERE staff.branch=b.branch_id AND staff.`enabled`='1'");
    $result=array();
    if($qry->num_rows>0){
        $result['status']="ok";
        while($info=$qry->fetch_assoc()){
            $result['data'][]=$info;
        }

        $q=$DB->query("SELECT * FROM `".TAB_BRANCH."`");
        if($q->num_rows>0){
            while($info=$q->fetch_assoc()){
                $result['branch_list'][]=$info;
            }
            $result['branch_list']['empty']=false;
        }else{
            $result['branch_list']['empty']=true;
        }

    }else{
        ThrowError("No Staff Found");
    }

    $app->response->body(json_encode($result));

});

$app->post('/Staff',function() use($app){
    global $DB;
    if(isset($_POST['fname'],$_POST['lname'],$_POST['mobile'],$_POST['branch'],$_POST['address']
    )&&!empty($_POST['fname'])&&!empty($_POST['lname'])&&!empty($_POST['mobile'])){
        $fname =$DB->real_escape_string($_POST['fname']);
        $lname =$DB->real_escape_string($_POST['lname']);
        $email =$DB->real_escape_string($_POST['email']);
        $mobile =$DB->real_escape_string($_POST['mobile']);
        $branch =$DB->real_escape_string($_POST['branch']);
        $address =$DB->real_escape_string($_POST['address']);

        $qry = $DB->query("INSERT INTO `".TAB_STAFF."`(`first_name`,`last_name`,`email`,`mobile`,`branch`,`address`)
                 VALUES('$fname','$lname','$email','$mobile','$branch','$address')") or ThrowError($DB->error);

        if($DB->affected_rows > 0){
            $app->status(201);
            $result = array("status"=>"ok","result"=>"Added successfully","last_id"=>$DB->insert_id);
        } else {
            $result = array("status"=>"no","result"=>"Error occurred while inserting data");
        }
        $app->response->body(json_encode($result));
    }else{
        ThrowError("Missing Required Field");
    }


});

$app->get('/Staff/:id',function($staff_id) use($app){
    global $DB;
    if($staff_id>0){

        $qry=$DB->query("SELECT * FROM `".TAB_STAFF."` as staff INNER JOIN `".TAB_BRANCH."` as b WHERE b.`branch_id`=staff.`branch` AND staff.`staff_id`='$staff_id'") or ThrowError($DB->error);
        if($qry->num_rows>0)
        {
            $result['status']="ok";
            $result['data']=$qry->fetch_assoc();
            $app->response->body(json_encode($result));
        }else{
            ThrowError("No Such Technician Found");
        }

    }else{
        ThrowError("Invalid Technician ID");
    }

});

$app->put('/Staff/:id',function($staff_id) use($app){
    global $DB;
    if($staff_id>0){
        $fname=$DB->real_escape_string($app->request->put("firstname"));
        $lname=$DB->real_escape_string($app->request->put("lastname"));
        $email=$DB->real_escape_string($app->request->put("email"));
        $mobile=$DB->real_escape_string($app->request->put("mobile"));
        $address=$DB->real_escape_string($app->request->put("address"));
        $branch=$DB->real_escape_string($app->request->put("branch"));
if(!empty($fname)&&!empty($lname)&&!empty($mobile)&&!empty($branch)){
        $DB->query("UPDATE `".TAB_STAFF."` SET `first_name`='$fname',`last_name`='$lname',`email`='$email',
        `mobile`='$mobile',`branch`='$branch',`address`='$address' WHERE `staff_id`='$staff_id'") or ThrowError($DB->error);
        if($DB->affected_rows>0)
        {
            $result['status']="ok";
            $result['result']="Successfully Updated";
            $app->response->body(json_encode($result));
        }else{
            ThrowError("No Changes Made");
        }
}else{
    ThrowError("Required Field Missing");
}
    }else{
        ThrowError("Invalid Technician ID");
    }

});

$app->delete('/Staff/:id',function($staff_id) use($app){
    global $DB;

    $DB->query("UPDATE `".TAB_STAFF."` SET `enabled`='3' WHERE `staff_id`='$staff_id'")or ThrowError($DB->error);
    if($DB->affected_rows>0)
    {
        $result['status']="ok";
        $result['result']="Successfully Deleted";
        $app->response->body(json_encode($result));
    }else{
        ThrowError("Unable to delete");
    }
});

?>