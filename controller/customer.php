<?php
/**
 * Created by  Rafique
 * Date: 6/17/14
 * Time: 6:05 PM
 */

namespace controller\customer;


class customer
{

    protected $cust_id, $first_name, $last_name, $display_name, $email, $phone, $enabled;

    protected $DB;


    function __construct($id)
    {
        $this->cust_id = $id;
        $this->DB = \controller\main\main::getDB();
    }

    function getCustomerInfo()
    {
        if ($this->isCustomerExist()) {
            $qry = $this->DB->query("SELECT * FROM `" . TAB_CUSTOMER . "` WHERE `cust_id`='{$this->cust_id}'") or die(new \Exception($this->DB->error));
            $info = $qry->fetch_assoc();
            $this->display_name = $info['display_name'];
            $this->email = $info['email'];
            $this->enabled = $info['enabled'];
            $this->first_name = $info['first_name'];
            $this->last_name = $info['last_name'];
            $this->phone = $info['phone'];
        }

    }

    function isCustomerExist()
    {
        $qry = $this->DB->query("SELECT * FROM `" . TAB_CUSTOMER . "` WHERE `cust_id`='{$this->cust_id}'");

        if ($qry->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @return mixed
     */
    public function getCustId()
    {
        return $this->cust_id;
    }

    /**
     * @return mixed
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }


}