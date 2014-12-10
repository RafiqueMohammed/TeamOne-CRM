<?php require_once("common.php");?>
		<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2.css" />
		<link rel="stylesheet" href="assets/plugins/DataTables/media/css/DT_bootstrap.css" />
<div class="row">

    <div class="col-sm-12">

    <!-- start: PAGE TITLE & BREADCRUMB -->
    <?php require_once(INC_DIR."breadcrumb.php"); ?>

        <!-- end: PAGE TITLE & BREADCRUMB -->

        <div class="page-header">

            <h1><i class="clip-stats text-info"></i> Reports <small>Generate Reports</small></h1>

        </div>

    </div>

</div>
<!-- end: PAGE HEADER -->



<!-- start: PAGE CONTENT -->
<div class="content col-md-12">


<div class=" col-md-3"><label>Reports for </label>
    <select class="form-control reports_for"><option  value="0">- Select -</option>
        <option>AMC</option>
        <option>Complaint</option>
        <option>OTS</option>
        <option>Installation</option>
        <option>Technician</option>
        <option>New Customers</option>
    </select>
</div>
    <div class=" col-md-3"><label>Report Type </label>
        <select class="form-control reports_type"><option value="0">- Select -</option>
        <option value="all">All</option>
        <option value="date">Datewise</option>
    </select>
</div>
    <div class=" col-md-4 date_container no-display">
    <div class="col-md-6"><label>Select From </label><input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="from_date datepicker form-control"> </div>
        <div class="col-md-6"><label>Select To </label><input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="to_date datepicker form-control"></div>
        </div>
    <div class="col-md-2">
        <label>&nbsp;</label>
        <input type="button" class="btn_generate_reports btn btn-primary form-control" value="Generate Reports">
        </div>
</div>
<div class="clearfix"></div>
<div class="generated_reports" style="margin-top: 40px">
    <div class="page-header">
        <span style="font-size:1.4em" id="total_reports_header" class="text-danger "><i class="clip-bars report_icon"></i> Total Data Retrieved : <span class="total_data" style="font-weight: bold">0</span> </span>
    </div>

    <div class='generated_reports_content'>
        <table class="table table-condensed table-striped table-bordered table-hover table-full-width" id="ViewReportsDataTable">
        	<thead>
                <tr>
                    <th class="center col-md-3 service">Service Info</th>
                    <th class="center col-md-3">Customer Info</th>
                    <th class="center col-md-3">Ac Info</th>        
                    <th class="center"><i class="clip-wrench-2"></i></th>        
                </tr>
        	</thead>
        	<tbody>
               <!-- <tr><td colspan="4" class="alert alert-info center">Please select above report type to generate reports</td></tr>-->
        	</tbody>
        </table>
    </div>

</div>

<div>

</div>
<!-- end: PAGE CONTENT-->
<script type="text/javascript" src="assets/js/Report.js"></script>
<script>
    jQuery(document).ready(function() {

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

        $('.dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('.dataTables_length select').addClass("m-wrap small");
        $('.dataTables_length select').select2();
    });
</script>