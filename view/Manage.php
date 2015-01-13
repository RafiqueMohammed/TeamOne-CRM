<?php require_once("common.php"); ?>
<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2.css" />
<div class="row">

    <div class="col-sm-12">
        <!-- start: PAGE TITLE & BREADCRUMB -->
        <ol class="breadcrumb">

        </ol>

        <div class="page-header">

            <h1>Manage AC
                <small>Brand, Tonnage & Location</small>
            </h1>
        </div>

        <!-- end: PAGE TITLE & BREADCRUMB -->

    </div>

</div>
        <?php
        $qry = $DB->query("SELECT * FROM `" . TAB_AC_MAKE . "` ORDER BY `make`") or die($DB->error);
        $make = '';
        $num_rows_make = $qry->num_rows;
        if ($qry->num_rows > 0) {
            $i = $num_rows_make;
            while ($data = $qry->fetch_array()) {
                $hidden_make="<div class='make_popup no-display'>
                                <div style='background:#fff;padding:10px;border-radius:5px'>
                                <h4 class='center'>Update Make</h4>
                                <input type='hidden' class='hidden_id' value='{$data['make_id']}'>
                                <table id='make_table' class='table table-bordered table-striped'>
                                <tr><th>Make</th><td><input type='text' class='form-control update_make_val'></td>
                                <td><input type='button' class='btn btn-primary' onclick='update(\"make_table\",\"make_list_$i\")' value='Update'></td></tr>
                                </table><div id='result'></div></div></div>";
                $b_id = $data['make_id'];
                $make .= "<li class='list-group-item make_list make_list_$i'><span class='make'>" . $data['make'] . "</span>
                <span style='cursor:pointer' onclick='delete_brand(\"make\",{$b_id},\".make_list_$i\")' class='badge badge-teal'><i class='fa fa-pencil'></i></span>{$hidden_make}</li>";
                $i--;
            }
        } else {
            $make .= "<li class='not_found list-group-item list-group-item-info' style='text-align: center;font-style: italic'>
            No Brand Added Yet..</li>";
        }

        $qry = $DB->query("SELECT * FROM `" . TAB_AC_TONNAGE . "`  ORDER BY `tonnage`") or die($DB->error);
        $tonnage = '';
        $num_rows_tonnage = $qry->num_rows;
        if ($qry->num_rows > 0) {
            $i = $num_rows_tonnage;
            while ($info = $qry->fetch_array()) {
                $hidden_ton="<div class='ton_popup no-display'>
                                <div style='background:#fff;padding:10px;border-radius:5px'>
                                <h4 class='center'>Update Tonnage</h4>
                                <input type='hidden' class='hidden_id' value='{$info['tonnage_id']}'>
                                <table id='tonnage_table' class='table table-bordered table-striped'>
                                <tr><th>Make</th><td><input type='text' class='form-control update_tonnage_val'></td>
                                <td><input type='button' class='btn btn-primary' onclick='update(\"tonnage_table\",\"ton_list_$i\")' value='Update'></td></tr>
                                </table><div id='result'></div></div></div>";
                $t_id = $info['tonnage_id'];
                $tonnage .= "<li class='list-group-item ton_list ton_list_$i'><span class='tonnage'>" . $info['tonnage'] . "</span>
                 <span style='cursor:pointer' onclick='delete_brand(\"ton\",{$t_id},\".ton_list_$i\")' class='badge badge-teal'><i class='fa fa-pencil'></i></span>{$hidden_ton}</li>";
                $i--;
            }
        } else {
            $tonnage .= "<li class='not_found list-group-item list-group-item-info' style='text-align: center;font-style: italic'>
            No Tonnage Added Yet..</li>";
        }

        $qry = $DB->query("SELECT * FROM `" . TAB_AC_LOCATION . "`  ORDER BY `location`") or die($DB->error);
        $location = '';
        $num_rows_location = $qry->num_rows;
        if ($qry->num_rows > 0) {
            $i = $num_rows_location;
            while ($info = $qry->fetch_array()) {
                $hidden_loc="<div class='location_popup no-display'>
                                <div style='background:#fff;padding:10px;border-radius:5px'>
                                <h4 class='center'>Update Location</h4>
                                <input type='hidden' class='hidden_id' value='{$info['ac_location_id']}'>
                                <table id='location_table' class='table table-bordered table-striped'>
                                <tr><th>Make</th><td><input type='text' class='form-control update_location_val'></td>
                                <td><input type='button' class='btn btn-primary' onclick='update(\"location_table\",\"loc_list_$i\")' value='Update'></td></tr>
                                </table><div id='result'></div></div></div>";
                $l_id = $info['ac_location_id'];
                $location .= "<li class='list-group-item loc_list loc_list_$i'><span class='location'>" . $info['location'] . "</span>
                 <span style='cursor:pointer' onclick='delete_brand(\"location\",{$l_id},\".loc_list_$i\")' class='badge badge-teal'><i class='fa fa-pencil'></i></span>{$hidden_loc}</li>";
                $i--;
            }
        } else {
            $location .= "<li class='not_found list-group-item list-group-item-info' style='text-align: center;font-style: italic'>
            No Location Added Yet..</li>";
        }

        $qry = $DB->query("SELECT * FROM `" . TAB_REFERRED_BY . "` ORDER BY `name`") or die($DB->error);
        $reference = '';
        $num_rows_reference = $qry->num_rows;
        if ($qry->num_rows > 0) {
            $i = $num_rows_reference;
            while ($info = $qry->fetch_array()) {
                $hidden_refer="<div class='reference_popup no-display'>
                                <div style='background:#fff;padding:10px;border-radius:5px'>
                                <h4 class='center'>Update Referred by</h4>
                                <input type='hidden' class='hidden_id' value='{$info['referred_id']}'>
                                <table id='refer_table' class='table table-bordered table-striped'>
                                <tr><th>Make</th><td><input type='text' class='form-control update_refer_val'></td>
                                <td><input type='button' class='btn btn-primary' onclick='update(\"reference_table\",\"ref_list_$i\")' value='Update'></td></tr>
                                </table><div id='result'></div></div></div>";
                $r_id = $info['referred_id'];
                $reference .= "<li class='list-group-item ref_list ref_list_$i'><span class='reference'>" . $info['name'] . "</span>
                 <span style='cursor:pointer' onclick='delete_brand(\"reference\",{$r_id},\".ref_list_$i\")' class='badge badge-teal'><i class='fa fa-pencil'></i></span>{$hidden_refer}</li>";
                $i--;
            }
        } else {
            $reference .= "<li class='not_found list-group-item list-group-item-info' style='text-align: center;font-style: italic'>
            No Reference Added Yet..</li>";
        }

        $qry = $DB->query("SELECT * FROM `" . TAB_AC_TYPE . "` ORDER BY `ac_type`") or die($DB->error);
        $ac_type = '';
        $num_rows_ac_type = $qry->num_rows;
        if ($qry->num_rows > 0) {
            $i = $num_rows_ac_type;
            while ($info1 = $qry->fetch_array()) {
                $hidden_type="<div class='actype_popup no-display'>
                                <div style='background:#fff;padding:10px;border-radius:5px'>
                                <h4 class='center'>Update AC Type</h4>
                                <input type='hidden' class='hidden_id' value='{$info1['ac_type_id']}'>
                                <table id='actype_table' class='table table-bordered table-striped'>
                                <tr><th>Make</th><td><input type='text' class='form-control update_ac_type_val'></td>
                                <td><input type='button' class='btn btn-primary' onclick='update(\"actype_table\",\"actype_list_$i\")' value='Update'></td></tr>
                                </table><div id='result'></div></div></div>";
                $ac_id = $info1['ac_type_id'];
                $ac_type .= "<li class='list-group-item actype_list actype_list_$i '><span class='actype'>" . $info1['ac_type'] . "</span>
                <span style='cursor:pointer' onclick='delete_brand(\"ac_type\",{$ac_id},\".actype_list_$i\")' class='badge badge-teal'><i class='fa fa-pencil'></i></span>{$hidden_type}</li>";
                $i--;
            }
        } else {
            $ac_type .= "<li class='not_found list-group-item list-group-item-info' style='text-align: center;font-style: italic'>
            No AC Type Added Yet..</li>";
        }
        
        $qry = $DB->query("SELECT * FROM `". TAB_PROBLEM_TYPE ."` ORDER BY `ac_problem_type`") or die($DB->error);
        $problem_type = '';
        $num_rows_problem_type = $qry->num_rows;
        if($qry->num_rows > 0){
            $i = $num_rows_problem_type;
            while($info2 = $qry->fetch_array()){
                $hidden_ptype="<div class='ptype_popup no-display'>
                                <div style='background:#fff;padding:10px;border-radius:5px'>
                                <h4 class='center'>Update Problem Type</h4>
                                <input type='hidden' class='hidden_id' value='{$info2['ac_problem_id']}'>
                                <table id='problem_type' class='table table-bordered table-striped'>
                                <tr><th>Make</th><td><input type='text' class='form-control req update_ptype_val'></td>
                                <td><input type='button' class='btn btn-primary' onclick='update(\"problem_table\",\"problem_type_list_$i\")' value='Update'></td></tr>
                                </table><div id='result'></div></div></div>";
                $p_id = $info2['ac_problem_id'];
                $problem_type .= "<li class='list-group-item problem_type problem_type_list_$i '><span class='ptype'>" . $info2['ac_problem_type'] . "</span>
                <span style='cursor:pointer' onclick='delete_brand(\"problem_type\",{$p_id},\".problem_type_list_$i\")' class='badge badge-teal'><i class='fa fa-pencil'></i></span>{$hidden_ptype}</li>";
                $i--;
            }
        } else {
            $problem_type .= "<li class='not_found list-group-item list-group-item-info' style='text-align: center;font-style: italic'>
            No Problem Type Added Yet..</li>";
        }
        
        $qry = $DB->query("SELECT * FROM `". TAB_BRANCH ."` ORDER BY `branch_name`") or die($DB->error);
        $branch = '';
        $num_rows_branch = $qry->num_rows;
        if($qry->num_rows > 0){
            $i = $num_rows_branch;
            while($info2 = $qry->fetch_array()){
                $hidden_branch="<div class='branch_popup no-display'>
                                <div style='background:#fff;padding:10px;border-radius:5px'>
                                <h4 class='center'>Update Branch</h4>
                                <input type='hidden' class='hidden_id' value='{$info2['branch_id']}'>
                                <table id='branch_table' class='table table-bordered table-striped'>
                                <tr><th>Branch</th><td><input type='text' class='form-control req update_branch_val'></td>
                                <td><input type='button' class='btn btn-primary' onclick='update(\"branch_table\",\"branch_list_$i\")' value='Update'></td></tr>
                                </table><div id='result'></div></div></div>";
                $b_id = $info2['branch_id'];
                $branch .= "<li class='list-group-item branch branch_list_$i '><span class='branch'>" . $info2['branch_name'] . "</span>
                <span style='cursor:pointer' onclick='delete_brand(\"branch\",{$p_id},\".branch_list_$i\")' class='badge badge-teal'><i class='fa fa-pencil'></i></span>{$hidden_branch}</li>";
                $i--;
            }
        } else {
            $branch .= "<li class='not_found list-group-item list-group-item-info' style='text-align: center;font-style: italic'>
            No Branch Added Yet..</li>";
        }

        ?>

