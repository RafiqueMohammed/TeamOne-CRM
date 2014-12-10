$(document).ready(function(){
   $(".reports_for").on("change",function(){
       $(".reports_type").prop('selectedIndex',0);
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

            blockThisUI($(".generated_reports"));

$("#total_reports_header").removeClass().addClass("text-danger");
            $('.total_data').text("0");


        if (type == "date") {
            var from_date = $(".from_date").val();
            var to_date = $(".to_date").val();
            console.log(from_date + " " + to_date);
        }
        if (type == "date") {
            $.ajax({
                type: 'post',
                url: 'api/Reports/AMC',
                data: {from_date: from_date, to_date: to_date},
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
                                val.info.amc_type = "Non-Comprehensive";
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
                            <tr><td>ODU</td><td>Serial No: " + val.odu_serial_no + "<br /> Model No :" + val.odu_model_no + "</td></tr>\
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

                            row += "<tr class='row_count_" + sr + "'><td>" + val.info.amc_type + " <i onclick='view_info(\".amc_popup\","+sr+")' class='fa fa-eye cursor' style='font-size:1.3em'></i>"+amc_div+"</td><td>" + val.customer_info.first_name + " " + val.customer_info.last_name + " <i onclick='view_cust_info(\".cust_popup\"," + sr + ")' class='fa fa-eye cursor' style='font-size:1.3em'></i> " + cust_div + "</td>\
                        <td>" + val.ac_info.make + " (" + val.ac_info.ac_type + ") <i onclick='view_ac_info(\".ac_popup\"," + sr + ")' class='fa fa-eye cursor' style='font-size:1.3em'></i>" + ac_div + "</td>\
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
        } else {
            if (reports_for == "AMC") {
                var URL = 'api/Reports/AMC'
                $.ajax({
                    type: 'get',
                    url: URL,
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
                                    val.info.amc_type = "Non-Comprehensive";
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
                            <tr><td>ODU</td><td>Serial No: " + val.odu_serial_no + "<br /> Model No :" + val.odu_model_no + "</td></tr>\
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

                                row += "<tr class='row_count_" + sr + "'><td>" + val.info.amc_type + " <i onclick='view_info(\".amc_popup\","+sr+")' class='fa fa-eye cursor' style='font-size:1.3em'></i>"+amc_div+"</td><td>" + val.customer_info.first_name + " " + val.customer_info.last_name + " <i onclick='view_cust_info(\".cust_popup\"," + sr + ")' class='fa fa-eye cursor' style='font-size:1.3em'></i> " + cust_div + "</td>\
                        <td>" + val.ac_info.make + " (" + val.ac_info.ac_type + ") <i onclick='view_ac_info(\".ac_popup\"," + sr + ")' class='fa fa-eye cursor' style='font-size:1.3em'></i>" + ac_div + "</td>\
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
            } else if (reports_for == "Complaint") {
                var URL = 'api/Reports/Complaints'

                $.ajax({
                    type: 'get',
                    url: URL,
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
                            <tr><td>Problem Type</td><td>" + val.info.problem_type + "</td></tr>\
                            <tr><td>Problem Description</td><td>" + val.info.problem_desc + "</td></tr>\
                            <tr><td>Preferred Date</td><td>" + val.info.preferred_date + "</td></tr>\
                            </table></div></div>";

                    row += "<tr class='row_count_" + sr + "'><td>" + val.info.problem_type + "<i onclick='view_info(\".complaint_popup\","+sr+")' class='fa fa-eye cursor' style='font-size:1.3em'></i>"+complaint_div+"</td><td>" + val.customer_info.first_name + " " + val.customer_info.last_name + " <i onclick='view_cust_info(\".cust_popup\"," + sr + ")' class='fa fa-eye cursor' style='font-size:1.3em'></i> " + cust_div + "</td>\
                    <td>" + val.ac_info.make + " (" + val.ac_info.ac_type + ") <i onclick='view_ac_info(\".ac_popup\"," + sr + ")' class='fa fa-eye cursor' style='font-size:1.3em'></i>" + ac_div + "</td>\
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
            } else if (reports_for == "OTS") {
                var URL = 'api/Reports/OTS'

                $.ajax({
                    type: 'get',
                    url: URL,
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

            row += "<tr class='row_count_" + sr + "'><td>" + val.info.service_type + "</td><td>" + val.customer_info.first_name + " " + val.customer_info.last_name + " <i onclick='view_cust_info(\".cust_popup\"," + sr + ")' class='fa fa-eye cursor' style='font-size:1.3em'></i> " + cust_div + "</td>\
                <td>" + val.ac_info.make + " (" + val.ac_info.ac_type + ") <i onclick='view_ac_info(\".ac_popup\"," + sr + ")' class='fa fa-eye cursor' style='font-size:1.3em'></i>" + ac_div + "</td>\
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
            } else if (reports_for == "Installation") {
                var URL = 'api/Reports/Installation'

                $.ajax({
                    type: 'get',
                    url: URL,
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
                                } else {
                                    val.info.amc_type = "Non-Comprehensive";
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
                            <tr><td>ODU</td><td>Serial No: " + val.odu_serial_no + "<br /> Model No :" + val.odu_model_no + "</td></tr>\
                            <tr><td colspan='2'>" + val.ac_info.remarks + "</td></tr></table></div></div>";

                                row += "<tr class='row_count_" + sr + "'><td>" + val.info.amc_type + "</td><td>" + val.customer_info.first_name + " " + val.customer_info.last_name + " <i onclick='view_cust_info(\".cust_popup\"," + sr + ")' class='fa fa-eye cursor' style='font-size:1.3em'></i> " + cust_div + "</td>\
                <td>" + val.ac_info.make + " (" + val.ac_info.ac_type + ") <i onclick='view_ac_info(\".ac_popup\"," + sr + ")' class='fa fa-eye cursor' style='font-size:1.3em'></i>" + ac_div + "</td>\
                <td><button class='btn btn-primary'></button></td>";
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
        }

        }else{
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