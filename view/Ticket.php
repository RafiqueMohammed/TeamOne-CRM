<?php require_once("common.php");
$technicians="<option value='-1'>Select Technician</option>";
$tech_data=fetchDatafromApi("api/Technicians");
foreach($tech_data['data'] as $data=>$val){
    $technicians .= "<option value='".$val['tech_id']."|".$val['first_name']." ".$val['last_name']."'>".$val['first_name']." ".$val['last_name']."</option>";
}
$json_content=fetchDatafromApi("api/Tickets");
$body="";
$ac_info="";
$cust_info="";
$service_info="";
$ticket="";
$isEmpty=true;
$i=1;
if($json_content['status']=="ok"){
    foreach($json_content['data'] as $data=>$val){     
        if($val['status']=="p"){
            $val['status']="Pending";
        }else{
            $val['status']="Closed";
        }
        $val['info']['account_type']=($val['info']['account_type']=="r")?"Residential":"Commercial";
        $type=$val['type'];
        switch($type){
            case 'installation':            
            
            $ac_info="<div style='display:none' class='ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                      <table class='table table-bordered'>
                      <tr><th>Make</th><td>".$val['ac_info']['make']."</td></tr>
                      <tr><th>AC Type</th><td>".$val['ac_info']['ac_type']."</td></tr>
                      <tr><th>Location</th><td>".$val['ac_info']['location']."</td></tr>
                      <tr><th>Tonnage</th><td>".$val['ac_info']['tonnage']."</td></tr>
                      <tr><th>IDU Serial No</th><td>".$val['ac_info']['idu_serial_no']."</td></tr>
                      <tr><th>IDU Model No</th><td>".$val['ac_info']['idu_model_no']."</td></tr>
                      <tr><th>ODU Serial No</th><td>".$val['ac_info']['odu_serial_no']."</td></tr>
                      <tr><th>ODU Model No</th><td>".$val['ac_info']['odu_model_no']."</td></tr>
                      <tr><th>Remarks</th><td>".$val['ac_info']['remarks']."</td></tr>
                      </table></div></div>";
                  
            $cust_info="<div style='display:none' class='cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <table class='table table-bordered'>
                    <tr><th>Account Type</th><td>".$val['info']['account_type']."</td></tr>
                    <tr><th>Organisation</th><td>".$val['info']['organisation']."</td></tr>
                    <tr><th>Name</th><td>".$val['info']['first_name']." ".$val['info']['last_name']."</td></tr>
                    <tr><th>Mobile</th><td>".$val['info']['mobile']."</td></tr>
                    <tr><th>Email</th><td>".$val['info']['email']."</td></tr>
                    <tr><th>City</th><td>".$val['info']['city']."</td></tr>
                    <tr><th>Address</th><td>".$val['info']['address']."</td></tr>
                    <tr><th>Landmark</th><td>".$val['info']['landmark']."</td></tr>
                    <tr><th>Location</th><td>".$val['info']['customer_location']."</td></tr>
                    <tr><th>Pincode</th><td>".$val['info']['pincode']."</td></tr>
                    </table></div></div>";
            ($val['assignment_info']['remarks']=="")?$val['assignment_info']['remarks']="<b class='text-danger'>No remarks added":$val['assignment_info']['remarks']=$val['assignment_info']['remarks'];
            $service_info="<div style='display:none' class='service_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                          <table class='table table-bordered table-striped'></tr><th>Installation Type</th><td>".$val['assignment_info']['install_type']."</td></tr>
                          </tr><th>Remarks</th><td>".$val['assignment_info']['remarks']."</td></tr></table>
                          </div></div>";
                    
            $close="<div style='display:none' class='close_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <div id='error'></div>
                    <table class='table table-bordered table-striped'>
                    <tr><th class='center'>Remarks</th></tr>
                    <tr><td><textarea class='form-control f_req remarks'></textarea></td></tr>
                    <tr><td><button class='pull-right btn btn-primary ticket_close'>Submit</button></td></tr>
                    </table><input type='hidden' value='".$val['assign_id']."' class='id'/>
                    <div id='result'></div>
                    </div></div>";
            
            if($val['ticket_remarks']==""){
                $val['ticket_remarks']="<b class='text-danger'>No Remarks added</b>";
            }
            $ticket="<div style='display:none' class='remark_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                      <table class='table table-bordered table-striped'>
                      <tr><th class='center'>Remarks</th></tr><td class='ticket_remarks'>".$val['ticket_remarks']."</td></tr>
                      </table></div></div>";

            $tryagain = "<div style='display:none' class='reassign'><div style='background:#fff;padding: 20px;border-radius:5px;'><div id='error'></div>
                    <h4>Reassign</h4><table class='table table-bordered table-striped'>
                    <tr><td>Date</td><td><input data-date-format='dd-mm-yyyy' data-date-viewmode='years' type='text' class='form-control date-picker re_req' value='".ConvertToIST($val['assign_date'])."'></td></tr>
                    <tr><td>Technician</td><td><select class='form-control technician re_req'>".$technicians."</select></td></tr>
                    <tr><td>Remarks</td><td><textarea class='form-control remarks re_req'>".$val['ticket_remarks']."</textarea></td></tr>
                    <tr><td colspan='2'><button class='btn btn-info btn-sm reassign_submit pull-right'>Submit</button></td></tr>
                    </table><div id='success'></div></div></div>";

            $body.= "<tr class='row_".$i."'><td>".$val['ticket_id']."</td><td>".$val['info']['first_name']." ".$val['info']['last_name']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"cust_popup\")' ></i>".$cust_info."</td>
            <td>".$val['ac_info']['make']." (".$val['ac_info']['ac_type'].") <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"ac_popup\")' ></i>".$ac_info."</td>
            <td>".$val['type']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"service_popup\")'></i>".$service_info."</td><td class='re_date'>".ConvertToIST($val['assign_date'])."</td>
            <td class='rename_technician'>".$val['technician_info']['first_name']." ".$val['technician_info']['last_name']."</td>
            <td>".$val['status']."</td><td class='center'><a class='big_icon btn'><i onclick='show_popup(\"row_".$i."\",\"remark_popup\")' class='clip-bubble-dots-2'></i></a>".$ticket."</td>
            <td class='center'><button class='btn btn-sm btn-warning' onclick='tryagain(".$val['assign_id'].",\"row_".$i."\",\"reassign\")'>Reassign</button>".$tryagain."
            <button class='btn btn-danger btn-sm tooltips' data-original-title='Click to Close Ticket' onclick='popup_close(".$val['assign_id'].",\"row_".$i."\",\"close_popup\")'>Close</button>".$close."</td></tr>";
            $i++;
            $isEmpty=false;
            break;
            
            case 'complaint':            
            
            $ac_info="<div style='display:none' class='ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                      <table class='table table-bordered'>
                      <tr><th>Make</th><td>".$val['ac_info']['make']."</td></tr>
                      <tr><th>AC Type</th><td>".$val['ac_info']['ac_type']."</td></tr>
                      <tr><th>Location</th><td>".$val['ac_info']['location']."</td></tr>
                      <tr><th>Tonnage</th><td>".$val['ac_info']['tonnage']."</td></tr>
                      <tr><th>IDU Serial No</th><td>".$val['ac_info']['idu_serial_no']."</td></tr>
                      <tr><th>IDU Model No</th><td>".$val['ac_info']['idu_model_no']."</td></tr>
                      <tr><th>ODU Serial No</th><td>".$val['ac_info']['odu_serial_no']."</td></tr>
                      <tr><th>ODU Model No</th><td>".$val['ac_info']['odu_model_no']."</td></tr>
                      <tr><th>Remarks</th><td>".$val['ac_info']['remarks']."</td></tr>
                      </table></div></div>";
                  
            $cust_info="<div style='display:none' class='cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <table class='table table-bordered'>
                    <tr><th>Account Type</th><td>".$val['info']['account_type']."</td></tr>
                    <tr><th>Organisation</th><td>".$val['info']['organisation']."</td></tr>
                    <tr><th>Name</th><td>".$val['info']['first_name']." ".$val['info']['last_name']."</td></tr>
                    <tr><th>Mobile</th><td>".$val['info']['mobile']."</td></tr>
                    <tr><th>Email</th><td>".$val['info']['email']."</td></tr>
                    <tr><th>City</th><td>".$val['info']['city']."</td></tr>
                    <tr><th>Address</th><td>".$val['info']['address']."</td></tr>
                    <tr><th>Landmark</th><td>".$val['info']['landmark']."</td></tr>
                    <tr><th>Location</th><td>".$val['info']['customer_location']."</td></tr>
                    <tr><th>Pincode</th><td>".$val['info']['pincode']."</td></tr>
                    </table></div></div>";
            ($val['assignment_info']['problem_desc']=="")?$val['assignment_info']['problem_desc']="<b class='text-danger'>No remarks added":$val['assignment_info']['problem_desc']=$val['assignment_info']['problem_desc'];        
            $service_info="<div style='display:none' class='service_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                           <table class='table table-bordered table-striped'></tr><th>Problem Type</th><td>".$val['assignment_info']['ac_problem_type']."</td></tr>
                           </tr><th>Description</th><td>".$val['assignment_info']['problem_desc']."</td></tr></table>
                           </div></div>";
                           
            $close="<div style='display:none' class='close_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <div id='error'></div>
                    <table class='table table-bordered table-striped'>
                    <tr><th class='center'>Remarks</th></tr>
                    <tr><td><textarea class='form-control f_req remarks'></textarea></td></tr>
                    <tr><td><button class='pull-right btn btn-primary ticket_close'>Submit</button></td></tr>
                    </table><input type='hidden' value='".$val['assign_id']."' class='id'/>
                    <div id='result'></div>
                    </div></div>"; 
            
            if($val['ticket_remarks']==""){
                $val['ticket_remarks']="<b class='text-danger'>No Remarks added</b>";
            }
            $ticket="<div style='display:none' class='remark_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                      <table class='table table-bordered table-striped'>
                      <tr><th class='center'>Remarks</th></tr><td class='ticket_remarks'>".$val['ticket_remarks']."</td></tr>
                      </table></div></div>";

            $tryagain = "<div style='display:none' class='reassign'><div style='background:#fff;padding: 20px;border-radius:5px;'><div id='error'></div>
                    <h4>Reassign</h4><table class='table table-bordered table-striped'>
                    <tr><td>Date</td><td><input data-date-format='dd-mm-yyyy' data-date-viewmode='years' type='text' class='form-control date-picker re_req' value='".ConvertToIST($val['assign_date'])."'></td></tr>
                    <tr><td>Technician</td><td><select class='form-control technician re_req'>".$technicians."</select></td></tr>
                    <tr><td>Remarks</td><td><textarea class='form-control remarks re_req'>".$val['ticket_remarks']."</textarea></td></tr>
                    <tr><td colspan='2'><button class='btn btn-info btn-sm reassign_submit pull-right'>Submit</button></td></tr>
                    </table><div id='success'></div></div></div>";

            $body.= "<tr class='row_".$i."'><td>".$val['ticket_id']."</td><td>".$val['info']['first_name']." ".$val['info']['last_name']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"cust_popup\")' ></i>".$cust_info."</td>
            <td>".$val['ac_info']['make']." (".$val['ac_info']['ac_type'].") <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"ac_popup\")' ></i>".$ac_info."</td>
            <td>".$val['type']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"service_popup\")'></i>".$service_info."</td><td class='re_date'>".ConvertToIST($val['assign_date'])."</td>
            <td class='rename_technician'>".$val['technician_info']['first_name']." ".$val['technician_info']['last_name']."</td>
            <td>".$val['status']."</td><td class='center'><a class='big_icon btn'><i onclick='show_popup(\"row_".$i."\",\"remark_popup\")' class='clip-bubble-dots-2'></i></a>".$ticket."</td>
            <td class='center'><button class='btn btn-sm btn-warning' onclick='tryagain(".$val['assign_id'].",\"row_".$i."\",\"reassign\")'>Reassign</button>".$tryagain."
            <button class='btn btn-danger btn-sm' onclick='popup_close(".$val['assign_id'].",\"row_".$i."\",\"close_popup\")'>Close</button>".$close."</td></tr>";
            $i++;
            $isEmpty=false;
            break;
            
            case 'amc':            
            
            $ac_info="<div style='display:none' class='ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                  <table class='table table-bordered'>
                  <tr><th>Make</th><td>".$val['ac_info']['make']."</td></tr>
                  <tr><th>AC Type</th><td>".$val['ac_info']['ac_type']."</td></tr>
                  <tr><th>Location</th><td>".$val['ac_info']['location']."</td></tr>
                  <tr><th>Tonnage</th><td>".$val['ac_info']['tonnage']."</td></tr>
                  <tr><th>IDU Serial No</th><td>".$val['ac_info']['idu_serial_no']."</td></tr>
                  <tr><th>IDU Model No</th><td>".$val['ac_info']['idu_model_no']."</td></tr>
                  <tr><th>ODU Serial No</th><td>".$val['ac_info']['odu_serial_no']."</td></tr>
                  <tr><th>ODU Model No</th><td>".$val['ac_info']['odu_model_no']."</td></tr>
                  <tr><th>Remarks</th><td>".$val['ac_info']['remarks']."</td></tr>
                  </table></div></div>";
                  
            $cust_info="<div style='display:none' class='cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <table class='table table-bordered'>
                    <tr><th>Account Type</th><td>".$val['info']['account_type']."</td></tr>
                    <tr><th>Organisation</th><td>".$val['info']['organisation']."</td></tr>
                    <tr><th>Name</th><td>".$val['info']['first_name']." ".$val['info']['last_name']."</td></tr>
                    <tr><th>Mobile</th><td>".$val['info']['mobile']."</td></tr>
                    <tr><th>Email</th><td>".$val['info']['email']."</td></tr>
                    <tr><th>City</th><td>".$val['info']['city']."</td></tr>
                    <tr><th>Address</th><td>".$val['info']['address']."</td></tr>
                    <tr><th>Landmark</th><td>".$val['info']['landmark']."</td></tr>
                    <tr><th>Location</th><td>".$val['info']['customer_location']."</td></tr>
                    <tr><th>Pincode</th><td>".$val['info']['pincode']."</td></tr>
                    </table></div></div>";
            
            ($val['assignment_info']['remarks']=="")?$val['assignment_info']['remarks']="<b class='text-danger'>No remarks added":$val['assignment_info']['remarks']=$val['assignment_info']['remarks'];        
            $service_info="<div style='display:none' class='service_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                          <table class='table table-bordered table-striped'>
                          </tr><th>Remarks</th><td>".$val['assignment_info']['remarks']."</td></tr></table>
                          </div></div>";
                          
            $close="<div style='display:none' class='close_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <div id='error'></div>
                    <table class='table table-bordered table-striped'>
                    <tr><th class='center'>Remarks</th></tr>
                    <tr><td><textarea class='form-control f_req remarks'></textarea></td></tr>
                    <tr><td><button class='pull-right btn btn-primary ticket_close'>Submit</button></td></tr>
                    </table><input type='hidden' value='".$val['assign_id']."' class='id'/>
                    <div id='result'></div>
                    </div></div>";
            
            if($val['ticket_remarks']==""){
                $val['ticket_remarks']="<b class='text-danger'>No Remarks added</b>";
            }
            $ticket="<div style='display:none' class='remark_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                      <table class='table table-bordered table-striped'>
                      <tr><th class='center'>Remarks</th></tr><td class='ticket_remarks'>".$val['ticket_remarks']."</td></tr>
                      </table></div></div>";

            $tryagain = "<div style='display:none' class='reassign'><div style='background:#fff;padding: 20px;border-radius:5px;'><div id='error'></div>
                        <h4>Reassign</h4><table class='table table-bordered table-striped'>
                        <tr><td>Date</td><td><input data-date-format='dd-mm-yyyy' data-date-viewmode='years' type='text' class='form-control date-picker re_req' value='".ConvertToIST($val['assign_date'])."'></td></tr>
                        <tr><td>Technician</td><td><select class='form-control technician re_req'>".$technicians."</select></td></tr>
                        <tr><td>Remarks</td><td><textarea class='form-control remarks re_req'>".$val['ticket_remarks']."</textarea></td></tr>
                        <tr><td colspan='2'><button class='btn btn-info btn-sm reassign_submit pull-right'>Submit</button></td></tr>
                        </table><div id='success'></div></div></div>";

            $body.= "<tr class='row_".$i."'><td>".$val['ticket_id']."</td><td>".$val['info']['first_name']." ".$val['info']['last_name']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"cust_popup\")' ></i>".$cust_info."</td>
            <td>".$val['ac_info']['make']." (".$val['ac_info']['ac_type'].") <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"ac_popup\")' ></i>".$ac_info."</td>
            <td>".$val['type']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"service_popup\")'></i>".$service_info."</td><td class='re_date'>".ConvertToIST($val['assign_date'])."</td>
            <td class='rename_technician'>".$val['technician_info']['first_name']." ".$val['technician_info']['last_name']."</td>
            <td>".$val['status']."</td><td class='center'><a class='big_icon btn'><i onclick='show_popup(\"row_".$i."\",\"remark_popup\")' class='clip-bubble-dots-2'></i></a>".$ticket."</td>
            <td class='center'><button class='btn btn-sm btn-warning' onclick='tryagain(".$val['assign_id'].",\"row_".$i."\",\"reassign\")'>Reassign</button>".$tryagain."
            <button class='btn btn-danger btn-sm' onclick='popup_close(".$val['assign_id'].",\"row_".$i."\",\"close_popup\")'>Close</button>".$close."</td></tr>";
            $i++;
            $isEmpty=false;
            break;
            
            case 'ots':
            
            $ac_info="<div style='display:none' class='ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                      <table class='table table-bordered'>
                      <tr><th>Make</th><td>".$val['ac_info']['make']."</td></tr>
                      <tr><th>AC Type</th><td>".$val['ac_info']['ac_type']."</td></tr>
                      <tr><th>Location</th><td>".$val['ac_info']['location']."</td></tr>
                      <tr><th>Tonnage</th><td>".$val['ac_info']['tonnage']."</td></tr>
                      <tr><th>IDU Serial No</th><td>".$val['ac_info']['idu_serial_no']."</td></tr>
                      <tr><th>IDU Model No</th><td>".$val['ac_info']['idu_model_no']."</td></tr>
                      <tr><th>ODU Serial No</th><td>".$val['ac_info']['odu_serial_no']."</td></tr>
                      <tr><th>ODU Model No</th><td>".$val['ac_info']['odu_model_no']."</td></tr>
                      <tr><th>Remarks</th><td>".$val['ac_info']['remarks']."</td></tr>
                      </table></div></div>";
                  
            $cust_info="<div style='display:none' class='cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <table class='table table-bordered'>
                    <tr><th>Account Type</th><td>".$val['info']['account_type']."</td></tr>
                    <tr><th>Organisation</th><td>".$val['info']['organisation']."</td></tr>
                    <tr><th>Name</th><td>".$val['info']['first_name']." ".$val['info']['last_name']."</td></tr>
                    <tr><th>Mobile</th><td>".$val['info']['mobile']."</td></tr>
                    <tr><th>Email</th><td>".$val['info']['email']."</td></tr>
                    <tr><th>City</th><td>".$val['info']['city']."</td></tr>
                    <tr><th>Address</th><td>".$val['info']['address']."</td></tr>
                    <tr><th>Landmark</th><td>".$val['info']['landmark']."</td></tr>
                    <tr><th>Location</th><td>".$val['info']['customer_location']."</td></tr>
                    <tr><th>Pincode</th><td>".$val['info']['pincode']."</td></tr>
                    </table></div></div>";
            ($val['assignment_info']['description']=="")?$val['assignment_info']['description']="<b class='text-danger'>No remarks added":$val['assignment_info']['description']=$val['assignment_info']['description'];
            $service_info="<div style='display:none' class='service_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                          <table class='table table-bordered table-striped'>
                          </tr><th>OTS Type</th><td>".$val['assignment_info']['service_type']."</td></tr>
                          </tr><th>Remarks</th><td>".$val['assignment_info']['description']."</td></tr>
                          </table>
                          </div></div>";
                          
            $close="<div style='display:none' class='close_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                    <div id='error'></div>
                    <table class='table table-bordered table-striped'>
                    <tr><th class='center'>Remarks</th></tr>
                    <tr><td><textarea class='form-control f_req remarks'></textarea></td></tr>
                    <tr><td><button class='pull-right btn btn-primary ticket_close'>Submit</button></td></tr>
                    </table><input type='hidden' value='".$val['assign_id']."' class='id'/>
                    <div id='result'></div>
                    </div></div>"; 
            
            if($val['ticket_remarks']==""){
                $val['ticket_remarks']="<span class='text-danger'> - No Remarks added - </span>";
            }
            $ticket="<div style='display:none' class='remark_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>
                      <table class='table table-bordered table-striped'>
                      <tr><th class='center'>Remarks</th></tr><td class='ticket_remarks'>".$val['ticket_remarks']."</td></tr>
                      </table></div></div>";

            $tryagain = "<div style='display:none' class='reassign'><div style='background:#fff;padding: 20px;border-radius:5px;'><div id='error'></div>
                        <h4>Reassign</h4><table class='table table-bordered table-striped'><form id='form1'>
                        <tr><td>Date</td><td><input data-date-format='dd-mm-yyyy' data-date-viewmode='years' type='text' class='form-control date-picker re_req' value='".ConvertToIST($val['assign_date'])."'></td></tr>
                        <tr><td>Technician</td><td><select class='form-control technician re_req'>".$technicians."</select></td></tr>
                        <tr><td>Remarks</td><td><textarea class='form-control remarks re_req'>".$val['ticket_remarks']."</textarea></td></tr>
                        <tr><td colspan='2'><button class='btn btn-info btn-sm reassign_submit pull-right'>Submit</button></td></tr>
                        </form></table><div id='success'></div></div></div>";
            
            $body.= "<tr class='row_".$i."'><td>".$val['ticket_id']."</td><td>".$val['info']['first_name']." ".$val['info']['last_name']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"cust_popup\")' ></i>".$cust_info."</td>
            <td>".$val['ac_info']['make']." (".$val['ac_info']['ac_type'].") <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"ac_popup\")' ></i>".$ac_info."</td>
            <td>".$val['type']." <i class='fa fa-eye cursor big_icon' onclick='show_popup(\"row_".$i."\",\"service_popup\")'></i>".$service_info."</td><td class='re_date'>".ConvertToIST($val['assign_date'])."</td>
            <td class='rename_technician'>".$val['technician_info']['first_name']." ".$val['technician_info']['last_name']."</td>
            <td>".$val['status']."</td><td class='center'><a class='big_icon btn'><i onclick='show_popup(\"row_".$i."\",\"remark_popup\")' class='clip-bubble-dots-2'></i></a>".$ticket."</td>
            <td class='center'><button class='btn btn-sm btn-warning' onclick='tryagain(".$val['assign_id'].",\"row_".$i."\",\"reassign\")'>Reassign</button>".$tryagain."
            <button class='btn btn-danger btn-sm' onclick='popup_close(".$val['assign_id'].",\"row_".$i."\",\"close_popup\")'>Close</button>".$close."</td></tr>";
            $i++;
            $isEmpty=false;
            break;
        }
        
    }
}else if($json_content['status']=="no"){
    $body="<tr><td colspan='9' class='alert alert-info'>No Data Found</td></tr>";
}
?>
<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2.css" />
<link rel="stylesheet" href="assets/plugins/DataTables/media/css/DT_bootstrap.css" />

