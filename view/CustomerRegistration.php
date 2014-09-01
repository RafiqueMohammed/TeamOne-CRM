<?php require_once("common.php");?>
<?php
$cust_id=(isset($_GET['cust_id'])&&!empty($_GET['cust_id']))? $_GET['cust_id']:-1;
?>
<input type="hidden" id="customer_id_holder" value="<?php echo $cust_id;?>" />
<div class="row">

    <div class="col-sm-12">

        <!-- start: PAGE TITLE & BREADCRUMB -->

        <ol class="breadcrumb">


        </ol>

        <div class="page-header">

            <h1>New Customer
                <small>Customer Registration Form</small>
            </h1>
        </div>

        <!-- end: PAGE TITLE & BREADCRUMB -->

    </div>

</div>

<!-- end: PAGE HEADER -->
<div id="validation_error" ></div>
<div class="row step-1">
<div class="table-responsive">
<form id="RegistrationForm" action="" method="post" name="RegistrationForm" onsubmit="return validate(this);">
<table id="table1" class="table table-striped table-bordered ">

<tbody>
<tr>

    <td class="col-sm-2">Account Type
        <span class="error_span"></span>
    </td>

    <td class="col-sm-4">

        <label class="radio-inline"> <input type="radio" class="green acc_type" name="acc_type" checked="checked" value="r">Residential
        </label>
        <label class="radio-inline"> <input type="radio" class="green acc_type" name="acc_type" value="c">Commercial
        </label>


    </td>

    <td class="col-sm-2">Organization Name
        </td>

    <td class="col-sm-4">
        <span>
        <textarea id="registration_organisation" class="form-control" name="org_name"></textarea>
            </span>
        <span class="error_span"></span>
    </td>

</tr>

<tr>

    <td>First name <span class="symbol required"></span>
        </td>

    <td>

<span class="input-icon">

<input type="text" class="form-control req" name="firstname" id="registration_firstname"
       placeholder="First Name"/>

<i class="fa fa-user"></i></span>
        <span class="error_span"></span>
    </td>

    <td>Last Name <span class="symbol required"></span></td>

    <td>

<span class="input-icon">

<input type="text" id="registration_lastname" class="form-control req" name="lastname"
       placeholder="Last Name"/>
<i class="fa fa-user"></i></span>
        <span class="error_span"></span>
    </td>

</tr>

<tr>

    <td>Mobile 1 <span class="symbol required"></span></td>

    <td><span class="input-icon">

<input type="text"  id="registration_mobile1" name="mobile1" maxlength="10"
       class="form-control req" placeholder="Mobile Number"/><i
                class=" clip-mobile "></i></span>
        <span class="error_span"></span>
    </td>

    <td>Mobile 2</td>

    <td><span class="input-icon">

<input type="text" id="registration_mobile2" class="form-control" maxlength="10"
       name="mobile2" placeholder="Mobile Number"/><i class=" clip-mobile "></i></span>
        <span class="error_span"></span>
    </td>

</tr>

<tr>

    <td>Email</td>

    <td>

<span class="input-icon">

<input type="text" id="registration_email" class="form-control" name="email" placeholder="Email"/><i
        class="fa fa-envelope-o"></i></span>
        <span class="error_span"></span>
    </td>

    <td>Landline</td>

    <td><span class="input-icon">

<input type="text" id="registration_landline" class="form-control"  maxlength="15"
       name="landline" placeholder="Ex: 022 25252525"/>

<i class="clip-phone"></i></span>
        <span class="error_span"></span>
    </td>

</tr>

<tr>

    <td>Address <span class="symbol required"></span></td>
    <td>
        <span class="input-icon">
        <textarea class="form-control req" id="registration_address" name="address" placeholder="Address"></textarea>
        
        </span>
        <span class="error_span"></span>
    </td>

    <td>Alternate Contacts</td>
    <td>
        <span class="input-icon">
        <textarea class="form-control" placeholder="David = 9820098200 " name="alternate_contact"
                  id="registration_alternate_contacts"></textarea>
        </span>
        <span class="error_span"></span>
    </td>

</tr>

<tr>

    <td>Pincode <span class="symbol required"></span></td> 
    <td >
<span class="input-icon">
    <input type="text" id="registration_pincode" maxlength="6" autocomplete="off"
           class="form-control req" name="pincode" placeholder="Pincode"/>
    <i class="fa fa-location-arrow"></i>
