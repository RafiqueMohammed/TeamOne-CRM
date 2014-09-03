<?php require_once("common.php");
$customer_id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : -1;
?>

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
        <a data-toggle="tab" id="tab_services" href="#panel_request">
            UnAssigned Request
        </a>
    </li>
    <li>
        <a data-toggle="tab" id="tab_services" href="#panel_status">
            Request Status
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
                        <i class="fa fa-plus"></i> Installations <span class="badge badge-info"> 4 </span>

                    </button>
                </div>
                <div class="col-sm-3">
                    <button id="add_complaints" class="btn btn-icon btn-block pulsate">
                        <i class="fa fa-plus"></i>  Complaints <span class="badge badge-info"> 23 </span>
                    </button>
                </div>
                <div class="col-sm-3">
                    <button id="add_amc" class="btn btn-icon btn-block">
                        <i class="fa fa-plus"></i>  AMC Contracts <span class="badge badge-info"> 5 </span>
                    </button>
                </div>
                <div class="col-sm-3">
                    <button id="add_ots" class="btn btn-icon btn-block">
                        <i class="fa fa-plus"></i> One Time Services <span class="badge badge-info"> 9 </span>
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
    <div class='center ac_info_res'></div>
    <div class="pull-right"><button class="btn btn-primary btn-sm" onclick="add_new_ac();"><i class="clip-plus-circle-2"></i> Add New</button></div>
    <div class="clearfix"></div>
    <div class="row ">

            <div id="viewCustomerAC" class="panel-collapse collapse in">
                <div class="panel-body">
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
        <tr>
            <th class="center col-sm-2">Product Type</th>
            <th class="center col-sm-1">Make</th>
            <th class="center col-sm-1">Tonnage</th>
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
                        <th class="col-md-3">No of Services</th>
                        <th class="col-md-1">Remarks</th>
                        <th class="col-md-2">Received on</th>
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
                        <th class="col-md-2">Type</th>
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
                        <th class="col-md-3">AC Info</th>
                        <th class="col-md-2">AMC Type</th>
                        <th class="col-md-1">No of Services</th>
                        <th class="col-md-1">Activation</th>
                        <th class="col-md-1">Expired</th>
                        <th class="col-md-1">Remarks</th>
                        <th class="center col-md-1"><i class="clip-wrench-2"></i></th>
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
                        <th class="col-md-6">AC type</th>
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
                            <th class="center"><i class="clip-menu-2"></i></th>
                            <th class="col-md-3">AC Information</th>
                            <th class="col-md-2">Installation Type</th>
                            <th class="col-md-4">Remarks</th>
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
                            <th class="center"><i class="clip-menu-2"></i></th>
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
                            <th class="center"><i class="clip-menu-2"></i></th>
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
                            <th class="center"><i class="clip-menu-2"></i></th>
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
<div id="panel_status" class="tab-pane">
    <div class="row ">

            <div id="viewCustomerAC" class="panel-collapse collapse in">
                <div class="panel-body">
                    <h1>Comming Soon....</h1>
                    
                </div>
            </div>
    </div>
</div>
</div>
</div>
</div>


</div>
<!-- end: PAGE CONTENT-->
<script type="text/javascript" src="assets/js/CustomerDetails.js"></script>
<script type="text/javascript" src="assets/js/AssignTechnician.js"></script>