<?php
require_once("common.php");
/**
 * Created by Rafique
 * Date: 7/16/14
 * Time: 5:24 PM
 */

?>

<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->

<!-- start: HEAD -->
<head>
    <?php require_once INC_DIR."head.php"; ?>
</head>
<!-- end: HEAD -->

<!-- start: BODY -->
<body>

<!-- start: HEADER -->
<?php require_once INC_DIR."header.php"; ?>
<!-- end: HEADER -->



<!-- start: MAIN CONTAINER -->
<div class="main-container">

    <?php require_once INC_DIR."sidebar.php"; ?>




    <!-- start: PAGE -->
    <div class="main-content">

        <!-- start: PANEL CONFIGURATION MODAL FORM -->
        <?php require_once(VIEW_DIR."ModalCollection.php"); ?>
        <!-- /.modal -->
        <!-- end: SPANEL CONFIGURATION MODAL FORM -->

        <!-- start: CONTAINER -->
        <div class="container">
        <?php
        /**
         * Created by Rafique
         * Date: 7/16/14
         * Time: 3:38 PM
         */

        ?>
        <div class="row">

            <div class="col-sm-12">

                <!-- start: PAGE TITLE & BREADCRUMB -->

                <ol class="breadcrumb">



                </ol>

                <div class="page-header">

                    <h1>Customer Registration <small>Register</small></h1>



                </div>

                <!-- end: PAGE TITLE & BREADCRUMB -->

            </div>

        </div>

        <!-- end: PAGE HEADER -->

        <form action="" method="post" name="form" onsubmit="return validate(this);">

        <table class="table table-bordered">

            <tr>

                <td>Place Type</td>

                <td><select class="form-control" name="place_type" id="form-field-1">

                        <option>--SELECT TYPE--</option>

                        <option value="Residential">Residential</option>

                        <option value="Commercial">Commercial</option>

                    </select></td>

                <td>Organization Name</td>

                <td><textarea class="form-control" name="org_name"></textarea><!--<input id="form-field-2" style="width: 100%;" type="text"  class="form-control" />--></td>

            </tr>

            <tr>

                <td>First name *</td>

                <td>

                            <span class="input-icon">

                            <input type="text" id="form-field-3" class="form-control" name="fname" placeholder="First Name"/>

                            <i class="fa fa-user"></i></span></td>

                <td>Last Name *</td>

                <td>

                            <span class="input-icon">

                            <input type="text" id="form-field-4" class="form-control" name="lname" placeholder="Last Name" />

                            <i class="fa fa-user"></i></span>

                </td>

            </tr>

            <tr>

                <td>Mobile 1 *</td>

                <td><span class="input-icon">

                            <input type="text" id="form-field-5" name="mobile1" size="10" maxlength="10" class="form-control" placeholder="Mobile Number" /><i class=" clip-mobile "></i></span></td>

                <td>Mobile 2 </td>

                <td><span class="input-icon">

                            <input type="text" id="form-field-6" class="form-control" size="10" maxlength="10" name="mobile2" placeholder="Mobile Number" /><i class=" clip-mobile "></i></span></td>

            </tr>

            <tr>

                <td>Email *</td>

                <td>

                            <span class="input-icon">

                            <input type="text" id="form-field-7" class="form-control" name="email" placeholder="Email" /><i class="fa-envelope-o"></i></span></td>

                <td>Landline *</td>

                <td><span class="input-icon">

                            <input type="text" id="form-field-8" class="form-control" size="12" maxlength="12" name="landline" placeholder="Ex: 022 25252525" />

                            <i class="clip-phone"></i></span></td>

            </tr>

            <tr>

                <td>Address *</td>

                <td><textarea class="form-control" id="form-field-13" name="address" placeholder="Address"></textarea>
                </td>

                <td>Pincode *</td>

                <td><input type="text" id="form-field-10" class="form-control" name="location" placeholder="Location"/></td>

            </tr>

            <tr>

                <td>City *</td>

                <td><input type="text" id="form-field-11" class="form-control" name="city" placeholder="City"/></td>

                <td>Landmark *</td>

                <td><input type="text" id="form-field-12"  class="form-control" name="landmark" placeholder="Landmark" /></td>

            </tr>

            <tr>

                <td>Location *</td>

                <td><input type="text" id="form-field-9" class="form-control" name="pincode" placeholder="Pincode" /></td>

                <td>Alternate Contacts</td>

                <td><textarea class="form-control" placeholder="David = 9820098200 " name="alternate_contact" id="form-field-14" ></textarea></td>

            </tr>

            <tr>

                <td>Mode Of Commumnication *</td>

                <td><select name="communication_type" class="form-control" id="form-field-15">

                        <option>--SELECT--</option>

                        <option value="Mobile">Mobile</option>

                        <option value="Email">Email</option>

                    </select></td>

                <td>Refered by *</td>

                <td><select name="refered_by" id="refer" class="form-control">

                        <option>--SELECT--</option>

                        <option value="Web">Web</option>

                        <option value="Team one website">Team one website</option>

                        <option value="Dealer">Dealer</option>

                        <option value="Existing Customer">Existing Customer</option>

                        <option value="Direct Marketing">Direct Marketing</option>

                        <option value="Just Dail">Just Dail</option>

                        <option id="customer" value="Existing Customer">Existing Customer</option>

                        <option value="other">Other</option>

                    </select></td>

            </tr>

            <tr id="other" style="display: none;">

                <td></td><td></td>

                <td>Specify Other *</td>

                <td><input name="other" id="form-field-16" class="form-control" /></td>

            </tr>

            <tr>

                <td>Date Of Birth</td>

                <td>

                    <div class="input-group">

                        <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" id="dob" name="birthdate" class="form-control date-picker"/>

                        <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>

                    </div>

                </td>

                <td>Remarks</td>

                <td><textarea class="form-control" name="remarks" id="form-field-17"></textarea></td>

            </tr>

            <tr>

                <td colspan="4" style="text-align: center;"><input type="submit" name="submit" id="register" class="btn btn-primary" value="Register"/></td>

            </tr>

        </table>

        </form>
        </div>
        <!-- end: CONTAINER -->

    </div>
    <!-- end: PAGE -->

</div>
<!-- end: MAIN CONTAINER -->

<!-- start: FOOTER -->
<?php require_once INC_DIR."footer.php"; ?>
<!-- end: FOOTER -->

</body>
<!-- end: BODY -->

</html>

