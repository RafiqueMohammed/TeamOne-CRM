<?php require_once("common.php"); ?>
<div class="row">

    <div class="col-sm-12">

        <!-- start: PAGE TITLE & BREADCRUMB -->
        <?php require_once(INC_DIR . "breadcrumb.php"); ?>

        <!-- end: PAGE TITLE & BREADCRUMB -->

        <div class="page-header">

            <h1><i class="clip-stats text-info"></i> Reports
                <small>Generate Reports</small>
            </h1>

        </div>

    </div>

</div>
<!-- end: PAGE HEADER -->


<!-- start: PAGE CONTENT -->
<div class="content col-md-12">


    <div class=" col-md-3"><label>Reports for </label>
        <select class="form-control reports_for">
            <option value="0">- Select -</option>
            <option value="AMC">AMC</option>
            <option value="Complaint">Complaint</option>
            <option value="OTS">OTS</option>
            <option value="Installation">Installation</option>
            <option value="Technician">Technician</option>
            <option value="Customer">New Customers</option>
        </select>
    </div>
    <div class=" col-md-3"><label>Report Type </label>
        <select class="form-control reports_type">
            <option value="0">- Select -</option>
        </select>
    </div>
    <div class=" col-md-4 date_container no-display">
        <div class="col-md-6"><label>Select From </label><input type="text" data-date-format="dd-mm-yyyy"
                                                                data-date-viewmode="years"
                                                                class="from_date  form-control"></div>
        <div class="col-md-6"><label>Select To </label><input type="text" data-date-format="dd-mm-yyyy"
                                                              data-date-viewmode="years" class="to_date  form-control">
        </div>
    </div>
    <div class="col-md-2">
        <label>&nbsp;</label>
        <input type="button" class="btn_generate_reports btn btn-primary form-control" value="Generate Reports">
    </div>
</div>
<div class="clearfix"></div>
<div class="generated_reports" style="margin-top: 40px">
    <div class="page-header">
        <span style="font-size:1.4em" id="total_reports_header" class="text-danger "><i
                class="clip-bars report_icon"></i> Total Data Retrieved : <span class="total_data"
                                                                                style="font-weight: bold">0</span> </span>
    </div>

    <div class='generated_reports_content col-md-12 no-display'>
        <table class="table table-condensed table-striped table-bordered table-hover table-full-width"
               id="ViewReportsDataTable">
            <thead>
            <tr>
                <th class="center col-md-3 service">Service Info</th>
                <th class="center col-md-3">Customer Info</th>
                <th class="center col-md-3">Ac Info</th>
                <th class="center col-md-1"><i class="clip-wrench-2"></i></th>
            </tr>
            </thead>
            <tbody>
            <!-- <tr><td colspan="4" class="alert alert-info center">Please select above report type to generate reports</td></tr>-->
            </tbody>
        </table>
    </div>
</div>

<div class='generated_reports_customer col-md-12 no-display'>
    <table class="table table-condensed table-striped table-bordered table-hover table-full-width"
           id="ViewReportsDataTable2">
        <thead>
        <tr>
            <th class="center col-md-3">Account Type</th>
            <th class="center col-md-3">Customer Name</th>
            <th class="center col-md-3">Created On</th>
            <th class="center col-md-1"><i class="clip-wrench-2"></i></th>
        </tr>
        </thead>
        <tbody>
        <!-- <tr><td colspan="4" class="alert alert-info center">Please select above report type to generate reports</td></tr>-->
        </tbody>
    </table>
</div>

<div class='generated_reports_technician col-md-12 no-display'>
    <table class="table table-condensed table-striped table-bordered table-hover table-full-width"
           id="ViewReportsDataTable3">
        <thead>
        <tr>
            <th class="center col-md-3">Technician Name</th>
            <th class="center col-md-3">Technician Mobile</th>
            <th class="center col-md-3">Technician Branch</th>
            <th class="center col-md-3">Technician Address</th>
        </tr>
        </thead>
        <tbody>
        <!-- <tr><td colspan="4" class="alert alert-info center">Please select above report type to generate reports</td></tr>-->
        </tbody>
    </table>
</div>


<div>

</div>
<!-- end: PAGE CONTENT-->
<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2.css"/>
<link rel="stylesheet" href="assets/plugins/DataTables/media/css/DT_bootstrap.css"/>
<script type="text/javascript" src="assets/js/Report.js"></script>
<script>
    jQuery(document).ready(function () {

        $("#ViewReportsDataTable").dataTable({
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

        $("#ViewReportsDataTable2").dataTable({

            "processing": true,
            "serverSide": true,
            "ajax": "http://192.168.0.200/team_one/getCustomers.php",

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

        $("#ViewReportsDataTable3").dataTable({

            "ajax": "http://192.168.0.200/team_one/api/Technicians",

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