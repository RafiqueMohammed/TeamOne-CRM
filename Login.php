<?php
session_start();
ob_start();
require_once("include/config.php");
require_once("controller/class.staff.php");
$staff=new controller\staff\Staff($DB);
if($staff->isLoggedin()){
    $staff->redirect("/",true);
}
/**
 * Created by Rafique
 * Date: 7/16/14
 * Time: 5:24 PM
 */
?>

<!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3.x Version: 1.3 Author: ClipTheme -->
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
<body class="login example2">
<div class="main-login col-sm-4 col-sm-offset-4">
    <div class="logo">TEAM<i class="clip-users-2"></i>ONE
    </div>
    <!-- start: LOGIN BOX -->
    <div class="box-login">
        <h3>Sign in to your account</h3>
        <p>
            Please enter your name and password to log in.
        </p>
        <form class="form-login">
            <div class="errorHandler alert alert-danger no-display">
                <i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
            </div>
            <fieldset>
                <div class="form-group">
							<span class="input-icon">
								<input type="text" class="form-control username" name="username" placeholder="Username">
								<i class="fa fa-user"></i> </span>
                </div>
                <div class="form-group form-actions">
							<span class="input-icon">
								<input type="password" class="form-control password" name="password" placeholder="Password">
								<i class="fa fa-lock"></i>
								 </span>
                </div>
                <div class="form-actions">

                    <button class="btn btn-bricky pull-right" id="btn_login">
                        Login <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
            </fieldset>
        </form>
    </div>
    <!-- end: LOGIN BOX -->

    <!-- start: COPYRIGHT -->
    <div class="copyright">

            2015 &copy; Developed by Growthwell Consulting Pvt. Ltd..

    </div>
    <!-- end: COPYRIGHT -->
</div>
<!-- start: MAIN JAVASCRIPTS -->
<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script src="assets/plugins/blockUI/jquery.blockUI.js"></script>
<script src="assets/plugins/iCheck/jquery.icheck.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
<script src="assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
<script src="assets/plugins/less/less-1.5.0.min.js"></script>
<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
<script src="assets/js/main.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="assets/js/login.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script>
    jQuery(document).ready(function() {
        Main.init();

    });
</script>
</body>
<!-- end: BODY -->
</html>