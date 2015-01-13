<?php

class sendsms
{
    public $api;
    public $wk;
    public $sid;
    public $to;
    private $api_url;
    private $time;
    private $unicode;
    private $working_key;
    private $start;
    private $sender_id;

    /** function to intialize constructor
     *
     * @param string_type $wk : it is working_key
     * @param string_type $sd : it is sender_id
     * @param string_type $apiurl : it is api_url
     *          used for intializing the parameter
     */
    function __construct($apiurl, $wk, $sd)
    {
        $this->setWorkingKey($wk);
        $this->setSenderId($sd);
        $this->setapiurl($apiurl);
    }

    /**function to set the working key
     *
     * @param string_type $wk :helps to change the working_key
     */
    function setWorkingKey($wk)
    {
        $this->working_key = $wk;
        /*$arraywk =array("12f4oicov0n8r68m8","1m87986s5c97e8xk3","1i65akb3e91rfqa4m","13f3m29172u7zb067","1zg0z0z06cy460wr8","185c969w4a892zdgs","1xhke3sg7w4n492a1","1l5x53ged73841mp2","16o6kt54zbeo833k","1ec47b74g4hpz28x5");
        if (in_array($wk, $arraywk))
            $this->working_key=$wk;
        else
            echo "invalid working key";
        */
    }

    /**function to set sender id
     *
     * @param string_type $sid :helps to change sender_id
     */
    function setSenderId($sid)
    {
        $this->sender_id = $sid;
        /*$arraysid=array("BULKSMS","sdssss","tigerr");
        if(in_array($sid, $arraysid))
            $this->sender_id=$sid;
        else
            echo "invalid sender id";
        */
    }

    /**function to set API url
     *
     * @param string_type $apiurl :it is used to set api url
     */
    function setapiurl($apiurl)
    {
        $this->api = $apiurl;
        $a = substr($api, 0, 7);

        if ($a == "http://") //checking if already contains http://
        {
            $api_url = substr($api, 7, strlen($api));
            $this->api_url = $api_url;
            $this->start = "http://";
        } elseif ($a == "https:/") //checking if already contains htps://
        {
            $api_url = substr($api, 8, strlen($api));
            $this->api_url = $api_url;
            $this->start = "https://";
        } else {
            $this->api_url = $apiurl;
            $this->start = "http://";
        }
    }

    /**
     * function to send sms
     *
     */
    function send_sms($to, $message, $dlr_url, $type = "xml")
    {
        $this->process_sms($to, $message, $dlr_url, $type = "xml", $time = "null", $unicode = "null");
    }

    /**
     * function to send out sms
     * @param string_type $to : is mobile number where message needs to be send
     * @param string_type $message :it is message content
     * @param string_type $dlr_url : it is used for delivering report to client
     * @param string_type $type : type in which report is delivered
     * @return output        $this->api=$apiurl;
     */
    function  process_sms($to, $message, $dlr_url = "", $type = "xml", $time = '', $unicode = '')
    {
        $message = urlencode($message);
        $this->to = $to;
        $to = substr($to, -10);
        $arrayto = array("9", "8", "7");
        $to_check = substr($to, 0, 1);

        if (in_array($to_check, $arrayto))
            $this->to = $to;
        else echo "invalid number";

        if ($time == 'null')
            $time = '';
        else
            $time = "&time=$time";
        if ($unicode == 'null')
            $unicode = '';
        else
            $unicode = "&unicode=$unicode";


        $url = "$this->start$this->api_url/web2sms.php?workingkey=$this->working_key&sender=$this->sender_id&to=$to&message=$message&type=$type&dlr_url=$dlr_url$time$unicode";

        $this->execute($url);
    }

    /**
     * function to request to clent url
     */
    function execute($url)
    {
        $ch = curl_init();
        // curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        echo $output;
        return $output;

    }

    /**
     * function to schedule sms
     *
     */
    function schedule_sms($to, $message, $dlr_url, $type = "xml", $time)
    {
        $this->process_sms($to, $message, $dlr_url, $type = "xml", $time, $unicode = '');
    }

    /**
     * function to send unicode message
     */
    function unicode_sms($to, $message, $dlr_url, $type = "xml", $unicode)
    {
        $this->process_sms($to, $message, $dlr_url, $type = "xml", $time = '', $unicode);
    }

    /**
     * function to check message delivery status
     * string_type $mid : it is message id
     */
    function messagedelivery_status($mid)
    {
        $url = "$this->start$this->api_url/status.php?workingkey=$this->working_key&messageid=$mid";
        $this->execute($url);
    }

    /**
     * function to check group message delivery
     *  string_type $gid: it is group id
     */
    function groupdelivery_status($gid)
    {
        $url = "$this->start$this->api_url/groupstatus.php?workingkey=$this->working_key&messagegid=$gid";
        $this->execute($url);

    }
}

?>