</span>

        <div id="pincode_display" style="position: absolute; z-index: 10; display: table; width: 27.5%;"></div>

            <span class="error_span"></span>

    </td>


    <td>City <span class="symbol required"></span></td>

    <td>
        <span class="input-icon">
        <input type="text" id="registration_city" class="form-control req" name="city" value="Mumbai" placeholder="City"/>
        <i class="clip-location"></i>
        </span>
        <span class="error_span"></span>
    </td>

</tr>

<tr>

    <td>Landmark <span class="symbol required"></span></td>

    <td>
        <span>
        <!--<input type="text" id="registration_landmark" class="form-control req" name="landmark" placeholder="Landmark"/>-->
        <select id="registration_landmark" class="form-control req" name="landmark">
            <option value="-1"> - Not Available - </option>
        </select>
        </span>
        <span class="error_span"></span>
    </td>

    <td>Location <span class="symbol required"></span></td>

    <td>
        <span class="input-icon">
        <input type="text" id="registration_location" class="form-control req" name="location" placeholder="Your Location"/>
        <i class="clip-map "></i>
        </span>
        <span class="error_span"></span>
    </td>

</tr>

<tr>

    <td>Mode Of Communication <span class="symbol required"></span></td>

    <td class="col-sm-4">  
        <label class="radio-inline"> <input type="radio" class="green" name="communication_type" checked value="m">Mobile
        </label>
        <label class="radio-inline"> <input type="radio" class="green" name="communication_type" value="e">Email
        </label>
        <label class="radio-inline"> <input type="radio" class="green" name="communication_type" value="b">Both
        </label>     
    </td>

    <td>Referred by <span class="symbol required"></span></td>

    <td>

        <span class="col-sm-6">
        <select name="referred" id="registration_referred" class="form-control req">

            <option value="">--SELECT--</option>

            <option value="Web">Web</option>

            <option value="Team one website">Team one website</option>

            <option value="Dealer">Dealer</option>

            <option value="Direct Marketing">Direct Marketing</option>

            <option value="Just Dial">Just Dial</option>

            <option class="referred_other" id="customer" value="exist_cust">Existing Customer</option>

            <option class="referred_other" value="other">Other</option>

        </select>
            </span>

       <span class="col-sm-6"> <input style="display: none;" name="referred_other" placeholder="Specify Other" id="registration_referred_other" class="form-control oth_show"/>
 </span>
        <span class="error_span"></span>
    </td>

</tr>

<tr>

    <td>Date Of Birth</td>

    <td>

<span class="input-icon">
            <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years"
                   id="registration_dob" name="dob"
                   class="form-control date-picker"/>
        <i class="clip-calendar"></i>
</span>
        <span class="error_span"></span>

    </td>

    <td>Remarks</td>
    
    <td><span class="input-icon"><textarea class="form-control" name="remarks" id="registration_remarks"></textarea>
    </span>
    </td>

</tr>
<!--<tr id="error_tr" style="display: none;">
    <td colspan="4" style="text-align: center;">
        <div class="col-sm-6 alert-msg"></div>
    </td>
</tr>-->
<tr>

    <td colspan="4" style="text-align: center;">
        <div class="col-sm-6 ">

        </div>
        <div class="col-sm-6" >
            <button name="submit" id="registration_submit" class="col-sm-12 btn btn-primary" >
              <i class="clip-plus-circle-2 "></i>  Create Account
                </button>
        </div>
        </td>

</tr>
</tbody>

</table>
</form>
</div>
</div>
<div class="row step-2" style="display: none">

    <input type="hidden" id="customer_new_id" value="-1">
    <div class="col-sm-12" id="error_result"></div>
    <div class="col-sm-12 table-responsive">

<!--- 2nd table starts  -->
<form id="customer_ac_form" name="form2">
<table  class="table table-bordered ">
    <thead>
    <tr>
        <td>AC type</td>
        <td>Make</td>
        <td>Tonnage</td>
        <td>IDU</td>
        <td>ODU</td>
        <td>Location</td>
        <td>Remarks</td>
        <td></td>
    </tr>
    </thead>
<tbody id="customer_ac_body">

</tbody>

        
        
</table>


<table class="table table-bordered">

    <tr>
        <td colspan="4" style="text-align: center;">
            <input type="button" class="btn btn-primary" name="submit" id="customer_ac_details_submit" value="Submit"/>

            <a class="pull-right btn btn-info" onclick="add_customer_ac_row()" style="cursor: pointer; border-radius:100%">+</a>
        </td>
    </tr>

</table>
</form>
<!--- 2nd table ends  -->


</div>
</div>
<script type="text/javascript" src="assets/js/CustomerRegistration.js"></script>