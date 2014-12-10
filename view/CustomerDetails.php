<?php require_once("common.php");
$customer_id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : -1;
?>
		<!--[if IE 7]>
		<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2.css" />
		<link rel="stylesheet" href="assets/plugins/DataTables/media/css/DT_bootstrap.css" />

<input value="<?php echo $customer_id; ?>" type="hidden" id="customer_id_holder"/>
<div class="row">

    <div class="col-sm-12">

        <!-- start: PAGE TITLE & BREADCRUMB -->
        <?php require_once(INC_DIR . "breadcrumb.php"); ?>

        <!-- end: PAGE TITLE & BREADCRUMB -->

        <div class="page-header">
        <?php

        if(isset($_GET['ref']) && !empty($_GET['ref'])){
            $ref=$_GET['ref'];
            echo "<div class='pull-right'> <a onclick='return LoadPage(\"{$ref}\");' href='{$ref}'><button class='btn btn-warning btn-sm'> &laquo; Go Back</button></a>
            </div>";
        }
?>
            <div class='clearfix'></div>
        
        </div>

    </div>

</div>
<!-- end: PAGE HEADER -->

<!-- start: PAGE CONTENT -->
<div class="row profile" >


<div class="col-sm-12">
<div class="tabbable">
<ul class="nav nav-tabs tab-padding tab-space-4" id="CustomerDetailsTab">
    <li class="active">
        <a data-toggle="tab" href="#panel_overview">
            Overview
        </a>
    </li>
    <li>
        <a data-toggle="tab" href="#panel_edit_account">
            Edit Account
        </a>
    </li>
    <li>
        <a data-toggle="tab" href="#panel_products">
            AC Information
        </a>
    </li>
    <li>
        <a data-toggle="tab" id="tab_installation" href="#panel_installation">
            Installation
        </a>
    </li>
    <li>
        <a data-toggle="tab" id="tab_complaints" href="#panel_complaints">
            Complaints
        </a>
    </li>
    <li>
        <a data-toggle="tab" id="tab_amc" href="#panel_amc">
            AMC
        </a>
    </li>
    <li>
        <a data-toggle="tab" id="tab_ots" href="#panel_ots">
            One time services
        </a>
    </li>
    <li>
        <a data-toggle="tab" id="tab_services_request" href="#panel_request">
            UnAssigned Request
        </a>
    </li>
    <li>
        <a data-toggle="tab" id="tab_services_status" href="#panel_status">
            Ticket Status
        </a>
    </li>    
</ul>
<div class="tab-content">
<div id="panel_overview" class="tab-pane in active">
    <div class="row">
        <div class="col-sm-5 col-md-4">
            <div class="user-left">
                <div class="center">
                    <h3><span class="username"></span></h3>
                </div>
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th colspan="3">General Information</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Account Type</th>
                        <td><span class="org_type"></span></td>
                    </tr>
                    <tr>
                        <th>Organization Name</th>
                        <td><span class="org_name"></span></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><span class="email"></span></td>
                    </tr>
                    <tr>
                        <th>Mobile 1</th>
                        <td><span class="mobile1"></span></td>
                    <tr>
                    <tr>
                        <th>Mobile 2</th>
                        <td><span class="mobile2"></span></td>
                    <tr>
                        <th>Phone:</th>
                        <td><span class="landline"></span></td>
                    </tr>
                    <tr>
                        <th>Alternate Contacts</th>
                        <td><span class="alternate_contacts"></span></td>
                    </tr>
                    </tbody>
                </table>
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th colspan="3">Contact information</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Address</th>
                        <td><span class="address"></span></td>
                    </tr>
                    <tr>
                        <th>Landmark</th>
                        <td><span class="landmark_info"></span></td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td><span class="location"></span></td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td><span class="city"></span></td>
                    </tr>
                    <tr>
                        <th>Pincode</th>
                        <td><span class="pincode"></span></td>
                    </tr>


                    </tbody>
                </table>
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th colspan="3">Additional information</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Mode Of Contact</th>
                        <td><span class="communication_m"></span></td>
                    </tr>
                    <tr>
                        <th>Reference</th>
                        <td><span class="referred_by"></span></td>
                    </tr>
                    <tr>
                        <th>Birth</th>
                        <td><span class="dob"></span></td>
                    </tr>
                    <tr>
                        <th>Created On</th>
                        <td><span class="created_on"></span></td>
                    </tr>
                    <tr>
                        <th>Remarks</th>
                        <td><span class="remarks"></span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-7 col-md-8">

            <div class="row">
                <div class="col-sm-3">
                    <button id="add_installation" class="btn btn-icon btn-block">
                        <i class="fa fa-plus"></i> Installations 
                    </button>
                </div>
                <div class="col-sm-3">
                    <button id="add_complaints" class="btn btn-icon btn-block pulsate">
                        <i class="fa fa-plus"></i>  Complaints
                    </button>
                </div>
                <div class="col-sm-3">
                    <button id="add_amc" class="btn btn-icon btn-block">
                        <i class="fa fa-plus"></i>  AMC Contracts
                    </button>
                </div>
                <div class="col-sm-3">
                    <button id="add_ots" class="btn btn-icon btn-block">
                        <i class="fa fa-plus"></i> One Time Services
                    </button>
                </div>
            </div>
            <div class="panel panel-white">

 <div class="possible-suggestion">

     <div class="panel-heading possible-suggestion-title">
         <i class="clip-link"></i> &nbsp;

         Possible Linked Account
         <div class="panel-tools">
             <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
             </a>
             <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                 <i class="fa fa-wrench"></i>
             </a>
             <a class="btn btn-xs btn-link panel-refresh" href="#">
                 <i class="fa fa-refresh"></i>
             </a>
             <a class="btn btn-xs btn-link panel-close" href="#">
                 <i class="fa fa-times"></i>
             </a>
         </div>
     </div>
