<?php
require_once("common.php");
/**
 * Created by Rafique
 * Date: 8/5/14
 * Time: 6:08 PM
 */

$app->get('/Technicians',function() use($app){
   global $DB;
    $qry=$DB->query("SELECT * FROM `".TAB_TECHNICIAN."` as tech INNER JOIN `".TAB_BRANCH."` as b WHERE tech.branch=b.branch_id AND tech.`enabled`='1'");
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
        ThrowError("No Technician Found");
    }

    $app->response->body(json_encode($result));

});

$app->post('/Technicians',function() use($app){
    global $DB;
    if(isset($_POST['firstname'],$_POST['lastname'],$_POST['mobile'],$_POST['branch'],$_POST['address']
    )&&!empty($_POST['firstname'])&&!empty($_POST['lastname'])&&!empty($_POST['mobile'])){



        $fname =$DB->real_escape_string($_POST['firstname']);
        $lname =$DB->real_escape_string($_POST['lastname']);
        $email =$DB->real_escape_string($_POST['email']);
        $mobile =$DB->real_escape_string($_POST['mobile']);
        $branch =$DB->real_escape_string($_POST['branch']);
        $address =$DB->real_escape_string($_POST['address']);

        $qry = $DB->query("INSERT INTO `".TAB_TECHNICIAN."`(`first_name`,`last_name`,`email`,`mobile`,`branch`,`address`)
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

$app->get('/Technicians/:id',function($tech_id) use($app){
    global $DB;
    if($tech_id>0){

        $qry=$DB->query("SELECT * FROM `".TAB_TECHNICIAN."` as tech INNER JOIN `".TAB_BRANCH."` as b WHERE b.`branch_id`=tech.`branch` AND tech.`tech_id`='$tech_id'") or ThrowError($DB->error);
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

$app->put('/Technicians/:id',function($tech_id) use($app){
    global $DB;
    if($tech_id>0){
        $fname=$DB->real_escape_string($app->request->put("firstname"));
        $lname=$DB->real_escape_string($app->request->put("lastname"));
        $email=$DB->real_escape_string($app->request->put("email"));
        $mobile=$DB->real_escape_string($app->request->put("mobile"));
        $address=$DB->real_escape_string($app->request->put("address"));
        $branch=$DB->real_escape_string($app->request->put("branch"));
if(!empty($fname)&&!empty($lname)&&!empty($mobile)&&!empty($branch)){
        $DB->query("UPDATE `".TAB_TECHNICIAN."` SET `first_name`='$fname',`last_name`='$lname',`email`='$email',
        `mobile`='$mobile',`branch`='$branch',`address`='$address' WHERE `tech_id`='$tech_id'") or ThrowError($DB->error);
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

$app->delete('/Technicians/:id',function($tech_id) use($app){
    global $DB;

    $DB->query("UPDATE `".TAB_TECHNICIAN."` SET `enabled`='3' WHERE `tech_id`='$tech_id'")or ThrowError($DB->error);
    if($DB->affected_rows>0)
    {
        $result['status']="ok";
        $result['result']="Successfully Deleted";
        $app->response->body(json_encode($result));
    }else{
        ThrowError("Unable to delete");
    }
});




