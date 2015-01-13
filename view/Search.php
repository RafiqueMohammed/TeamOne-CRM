<?php require_once("common.php");
if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = trim($_GET['keyword']);


    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $_SERVER['HTTP_HOST'] . SUB_FOLDER . "api/Search/{$keyword}");
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($c);

    if (curl_getinfo($c, CURLINFO_HTTP_CODE) == "200" && $output != "") {
        $json_content = json_decode($output, true);


    } else {
        $json_content = array("status" => "no", "result" => "Cannot fetch data from the API.Try Again..");
    }
    $body = "";
    if ($json_content['status'] == "ok") {

        foreach ($json_content["data"] as $data) {

            if ($data['account_type'] == "r") {

                $body .= " <div class='search-item'><span class='label label-default '>Residential</span>
            <h4><a href='CustomerDetails?id={$data['cust_id']}'>{$data['first_name']} {$data['last_name']}</a></h4>
            <a href='#'>{$data['location']}</a><br/><p><b>Email : </b>{$data['email']}<br>
            <b>Contact :</b>  {$data['mobile']}<br>  </p> <hr /></div>";

            } else {
                $body .= " <div class='search-item'><span class='label label-warning '>Commercial</span>
            <h4><a href='CustomerDetails?id={$data['cust_id']}'>{$data['organisation']}</a></h4>
            <a href='#'>{$data['location']}</a><br/><p><b>Contact Person : </b>{$data['first_name']} {$data['last_name']}<br>
            <b>Contact :</b> {$data['mobile']}<br>
            <b>Email : </b>{$data['email']}<br>
            <b>Alternate Contact :</b> {$data['alternate_mobile']}<br>  </p><hr /></div>";
            }
        }
    } else if ($json_content['status'] == "no") {
        $body .= "<div class='alert alert-danger'>{$json_content['result']}</div>";
    }

} else {
    $body = "<div class='alert alert-info'>Start searching customer by typing their mobile number or Organisation name</div>";
}
?>
<!-- start: PAGE HEADER -->
<div class="row">

    <div class="col-sm-12">

        <!-- start: PAGE TITLE & BREADCRUMB -->
        <?php require_once(INC_DIR . "breadcrumb.php"); ?>

        <!-- end: PAGE TITLE & BREADCRUMB -->

        <div class="page-header">

            <h1>Search
                <small>Customer Information</small>
            </h1>

        </div>

    </div>

</div>
<!-- end: PAGE HEADER -->


<!-- start: PAGE CONTENT -->
<div class="row">

    <div class="col-md-12">
        <!-- start: SEARCH RESULT -->
        <div class="search-classic">
            <form action="#" class="form-inline">
                <div class="input-group well">
                    <input type="text" class="form-control" id="customer_search_box" value="<?php if (isset($keyword)) {
                        echo $keyword;
                    } ?>" placeholder="Search...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" id="customer_search_button" type="button">
                                                <i class="fa fa-search"></i> Search
                                            </button> </span>
                </div>
            </form>
            <h3 class="search-keyword"><?php if (isset($keyword)) {
                    echo "Search for \"{$keyword}\"";
                } ?> </h3>
            <hr>

            <div class="search-result">
                <?php echo $body; ?>
            </div>
            <!--<div class="search-result">
                <span class="label label-warning ">Commercial</span>
                <h4>
                    <a href="#">
                        Growthwell Consulting Pvt. Ltd
                    </a></h4>

                <a href="#">
                    Andheri - Mumbai
                </a>

                <br/>
                <p>
                    <b>Full Name :</b>  Kapil Sanghavi
                    <br>
                    <b>Contact :</b>  9876543210
                    <br>  </p>
            </div>-->


            <!--
                        <ol class="pagination text-center pull-right no-display">
                            <li class="prev disabled">
                                <a href="#">
                                    Prev
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    1
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    2
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    3
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    4
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    5
                                </a>
                            </li>
                            <li class="next">
                                <a href="#">
                                    Next
                                </a>
                            </li>
                        </ol>
                        -->
        </div>
        <!-- end: SEARCH RESULT -->
    </div>


</div>
<!-- end: PAGE CONTENT-->
<script type="text/javascript" src="assets/js/search.js"></script>
