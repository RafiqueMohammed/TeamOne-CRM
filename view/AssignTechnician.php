<?php require_once("common.php");
$customer_id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : -1;
?>

<input value="<?php echo $customer_id; ?>" type="hidden" id="customer_id_holder"/>
<div class="row">
    <div class="col-sm-12">

    <!-- start: PAGE TITLE & BREADCRUMB -->
    <?php require_once(INC_DIR."breadcrumb.php"); ?>

        <!-- end: PAGE TITLE & BREADCRUMB -->
        <?php
        if($customer_id!=-1){
            ?>
            <div class="page-header">
                <div class="pull-left">
                <h1 style="cursor: pointer;" class="cust_full_name">  </h1>
                </div>
                <div class="pull-right"><a class="btn btn-warning" onclick="LoadPage('UnAssignedList');" href="UnAssignedList">Back</a></div>
           <div class="clearfix"></div>
            </div>
        <?php
        }
        ?>


    </div>

</div>
<!-- end: PAGE HEADER -->



<!-- start: PAGE CONTENT -->
<div class="row">


<!-- WRITE HEREEEE ---------->
<?php
if($customer_id!=-1){
?>

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
                            <th class="col-md-2">AC Information</th>
                            <th class="col-md-2">Type</th>
                            <th class="col-md-2">Installation Type</th>
                            <th class="col-md-3">Remarks</th>
                            <th class="col-md-2">Service Date</th>
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
<?php
}else{
    echo "<div class='alert alert-danger center'> Invalid Customer ID. Please try again with valid customer. <a class=' btn-warning btn-sm' href='UnAssignedList' onclick='LoadPage(\"UnAssignedList\");'> &laquo; Go Back</a> </div>";
}
?>
</div>
<!-- end: PAGE CONTENT-->
<script type="text/javascript" src="assets/js/AssignTechnician.js"></script>