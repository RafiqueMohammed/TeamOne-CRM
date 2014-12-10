<div id="default_modal_box" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--- AMC BOX START ---->
            <div id="amc_modal_box" style="display: none;" data-replace="true">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Annual Maintenance Contract</h4>
                    </div>
                    <div class="modal-body">
                        <div id="error"></div>
                            <div class="table-responsive">

                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th  class="center col-md-2">Select AC</th>
                                        <th  class="center col-md-3"> AC Information</th>
                                        <th  class="center  col-md-2" >Service Type</th>
                                        <th  class="center  col-md-2" >AMC Starts on</th>
                                        <th  class="center  col-md-1">No. of Services</th>
                                        <th  class="center  col-md-2">Remarks</th>
                                        <th class="center"><i class="fa fa-wrench"></i> </th>
                                    </tr>
                                    <tr>
                                                     <td colspan="8" class="center display_output"></td>
                                    </tr>
                                    </thead>
                                    <tbody class="table_body count">
                                    <tr class='aaa row_1'>
                                        <td class="col-sm-3">
                                            <select onchange="amc_ac_change();" class="form-control amc_select_ac">
                                                <option value="-1">-Select AC-</option>
                                            </select>
                                            <input type="text" class="amc_selected_ac" value="-1" />
                                        </td>
                                        <td class="ac_type col-md-2"> -- No Information -- </td>
                                        <td class="capacity col-md-2"> -- No Information -- </td>
                                        <td class="idu_no col-md-2"> -- No Information -- </td>
                                        <td class="odu_no col-md-2"> -- No Information -- </td>
                                        <td class='odu_no col-sm-2'> <select class="form-control amc_service_type">
                                                <option value="-1"> -- Select Service Type -- </option>
                                        </select> </td>
                                        <td class="center col-md-1"><input type="number" class="form-control" placeholder="Dry" size="1"> <br>
                                            <input type="number" class="form-control" placeholder="Wet" size="1"></td>
                                        <td class="center col-md-1"><textarea class="form-control"></textarea></td>
                                        <td class="" style='color: brown'><i onclick='remove_amc_row(1);' class='clip-minus-circle-2'></i></td>
                                    </tr>
                                    </tbody>
                                    <tfoot class="table_foot">
                                    <tr><td colspan="8"><div class="pull-right btn btn-danger add_btn"><i class="fa fa-plus"></i></div></td></tr>

                                    </tfoot>
                                </table><div id="result"></div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary create_btn">+ Create</button>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        <!-- /.modal -->

<div id="installation_modal_box" tabindex="-1"  style="display: none;" >
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Add Installation</h4>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td colspan="2"><select class="select_uninstalled_ac form-control">
                                        <option value=""> -- Select AC -- </option>
                                    </select>
                                    <br/>
                                    <input type="hidden" class="select_ac_id" value="-1"><div class="display_ac_info">
                                        <table class="table table-bordered">
                                            <tr><th>AC Type</th><td class="display_ac_info_type"> --N/A-- </td>
                                                <th>Make</th><td class="display_ac_info_make"> --N/A-- </td></tr>
                                            <tr><th>Place</th><td class="display_ac_info_place"> --N/A-- </td>
                                                <th>Tonnage / HP</th><td class="display_ac_info_tonnage"> --N/A-- </td></tr>
                                            <tr><th>IDU Serial No.</th><td class="display_ac_info_idu_sr"> --N/A-- </td>
                                                <th>ODU Serial No.</th><td class="display_ac_info_odu_sr"> --N/A-- </td></tr>
                                            <tr><th>IDU Model No.</th><td class="display_ac_info_idu_md"> --N/A-- </td>
                                                <th>ODU Model No.</th><td class="display_ac_info_odu_md"> --N/A-- </td></tr>
                                        </table>
                                    </div></td>
                            </tr>
                            <tr>
                                <th>Installation Type</th>
                                <td><select  class="form-control installation_type">
                                        <option value="-1">- Select -</option>
                                        <option value="s"> Standard </option>
                                        <option value="n"> Non-Standard </option>
                                        <option value="f"> Free </option>
                                    </select></td>
                            </tr>
                            <tr>
                                <th>No. of Service</th>
                                <td><input type="text" size="2" class="form-control no_of_service" /></td>
                            </tr>
                            <tr>
                                <th>Preferred date of installation</th>
                                <td><input data-date-viewmode="years" placeholder="dd-mm-yyyy" data-date-format="dd-mm-yyyy" type="text"  class="date-picker form-control installation_date" /></td>
                            </tr>
                            <tr>
                                <th>Remarks</th>
                                <td><textarea  class="form-control add_remarks"></textarea></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="center display_output"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="addInstallation()" class="btn btn-primary create_btn">+ Create</button>
            </div>
        </div><!-- /.modal-content -->