<div class="possible-suggestion-body">

    <div id="linked_account" class="panel-body panel-scroll" style="height:300px">
        <ul class="activities">
            <li>
                <a class="activity" href="javascript:void(0)">
                    <i class="clip-home-2 circle-icon circle-green"></i>
                    <span class="desc">Ronak Rathod | Home | 9820098200 | Andheri </span>

                    <div class="time">
                        <i class="fa fa-time bigger-110"></i>
                        <button class="btn btn-primary">View</button>
                    </div>
                </a>
            </li>
            <li>
                <a class="activity" href="javascript:void(0)">
                    <i class="fa fa-trello circle-icon circle-bricky"></i>
                    <span class="desc">Ronak Rathod | Commercial | 9820098200 | Andheri</span>

                    <div class="time">
                        <i class="fa fa-time bigger-110"></i>
                        <button class="btn btn-primary">View</button>
                    </div>
                </a>
            </li>
            <li>
                <a class="activity" href="javascript:void(0)">
                    <i class="fa fa-trello circle-icon circle-bricky"></i>
                    <span class="desc">Ronak Rathod | Commercial | 9820098200 | Andheri</span>

                    <div class="time">
                        <i class="fa fa-time bigger-110"></i>
                        <button class="btn btn-primary">View</button>
                    </div>
                </a>
            </li>
        </ul>
    </div>

</div>
 </div>
            </div>

        </div>
    </div>
</div>
<div id="panel_edit_account" class="tab-pane">
    <form action="#" role="form" id="form">
        <div class="row">
            <div class="col-md-12" id="error"></div>
            <div class="col-md-12">
                <h3>Account Info</h3>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                        <td class="col-md-6">
                            <label class="control-label">Acoount Type</label>
                            <input type="text" class="form-control org_type" id="org_type" name="org_type" disabled>
                        </td>
                        <td class="col-md-6">
                            <label class="control-label">Organisation Name</label>
                            <textarea class="form-control org_name" name="org_name" id="org_name"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="control-label">First Name&nbsp;<span style="color:red;">*</span></label>
                            <input type="text" placeholder="Your First Name" class="form-control up_req firstname"
                                   id="firstname" name="firstname">
                        </td>
                        <td>
                            <label class="control-label">Last Name&nbsp;<span style="color:red;">*</span></label>
                            <input class="form-control up_req lastname" type="text" name="lastname" id="lastname">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="control-label">Mobile 1&nbsp;<span style="color:red;">*</span></label>
                            <input type="text" maxlength="10" placeholder="Ex: 9820098200"
                                   class="form-control up_req mobile1" id="mobile1" name="mobile1">
                        </td>
                        <td>
                            <label class="control-label">Mobile 2</label>
                            <input class="form-control mobile2" type="text" maxlength="10" name="mobile2" id="mobile2">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="control-label">Email</label>
                            <input type="text" placeholder="peter@example.com" class="form-control email" id="email"
                                   name="email">
                        </td>
                        <td>
                            <label class="control-label">Landline</label>
                            <input class="form-control landline" maxlength="12" type="text" name="landline"
                                   id="landline">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="control-label">Address&nbsp;<span style="color:red;">*</span></label>
                            <textarea class="form-control up_req address" id="address" name="address"></textarea>
                        </td>
                        <td>
                            <label class="control-label">Alternate Contacts</label>
                            <textarea class="form-control alternate_contacts" name="alternate_contacts"
                                      id="alternate_contacts"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="control-label">Pincode&nbsp;<span style="color:red;">*</span></label>
                            <input type="text" placeholder="Ex: 400060" class="form-control up_req pincode" name="pincode"
                                   id="pincode">

                            <div id="pincode_display" style="z-index: 1;"></div>
                        </td>
                        <td>
                            <label class="control-label">City&nbsp;<span style="color:red;">*</span></label>
                            <input class="form-control up_req city" type="text" name="city" id="city">
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <label class="control-label">Landmark&nbsp;<span style="color:red;">*</span></label>
                            <select class="form-control up_req landmark" id="landmark" name="landmark">

                            </select>
                        </td>
                        <td>
                            <label class="control-label">Location&nbsp;<span style="color:red;">*</span></label>
                            <input class="form-control up_req location" type="text" name="location" id="location">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="control-label">Mode Of Communication&nbsp;<span
                                    style="color:red;">*</span></label><br/>
                            <select class="form-control up_req communication " name="communication" id="communication">
                                <option class="moc_mobile" value="m">Mobile</option>
                                <option class="moc_email" value="e">Email</option>
                                <option class="moc_both" value="b">Both</option>
                            </select>
                        </td>
                        <td>
                            <label class="control-label">Referred by</label>
                            <input class="form-control referred_by" name="referred_by" id="referred_by"
                                   disabled="disabled">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="control-label">Date of Birth</label>
                            <input class="form-control dob date-picker" data-date-format="dd-mm-yyyy"
                                   data-date-viewmode="years" type="text" name="dob" id="dob">
                        </td>
                        <td>
                            <label class="control-label">Remarks</label>
                            <textarea class="form-control remarks" name="remarks" id="remarks"></textarea>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="clear-fix"></div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-teal btn-block" id="update_customer_details" type="button">
                    Update <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
            <div class="col-md-6">
                <div id="update_customer_details_output"></div>
            </div>

        </div>
    </form>
