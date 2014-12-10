<?php require_once("common.php");

?>
<!-- start: PAGE HEADER -->
<div class="row">

    <div class="col-sm-12">

        <!-- start: PAGE TITLE & BREADCRUMB -->
        <?php require_once(INC_DIR . "breadcrumb.php"); ?>

        <!-- end: PAGE TITLE & BREADCRUMB -->

        <div class="page-header">

            <h1 id="page_header_title">Dashboard
                <small>Quick overview &amp; stats</small>
            </h1>

        </div>

    </div>

</div>
<!-- end: PAGE HEADER -->


<!-- start: PAGE CONTENT -->

<div class="col-md-12">
    <div class="col-sm-3">
        <div class="core-box">
            <div class="heading">
                <i class="fa fa-plus circle-icon circle-green"></i>

                <h2><a href="CustomerRegistration" onclick='return LoadPage("CustomerRegistration");'>New Registration</a></h2>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="core-box">
            <div class="heading">
                <i class="clip-user-5 circle-icon circle-teal"></i>

                <h2><a href="UnAssignedList" onclick='return LoadPage("UnAssignedList");'>Technicians</a></h2>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="core-box">
            <div class="heading">
                <i class="clip-bars circle-icon circle-bricky"></i>
                <h2>Generate Reports</h2>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="core-box">
            <div class="heading">
                <i class="clip-search-3 circle-icon circle-purple"></i>

                <h2><a href="CustomerRegistration" onclick='return LoadPage("Search");'>Search</a></h2>
            </div>
        </div>
    </div>
</div>

<div class="col-md-8">
    <div class="page-header"><h2>Today's Statistics</h2></div>
    <div class="well col-md-12">

        <div class="panel center  pull-left" style="width: 49.4%">
            <table class="table">
                <tr>
                    <td><h4>Complaints Received</h4></td>
                    <td class="label label-warning  pull-right">0</td>
                </tr>
            </table>
        </div>
        <div class="panel pull-right center" style="width: 49.4%">
            <table class="table">
                <tr>
                    <td><h4>Installations Request</h4></td>
                    <td class="label label-info  pull-right">2</td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>
        <div class="panel center pull-left" style="width: 49.4%">
            <table class="table">
                <tr>
                    <td><h4>OTS Request</h4></td>
                    <td class="label label-info pull-right">1</td>
                </tr>
            </table>
        </div>
        <div class="panel pull-right center" style="width: 49.4%">
            <table class="table">
                <tr>
                    <td><h4>AMC Request</h4></td>
                    <td class="label label-warning  pull-right">0</td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
    <!--<div class="col-md-6">
    <div class="page-header"><h2>Today's Statistics Received from
            <span class="label label-default">IGLOO</span></h2></div>
            <div class="well col-md-12">

            <div class="panel center  pull-left" style="width: 49.4%">
                <h3>Complaints Received <span class='btn btn-warning btn-sm'>0</span></h3>
            </div>
            <div class="panel pull-right center" style="width: 49.4%">
                <h3>Installations Request <span class='btn btn-warning btn-sm'>0</span></h3>
            </div>
            <div class="clearfix"></div>
            <div class="panel center pull-left" style="width: 49.4%">
                <h3>OTS Request <span class='btn btn-warning btn-sm'>0</span></h3>
            </div>
            <div class="panel pull-right center" style="width: 49.4%">
                <h3>AMC Received <span class='btn btn-warning btn-sm'>0</span></h3>
            </div>
            <div class="clearfix"></div>
        </div> -->
        <!--<div class="well col-md-12">

            <div class="panel center  pull-left" style="width: 49.4%">
                <table class="table">
                    <tr>
                        <td><h4>Complaints Received</h4></td>
                        <td class="label label-warning pull-right">0</td>
                    </tr>
                </table>
            </div>
            <div class="panel pull-right center" style="width: 49.4%">
                <table class="table">
                    <tr>
                        <td><h4>Installations Request</h4></td>
                        <td class="label label-warning pull-right">0</td>
                    </tr>
                </table>
            </div>
            <div class="clearfix"></div>
            <div class="panel center pull-left" style="width: 49.4%">
                <table class="table">
                    <tr>
                        <td><h4>OTS Request</h4></td>
                        <td class="label label-warning pull-right">0</td>
                    </tr>
                </table>
            </div>
            <div class="panel pull-right center" style="width: 49.4%">
                <table class="table">
                    <tr>
                        <td><h4>AMC Request</h4></td>
                        <td class="label label-info pull-right">7</td>
                    </tr>
                </table>
            </div>
            <div class="clearfix"></div>
        </div>-->
    <!--</div>-->






