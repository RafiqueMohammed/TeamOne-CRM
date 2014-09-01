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

<!--[if IE 8]>
<html class="ie8 no-js" lang="en"><![endif]-->

<!--[if IE 9]>
<html class="ie9 no-js" lang="en"><![endif]-->

<!--[if !IE]><!-->

<html lang="en" class="no-js">

<!--<![endif]-->

<!-- start: HEAD -->

<head>

    <?php require_once INC_DIR . "head.php"; ?>

</head>

<!-- end: HEAD -->

<!-- start: BODY -->

<body>

<!-- start: HEADER -->

<?php require_once INC_DIR . "header.php"; ?>

<!-- end: HEADER -->


<!-- start: MAIN CONTAINER -->

<div class="main-container">

<?php require_once INC_DIR . "sidebar.php"; ?>











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

            <h1>Blank Page
                <small>blank page</small>
            </h1>

        </div>

        <!-- end: PAGE TITLE & BREADCRUMB -->

    </div>

</div>

<!-- end: PAGE HEADER -->

<!-- start: PAGE CONTENT -->


<table class="table table-bordered" id="product_detail">

<tr>

    <th>AC Type</th>

    <th>Make</th>

    <th>Model no</th>

    <th>IDU</th>

    <th>ODU</th>

    <th>Tonnage</th>

    <th>Location</th>

    <th>Remarks</th>

</tr>

<tr>

    <td>

        <select class='form-control' name='product_type "+total+"' class='product_type'>
            <option value=''>Select</option>
            <option value='split'>Split</option>
            <option value='window'>Window</option>
            <option value='ducted'>Ducted</option>
        </select>

    </td>

    <td>

        <select class='form-control' name='brand_name "+total+"'>
            <option value=''>Select</option>
            <option value='Bluestar'>Blue Star</option>
            <option value='Onida'>Onida</option>
            <option value='Daiken'>Daiken</option>
            <option id='other' value='other'>Other</option>
        </select>

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td>

        <select name='capacity "+total+"' class='form-control'>
            <option value='0.75 ton'>0.75 ton</option>
            <option value='1 ton'>1 ton</option>
            <option value='1.5 ton'>1.5 ton</option>
            <option value='2 tons'>2 ton</option>
            <option value='3 ton and above'>3 ton Above</option>
        </select>

    </td>

    <td>

        <select class='form-control' name='location "+total+"'>
            <option value='living'>Living Room</option>
            <option value='bed'>Bed Room</option>
            <option value='hall'>Hall</option>
            <option value='Kidsroom'>Kids Room</option>
            <option value='other'>Other</option>
        </select>

    </td>

    <td>

        <textarea class="form-control"></textarea>

    </td>

</tr>

<tr>

    <td style="width:121px">

        <select style='width: 130px;' class='form-control' name='product_type "+total+"' class='product_type'>
            <option value=''>Select</option>
            <option value='split'>Split</option>
            <option value='window'>Window</option>
            <option value='ducted'>Ducted</option>
        </select>

    </td>

    <td style="width: 94px;">

        <select style='width: 110px;' class='form-control' name='brand_name "+total+"'>
            <option value=''>Select</option>
            <option value='Bluestar'>Blue Star</option>
            <option value='Onida'>Onida</option>
            <option value='Daiken'>Daiken</option>
            <option id='other' value='other'>Other</option>
        </select>

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td style="width: 92px;">

        <select style='width: 110px;' name='capacity "+total+"' class='form-control'>
            <option value='0.75 ton'>0.75 ton</option>
            <option value='1 ton'>1 ton</option>
            <option value='1.5 ton'>1.5 ton</option>
            <option value='2 tons'>2 ton</option>
            <option value='3 ton and above'>3 ton Above</option>
        </select>

    </td>

    <td style="width: 128px;">

        <select class='form-control' name='location "+total+"'>
            <option value='living'>Living Room</option>
            <option value='bed'>Bed Room</option>
            <option value='hall'>Hall</option>
            <option value='Kidsroom'>Kids Room</option>
            <option value='other'>Other</option>
        </select>

    </td>

    <td>

        <textarea class="form-control"></textarea>

    </td>

</tr>

<tr>

    <td style="width:121px">

        <select style='width: 130px;' class='form-control' name='product_type "+total+"' class='product_type'>
            <option value=''>Select</option>
            <option value='split'>Split</option>
            <option value='window'>Window</option>
            <option value='ducted'>Ducted</option>
        </select>

    </td>

    <td style="width: 94px;">

        <select style='width: 110px;' class='form-control' name='brand_name "+total+"'>
            <option value=''>Select</option>
            <option value='Bluestar'>Blue Star</option>
            <option value='Onida'>Onida</option>
            <option value='Daiken'>Daiken</option>
            <option id='other' value='other'>Other</option>
        </select>

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td style="width: 92px;">

        <select style='width: 110px;' name='capacity "+total+"' class='form-control'>
            <option value='0.75 ton'>0.75 ton</option>
            <option value='1 ton'>1 ton</option>
            <option value='1.5 ton'>1.5 ton</option>
            <option value='2 tons'>2 ton</option>
            <option value='3 ton and above'>3 ton Above</option>
        </select>

    </td>

    <td style="width: 128px;">

        <select class='form-control' name='location "+total+"'>
            <option value='living'>Living Room</option>
            <option value='bed'>Bed Room</option>
            <option value='hall'>Hall</option>
            <option value='Kidsroom'>Kids Room</option>
            <option value='other'>Other</option>
        </select>

    </td>

    <td>

        <textarea class="form-control"></textarea>

    </td>

</tr>