</div>

<!--- COMPLAINTS BOX STARTS --->
<div id="complaints_modal_box" class="modal fade" data-replace="true">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">Add Complaints</h4>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <td colspan="2"><select class="select_ac form-control"><option> -- Select AC -- </option></select>
                                <br/>
                            <input type="hidden" class="select_ac_id" value="-1"><div class="display_ac_info">
                                    <table class="table table-bordered">
                                        <tr><th>AC Type</th><td class="display_ac_info_type"> --N/A-- </td>
                                        <th>Make</th><td class="display_ac_info_make"> --N/A-- </td></tr>
                                        <tr><th>Place</th><td class="display_ac_info_place"> --N/A-- </td>
                                            <th>Tonnage / HP</th><td class="display_ac_info_tonnage"> --N/A-- </td></tr>
                                        <tr><th>IDU Serial No.</th><td class="display_ac_info_idu_sr"> --N/A-- </td>
                                        <th>ODU Serial No.</th><td class="display_ac_info_odu_sr"> --N/A-- </td></tr>
                                        <tr><th>IDU Model No.</th><td class="display_ac_info_idu_md"> --N/A-- </td>
                                        <th>ODU Model No.</th><td class="display_ac_info_odu_md"> --N/A-- </td></tr>
                                    </table>
                                       </div></td>
                        </tr>
                        <tr>
                            <th>Problem Type</th>
                            <td><select  class="form-control select_problem">
                                    <option value="-1">- Select -</option>
                                </select></td>
                        </tr>
                        <tr>
                            <th>Preferred Date</th>
                            <td><input type="text" class="form-control preffered_date" data-date-format="dd-mm-yyyy" data-date-viewmode="years"/></td>
                        </tr>
                        <tr>
                            <th>Problem Description</th>
                            <td><textarea  class="form-control problem_desc"></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="center display_output"><div></div></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary create_btn">+ Add This Complaint</button>
        </div>
    </div><!-- /.modal-content -->
</div>

<!--- OTS BOX STARTS --->
<div id="ots_modal_box" tabindex="-1"  style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">Add One Time Service</h4>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <td colspan="2"><select class="select_ac form-control"><option> -- Select AC -- </option></select>
                                <br/>
                                <input type="hidden" class="select_ac_id" value="-1"><div class="display_ac_info">
                                    <table class="table table-bordered">
                                        <tr><th>AC Type</th><td class="display_ac_info_type"> --N/A-- </td>
                                            <th>Make</th><td class="display_ac_info_make"> --N/A-- </td></tr>
                                        <tr><th>Place</th><td class="display_ac_info_place"> --N/A-- </td>
                                            <th>Tonnage / HP</th><td class="display_ac_info_tonnage"> --N/A-- </td></tr>
                                        <tr><th>IDU Serial No.</th><td class="display_ac_info_idu_sr"> --N/A-- </td>
                                            <th>ODU Serial No.</th><td class="display_ac_info_odu_sr"> --N/A-- </td></tr>
                                        <tr><th>IDU Model No.</th><td class="display_ac_info_idu_md"> --N/A-- </td>
                                            <th>ODU Model No.</th><td class="display_ac_info_odu_md"> --N/A-- </td></tr>
                                    </table>
                                </div></td>
                        </tr>
                        <tr>
                            <th>Service Type</th>
                            <td><select  class="form-control service_type">
                                    <option value="-1">- Select -</option>
                                    <option value="wet">WET</option>
                                    <option value="dry">DRY</option>
                                    <option value="chemical">Chemical Cleaning</option>
                                    <option value="pressure">Pressure Pump Cleaning</option>
                                </select></td>
                        </tr>
                        <tr>
                            <th>Preferred Date</th>
                            <td><input type="text" class="form-control preffered_date" data-date-format="dd-mm-yyyy" data-date-viewmode="years"/></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td><textarea  class="form-control desc"></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="center display_output"><div ></div></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary create_btn">+ Create</button>
        </div>
    </div><!-- /.modal-content -->
