<?php require_once("common.php"); ?>
<div class="row">

    <div class="col-sm-12">

        <!-- start: PAGE TITLE & BREADCRUMB -->
        <?php require_once(INC_DIR . "breadcrumb.php"); ?>

        <!-- end: PAGE TITLE & BREADCRUMB -->

        <div class="page-header">

            <h1><i class="fa fa-envelope-o"></i> Send Email
                <small>Bulk / Single</small>
            </h1>

        </div>

    </div>

</div>
<!-- end: PAGE HEADER -->


<!-- start: PAGE CONTENT -->
<div class="col-md-12">

    <div class="col-md-6">
        <div class="single_screen1" style="background:#444;color:#fff;min-height: 250px;margin: auto;">
            <h2 style="padding-top: 15%;padding-left: 30%">Single Email</h2>

        </div>
        <div class="single_screen2 no-display" style="padding: 8px">
            <div style="margin-top: 5px">
                <label>Email</label>
                <input class="form-control single_req single_email">
            </div>
            <div style="margin-top: 5px">
                <label>Your Message</label>
                <textarea class="form-control single_req single_email_message"></textarea>
            </div>

            <div style="margin-top: 8px">
                <input type='button' value="Send" class='col-md-6 send_single_mail_btn btn btn-lg btn-primary'/>

                <div id="single_screen_result" style="text-align: center;" class='col-md-6 no-display'></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="multiple_screen1" style="background:#444;color:#fff;min-height: 250px;margin: auto;">
            <h2 style="padding-top: 15%;padding-left: 30%">Bulk Email</h2>

        </div>
        <div class="multiple_screen2 no-display" style="padding: 8px">

            <div style="margin-top: 5px">
                <label>Your Message</label>
                <textarea class="form-control bulk_email" style="height: 135px;"></textarea>
            </div>

            <div style="margin-top: 8px">
                <input type='button' value="Send" class='col-md-6 send_multiple_mail_btn btn-lg btn btn-primary'/>

                <div id="multiple_screen_result" style="text-align: center;" class='col-md-6 no-display'></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>


</div>
<div class="clearfix"></div>
<!-- end: PAGE CONTENT-->
<script type="text/javascript" src="assets/js/Compose.js"/>