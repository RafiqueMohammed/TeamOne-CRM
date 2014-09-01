<?php
/**
 * Created by Rafique
 * Date: 6/17/14
 * Time: 1:13 PM
 */

function ConvertToIST($date){
    return date("d-m-Y",strtotime($date));
}

function ConvertToDateTime($date){
    return date("d-m-Y H:i:s",strtotime($date));
}

function ConvertFromIST($data){
    return date("Y-m-d",strtotime($data));
}

function GetDays($sStartDate, $sEndDate){
    $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));
    $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));

    // Start the variable off with the start date
    $aDays[] = $sStartDate;

    // Set a 'temp' variable, sCurrentDate, with
    // the start date - before beginning the loop
    $sCurrentDate = $sStartDate;

    // While the current date is less than the end date
    while($sCurrentDate < $sEndDate){
        // Add a day to the current date
        $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));

        // Add this new day to the aDays array
        $aDays[] = $sCurrentDate;
    }

    // Once the loop has finished, return the
    // array of days.
    return $aDays;
}