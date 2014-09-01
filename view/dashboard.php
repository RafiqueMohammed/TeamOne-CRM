<?php require_once("common.php");?>
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

<div class="row">
    <div class="col-sm-3">
        <div class="core-box">
            <div class="heading">
                <i class="circle-icon circle-green"><span style="font-size: 1.6em;">+</span></i>

                <h2><a href="CustomerRegistration" onclick='return LoadPage("CustomerRegistration");'>New Registration</a></h2>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="core-box">
            <div class="heading">
                <i class="clip-users circle-icon circle-teal"></i>

                <h2><a href="AssignTechnicianlist" onclick='return LoadPage("AssignTechnicianlist");'>Manage Technicians</h2>
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


<div class="row">
<div class="panel ">

<?php

//var_dump(GetDays("2014-08-30","2015-08-30"));

?>
<div class="tabbable">
<ul id="myTab" class="nav nav-tabs tab-bricky">
    <li class="active">
        <a href="#panel_tab3_example1" data-toggle="tab">
            <i class="green fa fa-home"></i>
            Installations
            <span class="badge badge-danger">8</span>
        </a>
    </li>
    <li>
        <a href="#panel_tab3_example2" data-toggle="tab">
            <i class="green fa fa-home"></i>
            Complaints
            <span class="badge badge-danger">9</span>
        </a>
    </li>
    <li>
        <a href="#panel_tab3_example3" data-toggle="tab">
            <i class="green fa fa-home"></i>
            AMC Contracts
            <span class="badge badge-danger">4</span>
        </a>
    </li>
    <li>
        <a href="#panel_tab3_example4" data-toggle="tab">
            <i class="green fa fa-home"></i>
            One Time Services
            <span class="badge badge-danger">7</span>
        </a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane in active" id="panel_tab3_example1">

        <div class="panel panel-default">

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="sample-table-1">
                        <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Customer Info</th>
                            <th>Ac Info</th>
                            <th>Type</th>
                            <th>Install Date</th>
                            <th>Technician</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>21/06/2014</td>
                            <td><b>Name</b> Ronak rathod<br/>
                                <b>Mobile</b> 9820098200<br/>
                            </td>
                            <td>Godrej (Split)</td>
                            <td>Standard</td>
                            <td>31/06/2014</td>
                            <td>
                                <select>
                                    <option>Vijay</option>
                                    <option>Vipul</option>
                                    <option>Vikas</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary">Assign</button>
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane" id="panel_tab3_example2">

        <div class="panel panel-default">

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="sample-table-1">
                        <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Customer Info</th>
                            <th>Ac Info</th>
                            <th>Problem</th>
                            <th>Technician</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>21/06/2014</td>
                            <td><b>Name</b> Ronak rathod<br/>
                                <b>Mobile</b> 9820098200<br/>
                            </td>
                            <td>Daiken (Window)</td>
                            <td>No Cooling</td>
                            <td>
                                <select>
                                    <option>Vijay</option>
                                    <option>Vipul</option>
                                    <option>Vikas</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary">Assign</button>
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane" id="panel_tab3_example3">

        <div class="panel panel-default">

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="sample-table-1">
                        <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Customer Info</th>
                            <th>Ac Info</th>
                            <th>AMC Info</th>
                            <th>Technician</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>21/06/2014</td>
                            <td><b>Name</b> Ronak rathod<br/>
                                <b>Mobile</b> 9820098200<br/>
                            </td>
                            <td>
                                Panasonic (Split)
                            </td>
                            <td>
                                <b>Type </b>Comprehensive<br/>
                                <b>No of services </b>16<br/>
                                <b>Dry services </b>8<br/>
                                <b>Wet services </b>8
                            </td>
                            <td>
                                <select>
                                    <option>Vijay</option>
                                    <option>Vipul</option>
                                    <option>Vikas</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary">Assign</button>
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane" id="panel_tab3_example4">

        <div class="panel panel-default">

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="sample-table-1">
                        <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Customer Info</th>
                            <th>Ac Info</th>
                            <th>Service Type</th>
                            <th>Technician</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>21/06/2014</td>
                            <td><b>Name</b> Ronak rathod<br/>
                                <b>Mobile</b> 9820098200<br/>
                            </td>
                            <td>Onida(Window)</td>
                            <td>Wet Service</td>
                            <td>
                                <select>
                                    <option>Vijay</option>
                                    <option>Vipul</option>
                                    <option>Vikas</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary">Assign</button>
                            </td>
                        </tr>


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