<tr>

    <td style="width:121px">

        <select style='width: 130px;' class='form-control' name='product_type "+total+"' class='product_type'>
            <option value=''>Select</option>
            <option value='split'>Split</option>
            <option value='window'>Window</option>
            <option value='ducted'>Ducted</option>
        </select>

    </td>

    <td style="width: 94px;">

        <select style='width: 110px;' class='form-control' name='brand_name "+total+"'>
            <option value=''>Select</option>
            <option value='Bluestar'>Blue Star</option>
            <option value='Onida'>Onida</option>
            <option value='Daiken'>Daiken</option>
            <option id='other' value='other'>Other</option>
        </select>

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td style="width: 92px;">

        <select style='width: 110px;' name='capacity "+total+"' class='form-control'>
            <option value='0.75 ton'>0.75 ton</option>
            <option value='1 ton'>1 ton</option>
            <option value='1.5 ton'>1.5 ton</option>
            <option value='2 tons'>2 ton</option>
            <option value='3 ton and above'>3 ton Above</option>
        </select>

    </td>

    <td style="width: 128px;">

        <select class='form-control' name='location "+total+"'>
            <option value='living'>Living Room</option>
            <option value='bed'>Bed Room</option>
            <option value='hall'>Hall</option>
            <option value='Kidsroom'>Kids Room</option>
            <option value='other'>Other</option>
        </select>

    </td>

    <td>

        <textarea class="form-control"></textarea>

    </td>

</tr>

<tr>

    <td style="width:121px">

        <select style='width: 130px;' class='form-control' name='product_type "+total+"' class='product_type'>
            <option value=''>Select</option>
            <option value='split'>Split</option>
            <option value='window'>Window</option>
            <option value='ducted'>Ducted</option>
        </select>

    </td>

    <td style="width: 94px;">

        <select style='width: 110px;' class='form-control' name='brand_name "+total+"'>
            <option value=''>Select</option>
            <option value='Bluestar'>Blue Star</option>
            <option value='Onida'>Onida</option>
            <option value='Daiken'>Daiken</option>
            <option id='other' value='other'>Other</option>
        </select>

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td>

        <input type="text" class="form-control">

    </td>

    <td style="width: 92px;">

        <select style='width: 110px;' name='capacity "+total+"' class='form-control'>
            <option value='0.75 ton'>0.75 ton</option>
            <option value='1 ton'>1 ton</option>
            <option value='1.5 ton'>1.5 ton</option>
            <option value='2 tons'>2 ton</option>
            <option value='3 ton and above'>3 ton Above</option>
        </select>

    </td>

    <td style="width: 128px;">

        <select class='form-control' name='location "+total+"'>
            <option value='living'>Living Room</option>
            <option value='bed'>Bed Room</option>
            <option value='hall'>Hall</option>
            <option value='Kidsroom'>Kids Room</option>
            <option value='other'>Other</option>
        </select>

    </td>

    <td>

        <textarea class="form-control"></textarea>

    </td>

</tr>

</table>

<table class="table table-bordered">

    <!--<tr><td colspan="4" style="text-align: center;"><input type="submit" class="btn btn-primary" name="add_new" id="add_new" value="Add New Product"/></td></tr>-->

    <tr>
        <td colspan="4" style="text-align: center;"><input type="submit" class="btn btn-primary" name="submit"
                                                           id="submit" value="Submit"/>

            <div class="pull-right" id="add_new" style="cursor: pointer">+</div>
        </td>
    </tr>

</table>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script type="text/javascript">

    $(function () {

// $('#product_details').css('display','none');

//$('#submit').css('display','none');

        $('#add_new').click(function (e) {

            $('#product_details').show();

            var total = $('.product_type').length;

            if (parseInt(total + 1) > 4) {

                $(this).remove();

            }

            total = total + 1;


            var htm = "<tr><td style=' padding: 2px;'><select style='width: 130px;' class='form-control' name='product_type " + total + "' class='product_type'><option value=''>Select</option><option value='split'>Split</option><option value='window'>Window</option><option value='ducted'>Ducted</option></select></td><td style='padding:10px; '><select style='width: 110px;' class='form-control' name='brand_name " + total + "'><option value=''>Select</option><option value='Bluestar'>Blue Star</option><option value='Onida'>Onida</option><option value='Daiken'>Daiken</option><option id='other' value='other'>Other</option></select></td><td style='padding:6px'><input type='text' style='width:80px' class='form-control'/></td><td style='padding:10px'><input style='width:80px' type='text' class='form-control'/></td><td style='padding:3px'><input style='width:80px' type='text' class='form-control'/></td><td style='padding:10px;'><select style='width: 110px; ' name='capacity " + total + "' class='form-control'><option value='0.75 ton'>0.75 ton</option><option value='1 ton'>1 ton</option><option value='1.5 ton'>1.5 ton</option><option value='2 tons'>2 ton</option><option value='3 ton and above'>3 ton Above</option></select></td><td style='padding: 5px;'><select class='form-control' style='width:114px'  name='location " + total + "'><option value='living'>Living Room</option><option value='bed'>Bed Room</option><option value='hall'>Hall</option><option value='Kidsroom'>Kids Room</option><option value='other'>Other</option></select></td><td style='padding: 10px;'><textarea style='width: 273px;' class='form-control'></textarea></td></tr>";


            $('#product_detail').append(htm).hide().slideDown("slow");

            if ($('#submit').css('display') == 'none') {

                $('#submit').show();

            }


        });

    });

</script>

<!-- end: PAGE CONTENT-->

</div>


<!-- BODY CONTENT ENDS HERE -->


</div>

<!-- end: PAGE -->


</div>

<!-- end: MAIN CONTAINER -->

<!-- start: FOOTER -->

<?php require_once INC_DIR . "footer.php"; ?>

<!-- end: FOOTER -->

</body>

<!-- end: BODY -->

</html>