</div>




<div id="registration_modal_box" class="modal fade">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"> </h4>
            </div>
            <div class="modal-body">

            </div>
        </div><!-- /.modal-content -->
</div>
<!-- Start of popup of add_ac_row in customer details -->

<div id="Customer_details_add_ac" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Add New AC </h4>
            </div>
            <div class="modal-body"><div id="error"></div>
                <table class="table table-bordered add_ac_table">
                    <thead>
                            <tr>
                                <th>AC Type</th>
                                <td class="cust_details_ac_type"></td>
                            </tr>
                            <tr>
                                <th>Make</th>
                                <td class="cust_details_make"></td>
                            </tr>
                            <tr>
                                <th>Tonnage / HP</th>
                                <td class="cust_details_tonnage"></td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <td class="cust_details_location"></td>
                            </tr>
                            <tr>
                                <td >IDU serial number</td>
                                <td > <input type="text" placeholder="IDU serial number" class="form-control add_cust_ac_idu_sr_no" /></td>
                            </tr>
                            <tr>
                                <td > IDU model number</td>
                                <td ><input type="text" placeholder="IDU model number" class="form-control add_cust_ac_idu_model_no" /></td>
                            </tr>
                            <tr>
                                <td >ODU serial number</td>
                                <td > <input type="text" placeholder="ODU serial number" class="form-control add_cust_ac_odu_sr_no" />
                                </td>
                            </tr>
                            <tr>
                                <td>ODU model number </td>
                                <td><input type="text" placeholder="ODU model number" class="form-control add_cust_ac_odu_model_no" />                                </td>
                            </tr>
                            <tr>
                            <th>Remarks</th>
                                <td colspan="2"><textarea class="form-control add_cust_ac_remarks"></textarea></td>
                            </tr>
                            <tr>
                            <td colspan="2">
                            <div id="result"></div>
                            <button class="btn btn-primary pull-right" id="face_add_ac">Add</button>
                            </td>
                            </tr>
                    </thead>
                    <tbody class="customer_ac_body"></tbody>
                </table>
            </div>
            
        </div><!-- /.modal-content -->
</div>

<!-- End of popup of add_ac_row in customer details -->

<!--- Start add Technician modal --->

