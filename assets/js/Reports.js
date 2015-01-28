$(document).ready(function(){
    
    $(".from_date").datepicker({
        autoclose:true
    })
    
    $(".to_date").datepicker({
        autoclose:true
    })
    
    $(".reports_for").on("change",function(){
        $(".date_container").hide();
        $(".reports_type").prop('selectedIndex',0);
        var val = $(".reports_for").val();
        if(val==0){
            $(".reports_type").html("<option value='0'>Select</option>")
        }else if(val=="Customer" || val=="Technician"){
            $(".reports_type").html("<option value='0'>Select</option><option value='date'>Datewise</option>");
        }else{
            $(".reports_type").html("<option value='all'>All</option><option value='date'>Datewise</option>");
        }
        
        if(val=="AMC" || val=="Complaint" || val=="Installation" || val=="OTS"){
            console.log("service");
            $(".generated_reports_content").show();
            $(".generated_reports_technician").hide();
            $(".generated_reports_customer").hide();
        }else if(val=="New Customers"){
            console.log("Customer");
            $(".generated_reports_technician").hide();
            $(".generated_reports_customer").show();
            $(".generated_reports_content").hide();
        }else{
            console.log("technician");
            $(".generated_reports_technician").show();
            $(".generated_reports_customer").hide();
            $(".generated_reports_content").hide();
        }
    });
    
    $(".reports_type").on("change",function(){
      if($(this).val()=="date"){
          $(".date_container").slideDown();
          $(".from_date").addClass("for_reports_req");
          $(".to_date").addClass("for_reports_req");
      }else{
          $(".date_container").slideUp();
          $(".from_date").removeClass("for_reports_req");
          $(".to_date").removeClass("for_reports_req");
      }
   });

    $(".btn_generate_reports").on("click",function() {

        if (type != 0) {

            if (type == "date") {
                $(".report_icon").removeClass("fa-list-ul").addClass("fa-calendar");
            } else {
                $(".report_icon").removeClass("fa-calendar").addClass("fa-list-ul");
            }

        }
        var reports_for = $(".reports_for").val();
        var type = $(".reports_type").val();

        if(reports_for!=0&&type!=0){

        $("#total_reports_header").removeClass().addClass("text-danger");
        $('.total_data').text("0");

        if (type == "date") {
            var from_date = $(".from_date").val();
            var to_date = $(".to_date").val();
            console.log(from_date + " " + to_date);
        }
        if(from_date==""){
            $(".from_date").parent().removeClass("has-success").addClass("has-error");
            
            if(to_date==""){
                $(".to_date").parent().removeClass("has-success").addClass("has-error");
                return false;
            }
            return false;
        }else{
            $(".from_date").parent().removeClass("has-error")
            $(".to_date").parent().removeClass("has-error")
        }
        blockThisUI($(".generated_reports"));

        if(reports_for == "AMC") {
            if(type=="all"){
                blockThisUI($(".generated_reports"));
                $.ajax({
                    type:'get',
                    url:'api/Reports/AMC',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == "ok") {
                            $("#total_reports_header").removeClass().addClass("text-success");
                            $('.total_data').html(response.data.length);
                            var row = "";
                            var sr = 0;
                            $.each(response.data, function (key, val) {
                                if (val.info.amc_type == "c") {
                                    val.info.amc_type = "Comprehensive";
                                } else if (val.info.amc_type == "s") {
                                    val.info.amc_type = "Semi-Comprehensive";
                                } else if(val.info.amc_type="n"){
                                    val.info.amc_type = "Labour only";
                                }
                                var acc_type = (val.customer_info.account_type == 'r') ? 'Residential' : 'Commercial';
                                if (val.customer_info.account_type == 'r') {
                                    val.customer_info.organisation = "Home";
                                }
                            var email = (val.customer_info.email == '') ? 'NA' : val.customer_info.email;
                            
                            var cust_div = "<div class='no-display cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                            <h4 class='center'>Customer Information</h4>\
                            <table class='table table-bordered table-striped'>\
                            <tr><td>Account type</td><td>" + acc_type + "</td></tr>\
                            <tr><td>Organisation</td><td>" + val.customer_info.organisation + "</td></tr>\
                            <tr><td>Name</td><td>" + val.customer_info.first_name + " " + val.customer_info.last_name + "</td></tr>\
                            <tr><td>Mobile</td><td>" + val.customer_info.mobile + "</td></tr>\
                            <tr><td>Email</td><td>" + email + "</td></tr>\
                            <tr><td>City</td><td>" + val.customer_info.city + "</td></tr>\
                            <tr><td>Address</td><td>" + val.customer_info.address + "</td></tr>\
                            <tr><td>Landmark</td><td>" + val.customer_info.landmark + "</td></tr>\
                            <tr><td>Location</td><td>" + val.customer_info.customer_location + "</td></tr>\
                            <tr><td>Pincode</td><td>" + val.customer_info.pincode + "</td></tr>\
                            </table>\
                            </div></div>";
    
                            var ac_div = "<div class='no-display ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                            <h4 class='center'>AC Information</h4>\
                            <table class='table table-bordered table-striped'>\
                            <tr><td>AC Type</td><td>" + val.ac_info.ac_type + "</td></tr>\
                            <tr><td>Make</td><td>" + val.ac_info.make + "</td></tr>\
                            <tr><td>Location</td><td>" + val.ac_info.location + "</td></tr>\
                            <tr><td>Tonnage</td><td>" + val.ac_info.tonnage + "</td></tr>\
                            <tr><td>IDU</td><td>Serial No: " + val.ac_info.idu_serial_no + "<br /> Model No :" + val.ac_info.idu_model_no + "</td></tr>\
                            <tr><td>ODU</td><td>Serial No: " + val.ac_info.odu_serial_no + "<br /> Model No :" + val.ac_info.odu_model_no + "</td></tr>\
                            <tr><td colspan='2'>" + val.ac_info.remarks + "</td></tr></table></div></div>";
                            
                            var amc_div = "<div class='no-display amc_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                            <h4 class='center'>AC Information</h4>\
                            <table class='table table-bordered table-striped'>\
                            <tr><td>AMC Type</td><td>" + val.info.amc_type + "</td></tr>\
                            <tr><td>No of service</td><td>" + val.info.no_of_service + "</td></tr>\
                            <tr><td>Dry Service</td><td>" + val.info.wet + "</td></tr>\
                            <tr><td>Wet Service</td><td>" + val.info.dry + "</td></tr>\
                            <tr><td>Activation</td><td>" + val.info.activation + "</td></tr>\
                            <tr><td>Expiry</td><td>" + val.info.expiration + "</td></tr>\
                            </table></div></div>";
    
                                row += "<tr class='row_count_" + sr + "'><td class='center'>" + val.info.amc_type + " <i onclick='view_info(\".amc_popup\","+sr+")' class='clip-popout cursor' style='font-size:1.3em'></i>"+amc_div+"</td><td class='center'>" + val.customer_info.first_name + " " + val.customer_info.last_name + " <i onclick='view_cust_info(\".cust_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i> " + cust_div + "</td>\
                        <td class='center'>" + val.ac_info.make + " (" + val.ac_info.ac_type + ") <i onclick='view_ac_info(\".ac_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i>" + ac_div + "</td>\
                        <td><button class='btn btn-primary'>View</button></td>";
                                sr++;
                            });
    
                        } else if (response.status == "no") {
                           row="<tr><td colspan='4' class='alert alert-danger center'> No data found</td></tr>";
                        }
                    $("#ViewReportsDataTable tbody").html(row);
                    unblockThisUI($(".generated_reports"));
                }
            });              
            }else{
                blockThisUI($(".generated_reports"));
                $.ajax({
                    type:post,
                    url:'api/Reports/AMC',
                    data:{from_date : $(".from_date").val(),to_date : $(".to_date").val()},
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == "ok") {
                            $("#total_reports_header").removeClass().addClass("text-success");
                            $('.total_data').html(response.data.length);
                            var row = "";
                            var sr = 0;
                            $.each(response.data, function (key, val) {
                                if (val.info.amc_type == "c") {
                                    val.info.amc_type = "Comprehensive";
                                } else if (val.info.amc_type == "s") {
                                    val.info.amc_type = "Semi-Comprehensive";
                                } else if(val.info.amc_type="n"){
                                    val.info.amc_type = "Labour only";
                                }
                                var acc_type = (val.customer_info.account_type == 'r') ? 'Residential' : 'Commercial';
                                if (val.customer_info.account_type == 'r') {
                                    val.customer_info.organisation = "Home";
                                }
                            var email = (val.customer_info.email == '') ? 'NA' : val.customer_info.email;
                            
                            var cust_div = "<div class='no-display cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                            <h4 class='center'>Customer Information</h4>\
                            <table class='table table-bordered table-striped'>\
                            <tr><td>Account type</td><td>" + acc_type + "</td></tr>\
                            <tr><td>Organisation</td><td>" + val.customer_info.organisation + "</td></tr>\
                            <tr><td>Name</td><td>" + val.customer_info.first_name + " " + val.customer_info.last_name + "</td></tr>\
                            <tr><td>Mobile</td><td>" + val.customer_info.mobile + "</td></tr>\
                            <tr><td>Email</td><td>" + email + "</td></tr>\
                            <tr><td>City</td><td>" + val.customer_info.city + "</td></tr>\
                            <tr><td>Address</td><td>" + val.customer_info.address + "</td></tr>\
                            <tr><td>Landmark</td><td>" + val.customer_info.landmark + "</td></tr>\
                            <tr><td>Location</td><td>" + val.customer_info.customer_location + "</td></tr>\
                            <tr><td>Pincode</td><td>" + val.customer_info.pincode + "</td></tr>\
                            </table>\
                            </div></div>";
    
                            var ac_div = "<div class='no-display ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                            <h4 class='center'>AC Information</h4>\
                            <table class='table table-bordered table-striped'>\
                            <tr><td>AC Type</td><td>" + val.ac_info.ac_type + "</td></tr>\
                            <tr><td>Make</td><td>" + val.ac_info.make + "</td></tr>\
                            <tr><td>Location</td><td>" + val.ac_info.location + "</td></tr>\
                            <tr><td>Tonnage</td><td>" + val.ac_info.tonnage + "</td></tr>\
                            <tr><td>IDU</td><td>Serial No: " + val.ac_info.idu_serial_no + "<br /> Model No :" + val.ac_info.idu_model_no + "</td></tr>\
                            <tr><td>ODU</td><td>Serial No: " + val.ac_info.odu_serial_no + "<br /> Model No :" + val.ac_info.odu_model_no + "</td></tr>\
                            <tr><td colspan='2'>" + val.ac_info.remarks + "</td></tr></table></div></div>";
                            
                            var amc_div = "<div class='no-display amc_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                            <h4 class='center'>AC Information</h4>\
                            <table class='table table-bordered table-striped'>\
                            <tr><td>AMC Type</td><td>" + val.info.amc_type + "</td></tr>\
                            <tr><td>No of service</td><td>" + val.info.no_of_service + "</td></tr>\
                            <tr><td>Dry Service</td><td>" + val.info.wet + "</td></tr>\
                            <tr><td>Wet Service</td><td>" + val.info.dry + "</td></tr>\
                            <tr><td>Activation</td><td>" + val.info.activation + "</td></tr>\
                            <tr><td>Expiry</td><td>" + val.info.expiration + "</td></tr>\
                            </table></div></div>";
    
                                row += "<tr class='row_count_" + sr + "'><td class='center'>" + val.info.amc_type + " <i onclick='view_info(\".amc_popup\","+sr+")' class='clip-popout cursor' style='font-size:1.3em'></i>"+amc_div+"</td><td class='center'>" + val.customer_info.first_name + " " + val.customer_info.last_name + " <i onclick='view_cust_info(\".cust_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i> " + cust_div + "</td>\
                        <td class='center'>" + val.ac_info.make + " (" + val.ac_info.ac_type + ") <i onclick='view_ac_info(\".ac_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i>" + ac_div + "</td>\
                        <td><button class='btn btn-primary'>View</button></td>";
                                sr++;
                            });
    
                        } else if (response.status == "no") {
                           row="<tr><td colspan='4' class='alert alert-danger center'> No data found</td></tr>";
                        }
                    $("#ViewReportsDataTable tbody").html(row);
                    unblockThisUI($(".generated_reports"));
                }
            });
            }
        }else if(reports_for == "Complaint") {
            if(type=="all"){
                $.ajax({
                    type:'get',
                    url:'api/Reports/Complaints',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == "ok") {
                            $("#total_reports_header").removeClass().addClass("text-success");
                            $('.total_data').html(response.data.length);
                            var row = "";
                            var sr = 0;
                            $.each(response.data, function (key, val) {

                                var acc_type = (val.customer_info.account_type == 'r') ? 'Resenditial' : 'Commercial';
                                if (val.customer_info.account_type == 'r') {
                                    val.customer_info.organisation = "Home";
                                }
                           var email = (val.customer_info.email == '') ? 'NA' : val.customer_info.email;
                           
                           var cust_div = "<div class='no-display cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                            <h4 class='center'>Customer Information</h4>\
                            <table class='table table-bordered table-striped'>\
                            <tr><td>Account type</td><td>" + acc_type + "</td></tr>\
                            <tr><td>Organisation</td><td>" + val.customer_info.organisation + "</td></tr>\
                            <tr><td>Name</td><td>" + val.customer_info.first_name + " " + val.customer_info.last_name + "</td></tr>\
                            <tr><td>Mobile</td><td>" + val.customer_info.mobile + "</td></tr>\
                            <tr><td>Email</td><td>" + email + "</td></tr>\
                            <tr><td>City</td><td>" + val.customer_info.city + "</td></tr>\
                            <tr><td>Address</td><td>" + val.customer_info.address + "</td></tr>\
                            <tr><td>Landmark</td><td>" + val.customer_info.landmark + "</td></tr>\
                            <tr><td>Location</td><td>" + val.customer_info.customer_location + "</td></tr>\
                            <tr><td>Pincode</td><td>" + val.customer_info.pincode + "</td></tr>\
                            </table>\
                            </div></div>";

                            var ac_div = "<div class='no-display ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                            <h4 class='center'>AC Information</h4>\
                            <table class='table table-bordered table-striped'>\
                            <tr><td>AC Type</td><td>" + val.ac_info.ac_type + "</td></tr>\
                            <tr><td>Make</td><td>" + val.ac_info.make + "</td></tr>\
                            <tr><td>Location</td><td>" + val.ac_info.location + "</td></tr>\
                            <tr><td>Tonnage</td><td>" + val.ac_info.tonnage + "</td></tr>\
                            <tr><td>IDU</td><td>Serial No: " + val.ac_info.idu_serial_no + "<br /> Model No :" + val.ac_info.idu_model_no + "</td></tr>\
                            <tr><td>ODU</td><td>Serial No: " + val.odu_serial_no + "<br /> Model No :" + val.odu_model_no + "</td></tr>\
                            <tr><td colspan='2'>" + val.ac_info.remarks + "</td></tr></table></div></div>";

                            var complaint_div = "<div class='no-display complaint_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                            <h4 class='center'>AC Information</h4>\
                            <table class='table table-bordered table-striped'>\
                            <tr><td>Problem Type</td><td>" + val.info.ac_problem_type + "</td></tr>\
                            <tr><td>Problem Description</td><td>" + val.info.problem_desc + "</td></tr>\
                            <tr><td>Preferred Date</td><td>" + val.info.preferred_date + "</td></tr>\
                            </table></div></div>";

                    row += "<tr class='row_count_" + sr + "'><td class='center'>" + val.info.ac_problem_type + "(Complaint) <i onclick='view_info(\".complaint_popup\","+sr+")' class='clip-popout cursor' style='font-size:1.3em'></i>"+complaint_div+"</td><td class='center'>" + val.customer_info.first_name + " " + val.customer_info.last_name + " <i onclick='view_cust_info(\".cust_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i> " + cust_div + "</td>\
                    <td class='center'>" + val.ac_info.make + " (" + val.ac_info.ac_type + ") <i onclick='view_ac_info(\".ac_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i>" + ac_div + "</td>\
                    <td><button class='btn btn-primary'>View</button></td>";
                                sr++;
                            });

                        } else if (response.status == "no") {
                            row="<tr><td colspan='4' class='alert alert-danger center'> No data found</td></tr>";
                        }
                        $("#ViewReportsDataTable tbody").html(row);
                        unblockThisUI($(".generated_reports"));
                    }
                });               
            }else{
                $.ajax({
                    type:'post',
                    url:'api/Reports/Complaints',
                    data:{from_date : $(".from_date").val(),to_date : $(".to_date").val()},
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == "ok") {
                            $("#total_reports_header").removeClass().addClass("text-success");
                            $('.total_data').html(response.data.length);
                            var row = "";
                            var sr = 0;
                            $.each(response.data, function (key, val) {

                                var acc_type = (val.customer_info.account_type == 'r') ? 'Resenditial' : 'Commercial';
                                if (val.customer_info.account_type == 'r') {
                                    val.customer_info.organisation = "Home";
                                }
                           var email = (val.customer_info.email == '') ? 'NA' : val.customer_info.email;
                           
                           var cust_div = "<div class='no-display cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                            <h4 class='center'>Customer Information</h4>\
                            <table class='table table-bordered table-striped'>\
                            <tr><td>Account type</td><td>" + acc_type + "</td></tr>\
                            <tr><td>Organisation</td><td>" + val.customer_info.organisation + "</td></tr>\
                            <tr><td>Name</td><td>" + val.customer_info.first_name + " " + val.customer_info.last_name + "</td></tr>\
                            <tr><td>Mobile</td><td>" + val.customer_info.mobile + "</td></tr>\
                            <tr><td>Email</td><td>" + email + "</td></tr>\
                            <tr><td>City</td><td>" + val.customer_info.city + "</td></tr>\
                            <tr><td>Address</td><td>" + val.customer_info.address + "</td></tr>\
                            <tr><td>Landmark</td><td>" + val.customer_info.landmark + "</td></tr>\
                            <tr><td>Location</td><td>" + val.customer_info.customer_location + "</td></tr>\
                            <tr><td>Pincode</td><td>" + val.customer_info.pincode + "</td></tr>\
                            </table>\
                            </div></div>";

                            var ac_div = "<div class='no-display ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                            <h4 class='center'>AC Information</h4>\
                            <table class='table table-bordered table-striped'>\
                            <tr><td>AC Type</td><td>" + val.ac_info.ac_type + "</td></tr>\
                            <tr><td>Make</td><td>" + val.ac_info.make + "</td></tr>\
                            <tr><td>Location</td><td>" + val.ac_info.location + "</td></tr>\
                            <tr><td>Tonnage</td><td>" + val.ac_info.tonnage + "</td></tr>\
                            <tr><td>IDU</td><td>Serial No: " + val.ac_info.idu_serial_no + "<br /> Model No :" + val.ac_info.idu_model_no + "</td></tr>\
                            <tr><td>ODU</td><td>Serial No: " + val.odu_serial_no + "<br /> Model No :" + val.odu_model_no + "</td></tr>\
                            <tr><td colspan='2'>" + val.ac_info.remarks + "</td></tr></table></div></div>";

                            var complaint_div = "<div class='no-display complaint_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                            <h4 class='center'>AC Information</h4>\
                            <table class='table table-bordered table-striped'>\
                            <tr><td>Problem Type</td><td>" + val.info.ac_problem_type + "</td></tr>\
                            <tr><td>Problem Description</td><td>" + val.info.problem_desc + "</td></tr>\
                            <tr><td>Preferred Date</td><td>" + val.info.preferred_date + "</td></tr>\
                            </table></div></div>";

                    row += "<tr class='row_count_" + sr + "'><td class='center'>" + val.info.ac_problem_type + "(Complaint) <i onclick='view_info(\".complaint_popup\","+sr+")' class='clip-popout cursor' style='font-size:1.3em'></i>"+complaint_div+"</td><td class='center'>" + val.customer_info.first_name + " " + val.customer_info.last_name + " <i onclick='view_cust_info(\".cust_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i> " + cust_div + "</td>\
                    <td class='center'>" + val.ac_info.make + " (" + val.ac_info.ac_type + ") <i onclick='view_ac_info(\".ac_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i>" + ac_div + "</td>\
                    <td><button class='btn btn-primary'>View</button></td>";
                                sr++;
                            });

                        } else if (response.status == "no") {
                            row="<tr><td colspan='4' class='alert alert-danger center'> No data found</td></tr>";
                        }
                        $("#ViewReportsDataTable tbody").html(row);
                        unblockThisUI($(".generated_reports"));
                    }
                });                 
            }
        }else if (reports_for == "OTS") {
            if(type=="all"){
                $.ajax({
                    type:'get',
                    url: 'api/Reports/OTS',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == "ok") {
                            $("#total_reports_header").removeClass().addClass("text-success");
                            $('.total_data').html(response.data.length);
                            var row = "";
                            var sr = 0;
                            $.each(response.data, function (key, val) {

                                var acc_type = (val.customer_info.account_type == 'r') ? 'Resenditial' : 'Commercial';
                                if (val.customer_info.account_type == 'r') {
                                    val.customer_info.organisation = "Home";
                                }
                    var email = (val.customer_info.email == '') ? 'NA' : val.customer_info.email;
                    
                    var cust_div = "<div class='no-display cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>Customer Information</h4>\
                    <table class='table table-bordered table-striped'>\
                    <tr><td>Account type</td><td>" + acc_type + "</td></tr>\
                    <tr><td>Organisation</td><td>" + val.customer_info.organisation + "</td></tr>\
                    <tr><td>Name</td><td>" + val.customer_info.first_name + " " + val.customer_info.last_name + "</td></tr>\
                    <tr><td>Mobile</td><td>" + val.customer_info.mobile + "</td></tr>\
                    <tr><td>Email</td><td>" + email + "</td></tr>\
                    <tr><td>City</td><td>" + val.customer_info.city + "</td></tr>\
                    <tr><td>Address</td><td>" + val.customer_info.address + "</td></tr>\
                    <tr><td>Landmark</td><td>" + val.customer_info.landmark + "</td></tr>\
                    <tr><td>Location</td><td>" + val.customer_info.customer_location + "</td></tr>\
                    <tr><td>Pincode</td><td>" + val.customer_info.pincode + "</td></tr>\
                    </table>\
                    </div></div>";

                    var ac_div = "<div class='no-display ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                    <tr><td>AC Type</td><td>" + val.ac_info.ac_type + "</td></tr>\
                    <tr><td>Make</td><td>" + val.ac_info.make + "</td></tr>\
                    <tr><td>Location</td><td>" + val.ac_info.location + "</td></tr>\
                    <tr><td>Tonnage</td><td>" + val.ac_info.tonnage + "</td></tr>\
                    <tr><td>IDU</td><td>Serial No: " + val.ac_info.idu_serial_no + "<br /> Model No :" + val.ac_info.idu_model_no + "</td></tr>\
                    <tr><td>ODU</td><td>Serial No: " + val.odu_serial_no + "<br /> Model No :" + val.odu_model_no + "</td></tr>\
                    <tr><td colspan='2'>" + val.ac_info.remarks + "</td></tr></table></div></div>";

                    var ots_div = "<div class='no-display complaint_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                    <tr><td>Problem Type</td><td>" + val.info.problem_type + "</td></tr>\
                    <tr><td>Problem Description</td><td>" + val.info.problem_desc + "</td></tr>\
                    <tr><td>Preferred Date</td><td>" + val.info.preferred_date + "</td></tr>\
                    </table></div></div>";

                    row += "<tr class='row_count_" + sr + "'><td class='center'>" + val.info.service_type + "</td><td class='center'>" + val.customer_info.first_name + " " + val.customer_info.last_name + " <i onclick='view_cust_info(\".cust_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i> " + cust_div + "</td>\
                        <td class='center'>" + val.ac_info.make + " (" + val.ac_info.ac_type + ") <i onclick='view_ac_info(\".ac_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i>" + ac_div + "</td>\
                        <td><button class='btn btn-primary'>View</button></td>";
                                sr++;
                            });

                        } else if (response.status == "no") {
                            row="<tr><td colspan='4' class='alert alert-danger center'> No data found</td></tr>";
                        }
                        $("#ViewReportsDataTable tbody").html(row);
                        unblockThisUI($(".generated_reports"));
                    }
                });
            }else{
                $.ajax({
                    type:'post',
                    url: 'api/Reports/OTS',
                    data:{from_date : $(".from_date").val(),to_date : $(".to_date").val()},
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == "ok") {
                            $("#total_reports_header").removeClass().addClass("text-success");
                            $('.total_data').html(response.data.length);
                            var row = "";
                            var sr = 0;
                            $.each(response.data, function (key, val) {

                                var acc_type = (val.customer_info.account_type == 'r') ? 'Resenditial' : 'Commercial';
                                if (val.customer_info.account_type == 'r') {
                                    val.customer_info.organisation = "Home";
                                }
                    var email = (val.customer_info.email == '') ? 'NA' : val.customer_info.email;
                    
                    var cust_div = "<div class='no-display cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>Customer Information</h4>\
                    <table class='table table-bordered table-striped'>\
                    <tr><td>Account type</td><td>" + acc_type + "</td></tr>\
                    <tr><td>Organisation</td><td>" + val.customer_info.organisation + "</td></tr>\
                    <tr><td>Name</td><td>" + val.customer_info.first_name + " " + val.customer_info.last_name + "</td></tr>\
                    <tr><td>Mobile</td><td>" + val.customer_info.mobile + "</td></tr>\
                    <tr><td>Email</td><td>" + email + "</td></tr>\
                    <tr><td>City</td><td>" + val.customer_info.city + "</td></tr>\
                    <tr><td>Address</td><td>" + val.customer_info.address + "</td></tr>\
                    <tr><td>Landmark</td><td>" + val.customer_info.landmark + "</td></tr>\
                    <tr><td>Location</td><td>" + val.customer_info.customer_location + "</td></tr>\
                    <tr><td>Pincode</td><td>" + val.customer_info.pincode + "</td></tr>\
                    </table>\
                    </div></div>";

                    var ac_div = "<div class='no-display ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                    <tr><td>AC Type</td><td>" + val.ac_info.ac_type + "</td></tr>\
                    <tr><td>Make</td><td>" + val.ac_info.make + "</td></tr>\
                    <tr><td>Location</td><td>" + val.ac_info.location + "</td></tr>\
                    <tr><td>Tonnage</td><td>" + val.ac_info.tonnage + "</td></tr>\
                    <tr><td>IDU</td><td>Serial No: " + val.ac_info.idu_serial_no + "<br /> Model No :" + val.ac_info.idu_model_no + "</td></tr>\
                    <tr><td>ODU</td><td>Serial No: " + val.odu_serial_no + "<br /> Model No :" + val.odu_model_no + "</td></tr>\
                    <tr><td colspan='2'>" + val.ac_info.remarks + "</td></tr></table></div></div>";

                    var ots_div = "<div class='no-display complaint_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                    <tr><td>Problem Type</td><td>" + val.info.problem_type + "</td></tr>\
                    <tr><td>Problem Description</td><td>" + val.info.problem_desc + "</td></tr>\
                    <tr><td>Preferred Date</td><td>" + val.info.preferred_date + "</td></tr>\
                    </table></div></div>";

                    row += "<tr class='row_count_" + sr + "'><td class='center'>" + val.info.service_type + "</td><td class='center'>" + val.customer_info.first_name + " " + val.customer_info.last_name + " <i onclick='view_cust_info(\".cust_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i> " + cust_div + "</td>\
                        <td class='center'>" + val.ac_info.make + " (" + val.ac_info.ac_type + ") <i onclick='view_ac_info(\".ac_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i>" + ac_div + "</td>\
                        <td><button class='btn btn-primary'>View</button></td>";
                                sr++;
                            });

                        } else if (response.status == "no") {
                            row="<tr><td colspan='4' class='alert alert-danger center'> No data found</td></tr>";
                        }
                        $("#ViewReportsDataTable tbody").html(row);
                        unblockThisUI($(".generated_reports"));
                    }
                });
            }
        }else if (reports_for == "Installation") {
            if(type=="all"){
                $.ajax({
                    type:'get',
                    url:'api/Reports/Installation',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == "ok") {
                            $("#total_reports_header").removeClass().addClass("text-success");
                            $('.total_data').html(response.data.length);
                            var row = "";
                            var sr = 0;
                            $.each(response.data, function (key, val) {
                                if (val.info.install_type == "s") {
                                    val.info.install_type = "Standard";
                                } else if (val.info.install_type == "n") {
                                    val.info.install_type = "Non-Standard";
                                } else {
                                    val.info.install_type = "Free";
                                }
                                var acc_type = (val.customer_info.account_type == 'r') ? 'Resenditial' : 'Commercial';
                                if (val.customer_info.account_type == 'r') {
                                    val.customer_info.organisation = "Home";
                                }
                                var email = (val.customer_info.email == '') ? 'NA' : val.customer_info.email;
                                var cust_div = "<div class='no-display cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                        <h4 class='center'>Customer Information</h4>\
                        <table class='table table-bordered table-striped'>\
                            <tr><td>Account type</td><td>" + acc_type + "</td></tr>\
                            <tr><td>Organisation</td><td>" + val.customer_info.organisation + "</td></tr>\
                            <tr><td>Name</td><td>" + val.customer_info.first_name + " " + val.customer_info.last_name + "</td></tr>\
                            <tr><td>Mobile</td><td>" + val.customer_info.mobile + "</td></tr>\
                            <tr><td>Email</td><td>" + email + "</td></tr>\
                            <tr><td>City</td><td>" + val.customer_info.city + "</td></tr>\
                            <tr><td>Address</td><td>" + val.customer_info.address + "</td></tr>\
                            <tr><td>Landmark</td><td>" + val.customer_info.landmark + "</td></tr>\
                            <tr><td>Location</td><td>" + val.customer_info.customer_location + "</td></tr>\
                            <tr><td>Pincode</td><td>" + val.customer_info.pincode + "</td></tr>\
                        </table>\
                        </div></div>";

                                var ac_div = "<div class='no-display ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                            <tr><td>AC Type</td><td>" + val.ac_info.ac_type + "</td></tr>\
                            <tr><td>Make</td><td>" + val.ac_info.make + "</td></tr>\
                            <tr><td>Location</td><td>" + val.ac_info.location + "</td></tr>\
                            <tr><td>Tonnage</td><td>" + val.ac_info.tonnage + "</td></tr>\
                            <tr><td>IDU</td><td>Serial No: " + val.ac_info.idu_serial_no + "<br /> Model No :" + val.ac_info.idu_model_no + "</td></tr>\
                            <tr><td>ODU</td><td>Serial No: " + val.ac_info.odu_serial_no + "<br /> Model No :" + val.ac_info.odu_model_no + "</td></tr>\
                            <tr><td colspan='2'>" + val.ac_info.remarks + "</td></tr></table></div></div>";
                            
                            var ins_div = "<div class='no-display install_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                            <tr><td>Installation Type</td><td>" + val.info.install_type + "</td></tr>\
                            <tr><td>No of service</td><td>" + val.info.no_of_service + "</td></tr>\
                            <tr><td>Preferred Date</td><td>" + val.info.preferred_date + "</td></tr>\
                            </table></div></div>";

                                row += "<tr class='row_count_" + sr + "'><td class='center'>" + val.info.install_type + " <i onclick='view_info(\".install_popup\","+sr+")' class='clip-popout cursor' style='font-size:1.3em'></i>"+ins_div+"</td>\
                                <td class='center'>" + val.customer_info.first_name + " " + val.customer_info.last_name + " <i onclick='view_cust_info(\".cust_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i> " + cust_div + "</td>\
                <td class='center'>" + val.ac_info.make + " (" + val.ac_info.ac_type + ") <i onclick='view_ac_info(\".ac_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i>" + ac_div + "</td>\
                <td><button class='btn btn-primary btn-sm'>View</button></td>";
                                sr++;
                            });

                        } else if (response.status == "no") {
                            row="<tr><td colspan='4' class='alert alert-danger center'> No data found</td></tr>";
                        }
                        $("#ViewReportsDataTable tbody").html(row);
                        unblockThisUI($(".generated_reports"));
                    }

                });
            }else{
                $.ajax({
                    type:'post',
                    url: 'api/Reports/Installation',
                    data:{from_date : $(".from_date").val(),to_date : $(".to_date").val()},
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == "ok") {
                            $("#total_reports_header").removeClass().addClass("text-success");
                            $('.total_data').html(response.data.length);
                            var row = "";
                            var sr = 0;
                            $.each(response.data, function (key, val) {
                                if (val.info.install_type == "s") {
                                    val.info.install_type = "Standard";
                                } else if (val.info.install_type == "n") {
                                    val.info.install_type = "Non-Standard";
                                } else {
                                    val.info.install_type = "Free";
                                }
                                var acc_type = (val.customer_info.account_type == 'r') ? 'Resenditial' : 'Commercial';
                                if (val.customer_info.account_type == 'r') {
                                    val.customer_info.organisation = "Home";
                                }
                                var email = (val.customer_info.email == '') ? 'NA' : val.customer_info.email;
                                var cust_div = "<div class='no-display cust_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                        <h4 class='center'>Customer Information</h4>\
                        <table class='table table-bordered table-striped'>\
                            <tr><td>Account type</td><td>" + acc_type + "</td></tr>\
                            <tr><td>Organisation</td><td>" + val.customer_info.organisation + "</td></tr>\
                            <tr><td>Name</td><td>" + val.customer_info.first_name + " " + val.customer_info.last_name + "</td></tr>\
                            <tr><td>Mobile</td><td>" + val.customer_info.mobile + "</td></tr>\
                            <tr><td>Email</td><td>" + email + "</td></tr>\
                            <tr><td>City</td><td>" + val.customer_info.city + "</td></tr>\
                            <tr><td>Address</td><td>" + val.customer_info.address + "</td></tr>\
                            <tr><td>Landmark</td><td>" + val.customer_info.landmark + "</td></tr>\
                            <tr><td>Location</td><td>" + val.customer_info.customer_location + "</td></tr>\
                            <tr><td>Pincode</td><td>" + val.customer_info.pincode + "</td></tr>\
                        </table>\
                        </div></div>";

                                var ac_div = "<div class='no-display ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                            <tr><td>AC Type</td><td>" + val.ac_info.ac_type + "</td></tr>\
                            <tr><td>Make</td><td>" + val.ac_info.make + "</td></tr>\
                            <tr><td>Location</td><td>" + val.ac_info.location + "</td></tr>\
                            <tr><td>Tonnage</td><td>" + val.ac_info.tonnage + "</td></tr>\
                            <tr><td>IDU</td><td>Serial No: " + val.ac_info.idu_serial_no + "<br /> Model No :" + val.ac_info.idu_model_no + "</td></tr>\
                            <tr><td>ODU</td><td>Serial No: " + val.ac_info.odu_serial_no + "<br /> Model No :" + val.ac_info.odu_model_no + "</td></tr>\
                            <tr><td colspan='2'>" + val.ac_info.remarks + "</td></tr></table></div></div>";
                            
                            var ins_div = "<div class='no-display install_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                            <tr><td>Installation Type</td><td>" + val.info.install_type + "</td></tr>\
                            <tr><td>No of service</td><td>" + val.info.no_of_service + "</td></tr>\
                            <tr><td>Preferred Date</td><td>" + val.info.preferred_date + "</td></tr>\
                            </table></div></div>";

                                row += "<tr class='row_count_" + sr + "'><td class='center'>" + val.info.install_type + " <i onclick='view_info(\".install_popup\","+sr+")' class='clip-popout cursor' style='font-size:1.3em'></i>"+ins_div+"</td>\
                                <td class='center'>" + val.customer_info.first_name + " " + val.customer_info.last_name + " <i onclick='view_cust_info(\".cust_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i> " + cust_div + "</td>\
                <td class='center'>" + val.ac_info.make + " (" + val.ac_info.ac_type + ") <i onclick='view_ac_info(\".ac_popup\"," + sr + ")' class='clip-popout cursor' style='font-size:1.3em'></i>" + ac_div + "</td>\
                <td><button class='btn btn-primary btn-sm'>View</button></td>";
                                sr++;
                            });

                        } else if (response.status == "no") {
                            row="<tr><td colspan='4' class='alert alert-danger center'> No data found</td></tr>";
                        }
                        $("#ViewReportsDataTable tbody").html(row);
                        unblockThisUI($(".generated_reports"));
                    }

                });
            }
        } else if(reports_for == "New Customers"){
                var URL = 'api/Customers';
                var row="";
                $.get(URL,function(response){
                    console.log(response.status);
                    if(response.status=="ok"){
                        $.each(response.data, function(key,val){
                            (val.account_type=="r")?val.account_type="Residential":val.account_type="Commercial";
                            row+="<tr><td class='center'>"+val.account_type+"</td><td class='center'>"+val.first_name+" "+val.last_name+"</td><td class='center'>"+val.created_on+"</td>\
                            <td class='center'><button href='CustomerDetails?id='"+val.cust_id+"' onclick='return LoadPage(\"CustomerDetails?id="+val.cust_id+"\")' class='btn btn-primary btn-sm'>View</button></td></tr>";
                        });
                    }else if(response.status=="no"){
                        row="<tr><td colspan='4' class='alert alert-danger center'> No data found</td></tr>";
                    }
                    $(".generated_reports_customer tbody").html(row);
                    unblockThisUI($(".generated_reports"));
                });
                
        } else if(reports_for == "Technician"){
                var URL = 'api/Technicians';
                var row="";
                $.get(URL,function(response){
                    console.log(response.status);
                    if(response.status=="ok"){
                        $.each(response.data, function(key,val){
                            row+="<tr><td class='center'>"+val.first_name+" "+val.last_name+"</td><td class='center'>"+val.mobile+"</td>\
                            <td class='center'>"+val.branch_name+"</td><td class='center'>"+val.address+"</td></tr>";
                        });
                    }else if(response.status=="no"){
                        row="<tr><td colspan='4' class='alert alert-danger center'> No data found</td></tr>";
                    }
                    $(".generated_reports_technician tbody").html(row);
                    unblockThisUI($(".generated_reports"));
                });                
        } else{
            alert("Required field is not selected");
        }
    });

});


function view_ac_info(elem,sub){
    var content = $(".row_count_"+sub).find(elem).html();
    $.facebox(content);
}

function view_info(elem,sub){
    var content = $(".row_count_"+sub).find(elem).html();
    $.facebox(content);
}

function view_cust_info(elem,sub){
    var content = $(".row_count_"+sub).find(elem).html();
    $.facebox(content);
}