<script type="text/javascript" src="assets/js/Brand.js"></script>
<script type="text/javascript" src="assets/js/pincode.js"></script>


<div class="col-md-10">        
<div class="tabbable">
		<ul id="myTab4" class="nav nav-tabs tab-padding tab-space-3 tab-blue">
            <li class="active">
                <a href="#panel_tab_actype" data-toggle="tab">
                    <i class="pink fa fa-dashboard"></i> AC Type
                </a>
            </li>
            <li class="">
                <a href="#panel_tab_make" data-toggle="tab">
                    <i class="blue fa fa-user"></i> Make
                </a>
            </li>
            <li class="">
                <a href="#panel_tab_tonnage" data-toggle="tab">
                    <i class="fa fa-rocket"></i> Tonnage
                </a>
            </li>
            <li class="">
                <a href="#panel_tab_location" data-toggle="tab">
                    <i class="fa fa-rocket"></i> Location
                </a>
            </li>
            <li class="">
                <a href="#panel_tab_reference" data-toggle="tab">
                    <i class="fa fa-rocket"></i> Reference
                </a>
            </li>
            <li class="">
                <a href="#panel_tab_problemtype" data-toggle="tab">
                    <i class="fa fa-rocket"></i> Problem Type
                </a>
            </li>
            <li class="">
                <a href="#panel_tab_branch" data-toggle="tab">
                    <i class="fa fa-rocket"></i> Branch
                </a>
            </li> 
            <li class="">
                <a href="#panel_tab_pincode" data-toggle="tab">
                    <i class="fa fa-rocket"></i> Pincode
                </a>
            </li>           
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="panel_tab_actype">
                <span class="text-danger ac_type_err"></span>
                    <form action="" id="ac_type" method="post">
                        <div class="col-md-5 pull-left" style="padding-bottom: 10px; padding-left: 0px;">
                            <input type="text" name="ac_type" placeholder="AC Type" class="form-control"/></div>
                        <div class="col-md-2 pull-left">
                            <input type="button" class="btn btn-primary" id="add_ac_type" value="ADD"
                                   name="submit"/> 
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <ul class="list-group ac_type_list">
                        <?php echo $ac_type; ?>
                    </ul>    
            </div>
			<div class="tab-pane" id="panel_tab_make">
                <span class="text-danger brand_err"></span>
                    <form action="" id="brand" method="post">
                        <div class="col-md-5 pull-left" style="padding-bottom: 10px; padding-left: 0px;">
                            <input type="text" name="make" placeholder="Make" class="form-control"/></div>
                        <div class="col-md-2 pull-left">
                            <input type="button" class="btn btn-primary" id="add_brand" value="ADD" name="submit"/>
                        </div>
                    </form> 
                    <div class="clearfix"></div>
                    <ul class="list-group brand_list">
                        <?php echo $make; ?>
                    </ul>
            </div>
			<div class="tab-pane" id="panel_tab_tonnage">
                <span class="text-danger tonnage_err"></span>
                <form action="" method="post">
                    <div class="col-md-5 pull-left" style="padding-bottom: 10px; padding-left: 0px;">
                        <input type="text" name="tonnage" placeholder="Tonnage" class="form-control"/>
                    </div>
                    <div class="col-md-2 pull-left">
                        <input type="button" name="submit_t" id="add_ton" value="ADD" class="btn btn-primary"/>
                    </div>
                </form>
                <div class="clearfix"></div>
                <ul class="list-group tonnage_list">
                    <?php echo $tonnage; ?>
                </ul>
            </div>
            
            <div class="tab-pane" id="panel_tab_location">
                <span class="text-danger location_err"></span>
                    <form action="" method="post">
                        <div class="col-md-5 pull-left" style="padding-bottom: 10px; padding-left: 0px;">
                            <input type="text" name="location" class="form-control"/>
                        </div>
                        <div class="col-md-2 pull-left">
                            <input type="button" name="submit_t" id="add_location" value="ADD" class="btn btn-primary"/>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <ul class="list-group location_list">
                        <?php echo $location; ?>
                    </ul>
            </div>
            
            <div class="tab-pane" id="panel_tab_reference">
                <span class="text-danger reference_err"></span>
                    <form action="" method="post">
                        <div class="col-md-5" style="padding-bottom: 10px; padding-left: 0px;">
                            <input type="text" name="reference" class="form-control"/>
                        </div>
                        <div class="col-md-2 pull-left">
                            <input type="button" name="submit_ref" id="add_reference" value="ADD" class="btn btn-primary"/>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <ul class="list-group reference_list">
                        <?php echo $reference; ?>
                    </ul>
            </div>
            <div class="tab-pane" id="panel_tab_problemtype">
                <span class="text-danger problem_type_err"></span>
                    <form action="" method="post">
                        <div class="col-md-5" style="padding-bottom: 10px; padding-left: 0px;">
                            <input type="text" name="problem_type" class="form-control"/>
                        </div>
                        <div class="col-md-2 pull-left">
                            <input type="button" name="problem_t" id="add_problem" value="ADD" class="btn btn-primary"/>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <ul class="list-group problem_type_list">
                        <?php echo $problem_type; ?>
                    </ul>
            </div>
            <div class="tab-pane" id="panel_tab_branch">
                <span class="text-danger branch_err"></span>
                    <form action="" method="post">
                        <div class="col-md-5" style="padding-bottom: 10px; padding-left: 0px;">
                            <input type="text" name="branch" placeholder="Add Branch" class="form-control"/>
                        </div>
                        <div class="col-md-2 pull-left">
                            <input type="button" name="branch_t" id="add_branch" value="ADD" class="btn btn-primary"/>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <ul class="list-group branch_list">
                        <?php echo $branch; ?>
                    </ul>
            </div>
            <div class="tab-pane" id="panel_tab_pincode">
                <div class="col-md-12">
                <div class="col-md-6">
                <table class="table table-bordered">
                <tr>
                <td class="col-md-4"><b>Select Pincode</b></td>
                <td class="col-md-8">
                <select class="" id="pincode" name="pincode">
                <?php
                $pin = "<option value='-1'>Select Pincode</option>";
                for($i=400001;$i<=401000;$i++){
                    $pin .= "<option value=".$i.">".$i."</option>";   
                }
                echo $pin;
                ?>
                </select>
                </td>
                </tr>
                </table>
                </div>
                <div class="col-md-6">
                <table class="table table-bordered">
                <tr>
                <td><input type="text" name="new_landmark" placeholder="Landmark" class="form-control" id="new_landmark"/></td>
                <td><button id="add_pincode" class="btn btn-primary">Add</button></td>
                <input type="hidden" id="hidden_pincode"/>
                </tr>
                </table>
                </div>     
                </div>    
                <div class="clearfix"></div>  
                <div id="show_my_output"></div>
                <table class="pin_row table table-striped table-bordered table-hover table-full-width" id="pincode_table">
                    <thead><tr>
						<th>Pincode</th>
                        <th>Landmark</th>
                        <th class="center"><i class="clip-wrench-2"></i></th>
					</tr></thead>
                    <tbody>
                        <tr><td colspan="3" class="alert alert-info center"> <i class="clip-info"></i> Please Select Pincode first</td></tr>
                    </tbody>
                </table>  
            </div>
        </div>
</div>
</div>

