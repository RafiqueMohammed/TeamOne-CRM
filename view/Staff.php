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
        <?php require_once(INC_DIR."breadcrumb.php"); ?>

        <!-- end: PAGE TITLE & BREADCRUMB -->

        <div class="page-header">

            <h1>Staff <small>Registration</small></h1>

        </div>

    </div>

</div>
<!-- end: PAGE HEADER -->

<!-- start: PAGE CONTENT -->
<div class="row">

<div class="col-md-12">
<span id="staff_response_result"></span>
<button id="add_staff" style="margin-bottom: 10px;" class="pull-right btn btn-primary">+ Add New</button>
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
