<?php
require_once("common.php");
/**
 * Created by Rafique
 * Date: 7/16/14
 * Time: 5:24 PM
 */
?>
<!DOCTYPE html>
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
    <div id="main-content" class="main-content">

        <!-- start: PANEL CONFIGURATION MODAL FORM -->
        <?php require_once(VIEW_DIR . "ModalCollection.php"); ?>

        <!-- end: SPANEL CONFIGURATION MODAL FORM -->

        <!-- start: STYLE SELECTOR BOX -->
        <?php require_once(INC_DIR . "QuickSearch.php"); ?>
        <!-- end: STYLE SELECTOR BOX -->

        <!-- start: CONTAINER -->
        <div class="container">
            <?php
            $dir = (isset($_GET['dir']) && !empty($_GET['dir'])) ? $_GET['dir'] : "";
            $page = (isset($_GET['page']) && !empty($_GET['page'])) ? trim($_GET['page']) : "404";
            $link = "";

            if (is_dir(VIEW_DIR . $dir . "/")) {
                $link = VIEW_DIR . "{$dir}/{$page}.php";
            } else {
                $link = VIEW_DIR . "{$page}.php";
            }


            if (file_exists($link)) {
                require_once($link);
            } else {
                require_once(VIEW_DIR . "404.php");
            }


            ?>
        </div>


        <!-- end: CONTAINER -->

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