</div>

<!-- AC INFORMATION CONTENT STARTS HERE ------->

<div id="panel_products" class="tab-pane">
    <div class='center' id="ac_info_res"></div>
    <div class="pull-right"><button class="btn btn-primary btn-sm" onclick="add_new_ac();"><i class="clip-plus-circle-2"></i> Add New</button></div>
    <div class="clearfix"></div>
    <div class="row ">

            <div id="viewCustomerAC" class="panel-collapse collapse in">
                <div class="panel-body">
<div class="table-responsive">
    <table class="table table-striped table-bordered  table-condensed">
        <thead>
        <tr>
            <th class="center col-sm-2">AC Type</th>
            <th class="center col-sm-1">Make</th>
            <th class="center col-sm-1">Tonnage/HP</th>
            <th class="center col-sm-2">ODU</th>
            <th class="center col-sm-2">IDU</th>
            <th class="center col-sm-3">Location</th>
            <th class="center col-sm-1">Remarks</th>
            <th class="center"><i class="clip-wrench-2 "></i></th>
        </tr>
        </thead>
        <tbody class="customer_product_view">

        </tbody>

    </table>

</div>
                </div>
            </div>

    </div>
</div>
<!-- AC INFORMATION CONTENT ENDS HERE ------->
<div id="panel_installation" class="tab-pane">

    <div class="row ">

            <div id="viewCustomerAC" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="center" id="result_install"></div>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                        <th class="col-md-3">AC Info</th>
                        <th class="col-md-2">Installation Type</th>
                        <th class="col-md-1">Install on</th>
                        <th class="col-md-2">No of Services</th>
                        <th class="col-md-1">Remarks</th>
                        <th class="col-md-2">Received on</th>
                        <th class="center col-md-1"><i class='clip-wrench-2'></i></th>
                        <th class="center"><i class='clip-wrench-2'></i></th>
                        </tr>
                        </thead>
                        <tbody class="installed_product">

                        </tbody>

                    </table>
                </div>
            </div>

    </div>
</div>
<div id="panel_complaints" class="tab-pane">

    <div class="row ">

            <div id="viewCustomerAC" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="center" id="result_complaints"></div>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                        <th class="col-md-6">AC Info</th>
                        <th class="col-md-2">Complaint Type</th>
                        <th class="col-md-2">Complaint Remarks</th>
                        <th class="col-md-2">Received on</th>
                        <th class="center"><i class='clip-wrench-2'></i></th>
                        </tr>
                        </thead>
                        <tbody class="complaint_product">

                        </tbody>

                    </table>
                </div>
            </div>

    </div>
</div>
<div id="panel_amc" class="tab-pane">

    <div class="row ">

            <div id="viewCustomerAC" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="center" id="result_amc"></div>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                        <th class="col-md-4">AC Info</th>
                        <th class="col-md-2">AMC Type</th>
                        <th class="col-md-2">No of Services</th>
                        <th class="col-md-1">Activation Date</th>
                        <th class="col-md-1">Expiry Date</th>
                        <th class="col-md-1">Remarks</th>
                        <th class="center col-md-1"><i class="clip-wrench-2"></i></th>
                        <th class="center"><i class="clip-wrench-2"></i></th>
                        </tr>
                        </thead>
                        <tbody class="amc_product">

                        </tbody>

                    </table>
                </div>
            </div>

    </div>
</div>
<div id="panel_ots" class="tab-pane">
    <div class="row ">

            <div id="viewCustomerAC" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="center" id="result_ots"></div>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                        <th class="col-md-6">AC Info</th>
                        <th class="col-md-2">OTS Type</th>
                        <th class="col-md-2">OTS Remarks</th>
                        <th class="col-md-2">Received on</th>
                        <th class="center"><i class='clip-wrench-2'></i></th>
                        </tr>
                        </thead>
                        <tbody class="ots_product">

                        </tbody>

                    </table>
                </div>
            </div>
    </div>
</div>
<div id="panel_request" class="tab-pane">
    <div class="row ">
        <div class="panel ">
