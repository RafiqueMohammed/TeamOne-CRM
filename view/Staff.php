<?php require_once("common.php");
/**
 * Created by Rafique
 * Date: 8/4/14
 * Time: 5:49 PM
 */
?>

<div class="row">

    <div class="col-sm-12">

        <!-- start: PAGE TITLE & BREADCRUMB -->
        <?php require_once(INC_DIR . "breadcrumb.php"); ?>

        <!-- end: PAGE TITLE & BREADCRUMB -->

        <div class="page-header">
            <div class="pull-left"><h1>Manage Staff</h1></div>
            <div class="pull-right">
                <button id="add_staff" style="margin-bottom: 10px;" class="pull-right btn btn-primary"><i
                        class="clip-user-plus" style="font-size: 1.4em;"></i></button>
            </div>
            <div class="clearfix"></div>
        </div>


    </div>

</div>
<!-- end: PAGE HEADER -->

<!-- start: PAGE CONTENT -->
<div class="row staff_list">

    <div class="col-md-12">
        <div id="staff_response_result"></div>

        <table id="staff_details" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Address</th>
                <th>Branch</th>
                <th class="center"><i class="clip-wrench-2"></i></th>
            </tr>
            </thead>
            <tbody class="staff_row_c">

            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>

    <!-- WRITE HEREEEE ---------->


</div>


<!-- end: PAGE CONTENT-->
<script src="assets/js/staff.js"></script>
