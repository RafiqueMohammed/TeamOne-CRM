<?php

namespace controller\staff;

class Staff
{
    var $DB;

    public function __construct($db)
    {
        $this->DB = $db;
    }

    function getStaffInfo()
    {
        $Staff = $this->getSessionStaff();
        $staff_id = $Staff['AuthID'];
        $qry = $this->DB->query("SELECT * FROM `" . TAB_STAFF . "` WHERE `staff_id`='$staff_id'");
        $info = $qry->fetch_assoc();
        return $info;
    }

    function getSessionStaff()
    {
        return $_SESSION['Staff'];
    }

    function mustLogin()
    {
        if (!$this->isLoggedin()) {
            $this->redirect(SUB_FOLDER."Login.php");
        }
    }

    function isLoggedin()
    {
        if (isset($_SESSION['Staff'], $_SESSION['Staff']['Logged'], $_SESSION['Staff']['AuthID']) && $_SESSION['Staff']['Logged'] ==
            "1" && count($_SESSION['Staff']) > 0
        ) {
            return true;
        } else {
            return false;
        }
    }

    function redirect($url, $die = true)
    {

        header("location:$url");
        if ($die) {
            exit();
        }

    }

    function isAdmin()
    {
        if (!isset($_SESSION['Staff']['isAdmin']))
            return false;

        if ($_SESSION['Staff']['isAdmin']) {
            return true;
        } else {
            return false;
        }
    }

    function initUser($array)
    {

    }

    function logout()
    {

    }

    function setStaff($data)
    {
        if (is_array($data)) {
            $_SESSION['Staff'] = array();
            $_SESSION['Staff']['isAdmin'] = ($data['isAdmin'] == 'y') ? true : false;
            $_SESSION['Staff']['AuthID'] = $data['AuthID'];
            $_SESSION['Staff']['Logged'] = 1;
            $_SESSION['Staff']['Username'] = $data['Username'];
            $_SESSION['Staff']['FullName'] = $data['FullName'];
            return true;
        } else {
            return false;
        }
    }

}