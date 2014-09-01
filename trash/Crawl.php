<?php
require_once("common.php");
/**
 * Created by Rafique
 * Date: 7/16/14
 * Time: 5:24 PM
 */
$notfound=VIEW_DIR."404.php";

if(isset($_GET['page'])&&!empty($_GET['page'])){

    $filename=$_GET['page'];
    $page=VIEW_DIR."{$filename}.php";
    if(!file_exists($page)){
        $page=$notfound;
    }
    $content=file_get_contents($page);
}else{
    $content=file_get_contents($notfound);
}
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
            <?php echo $content ?>
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

