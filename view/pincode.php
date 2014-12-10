<?php require_once("common.php");?>

		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link rel="stylesheet" href="tmp/assets/plugins/select2/select2.css">
		<link rel="stylesheet" href="tmp/assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css">
		<link rel="stylesheet" href="tmp/assets/plugins/x-editable/css/bootstrap-editable.css">
		<link rel="stylesheet" href="tmp/assets/plugins/typeaheadjs/lib/typeahead.js-bootstrap.css">
		<link rel="stylesheet" href="tmp/assets/plugins/jquery-address/address.css">
		<link rel="stylesheet" href="tmp/assets/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.css">
		<link rel="stylesheet" href="tmp/assets/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/wysiwyg-color.css">
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
<div class="row">

    <div class="col-sm-12">

    <!-- start: PAGE TITLE & BREADCRUMB -->
    <?php require_once(INC_DIR."breadcrumb.php"); ?>

        <!-- end: PAGE TITLE & BREADCRUMB -->

        <div class="page-header">

            <h1>Blank <small>page</small></h1>

        </div>

    </div>

</div>
<!-- end: PAGE HEADER -->



<!-- start: PAGE CONTENT -->
<div class="row">


<!-- WRITE HEREEEE ---------->

<div class="row">
						<div class="col-sm-12">
							<table id="user" class="table table-bordered table-striped" style="clear: both">
								<tbody>
									<tr>
										<td class="column-left">Simple text field</td>
										<td class="column-right">
										<a href="#" id="username" data-type="text" data-pk="1" data-original-title="Enter username">
											superuser
										</a></td>
									</tr>
									<tr>
										<td>Empty text field, required</td>
										<td><a href="#" id="firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-original-title="Enter your firstname">
										</a></td>
									</tr>
									<tr>
										<td>Select, local array, custom display</td>
										<td><a href="#" id="sex" data-type="select" data-pk="1" data-value="" data-original-title="Select sex">
										</a></td>
									</tr>
									<tr>
										<td>Select, remote array, no buttons</td>
										<td>
										<a href="#" id="group" data-type="select" data-pk="1" data-value="5" data-source="/groups" data-original-title="Select group">
											Admin
										</a></td>
									</tr>
									<tr>
										<td>Select, error while loading</td>
										<td>
										<a href="#" id="status" data-type="select" data-pk="1" data-value="0" data-source="/status" data-original-title="Select status">
											Active
										</a></td>
									</tr>
									<tr>
										<td>Combodate (date)</td>
										<td><a href="#" id="dob" data-type="combodate" data-value="1984-05-15" data-format="YYYY-MM-DD" data-viewformat="DD/MM/YYYY" data-template="D / MMM / YYYY" data-pk="1"  data-original-title="Select Date of birth">
										</a></td>
									</tr>
									<tr>
										<td>Combodate (datetime)</td>
										<td><a href="#" id="event" data-type="combodate" data-template="D MMM YYYY  HH:mm" data-format="YYYY-MM-DD HH:mm" data-viewformat="MMM D, YYYY, HH:mm" data-pk="1"  data-original-title="Setup event date and time">
										</a></td>
									</tr>
									<tr>
										<td>Textarea, buttons below. Submit by <i>ctrl+enter</i></td>
										<td><a href="#" id="comments" data-type="textarea" data-pk="1" data-placeholder="Your comments here..." data-original-title="Enter comments">
											awesome user!</a></td>
									</tr>
									<tr>
										<td>Twitter typeahead.js</td>
										<td><a href="#" id="state2" data-type="typeaheadjs" data-pk="1" data-placement="right" data-original-title="Start typing State..">
										</a></td>
									</tr>
									<tr>
										<td>Checklist</td>
										<td><a href="#" id="fruits" data-type="checklist" data-value="2,3" data-original-title="Select fruits">
										</a></td>
									</tr>
									<tr>
										<td>Select2 (tags mode)</td>
										<td>
										<a href="#" id="tags" data-type="select2" data-pk="1" data-original-title="Enter tags">
											html, javascript
										</a></td>
									</tr>
									<tr>
										<td>Select2 (dropdown mode)</td>
										<td><a href="#" id="country" data-type="select2" data-pk="1" data-value="BS" data-original-title="Select country">
										</a></td>
									</tr>
									<tr>
										<td>Custom input, several fields</td>
										<td><a href="#" id="address" data-type="address" data-pk="1" data-original-title="Please, fill address">
										</a></td>
									</tr>
									<tr>
										<td>Notes <a id="pencil" href="#"><i class="fa fa-pencil"></i> [edit]</a>
										<br>
										<span class="text-muted">Wysihtml5 (bootstrap only).
											<br>
											Toggle by another element</span></td>
										<td>
										<div data-original-title="Enter notes" data-toggle="manual" data-type="wysihtml5" data-pk="1" id="note" class="editable" tabindex="-1" style="display: block;">
											<h3>WYSIWYG</h3>
											WYSIWYG means <i>What You See Is What You Get</i>.
											<br>
											But may also refer to:
											<ul>
												<li>
													WYSIWYG (album), a 2000 album by Chumbawamba
												</li>
												<li>
													"Whatcha See is Whatcha Get", a 1971 song by The Dramatics
												</li>
												<li>
													WYSIWYG Film Festival, an annual Christian film festival
												</li>
											</ul>
											<i>Source:</i>
											<a href="http://en.wikipedia.org/wiki/WYSIWYG_%28disambiguation%29">
												wikipedia.org
											</a>
										</div></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
     

</div>
<!-- end: PAGE CONTENT-->
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="tmp/assets/plugins/jquery-mockjax/jquery.mockjax.js"></script>
		<script src="tmp/assets/plugins/moment/moment.js"></script>
		<script src="tmp/assets/plugins/select2/select2.min.js"></script>
		<script src="tmp/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
		<script src="tmp/assets/plugins/x-editable/js/bootstrap-editable.min.js"></script>
		<script src="tmp/assets/plugins/typeaheadjs/typeaheadjs.js"></script>
		<script src="tmp/assets/plugins/typeaheadjs/lib/typeahead.js"></script>
		<script src="tmp/assets/plugins/jquery-address/address.js"></script>
		<script src="tmp/assets/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/wysihtml5-0.3.0.min.js"></script>
		<script src="tmp/assets/plugins/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5.js"></script>
		<script src="tmp/assets/plugins/wysihtml5/wysihtml5.js"></script>
		<script src="tmp/assets/plugins/x-editable/demo-mock.js"></script>
		<script src="tmp/assets/plugins/x-editable/demo.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script>
			jQuery(document).ready(function() {
				Main.init();
			});
		</script>