<div id="modal_add_tech" style="display: none;">
<div style="background-color: #fff; border-radius: 5px;">
    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" onclick="reset_form('#add_technicians_box')" aria-hidden="true">
			&times;
		</button>
		<h4 class="modal-title">Add Technician</h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12">
            <div id="error"></div>
                <form id="add_technicians_box">
                <table class="table table-bordered">
                    <tr>
                        <td>
                            <label>First Name<span style="color: red;">&nbsp;*</span></label>
                            <input placeholder="First name" class="form-control tech_req" name="tech_fname" />
                        </td>
                        <td>
                            <label>Last Name<span style="color: red;">&nbsp;*</span></label>
                            <input placeholder="Last name" class="form-control tech_req" name="tech_lname" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Mobile<span style="color: red;">&nbsp;*</span></label><span class="mob_error"></span>
                            <input placeholder="Ex: 9820098200" maxlength="10" class="form-control tech_req" name="tech_mobile" onkeypress="return isNumber(event)" />
                            
                        </td>
                        <td>
                            <label>Email</label>
                            <input placeholder="Ex: abc@example.com" class="form-control" name="tech_email" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Address<span style="color: red;">&nbsp;*</span></label>
                            <textarea placeholder="Address" class="form-control tech_req" name="tech_address"></textarea>
                        </td>
                        <td>
                            <label>Branch<span style="color: red;">&nbsp;*</span></label>
                            <select class="form-control tech_req" name="tech_branch" >
                                <option value="-1">-SELECT-</option>
                                <option value="1">Mumbai</option>
                                <option value="2">Pune</option>
                                <option value="3">Thane</option>
                            </select>
                        </td>
                    </tr>                            
                </table>
                </form>
                <div id="result"></div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
        <button class="btn btn-blue tech_register">Create</button>
	</div> 
    </div>  
</div>

<!---End add technician modal --->
<!-- Start Edit Technician modal -->

<div id="modal_edit_tech" style="display: none;">
<div style="background-color: #fff; border-radius: 5px;">
 <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            &times;
        </button>
        <h4 class="modal-title">Edit Technician</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div id="error"></div>
                <form id="edit_technicians_box">
                    <table class="table table-bordered">
                        <!--<tr>
                            <td colspan="2"><select class="form-control select_tech">
                                <option value="a">pls</option>
                            </select></td>
                        </tr>-->
                        <tr>
                            <td>
                                <label>First Name<span style="color: red;">&nbsp;*</span></label>
                                <input placeholder="First name" class="form-control req_t display_tech_fname" id="fname_edit" name="fname" />
                            </td>
                            <td>
                                <label>Last Name<span style="color: red;">&nbsp;*</span></label>
                                <input placeholder="Last name" class="form-control req_t display_tech_lname" id="lname_edit" name="lname" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Mobile<span style="color: red;">&nbsp;*</span></label><span class="mob_error"></span>
                                <input placeholder="Ex: 9820098200" maxlength="10" class="form-control req_t display_tech_mobile" id="mobile_edit" name="mob" onkeypress="return isNumber(event)" />

                            </td>
                            <td>
                                <label>Email</label>
                                <input placeholder="Ex: abc@example.com" class="form-control display_tech_email" id="email_edit" name="mail" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Address<span style="color: red;">&nbsp;*</span></label>
                                <textarea placeholder="Address" class="form-control req_t display_tech_address" id="address_edit" name="add"></textarea>
                            </td>
                            <td>
                                <label>Branch<span style="color: red;">&nbsp;*</span></label>
                                <select class="form-control req_t display_tech_branch" id="branch_edit" name="branch" >
                           
                                </select>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" class="display_tech_id" id="id_edit"/>
                </form>
                <div id="result"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-blue tech_update_btn">Update</button>
    </div>
   </div>
</div>

<!-- End Edit Technician modal -->

<!-- Start Staff Add modal  -->

