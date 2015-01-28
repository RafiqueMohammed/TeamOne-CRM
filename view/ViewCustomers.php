<?php require_once("common.php"); ?>
<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/main.css">
<link rel="stylesheet" href="assets/css/main-responsive.css">
<link rel="stylesheet" href="assets/css/theme_light.css" type="text/css" id="skin_color">

<!--[if IE 7]>
<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<!-- end: MAIN CSS -->
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2.css"/>
<link rel="stylesheet" href="assets/plugins/DataTables/media/css/DT_bootstrap.css"/>
<div class="row">

    <div class="col-sm-12">

        <!-- start: PAGE TITLE & BREADCRUMB -->
        <?php require_once(INC_DIR . "breadcrumb.php"); ?>

        <!-- end: PAGE TITLE & BREADCRUMB -->

        <div class="page-header">

            <h1>Customers
                <small>Information</small>
            </h1>

        </div>

    </div>

</div>
<!-- end: PAGE HEADER -->

<!-- start: PAGE CONTENT -->
<div class="row">


    <div class="col-md-12">
    <div id="customer_result"></div>
        <?php

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $_SERVER['HTTP_HOST'] . SUB_FOLDER . "api/Customers");
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($c);

        if (curl_getinfo($c, CURLINFO_HTTP_CODE) == "200" && $output != "") {
            $json_content = json_decode($output, true);


        } else {
            $json_content = array("status" => "no", "result" => "Cannot fetch data from the API.Try Again..");
        }
        $body = "";
        if ($json_content['status'] == "ok") {
            foreach ($json_content['data'] as $data) {
                if ($data['account_type'] == "r") {
                    $data['account_type'] = "<i class='clip-home-2' style='color:green'></i>&nbsp;&nbsp;&nbsp;Residential";
                    $data['organisation'] = "Home";
                } else {
                    $data['account_type'] = "<i class='fa fa-trello' style='color:red'></i>&nbsp;&nbsp;&nbsp;Commercial";
                }
                $body .= "<tr class='cust_row_".$data['cust_id']."'><td class='center'>" . $data['account_type'] . "</td><td>" . $data['organisation'] . "</td>
                <td>" . $data['first_name'] . " " . $data['last_name'] . "</td><td>" . $data['mobile'] . "</td><td>" . $data['location'] . "</td><td>" . $data['created_on'] . "</td>
                <td class='center'><button class='btn-primary btn-sm btn tooltips'  data-placement='top' data-original-title='More Info' 
                onclick='return LoadPage(\"CustomerDetails?id=" . $data['cust_id'] . "&ref=ViewCustomers\");' href='CustomerDetails?id=" . $data['cust_id'] . "&ref=ViewCustomers'>
                <i class='clip-info-2'></i></button> <button class='btn-danger btn-sm btn tooltips'  data-placement='top' data-original-title='Delete' onclick='remove_customer(".$data['cust_id'].")'><i class='fa fa-trash-o'></i></button></td></tr>";
            }
            ?>

            <table class="table table-condensed table-striped table-bordered table-hover table-full-width"
                   id="ViewCustomerDataTable">
                <thead>
                <tr>
                    <th class="center col-md-2">Account Type</th>
                    <th class="center col-md-3">Organisation Name</th>
                    <th class="center col-md-2">Name</th>
                    <th class="center col-md-1">Mobile No</th>
                    <th class="center col-md-2">Location</th>
                    <th class="center col-md-1">Created On</th>
                    <th class="center col-md-1"><i class="clip-wrench-2"></i></th>
                </tr>
                </thead>
                <tbody>
                <?php echo $body; ?>
                </tbody>
            </table>

        <?php
        } else {
            $body = "<tr><td colspan='7' class='center alert alert-info'><i class='clip-info'></i> No Customer Added yet </td></tr>";
            ?>

            <table class="table table-condensed table-striped table-bordered table-hover table-full-width">
                <thead>
                <tr>
                    <th class="center col-md-2">Account Type</th>
                    <th class="center col-md-3">Organisation Name</th>
                    <th class="center col-md-2">Name</th>
                    <th class="center col-md-1">Mobile No</th>
                    <th class="center col-md-2">Location</th>
                    <th class="center col-md-1">Created On</th>
                    <th class="center col-md-1"><i class="clip-wrench-2"></i></th>
                </tr>
                </thead>
                <tbody>
                <?php echo $body; ?>
                </tbody>
            </table>
        <?php
        }
        ?>

    </div>
    <!-- WRITE HEREEEE ---------->


</div>

<script>
    jQuery(document).ready(function () {

        $("#ViewCustomerDataTable").dataTable({
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
<script src="assets/js/ViewCustomer.js" type="text/javascript"></script>