<div class="row">

    <div class="col-sm-12">

    <!-- start: PAGE TITLE & BREADCRUMB -->
    <?php require_once(INC_DIR."breadcrumb.php"); ?>

        <!-- end: PAGE TITLE & BREADCRUMB -->

        <div class="page-header">

            <h1>Tickets</h1>

        </div>

    </div>

</div>

<div class="row">
	<div class=" col-md-12">
		<!-- start: DYNAMIC TABLE PANEL -->
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover table-condensed table-full-width" <?php if(!$isEmpty){ echo "id='TicketDataTable'";} ?>>
					<thead>
						<tr>
                            <th class="hidden-xs">Ticket</th>
							<th>Customer Info</th>
							<th class="hidden-xs">AC Info</th>
							<th>Service Type</th>
							<th class="hidden-xs">Assigned Date</th>
							<th>Technician</th>
                            <th class="hidden-xs">Status</th>
							<th>Remarks</th>
                            <th class="center"><i class="clip-wrench-2"></i></th>
						</tr>
					</thead>
					<tbody>
                        <?php echo $body; ?>
					</tbody>
				</table>
                <?php echo $ticket ?>
			</div>
		<!-- end: DYNAMIC TABLE PANEL -->
	</div>
</div>

<script type="text/javascript" src="assets/js/Ticket.js"></script>

<script>
    jQuery(document).ready(function() {

        $("#TicketDataTable").dataTable({
            "aoColumnDefs": [{
                "aTargets": [0]
            }],
            "oLanguage": {
                "sLengthMenu": "Show _MENU_ Rows",
                "sSearch": "",
                "oPaginate": {
                    "sPrevious": "",
                    "sNext": ""
                }
            },
            "aaSorting": [
                [1, 'asc']
            ],
            "aLengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 10,
        });

        $('.dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('.dataTables_length select').addClass("m-wrap small");
        $('.dataTables_length select').select2();
    });
</script>