<div class="tabbable">
<ul id="myTab" class="nav nav-tabs tab-bricky">
    <li class="active">
        <a href="#panel_tab_assign_install" data-toggle="tab">
            <i class="green fa fa-home"></i>
            Installations
            <span class="badge badge-danger" id="Ins_count">0</span>
        </a>
    </li>
    <li>
        <a href="#panel_tab_assign_complaint" data-toggle="tab">
            <i class="green fa fa-home"></i>
            Complaints
            <span class="badge badge-danger" id="Com_count">0</span>
        </a>
    </li>
    <li>
        <a href="#panel_tab_assign_amc" data-toggle="tab">
            <i class="green fa fa-home"></i>
            AMC Contracts
            <span class="badge badge-danger" id="AMC_count">0</span>
        </a>
    </li>
    <li>
        <a href="#panel_tab_assign_ots" data-toggle="tab">
            <i class="green fa fa-home"></i>
            One Time Services
            <span class="badge badge-danger" id="OTS_count">0</span>
        </a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane in active" id="panel_tab_assign_install">

        <div class="panel panel-default">

            <div class="panel-body">
                <div class="table-responsive">
                    <table id="at_install_table" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="col-md-2">AC Info</th>
                            <th class="col-md-2">Type</th>
                            <th class="col-md-2">Installation Type</th>
                            <th class="col-md-3">Remarks</th>
                            <th class="col-md-2">Created On</th>
                            <th class="center col-md-1"><i class="clip-wrench-2"></i></th>
                        </tr>
                        </thead>
                        <tbody class="install_assign">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane" id="panel_tab_assign_complaint">

        <div class="panel panel-default">

            <div class="panel-body">
                <div class="table-responsive">
                    <table id="at_complaint_table" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="col-md-3">Ac Info</th>
                            <th class="col-md-3">Problem</th>
                            <th class="col-md-4">Remarks</th>
                            <th class="col-md-2">Created_on</th>
                            <th class="center col-md-1"><i class="clip-wrench-2"></i></th>
                        </tr>
                        </thead>
                        <tbody class="complaint_assign">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane" id="panel_tab_assign_amc">

        <div class="panel panel-default">

            <div class="panel-body">
                <div class="table-responsive">
                    <table id="at_amc_table" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="col-md-2">AC Info</th>
                            <th class="col-md-2">AMC Info</th>
                            <th class="col-md-1">No of Services</th>
                            <th class="col-md-3">Remarks</th>
                            <th class="col-md-2">Validity</th>
                            <th class="col-md-1">Service Date</th>
                            <th class="col-md-1">Status</th>
                        </tr>
                        </thead>
                        <tbody class="amc_assign">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane" id="panel_tab_assign_ots">

        <div class="panel panel-default">

            <div class="panel-body">
                <div class="table-responsive">
                    <table id="at_ots_table" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="col-md-3">Ac Info</th>
                            <th class="col-md-2">Service Type</th>
                            <th class="col-md-4">Remarks</th>
                            <th class="col-md-2">Created On</th>
                            <th class="col-md-1">Status</th>
                        </tr>
                        </thead>
                        <tbody class="ots_assign">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

</div>
            
    </div>
</div>
<?php

   $c=curl_init();
    curl_setopt($c,CURLOPT_URL,$_SERVER['HTTP_HOST'].SUB_FOLDER."api/Tickets/Customer/".$_GET['id']);
    curl_setopt($c,CURLOPT_RETURNTRANSFER,true);
    $output=curl_exec($c);

    if(curl_getinfo($c,CURLINFO_HTTP_CODE)=="200" && $output!=""){
        $json_content=json_decode($output,true);


    }else{
$json_content=array("status"=>"no","result"=>"Cannot fetch data from the API.Try Again..");
    }
