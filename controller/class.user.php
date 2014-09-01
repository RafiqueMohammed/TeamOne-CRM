<?php

namespace controller\staff;

class Staff
{
    var $DB;

    public function __construct($db)
    {
        $this->DB = $db;
    }

    function getUserInfo()
    {
        $userInfo = $this->getSessionUserInfo();
        $email = $userInfo['email'];
        $qry = $this->DB->query("SELECT * FROM `" . TAB_MEMBER . "` WHERE `email`='$email'");
        $info = $qry->fetch_assoc();
        return $info;
    }

    function getSessionUserInfo()
    {
        return $_SESSION['userInfo'];
    }

    function checkLogin()
    {
        if (isset($_SESSION['userInfo'], $_SESSION['logged']) && $_SESSION['logged'] ==
            "1" && count($_SESSION['userInfo']) == 6
        ) {
            return true;
        } else {
            return false;
        }
    }

    function mustLogin()
    {
        if (!$this->checkLogin()) {
            $this->redirect("Login.php");
        }
    }

    function isPremium()
    {
        if (!isset($_SESSION['userInfo']['premium']))
            return false;

        if ($_SESSION['userInfo']['premium'] == '1') {
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

    function redirect($url, $die = true)
    {

        header("location:$url");
        if ($die) {
            exit();
        }

    }


    function generateToken()
    {
        $tmpToken = md5(rand(0, 500));
        $_SESSION['security']['token'] = $tmpToken;
        return $tmpToken;
    }

    function getToken()
    {
        return (isset($_SESSION['security']['token'])) ? $_SESSION['security']['token'] :
            "none";
    }

}