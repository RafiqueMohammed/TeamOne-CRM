<?php
require_once("../common.php");
?>
    <style>
        #pincode_dropdown {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        #pincode_dropdown li {
            list-style: none;
            margin: 0px;
            width: 100%;
            display: block;
            padding: 5px;
            background-color: #ccc;
            border-bottom: 1px solid #367;
        }

        #pincode_dropdown li:hover {
            background: #3374C2;
            cursor: pointer;
        }
    </style>
<?php

if (isset($_POST['type'])) {
    $type = $_POST['type'];
    switch ($type) {
        case 'referred':
            $qry = $DB->query("SELECT * FROM `referred_by`") or die($DB->error);
            while ($data = $qry->fetch_assoc()) {
                echo "<option value=" . $data['name'] . ">" . $data['name'] . "</option>";
            }
            break;

        case 'pincode':

            if (isset($_POST['pincode']) && !empty($_POST['pincode'])) {
                $pincode = $_POST['pincode'];
                $qry = $DB->query("SELECT distinct(`pincode`) FROM `" . TAB_LOCALITY . "` WHERE `pincode` LIKE '$pincode%' LIMIT 6 ");
                echo "<ul id='pincode_dropdown'>";
                if ($qry->num_rows > 0) {


                    while ($data = $qry->fetch_array()) {
                        ?>
                        <li onclick='fill_locality("<?php echo $data['pincode']; ?>")'><?php echo $data['pincode']; ?></li>
                    <?php
                    }
                    echo "</ul>";
                } else {
                    echo "<ul id='pincode_dropdown'><li> - No Such Pincode Found - </li></ul>";
                }
            }

            break;
    }
}

?>