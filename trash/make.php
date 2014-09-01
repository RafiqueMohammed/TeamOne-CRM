<?php

include_once("common.php");

/**

 * Created by Rafique

 * Date: 6/17/14

 * Time: 2:55 PM

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

        <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">

                            &times;

                        </button>

                        <h4 class="modal-title">Panel Configuration</h4>

                    </div>

                    <div class="modal-body">

                        Here will be a configuration form

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">

                            Close

                        </button>

                        <button type="button" class="btn btn-primary">

                            Save changes

                        </button>

                    </div>

                </div>

                <!-- /.modal-content -->

            </div>

            <!-- /.modal-dialog -->

        </div>

        <!-- /.modal -->

        <!-- end: SPANEL CONFIGURATION MODAL FORM -->





<!-- BODY CONTENT STARTS HERE -->



        <div class="container">

            <!-- start: PAGE HEADER -->

            <div class="row">

                <div class="col-sm-12">

                    <!-- start: PAGE TITLE & BREADCRUMB -->

                    <ol class="breadcrumb">

                        <li>

                            <i class="clip-file"></i>

                            <a href="#">

                                Pages

                            </a>

                        </li>

                        <li class="active">

                            Blank Page

                        </li>

                        <li class="search-box">

                            <form class="sidebar-search">

                                <div class="form-group">

                                    <input type="text" placeholder="Start Searching...">

                                    <button class="submit">

                                        <i class="clip-search-3"></i>

                                    </button>

                                </div>

                            </form>

                        </li>

                    </ol>

                    <div class="page-header">

                        <h1>Blank Page <small>blank page</small></h1>

                    </div>

                    <!-- end: PAGE TITLE & BREADCRUMB -->

                </div>

            </div>

            <!-- end: PAGE HEADER -->

            <!-- start: PAGE CONTENT -->
            <div class="col-md-8">
            <?php
            if(isset($_POST['submit'])){
                $type=$_POST['type'];
                $make=$_POST['make'];
                $model=$_POST['model'];
                $tonnage=$_POST['tonnage'];
                echo $make." ".$type." ".$model." ".$tonnage;
                $qry=$DB->query("INSERT INTO `customer_ac_details` (`ac_type`,`make`) VALUES('$type','$make')") or die($DB->error);
                if($DB->affected_rows > 0){
                    echo  "<h4 class='alert alert-succes'>Inserted Succesfully</h4>";
                }else{
                    echo "<h4 class='alert alert-danger'>Cannot insert the record.. please try again! </h4>";
                }
            }
            ?>            
            </div>
            <div class="col-md-8">
            <form action="" method="post">
            <table class="table table-bordered">
                <tr>
                    <th>AC Type</th>
                    <th>Make</th>
                    <th>Model no</th>
                    <th>Tonnage</th>
                </tr>
                <tr>
                    <td><input type="text" name="type" class="form-control" /></td>
                    <td><input type="text" name="make" class="form-control" /></td>
                    <td><input type="text" name="model" class="form-control" /></td>
                    <td><input type="text" name="tonnage" class="form-control" /></td>
                </tr>
                <tr>
                    <td colspan="4"><input type="submit" name="submit" class="btn btn-primary" /></td>
                </tr>
            </table>
            </form>
            </div>
            <!-- end: PAGE CONTENT-->

        </div>



        <!-- BODY CONTENT ENDS HERE -->







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