$body="";
$ac_info="";
$cust_info="";
$service_info="";
$i=1;
if($json_content['status']=="ok"){
    foreach($json_content['data'] as $data=>$val){     
        if($val['status']=="p"){
            $val['status']="Pending";
        }else{
            $val['status']="Closed";
        }
        ($val['info']['account_type']=="r")?$val['info']['account_type']="Residential":"Commercial";
        $type=$val['type'];
        switch($type){
            case 'installation':            
            
            $ac_info="<div style='display:none' class='ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                  <table class='table table-bordered'>
                  <tr><th>Make</th><td>".$val['ac_info']['make']."</td></tr>
                  <tr><th>AC Type</th><td>".$val['ac_info']['ac_type']."</td></tr>
                  <tr><th>Location</th><td>".$val['ac_info']['location']."</td></tr>
                  <tr><th>Tonnage</th><td>".$val['ac_info']['tonnage']."</td></tr>
                  <tr><th>IDU Serial No</th><td>".$val['ac_info']['idu_serial_no']."</td></tr>
                  <tr><th>IDU Model No</th><td>".$val['ac_info']['idu_model_no']."</td></tr>
                  <tr><th>ODU Serial No</th><td>".$val['ac_info']['odu_serial_no']."</td></tr>
                  <tr><th>ODU Model No</th><td>".$val['ac_info']['odu_model_no']."</td></tr>
                  <tr><th>Remarks</th><td>".$val['ac_info']['remarks']."</td></tr>
                  </table></div></div>";
                  
            $cust_info="<div style='display:none' class='cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <table class='table table-bordered'>
                    <tr><th>Account Type</th><td>".$val['info']['account_type']."</td></tr>
                    <tr><th>Organisation</th><td>".$val['info']['organisation']."</td></tr>
                    <tr><th>Name</th><td>".$val['info']['first_name']." ".$val['info']['last_name']."</td></tr>
                    <tr><th>Mobile</th><td>".$val['info']['mobile']."</td></tr>
                    <tr><th>Email</th><td>".$val['info']['email']."</td></tr>
                    <tr><th>City</th><td>".$val['info']['city']."</td></tr>
                    <tr><th>Address</th><td>".$val['info']['address']."</td></tr>
                    <tr><th>Landmark</th><td>".$val['info']['landmark']."</td></tr>
                    <tr><th>Location</th><td>".$val['info']['customer_location']."</td></tr>
                    <tr><th>Pincode</th><td>".$val['info']['pincode']."</td></tr>
                    </table></div></div>";
                $val['assignment_info']['remarks']=($val['assignment_info']['remarks']=="")?"<b class='text-danger'>No remarks added":$val['assignment_info']['remarks'];
            $service_info="<div style='display:none' class='service_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                          <table class='table table-bordered table-striped'></tr><th>Installation Type</th><td>".$val['assignment_info']['install_type']."</td></tr>
                          </tr><th>Remarks</th><td>".$val['assignment_info']['remarks']."</td></tr></table>
                          </div></div>";
                    
            $close="<div style='display:none' class='close_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <div id='error'></div>
                    <table class='table table-bordered table-striped'>
                    <tr><th class='center'>Remarks</th></tr>
                    <tr><td><textarea class='form-control f_req remarks'></textarea></td></tr>
                    <tr><td><button class='pull-right btn btn-primary ticket_close'>Submit</button></td></tr>
                    </table><input type='hidden' value='".$val['assign_id']."' class='id'/>
                    <div id='result'></div>
                    </div></div>";
            
            if($val['ticket_remarks']==""){
                $val['ticket_remarks']="<b class='text-danger'>No Remarks added</b>";
            }
            $ticket="<div style='display:none' class='remark_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                      <table class='table table-bordered table-striped'>
                      <tr><th class='center'>Remarks</th></tr><td>".$val['ticket_remarks']."</td></tr>
                      </table></div></div>";
            
            $body.= "<tr class='row_".$i."'><td>".$val['ticket_id']."</td><td>".$val['info']['first_name']." ".$val['info']['last_name']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"cust_popup\")' ></i>".$cust_info."</td>
            <td>".$val['ac_info']['make']." (".$val['ac_info']['ac_type'].") <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"ac_popup\")' ></i>".$ac_info."</td>
            <td>".$val['type']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"service_popup\")'></i>".$service_info."</td><td>".ConvertToIST($val['assign_date'])."</td>
            <td>".$val['technician_info']['first_name']." ".$val['technician_info']['last_name']."</td>
            <td>".$val['status']."</td><td class='center'><a class='big_icon btn'><i onclick='show_popup(\"row_".$i."\",\"remark_popup\")' class='clip-bubble-dots-2'></i></a>".$ticket."</td>
            <td class='center'><button class='btn btn-danger btn-sm tooltips' data-original-title='Click to Close Ticket' onclick='popup_close(".$val['assign_id'].",\"row_".$i."\",\"close_popup\")'>Close</button>".$close."</td></tr>";
            $i++;
            break;
            
            case 'complaint':            
            
            $ac_info="<div style='display:none' class='ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                  <table class='table table-bordered'>
                  <tr><th>Make</th><td>".$val['ac_info']['make']."</td></tr>
                  <tr><th>AC Type</th><td>".$val['ac_info']['ac_type']."</td></tr>
                  <tr><th>Location</th><td>".$val['ac_info']['location']."</td></tr>
                  <tr><th>Tonnage</th><td>".$val['ac_info']['tonnage']."</td></tr>
                  <tr><th>IDU Serial No</th><td>".$val['ac_info']['idu_serial_no']."</td></tr>
                  <tr><th>IDU Model No</th><td>".$val['ac_info']['idu_model_no']."</td></tr>
                  <tr><th>ODU Serial No</th><td>".$val['ac_info']['odu_serial_no']."</td></tr>
                  <tr><th>ODU Model No</th><td>".$val['ac_info']['odu_model_no']."</td></tr>
                  <tr><th>Remarks</th><td>".$val['ac_info']['remarks']."</td></tr>
                  </table></div></div>";
                  
            $cust_info="<div style='display:none' class='cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <table class='table table-bordered'>
                    <tr><th>Account Type</th><td>".$val['info']['account_type']."</td></tr>
                    <tr><th>Organisation</th><td>".$val['info']['organisation']."</td></tr>
                    <tr><th>Name</th><td>".$val['info']['first_name']." ".$val['info']['last_name']."</td></tr>
                    <tr><th>Mobile</th><td>".$val['info']['mobile']."</td></tr>
                    <tr><th>Email</th><td>".$val['info']['email']."</td></tr>
                    <tr><th>City</th><td>".$val['info']['city']."</td></tr>
                    <tr><th>Address</th><td>".$val['info']['address']."</td></tr>
                    <tr><th>Landmark</th><td>".$val['info']['landmark']."</td></tr>
                    <tr><th>Location</th><td>".$val['info']['customer_location']."</td></tr>
                    <tr><th>Pincode</th><td>".$val['info']['pincode']."</td></tr>
                    </table></div></div>";
            ($val['assignment_info']['problem_desc']=="")?$val['assignment_info']['problem_desc']="<b class='text-danger'>No remarks added":$val['assignment_info']['problem_desc']=$val['assignment_info']['problem_desc'];        
            $service_info="<div style='display:none' class='service_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                           <table class='table table-bordered table-striped'></tr><th>Problem Type</th><td>".$val['assignment_info']['ac_problem_type']."</td></tr>
                           </tr><th>Description</th><td>".$val['assignment_info']['problem_desc']."</td></tr></table>
                           </div></div>";
                           
            $close="<div style='display:none' class='close_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <div id='error'></div>
                    <table class='table table-bordered table-striped'>
                    <tr><th class='center'>Remarks</th></tr>
                    <tr><td><textarea class='form-control f_req remarks'></textarea></td></tr>
                    <tr><td><button class='pull-right btn btn-primary ticket_close'>Submit</button></td></tr>
                    </table><input type='hidden' value='".$val['assign_id']."' class='id'/>
                    <div id='result'></div>
                    </div></div>"; 
            
            if($val['ticket_remarks']==""){
                $val['ticket_remarks']="<b class='text-danger'>No Remarks added</b>";
            }
            $ticket="<div style='display:none' class='remark_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                      <table class='table table-bordered table-striped'>
                      <tr><th class='center'>Remarks</th></tr><td>".$val['ticket_remarks']."</td></tr>
                      </table></div></div>";
            
            $body.= "<tr class='row_".$i."'><td>".$val['ticket_id']."</td><td>".$val['info']['first_name']." ".$val['info']['last_name']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"cust_popup\")' ></i>".$cust_info."</td>
            <td>".$val['ac_info']['make']." (".$val['ac_info']['ac_type'].") <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"ac_popup\")' ></i>".$ac_info."</td>
            <td>".$val['type']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"service_popup\")'></i>".$service_info."</td><td>".ConvertToIST($val['assign_date'])."</td>
            <td>".$val['technician_info']['first_name']." ".$val['technician_info']['last_name']."</td>
            <td>".$val['status']."</td><td class='center'><a class='big_icon btn'><i onclick='show_popup(\"row_".$i."\",\"remark_popup\")' class='clip-bubble-dots-2'></i></a>".$ticket."</td>
            <td class='center'><button class='btn btn-danger btn-sm' onclick='popup_close(".$val['assign_id'].",\"row_".$i."\",\"close_popup\")'>Close</button>".$close."</td></tr>";
            $i++;
            break;
            
            case 'amc':            
            
            $ac_info="<div style='display:none' class='ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                  <table class='table table-bordered'>
                  <tr><th>Make</th><td>".$val['ac_info']['make']."</td></tr>
                  <tr><th>AC Type</th><td>".$val['ac_info']['ac_type']."</td></tr>
                  <tr><th>Location</th><td>".$val['ac_info']['location']."</td></tr>
                  <tr><th>Tonnage</th><td>".$val['ac_info']['tonnage']."</td></tr>
                  <tr><th>IDU Serial No</th><td>".$val['ac_info']['idu_serial_no']."</td></tr>
                  <tr><th>IDU Model No</th><td>".$val['ac_info']['idu_model_no']."</td></tr>
                  <tr><th>ODU Serial No</th><td>".$val['ac_info']['odu_serial_no']."</td></tr>
                  <tr><th>ODU Model No</th><td>".$val['ac_info']['odu_model_no']."</td></tr>
                  <tr><th>Remarks</th><td>".$val['ac_info']['remarks']."</td></tr>
                  </table></div></div>";
                  
            $cust_info="<div style='display:none' class='cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <table class='table table-bordered'>
                    <tr><th>Account Type</th><td>".$val['info']['account_type']."</td></tr>
                    <tr><th>Organisation</th><td>".$val['info']['organisation']."</td></tr>
                    <tr><th>Name</th><td>".$val['info']['first_name']." ".$val['info']['last_name']."</td></tr>
                    <tr><th>Mobile</th><td>".$val['info']['mobile']."</td></tr>
                    <tr><th>Email</th><td>".$val['info']['email']."</td></tr>
                    <tr><th>City</th><td>".$val['info']['city']."</td></tr>
                    <tr><th>Address</th><td>".$val['info']['address']."</td></tr>
                    <tr><th>Landmark</th><td>".$val['info']['landmark']."</td></tr>
                    <tr><th>Location</th><td>".$val['info']['customer_location']."</td></tr>
                    <tr><th>Pincode</th><td>".$val['info']['pincode']."</td></tr>
                    </table></div></div>";
            
            ($val['assignment_info']['remarks']=="")?$val['assignment_info']['remarks']="<b class='text-danger'>No remarks added":$val['assignment_info']['remarks']=$val['assignment_info']['remarks'];        
            $service_info="<div style='display:none' class='service_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                          <table class='table table-bordered table-striped'>
                          </tr><th>Remarks</th><td>".$val['assignment_info']['remarks']."</td></tr></table>
                          </div></div>";
                          
            $close="<div style='display:none' class='close_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <div id='error'></div>
                    <table class='table table-bordered table-striped'>
                    <tr><th class='center'>Remarks</th></tr>
                    <tr><td><textarea class='form-control f_req remarks'></textarea></td></tr>
                    <tr><td><button class='pull-right btn btn-primary ticket_close'>Submit</button></td></tr>
                    </table><input type='hidden' value='".$val['assign_id']."' class='id'/>
                    <div id='result'></div>
                    </div></div>";
            
            if($val['ticket_remarks']==""){
                $val['ticket_remarks']="<b class='text-danger'>No Remarks added</b>";
            }
            $ticket="<div style='display:none' class='remark_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                      <table class='table table-bordered table-striped'>
                      <tr><th class='center'>Remarks</th></tr><td>".$val['ticket_remarks']."</td></tr>
                      </table></div></div>";
                    
            $body.= "<tr class='row_".$i."'><td>".$val['ticket_id']."</td><td>".$val['info']['first_name']." ".$val['info']['last_name']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"cust_popup\")' ></i>".$cust_info."</td>
            <td>".$val['ac_info']['make']." (".$val['ac_info']['ac_type'].") <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"ac_popup\")' ></i>".$ac_info."</td>
            <td>".$val['type']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"service_popup\")'></i>".$service_info."</td><td>".ConvertToIST($val['assign_date'])."</td>
            <td>".$val['technician_info']['first_name']." ".$val['technician_info']['last_name']."</td>
            <td>".$val['status']."</td><td class='center'><a class='big_icon btn'><i onclick='show_popup(\"row_".$i."\",\"remark_popup\")' class='clip-bubble-dots-2'></i></a>".$ticket."</td>
            <td class='center'><button class='btn btn-danger btn-sm' onclick='popup_close(".$val['assign_id'].",\"row_".$i."\",\"close_popup\")'>Close</button>".$close."</td></tr>";
            $i++;
            break;
            
            case 'ots':
            
            $ac_info="<div style='display:none' class='ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                  <table class='table table-bordered'>
                  <tr><th>Make</th><td>".$val['ac_info']['make']."</td></tr>
                  <tr><th>AC Type</th><td>".$val['ac_info']['ac_type']."</td></tr>
                  <tr><th>Location</th><td>".$val['ac_info']['location']."</td></tr>
                  <tr><th>Tonnage</th><td>".$val['ac_info']['tonnage']."</td></tr>
                  <tr><th>IDU Serial No</th><td>".$val['ac_info']['idu_serial_no']."</td></tr>
                  <tr><th>IDU Model No</th><td>".$val['ac_info']['idu_model_no']."</td></tr>
                  <tr><th>ODU Serial No</th><td>".$val['ac_info']['odu_serial_no']."</td></tr>
                  <tr><th>ODU Model No</th><td>".$val['ac_info']['odu_model_no']."</td></tr>
                  <tr><th>Remarks</th><td>".$val['ac_info']['remarks']."</td></tr>
                  </table></div></div>";
                  
            $cust_info="<div style='display:none' class='cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <table class='table table-bordered'>
                    <tr><th>Account Type</th><td>".$val['info']['account_type']."</td></tr>
                    <tr><th>Organisation</th><td>".$val['info']['organisation']."</td></tr>
                    <tr><th>Name</th><td>".$val['info']['first_name']." ".$val['info']['last_name']."</td></tr>
                    <tr><th>Mobile</th><td>".$val['info']['mobile']."</td></tr>
                    <tr><th>Email</th><td>".$val['info']['email']."</td></tr>
                    <tr><th>City</th><td>".$val['info']['city']."</td></tr>
                    <tr><th>Address</th><td>".$val['info']['address']."</td></tr>
                    <tr><th>Landmark</th><td>".$val['info']['landmark']."</td></tr>
                    <tr><th>Location</th><td>".$val['info']['customer_location']."</td></tr>
                    <tr><th>Pincode</th><td>".$val['info']['pincode']."</td></tr>
                    </table></div></div>";
            ($val['assignment_info']['description']=="")?$val['assignment_info']['description']="<b class='text-danger'>No remarks added":$val['assignment_info']['description']=$val['assignment_info']['description'];
            $service_info="<div style='display:none' class='service_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                          <table class='table table-bordered table-striped'>
                          </tr><th>OTS Type</th><td>".$val['assignment_info']['service_type']."</td></tr>
                          </tr><th>Remarks</th><td>".$val['assignment_info']['description']."</td></tr>
                          </table>
                          </div></div>";
                          
            $close="<div style='display:none' class='close_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <div id='error'></div>
                    <table class='table table-bordered table-striped'>
                    <tr><th class='center'>Remarks</th></tr>
                    <tr><td><textarea class='form-control f_req remarks'></textarea></td></tr>
                    <tr><td><button class='pull-right btn btn-primary ticket_close'>Submit</button></td></tr>
                    </table><input type='hidden' value='".$val['assign_id']."' class='id'/>
                    <div id='result'></div>
                    </div></div>"; 
            
            if($val['ticket_remarks']==""){
                $val['ticket_remarks']="<b class='text-danger'>No Remarks added</b>";
            }
            $ticket="<div style='display:none' class='remark_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                      <table class='table table-bordered table-striped'>
                      <tr><th class='center'>Remarks</th></tr><td>".$val['ticket_remarks']."</td></tr>
                      </table></div></div>";
            
            $body.= "<tr class='row_".$i."'><td>".$val['ticket_id']."</td><td>".$val['info']['first_name']." ".$val['info']['last_name']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"cust_popup\")' ></i>".$cust_info."</td>
            <td>".$val['ac_info']['make']." (".$val['ac_info']['ac_type'].") <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"ac_popup\")' ></i>".$ac_info."</td>
            <td>".$val['type']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"service_popup\")'></i>".$service_info."</td><td>".ConvertToIST($val['assign_date'])."</td>
            <td>".$val['technician_info']['first_name']." ".$val['technician_info']['last_name']."</td>
            <td>".$val['status']."</td><td class='center'><a class='big_icon btn'><i onclick='show_popup(\"row_".$i."\",\"remark_popup\")' class='clip-bubble-dots-2'></i></a>".$ticket."</td>
            <td class='center'><button class='btn btn-danger btn-sm' onclick='popup_close(".$val['assign_id'].",\"row_".$i."\",\"close_popup\")'>Close</button>".$close."</td></tr>";
            $i++;
            break;
        }
        
    }
?>
<div id="panel_status" class="tab-pane">
    <div class="row ">
        <div id="viewCustomerAC" class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="table-responsive">
    				<table class="table table-striped table-bordered table-hover table-condensed table-full-width" id="TicketDataTable">
    					<thead>
                            <tr>
                                <th class="hidden-xs col-md-1">Ticket</th>
                                <th class="col-md-2">Customer Info</th>
                                <th class="hidden-xs col-md-2">AC Info</th>
                                <th class="col-md-2">Service Type</th>
                                <th class="hidden-xs col-md-2">Assigned Date</th>
                                <th class="col-md-2">Technician</th>
                                <th class="hidden-xs col-md-1">Status</th>
                                <th>Remarks</th>
                                <th class="center"><i class="clip-wrench-2"></i></th>
                            </tr>
    					</thead>
    					<tbody>
                            <?php echo $body; ?>
    					</tbody>
    				</table>
		         </div>
            </div>
        </div>
    </div>
</div>
<?php
}else{    
    $body="<tr><td colspan='9' class='alert alert-info center'><i class='clip-info'></i> No Data Found</td></tr>";
?>

<div id="panel_status" class="tab-pane">
    <div class="row ">
        <div id="viewCustomerAC" class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="table-responsive">
    				<table class="table table-striped table-bordered table-hover table-condensed table-full-width">
    					<thead>
                            <tr>
                                <th class="hidden-xs col-md-1">Ticket</th>
                                <th class="col-md-2">Customer Info</th>
                                <th class="hidden-xs col-md-2">AC Info</th>
                                <th class="col-md-2">Service Type</th>
                                <th class="hidden-xs col-md-2">Assigned Date</th>
                                <th class="col-md-2">Technician</th>
                                <th class="hidden-xs col-md-1">Status</th>
                                <th>Remarks</th>
                                <th class="center"><i class="clip-wrench-2"></i></th>
                            </tr>
    					</thead>
    					<tbody>
                            <?php echo $body; ?>
    					</tbody>
    				</table>
		         </div>
            </div>
        </div>
    </div>
</div>

<?php
}

?>

</div>
</div>
</div>


</div>
<!-- end: PAGE CONTENT-->
		<script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
		<script type="text/javascript" src="assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
		<script src="assets/js/table-data.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script>
			jQuery(document).ready(function() {
				$("#TicketDataTable").dataTable({
            "aoColumnDefs": [{
                "aTargets": [0]
            }],
            "oLanguage": {
                "sLengthMenu": "Show _MENU_ Rows",
                "sSearch": "",
                "oPaginate": {
                    "sPrevious": "",
                    "sNext": ""
                }
            },
            "aaSorting": [
                [1, 'asc']
            ],
            "aLengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 10,
        });

        $('.dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('.dataTables_length select').addClass("m-wrap small");
        $('.dataTables_length select').select2();
			});
		</script>
        <script type="text/javascript" src="assets/js/CustomerDetails.js"></script>
        <script type="text/javascript" src="assets/js/Ticket.js"></script>