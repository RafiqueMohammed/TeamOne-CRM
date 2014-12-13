<?php
session_start();
unset($_SESSION['Staff']);
session_destroy();
header("Location:Login.php");