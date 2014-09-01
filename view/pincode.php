<?php require_once("common.php");
/**
 * Created by Rafique
 * Date: 8/4/14
 * Time: 5:49 PM
 */
 
$qry=$DB->query("SELECT * FROM `".TAB_LOCALITY."`");
$pin = '';
while($info=$qry->fetch_array()){
    $pin .= "<tr><td>".$info['pincode']."</td></tr>";
} 
?>

		<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2.css" />
		<link rel="stylesheet" href="assets/plugins/DataTables/media/css/DT_bootstrap.css" />
<div class="row">

    <div class="col-sm-12">

        <!-- start: PAGE TITLE & BREADCRUMB -->
        <?php require_once(INC_DIR."breadcrumb.php"); ?>

        <!-- end: PAGE TITLE & BREADCRUMB -->

        <div class="page-header">

            <h1>Pincode <small>For Test</small></h1>

        </div>

    </div>

</div>
<!-- end: PAGE HEADER -->



<!-- start: PAGE CONTENT -->


    <!-- WRITE HEREEEE ---------->
<div class="row">
						<div class="col-md-12">
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
                                    Dynamic Table
								</div>
								<div class="panel-body">
									<table class="pin_row table table-striped table-bordered table-hover table-full-width" id="sample_1">
											<thead><tr>
												<th>Pincode</th>
											</tr></thead>
                                            <tbody>
                                            <?php echo $pin; ?>
                                            </tbody>
									</table>
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
</div>


<!-- end: PAGE CONTENT-->
		<script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
		<script type="text/javascript" src="assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
        <script src="tmp/assets/js/table-data.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				TableData.init();
			});
		</script>       