<div id="modal_add_staff"  style="display: none;">
    <div style="background-color: #fff; border-radius: 5px;">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Add Staff</h4>
			</div>
            <div id="error"></div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
                    
                        <form id="staff">
                        <table id="staff_form" class="table table-bordered">
                            <tr>
                                <td>
                                    <label>First Name<span style="color: red;">&nbsp;*</span></label>
                                    <input placeholder="First name" class="form-control staff_req" name="fname" />
                                </td>
                                <td>
                                    <label>Last Name<span style="color: red;">&nbsp;*</span></label>
                                    <input placeholder="Last name" class="form-control staff_req" name="lname" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Mobile<span style="color: red;">&nbsp;*</span></label>
                                    <input placeholder="Ex: 9820098200" maxlength="10" class="form-control staff_req" name="mobile" onkeypress="return isNumber(event)" />
                                    <span class="error_span"></span>
                                </td>
                                <td>
                                    <label>Email</label>
                                    <input placeholder="Ex: abc@example.com" class="form-control" name="email" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Address<span style="color: red;">&nbsp;*</span></label>
                                    <textarea placeholder="Address" class="form-control staff_req" name="address"></textarea>
                                </td>
                                <td>
                                    <label>Branch<span style="color: red;">&nbsp;*</span></label>
                                    <select class="form-control staff_req" name="staff_branch" >
                                        <option value="-1">-SELECT-</option>
                                        <option value="1">Mumbai</option>
                                        <option value="2">Pune</option>
                                        <option value="3">Thane</option>
                                    </select>
                                </td>
                            </tr>                            
                        </table>
                        </form>
                        <div id="result"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                <button id="staff_register" type="button" class="btn btn-blue">Create</button>
			</div>
   </div>
</div>

<!-- End Staff Add modal -->

<!-- Start Staff Edit modal  -->

<div id="modal_edit_staff"  style="display: none;">
    <div style="background-color: #fff; border-radius: 5px;">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Edit Staff</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
                        <div id="error"></div>
                        <form id="staff">
                        <table id="staff_form" class="table table-bordered">
                            <tr>
                                <td>
                                    <label>First Name<span style="color: red;">&nbsp;*</span></label>
                                    <input placeholder="First name" class="form-control req_s edit_s_fname" id="up_staff_fname" name="fname" />
                                </td>
                                <td>
                                    <label>Last Name<span style="color: red;">&nbsp;*</span></label>
                                    <input placeholder="Last name" class="form-control req_s edit_s_lname" id="up_staff_lname" name="lname" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Mobile<span style="color: red;">&nbsp;*</span></label>
                                    <input placeholder="Ex: 9820098200" maxlength="10" class="form-control req_s edit_s_mobile" id="up_staff_mobile" name="mob" onkeypress="return isNumber(event)" />
                                    <span class="error_span"></span>
                                </td>
                                <td>
                                    <label>Email</label>
                                    <input placeholder="Ex: abc@example.com" class="form-control edit_s_email" id="up_staff_email" name="mail" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Address<span style="color: red;">&nbsp;*</span></label>
                                    <textarea placeholder="Address" class="form-control req_s edit_s_address" id="up_staff_address" name="add"></textarea>
                                </td>
                                <td>
                                    <label>Branch<span style="color: red;">&nbsp;*</span></label>
                                    <select class="form-control req_s edit_s_branch" id="up_staff_branch" name="staff_branch" >

                                    </select>
                                </td>
                            </tr>                            
                        </table>
                        <input type="hidden" class="edit_s_id" id="up_staff_id" />
                        </form>
                        <div id="result"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                <input id="staff_update" type="button" class="btn btn-blue" value="Update" />
			</div>
   </div>
</div>

<!-- End Staff Edit modal -->


<div id="assign_techncican_modal" style="display: none;">
    <div style="background-color: #fff; border-radius: 5px; ">
        <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Assign</h4>
		</div>
        <div class="modal-body"><div id="error"></div>
            <table id="assign_tech_table" class="table table-striped table-bordered">
                
            </table>
            <div id="result"></div>
        </div>
        <div class="modal-footer">
              <div id="assign_tech_table_footer">

              </div>
		</div>
    </div>
</div>


<div id="view_amc_modal" style="display: none;">
    <div style="background-color: #fff; border-radius: 5px; ">
        <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Service Date</h4>
		</div>
        <div class="col-md-12" style="background-color: white;"><div id="error"></div>

                    <table id="service_date_table" class="table table-striped table-bordered table-condensed">
                        
                    </table>              


  
            <div id="result"></div>
        </div>
        <div class="modal-footer">
		</div>
    </div>
</div>

<div id="dialog_modal_box" class="modal fade">
    <div class="modal-dialog">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>

    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->