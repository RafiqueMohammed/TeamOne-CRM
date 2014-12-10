var customer_id;
var customer_info = {};
var technicians = {};
var technician_dropdown;
var inst_count = 0;
var comp_count = 0;
var amc_count = 0;
var ots_count = 0;
$(function () {

    var ac_info_div = "<div class='no-display ac_popup'>\
    <div class='' style='background:#fff;padding: 20px;'>\
    <h2 class='center'> AC Informations</h2>\
    <table class='table table-bordered table-striped'>\
                    <tr><td>AC Type</td><td>{type}</td></tr>\
                    <tr><td>Make</td><td>{make}</td></tr>\
                    <tr><td>Location</td><td>{location}</td></tr>\
                    <tr><td>Tonnage</td><td>{tonnage}</td></tr>\
                    <tr><td>IDU</td><td>Serial No: {idu_serial_no}<br /> Model No :{idu_model_no}</td></tr>\
                    <tr><td>ODU</td><td>Serial No: {odu_serial_no}<br /> Model No :{odu_model_no}</td></tr>\
                    <tr><td colspan='2'>{remarks}</td></tr></table></div></div>";

    var technician_dropdown = "<option>-SELECT TECH-</option>";
    customer_id = $("#customer_id_holder").val();
    blockThisUI($(".tabbable"));
    $.getJSON("api/Technicians", function (tech) {
        if (tech.status == "ok") {
            technicians = tech.data;

            $.each(technicians, function (key, value) {
                technician_dropdown += "<option value='" + value.tech_id + "'>" + value.first_name + " " + value.last_name + "</option>";
            });
        } else {
            technician_dropdown = "<option value='-1'>No Technician available</option>";
        }


        $.getJSON("api/Assign/Customer/" + customer_id, function (response) {
            if (response.status == "ok") {
                customer_info.details = response.data.customer_info;
                customer_info.amc = response.data.amc;
                customer_info.ots = response.data.ots;
                customer_info.installations = response.data.installations;
                customer_info.complaints = response.data.complaints;
                $(".cust_full_name").html(customer_info.details.first_name + " " + customer_info.details.last_name + "\
                 <a onclick='return LoadPage(\"CustomerDetails?id=" + customer_id + "&ref=AssignTechnician?id=" + customer_id + "\")'\
                  href='CustomerDetails?id=" + customer_id + "&ref=AssignTechnician?id=" + customer_id + "'><i style='font-size: 20px; color: rgb(98, 98, 98);' \
                  class='clip-info info'></i>");

                var install_tab_row = "";
                var notification = 0;
                var sr_no = 1;
                if (customer_info.installations.empty) {
                    install_tab_row = "<tr><td colspan='8' class='alert alert-info center'><i class='clip-info'></i>&nbsp;&nbsp;No Installation Added Yet</td></tr>"
                } else {

                    var tmp_ac_div = ac_info_div;

                    delete customer_info.installations.empty;
                    $.each(customer_info.installations, function (key, val) {

                        tmp_ac_div = tmp_ac_div.replace("{type}", val.ac_type);
                        tmp_ac_div = tmp_ac_div.replace("{make}", val.make);
                        tmp_ac_div = tmp_ac_div.replace("{location}", val.location);
                        tmp_ac_div = tmp_ac_div.replace("{tonnage}", val.tonnage);
                        tmp_ac_div = tmp_ac_div.replace("{idu_serial_no}", val.idu_serial_no);
                        tmp_ac_div = tmp_ac_div.replace("{idu_model_no}", val.idu_model_no);
                        tmp_ac_div = tmp_ac_div.replace("{odu_serial_no}", val.odu_serial_no);
                        tmp_ac_div = tmp_ac_div.replace("{odu_model_no}", val.odu_model_no);
                        tmp_ac_div = tmp_ac_div.replace("{remarks}", val.remarks);


                        if (val.install_type == "s") {
                            val.install_type = "Standard"
                        }
                        else if (val.install_type == "n") {
                            val.install_type = "Non-standard"
                        } else if (val.install_type == "f") {
                            val.install_type = "Free"
                        }
                        $.each(customer_info.installations[key].service_info, function(k,v){
                        if(v.type=="installation"){
                            if(val.remarks==""){val.remarks="<b>No remarks added"}else{val.remarks=val.remarks}
                        install_tab_row += "<tr class='i_num_rows i_row_num_c_" + sr_no + "'><td>" + val.make + "&nbsp;(" + val.location + ") <i onclick='view_ac_info(\".ac_popup\")' class='fa fa-eye cursor' style='font-size:1.3em'></i>" + tmp_ac_div +
                            "</td><td> Installation </td><td>"+val.install_type+"</td>" +
                            "<td>" +  val.remarks + "</td><td>" + val.created_on + "</td><td><button onclick='assign_technician(" + sr_no + ",\"installation\"," + v.install_service_id + ",\"" + v.date + "\")' class='btn btn-primary btn-sm'>Assign</button></td></tr>"
                        notification++;
                        sr_no++;
                        }else{
                            if(v.remarks==""){v.remarks="<b>No remarks added"}else{v.remarks=v.remarks}
                            install_tab_row += "<tr class='i_num_rows i_row_num_c_" + sr_no + "'><td>" + val.make + "&nbsp;(" + val.location + ") <i onclick='view_ac_info(\".ac_popup\")' class='fa fa-eye cursor' style='font-size:1.3em'></i>" + tmp_ac_div +
                            "</td><td> Service </td><td>-</td>" +
                            "<td>" + v.remarks + "</td><td>" + v.date + "</td><td><button onclick='assign_technician(" + sr_no + ",\"ins_service\"," + v.install_service_id + ",\"" + v.date + "\")' class='btn btn-primary btn-sm'>Assign</button></td></tr>";
                        notification++;
                        sr_no++;
                        }
                        inst_count = notification;
                        //console.log(val.install_date);
                        
                        });
                    });
                }
                if (notification != 0) {
                    $("#Ins_count").html(notification);
                }

                $("#at_install_table tbody").html(install_tab_row);
                $('.install_datepicker').datepicker({
                    autoclose: true
                });


                var complaint_tab_row = "";
                var notification = 0;
                var sr_no = 1;
                if (customer_info.complaints.empty) {
                    complaint_tab_row = "<tr><td colspan='7' class='alert alert-info center'><i class='clip-info'></i>&nbsp;&nbsp;No Complaint Added Yet</td></tr>";
                } else {
                    delete customer_info.complaints.empty;
                    $.each(customer_info.complaints, function (key, val) {

                        var ac_div = "<div class='no-display ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                            <tr><td>AC Type</td><td>" + val.ac_type + "</td></tr>\
                            <tr><td>Make</td><td>" + val.make + "</td></tr>\
                            <tr><td>Location</td><td>" + val.location + "</td></tr>\
                            <tr><td>Tonnage</td><td>" + val.tonnage + "</td></tr>\
                            <tr><td>IDU</td><td>Serial No: " + val.idu_serial_no + "<br /> Model No :" + val.idu_model_no + "</td></tr>\
                            <tr><td>ODU</td><td>Serial No: " + val.odu_serial_no + "<br /> Model No :" + val.odu_model_no + "</td></tr>\
                            <tr><td colspan='2'>" + val.remarks + "</td></tr></table></div></div>";

                        complaint_tab_row += "<tr class='c_num_rows c_row_num_c_" + sr_no + "'><td>" + val.make + "&nbsp; (" + val.ac_type + ") <i onclick='view_ac_info(\".ac_popup\")' class='fa fa-eye cursor' style='font-size:1.3em'></i>" + ac_div + "</td><td>" + val.ac_problem_type + "</td>" +
                            "<td>" + val.remarks + "</td><td>" + val.created_on + "</td><td><button onclick='assign_technician(" + sr_no + ",\"complaint\"," + val.com_id + ",\"" + val.preferred_date + "\")' class='btn btn-primary btn-sm'>Assign</button></td></tr>";
                        notification++;
                        sr_no++;
                        comp_count = notification;
                    });
                }
                if (notification != 0) {
                    $("#Com_count").html(notification);
                }

                $("#at_complaint_table tbody").prepend(complaint_tab_row);
                $('.complaints_datepicker').datepicker({
                    autoclose: true
                });

                var amc_tab_row = "";
                var notification = 0;
                var sr_no = 1;
                if (customer_info.amc.empty) {
                    amc_tab_row = "<tr><td colspan='8' class='alert alert-info center'><i class='clip-info'></i>&nbsp;&nbsp;No AMC Added Yet</td></tr>";
                } else {
                    delete customer_info.amc.empty;
                    console.log(customer_info.amc);
                    $.each(customer_info.amc, function (key, val) {

                        $.each(customer_info.amc[key].service_info, function (k, v) {
                            //console.log(v.date)
                            if (val.amc_type == "s") {
                                val.amc_type = "Standard"
                            } else if (val.amc_type == "n") {
                                val.amc_type = "Non-standard"
                            } else if (val.amc_type == "c") {
                                val.amc_type = "Comprehensive";
                            }

                            var ac_div = "<div class='no-display ac_popup'><div class='' style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                            <tr><td>AC Type</td><td>" + val.ac_type + "</td></tr>\
                            <tr><td>Make</td><td>" + val.make + "</td></tr>\
                            <tr><td>Location</td><td>" + val.location + "</td></tr>\
                            <tr><td>Tonnage</td><td>" + val.tonnage + "</td></tr>\
                            <tr><td>IDU</td><td>Serial No: " + val.idu_serial_no + "<br /> Model No :" + val.idu_model_no + "</td></tr>\
                            <tr><td>ODU</td><td>Serial No: " + val.odu_serial_no + "<br /> Model No :" + val.odu_model_no + "</td></tr>\
                            <tr><td colspan='2'>" + val.remarks + "</td></tr></table></div></div>";

                            amc_tab_row += "<tr class='a_num_rows a_row_num_c_" + sr_no + "'><td>" + val.make + "&nbsp;(" + val.location + ") <i onclick='view_ac_info(\".ac_popup\")' class='fa fa-eye cursor' style='font-size:1.3em'></i>" + ac_div + "</td><td>" + val.amc_type + "</td><td><b>Dry : </b>" + val.dry + "<br /><b>Wet : </b>" + val.wet + "</td>\
                        <td>" + val.amc_remarks + "</td><td><b>Activation : </b>" + val.activation + "<br /><b>Expiration : " + val.expiration + "</b></td><td>" + v.date + "</td>\
                        <td><button onclick='assign_technician(" + sr_no + ",\"amc\"," + v.amc_service_id + ",\"" + v.date + "\")' class='btn btn-primary btn-sm'>Assign</button></td></tr>";
                            notification++;
                            sr_no++;
                            amc_count = notification;
                        });
                    });
                }
                if (notification != 0) {
                    $("#AMC_count").html(notification);
                }

                $("#at_amc_table tbody").prepend(amc_tab_row);


                var ots_tab_row;
                var notification = 0;
                var sr_no = 1;
                if (customer_info.ots.empty) {
                    ots_tab_row = "<tr><td colspan='6' class='alert alert-info center'><i class='clip-info'></i>&nbsp;&nbsp;No OTSs Added Yet</td></tr>";
                } else {
                    delete customer_info.ots.empty;
                    var notification = 0;
                    var sr_no = 1
                    console.log(customer_info.ots);
                    $.each(customer_info.ots, function (key, val) {

                        var ac_div = "<div class='no-display ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                            <tr><td>AC Type</td><td>" + val.ac_type + "</td></tr>\
                            <tr><td>Make</td><td>" + val.make + "</td></tr>\
                            <tr><td>Location</td><td>" + val.location + "</td></tr>\
                            <tr><td>Tonnage</td><td>" + val.tonnage + "</td></tr>\
                            <tr><td>IDU</td><td>Serial No: " + val.idu_serial_no + "<br /> Model No :" + val.idu_model_no + "</td></tr>\
                            <tr><td>ODU</td><td>Serial No: " + val.odu_serial_no + "<br /> Model No :" + val.odu_model_no + "</td></tr>\
                            <tr><td colspan='2'>" + val.remarks + "</td></tr></table></div></div>";

                        ots_tab_row += "<tr class='o_num_rows o_row_num_c_" + sr_no + "'><td>" + val.make + "<br />(" + val.ac_type + "," + val.location + ") <i onclick='view_ac_info(\".ac_popup\")' class='fa fa-eye cursor' style='font-size:1.3em'></i>" + ac_div + "</td><td>" + val.service_type + "</td><td>" + val.description + "</td>" +
                            "<td>" + val.created_on + "</td>" +
                            "<td><button onclick='assign_technician(" + sr_no + ",\"ots\"," + val.ots_id + ",\"" + val.preferred_date + "\")' class='btn btn-primary btn-sm'>Assign</button></td></tr>";
                        notification++;
                        sr_no++;
                        ots_count = notification;
                    });
                    if (notification != 0) {
                        $("#OTS_count").html(notification);
                    }
                }
                $("#at_ots_table tbody").html(ots_tab_row);
                //console.log(customer_info);
            } else if (response.status == "no") {
                $("#at_install_table tbody").html("<tr><td colspan='8' class='alert alert-info center'><i class='clip-info'></i>&nbsp;&nbsp;No Instalation Assigned Yet</td></tr>");
                $("#at_complaint_table tbody").html("<tr><td colspan='8' class='alert alert-info center'><i class='clip-info'></i>&nbsp;&nbsp;No Complaint Assigned Yet</td></tr>");
                $("#at_amc_table tbody").html("<tr><td colspan='8' class='alert alert-info center'><i class='clip-info'></i>&nbsp;&nbsp;No AMC Assigned Yet</td></tr>");
                $("#at_ots_table tbody").html("<tr><td colspan='8' class='alert alert-info center'><i class='clip-info'></i>&nbsp;&nbsp;No OTS Assigned Yet</td></tr>");
            }

            unblockThisUI($(".tabbable"));
        });
    });
});

function assign_technician(serial, type, id, date) {
    console.log(serial + " " + type + " " + id + " " + date)
    if (date == "" || date == null) {
        date = "";
    }

    switch (type) {
        case 'installation':

            var technician_dropdown = "<option value='-1'>-SELECT TECH-</option>";
            $.each(technicians, function (key, value) {
                technician_dropdown += "<option value='" + value.tech_id + "'>" + value.first_name + " " + value.last_name + "</option>";
            });

            var date_box = "<input type='text' value='" + date + "' class='datepicker_for_all compulsory form-control' data-date-format='dd-mm-yyyy' data-date-viewmode='years'>";
            var remarks_box = "<textarea class='remarks_for_assign form-control'></textarea>";
            var button = "<button class='btn btn-primary assign_tech_submit'>Submit</button>"
            var row = "<tr><td><label><b>Technician</b></label></td><td><select class='form-control compulsory select_tech_for_assign'>" + technician_dropdown + "</select></td></tr>\
                    <tr><td><label><b>Preferred Date</b></label></td><td>" + date_box + "</td></tr>\
                    <tr><td><label><b>Add remarks</b></label></td><td>" + remarks_box + "</td></tr>";

            $("#assign_tech_table").html(row);
            $("#assign_tech_table_footer").html(button);
            $.facebox({ div: "#assign_techncican_modal" });
            $("#facebox .datepicker_for_all").datepicker({autoclose: true});

            $("#facebox .assign_tech_submit").on("click", function () {

                var input_length = $("#facebox .compulsory").length;

                var c = 0;
                for (var i = 0; i < input_length; i++) {
                    if ($("#facebox .compulsory").eq(i).val() == "" || $("#facebox .compulsory").eq(i).val() == -1) {
                        $("#facebox .compulsory").eq(i).parent().removeClass("has-success").addClass("has-error");
                        c++;
                    } else {
                        $("#facebox .compulsory").eq(i).parent().removeClass("has-error");

                    }
                }
                if (c > 0) {
                    $("#facebox #error").show().html("Please fill the required fields").removeClass().addClass("alert alert-danger center");
                } else {
                    $("#facebox #error").hide();
                    var assign_t_id = $("#facebox .select_tech_for_assign").val();
                    var assign_date = $("#facebox .datepicker_for_all").val();
                    var assign_remarks = $("#facebox .remarks_for_assign").val();
                    var qry = "tech_id=" + assign_t_id + "&assign_date=" + assign_date + "&assign_remarks=" + assign_remarks + "&type=" + type + "&assign_of=" + id + "&cust_id=" + customer_id;

                    $("#facebox #result").show().html("Please wait...<i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");

                    $.ajax({
                        type: 'post',
                        url: 'api/Assign',
                        data: qry,
                        dataType: 'json',
                        success: function (data) {
                            if (data.status == "ok") {
                                $(".i_row_num_c_" + serial).remove();
                                if ($(".install_assign tr").length == 0) {
                                    $(".install_assign").html("<tr><td colspan='6' class='alert alert-info center'><i class='clip-info'></i> No intsallation assigned</td></tr>")
                                }
                                $("#facebox #result").show().html("Successfully Assigned").removeClass().addClass("alert alert-success center");
                                $("#Ins_count").html(parseInt($("#Ins_count").text()) - 1);
                                setTimeout(function () {
                                    jQuery(document).trigger('close.facebox');
                                }, 1000);
                            }
                            else if (data.status == "no") {
                                console.log("error")
                                $("#facebox #result").show().html(data.result).removeClass().addClass("alert alert-danger center");
                            }
                            setTimeout(function () {
                                $("#facebox #result").slideUp();
                            }, 1000);
                        }
                    });
                }
            });

            break;

        case 'ins_service':

            var technician_dropdown = "<option value='-1'>-SELECT TECHNICIAN-</option>";
            $.each(technicians, function (key, value) {
                technician_dropdown += "<option value='" + value.tech_id + "'>" + value.first_name + " " + value.last_name + "</option>";
            });

            var date_box = "<input type='text' value='" + date + "' class='datepicker_for_all compulsory form-control' data-date-format='dd-mm-yyyy' data-date-viewmode='years'>";
            var remarks_box = "<textarea class='remarks_for_assign form-control'></textarea>";
            var button = "<button class='btn btn-primary assign_tech_submit'>Submit</button>"
            var row = "<tr><td><label><b>Technician</b></label></td><td><select class='form-control compulsory select_tech_for_assign'>" + technician_dropdown + "</select></td></tr>\
                    <tr><td><label><b>Preferred Date</b></label></td><td>" + date_box + "</td></tr>\
                    <tr><td><label><b>Add remarks</b></label></td><td>" + remarks_box + "</td></tr>";

            $("#assign_tech_table").html(row);
            $("#assign_tech_table_footer").html(button);
            $.facebox({ div: "#assign_techncican_modal" });
            $("#facebox .datepicker_for_all").datepicker({autoclose: true});

            $("#facebox .assign_tech_submit").on("click", function () {

                var input_length = $("#facebox .compulsory").length;

                var c = 0;
                for (var i = 0; i < input_length; i++) {
                    if ($("#facebox .compulsory").eq(i).val() == "" || $("#facebox .compulsory").eq(i).val() == -1) {
                        $("#facebox .compulsory").eq(i).parent().removeClass("has-success").addClass("has-error");
                        c++;
                    } else {
                        $("#facebox .compulsory").eq(i).parent().removeClass("has-error");

                    }
                }
                if (c > 0) {
                    $("#facebox #error").show().html("Please fill the required fields").removeClass().addClass("alert alert-danger center");
                } else {
                    $("#facebox #error").hide();
                    var assign_t_id = $("#facebox .select_tech_for_assign").val();
                    var assign_date = $("#facebox .datepicker_for_all").val();
                    var assign_remarks = $("#facebox .remarks_for_assign").val();
                    var qry = "tech_id=" + assign_t_id + "&assign_date=" + assign_date + "&assign_remarks=" + assign_remarks + "&type=" + type + "&assign_of=" + id + "&cust_id=" + customer_id;

                    $("#facebox #result").show().html("Please wait...<i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");

                    $.ajax({
                        type: 'post',
                        url: 'api/Assign',
                        data: qry,
                        dataType: 'json',
                        success: function (data) {
                            if (data.status == "ok") {
                                $(".i_row_num_c_" + serial).remove();
                                if ($(".install_assign tr").length == 0) {
                                    $(".install_assign").html("<tr><td colspan='6' class='alert alert-info center'><i class='clip-info'></i> No intsallation assigned</td></tr>")
                                }
                                $("#facebox #result").show().html("Successfully Assigned").removeClass().addClass("alert alert-success center");
                                $("#Ins_count").html(parseInt($("#Ins_count").text()) - 1);
                                setTimeout(function () {
                                    jQuery(document).trigger('close.facebox');
                                }, 1000);
                            }
                            else if (data.status == "no") {
                                console.log("error")
                                $("#facebox #result").show().html(data.result).removeClass().addClass("alert alert-danger center");
                            }
                            setTimeout(function () {
                                $("#facebox #result").slideUp();
                            }, 1000);
                        }
                    });
                }
            });

            break;

        case 'complaint':

            var technician_dropdown = "<option value='-1'>-SELECT TECH-</option>";
            $.each(technicians, function (key, value) {
                technician_dropdown += "<option value='" + value.tech_id + "'>" + value.first_name + " " + value.last_name + "</option>";
            });

            var date_box = "<input type='text' value='" + date + "' class='datepicker_for_all form-control compulsory' data-date-format='dd-mm-yyyy' data-date-viewmode='years'>";
            var remarks_box = "<textarea class='form-control remarks_for_assign'></textarea>";
            var button = "<button class='btn btn-primary assign_tech_submit'>Submit</button>"
            var row = "<tr><td><label><b>Technician</b></label></td><td><select class='compulsory form-control select_tech_for_assign'>" + technician_dropdown + "</select></td></tr>\
                    <tr><td><label><b>Preferred Date</b></label></td><td>" + date_box + "</td></tr>\
                    <tr><td><label><b>Add remarks</b></label></td><td>" + remarks_box + "</td></tr>";

            $("#assign_tech_table").html(row);
            $("#assign_tech_table_footer").html(button);
            $.facebox({ div: "#assign_techncican_modal" });
            $("#facebox .datepicker_for_all").datepicker({autoclose: true});

            $("#facebox .assign_tech_submit").on("click", function () {

                var input_length = $("#facebox .compulsory").length;

                var c = 0;
                for (var i = 0; i < input_length; i++) {
                    if ($("#facebox .compulsory").eq(i).val() == "" || $("#facebox .compulsory").eq(i).val() == -1) {
                        $("#facebox .compulsory").eq(i).parent().removeClass("has-success").addClass("has-error");
                        c++;
                    } else {
                        $("#facebox .compulsory").eq(i).parent().removeClass("has-error");

                    }
                }
                if (c > 0) {
                    $("#facebox #error").show().html("Please fill the required fields").removeClass().addClass("alert alert-danger center");
                } else {
                    $("#facebox #error").hide();
                    var assign_t_id = $("#facebox .select_tech_for_assign").val();
                    var assign_date = $("#facebox .datepicker_for_all").val();
                    var assign_remarks = $("#facebox .remarks_for_assign").val();
                    var qry = "tech_id=" + assign_t_id + "&assign_date=" + assign_date + "&assign_remarks=" + assign_remarks + "&type=" + type + "&assign_of=" + id + "&cust_id=" + customer_id;

                    $("#facebox #result").show().html("Please wait...<i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");

                    $.ajax({
                        type: 'post',
                        url: 'api/Assign',
                        data: qry,
                        dataType: 'json',
                        success: function (data) {
                            if (data.status == "ok") {
                                $(".c_row_num_c_" + serial).remove();
                                console.log(".c_row_num_c_" + serial);
                                if ($(".complaint_assign tr").length == 0) {
                                    $(".complaint_assign").html("<tr><td colspan='6' class='alert alert-info center'><i class='clip-info'></i> No Complaints assigned</td></tr>")
                                }
                                $("#facebox #result").show().html("Successfully Assigned").removeClass().addClass("alert alert-success center");
                                $("#Com_count").html(parseInt($("#Com_count").text()) - 1);
                                setTimeout(function () {
                                    jQuery(document).trigger('close.facebox');
                                }, 1000);
                            } else if (data.status == "no") {
                                $("#facebox #result").show().html(data.result).removeClass().addClass("alert alert-danger center");
                            }
                            setTimeout(function () {
                                $("#facebox #result").slideUp();
                            }, 1000);
                        }
                    });
                }
            })

            break;

        case 'amc':

            var technician_dropdown = "<option value='-1'>-SELECT TECH-</option>";
            $.each(technicians, function (key, value) {
                technician_dropdown += "<option value='" + value.tech_id + "'>" + value.first_name + " " + value.last_name + "</option>";
            });

            var date_box = "<input type='text' value='" + date + "' class='datepicker_for_all form-control compulsory' data-date-format='dd-mm-yyyy' data-date-viewmode='years'>";
            var remarks_box = "<textarea class='form-control remarks_for_assign'></textarea>";
            var button = "<button class='btn btn-primary assign_tech_submit'>Submit</button>"
            var row = "<tr><td><label><b>Technician</b></label></td><td><select class='form-control select_tech_for_assign compulsory'>" + technician_dropdown + "</select></td></tr>\
                   <tr><td><label><b>Preferred Date</b></label></td><td>" + date_box + "</td></tr>\
                   <tr><td><label><b>Add remarks</b></label></td><td>" + remarks_box + "</td></tr>";

            $("#assign_tech_table").html(row);
            $("#assign_tech_table_footer").html(button);
            $.facebox({ div: "#assign_techncican_modal" });
            $("#facebox .datepicker_for_all").datepicker({autoclose: true});

            $("#facebox .assign_tech_submit").on("click", function () {
                var input_length = $("#facebox .compulsory").length;

                var c = 0;
                for (var i = 0; i < input_length; i++) {
                    if ($("#facebox .compulsory").eq(i).val() == "" || $("#facebox .compulsory").eq(i).val() == -1) {
                        $("#facebox .compulsory").eq(i).parent().removeClass("has-success").addClass("has-error");
                        c++;
                    } else {
                        $("#facebox .compulsory").eq(i).parent().removeClass("has-error");

                    }
                }
                if (c > 0) {
                    $("#facebox #error").show().html("Please fill the required fields").removeClass().addClass("alert alert-danger center");
                } else {
                    $("#facebox #error").hide();

                    var assign_t_id = $("#facebox .select_tech_for_assign").val();
                    var assign_date = $("#facebox .datepicker_for_all").val();
                    var assign_remarks = $("#facebox .remarks_for_assign").val();
                    var qry = "tech_id=" + assign_t_id + "&assign_date=" + assign_date + "&assign_remarks=" + assign_remarks + "&type=" + type + "&assign_of=" + id + "&cust_id=" + customer_id;
                    console.log(qry);
                    $("#facebox #result").show().html("Please wait...<i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");
                    $.ajax({
                        type: 'post',
                        url: 'api/Assign',
                        data: qry,
                        dataType: 'json',
                        success: function (data) {
                            if (data.status == "ok") {
                                $(".a_row_num_c_" + serial).remove();
                                console.log(".a_row_num_c_" + serial);
                                if ($(".amc_assign tr").length == 0) {
                                    $(".amc_assign").html("<tr><td colspan='6' class='alert alert-info center'><i class='clip-info'></i> No Complaints assigned</td></tr>")
                                }
                                $("#facebox #result").show().html("Successfully Assigned").removeClass().addClass("alert alert-success center");

                                $("#AMC_count").html(parseInt($("#AMC_count").text()) - 1);
                                setTimeout(function () {
                                    jQuery(document).trigger('close.facebox');
                                }, 1000);
                            } else if (data.status == "no") {
                                $("#facebox #result").show().html(data.result).removeClass().addClass("alert alert-danger center");
                            }
                            setTimeout(function () {
                                $("#facebox #result").slideUp();
                            }, 1000);
                        }
                    });
                }
            });

            break;

        case 'ots':

            var technician_dropdown = "<option value='-1'>-SELECT TECH-</option>";
            $.each(technicians, function (key, value) {
                technician_dropdown += "<option value='" + value.tech_id + "'>" + value.first_name + " " + value.last_name + "</option>";
            });

            var date_box = "<input type='text' value='" + date + "' class='datepicker_for_all form-control compulsory' data-date-format='dd-mm-yyyy' data-date-viewmode='years'>";
            var remarks_box = "<textarea class='form-control remarks_for_assign'></textarea>";
            var button = "<button value='submit' class='btn btn-primary assign_tech_submit'>Submit</button>"
            var row = "<tr><td><label><b>Technician</b></label></td><td><select class='compulsory form-control select_tech_for_assign'>" + technician_dropdown + "</select></td></tr>\
                    <tr><td><label><b>Preferred Date</b></label></td><td>" + date_box + "</td></tr>\
                    <tr><td><label><b>Add remarks</b></label></td><td>" + remarks_box + "</td></tr>";

            $("#assign_tech_table").html(row);
            $("#assign_tech_table_footer").html(button);
            $.facebox({ div: "#assign_techncican_modal" });
            $("#facebox .datepicker_for_all").datepicker({autoclose: true});

            $("#facebox .assign_tech_submit").on("click", function () {

                var input_length = $("#facebox .compulsory").length;

                var c = 0;
                for (var i = 0; i < input_length; i++) {
                    if ($("#facebox .compulsory").eq(i).val() == "" || $("#facebox .compulsory").eq(i).val() == -1) {
                        $("#facebox .compulsory").eq(i).parent().removeClass("has-success").addClass("has-error");
                        c++;
                    } else {
                        $("#facebox .compulsory").eq(i).parent().removeClass("has-error");

                    }
                }
                if (c > 0) {
                    $("#facebox #error").show().html("Please fill the required fields").removeClass().addClass("alert alert-danger center");
                } else {
                    $("#facebox #error").hide();
                    var assign_t_id = $("#facebox .select_tech_for_assign").val();
                    var assign_date = $("#facebox .datepicker_for_all").val();
                    var assign_remarks = $("#facebox .remarks_for_assign").val();
                    var qry = "tech_id=" + assign_t_id + "&assign_date=" + assign_date + "&assign_remarks=" + assign_remarks + "&type=" + type + "&assign_of=" + id + "&cust_id=" + customer_id;

                    $("#facebox #result").show().html("Please wait...<i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");

                    $.ajax({
                        type: 'post',
                        url: 'api/Assign',
                        data: qry,
                        dataType: 'json',
                        success: function (data) {
                            if (data.status == "ok") {
                                console.log("success")
                                $(".o_row_num_c_" + serial).remove();
                                console.log(".o_row_num_c_" + serial);
                                if ($(".ots_assign tr").length == 0) {
                                    $(".ots_assign").html("<tr><td colspan='6' class='alert alert-info center'><i class='clip-info'></i> No OTS assigned</td></tr>")
                                }
                                $("#facebox #result").show().html("Successfully Assigned").removeClass().addClass("alert alert-success center");
                                $("#OTS_count").html(parseInt($("#OTS_count").text()) - 1);
                                setTimeout(function () {
                                    jQuery(document).trigger('close.facebox');
                                }, 1000);
                            } else if (data.status == "no") {
                                console.log("error")
                                $("#facebox #result").show().html(data.result).removeClass().addClass("alert alert-danger center");
                            }
                            setTimeout(function () {
                                $("#facebox #result").slideUp();
                            }, 1000);
                        }
                    });
                }
            })

            break;
    }
}

function createTextbox(wet, dry) {

    var technician_dropdown = "<option value='-1'>-SELECT TECH-</option>";
    $.each(technicians, function (key, value) {
        technician_dropdown += "<option value='" + value.tech_id + "'>" + value.first_name + " " + value.last_name + "</option>";
    });


    var tmp_dry = "";
    for (var i = 0; i < dry; i++) {
        tmp_dry += "<tr><td><input type='text' class='amc_assign_required form-control datepicker'></td><td><select class='amc_assign_required form-control'>" + technician_dropdown + "</select></td><td><textarea class='form-control amc_assign_required'></textarea></td></tr>";
    }

    var tmp_wet = "";
    for (var i = 0; i < wet; i++) {
        tmp_wet += "<tr><td><input type='text' class='form-control amc_assign_required datepicker'></td><td><select class='form-control amc_assign_required'>" + technician_dropdown + "</select></td><td><textarea class='form-control amc_assign_required'></textarea></td></tr>";
    }

    var button = "<tr><td><button class='btn btn-primary amc_assign_btn'>Submit</button></td></tr>"

    $("#assign_tech_table_dry").html(tmp_dry);
    $("#assign_tech_table_wet").html(tmp_wet);
    $("#assign_tech_table_wet tr:last").after(button);
    $.facebox({ div: "#assign_techncican_modal_amc" });
    $('#facebox .datepicker').each(function () {
        autoclose: true
        $(this).datepicker();
    });

    $("#facebox .amc_assign_btn").on("click", function () {
        console.log("click");
        var c = 0;
        var input_length = $("#facebox .amc_assign_required").length;
        console.log(input_length);
        for (var i = 0; i < input_length; i++) {
            if ($("#facebox .amc_assign_required").eq(i).val() == "" || $("#facebox .amc_assign_required").eq(i).val() == -1) {
                $("#facebox .amc_assign_required").eq(i).parent().removeClass("has-success").addClass("has-error");
                c++;
            } else {
                $("#facebox .amc_assign_required").eq(i).parent().removeClass("has-error");
            }
        }
    })


}

function view_ac_info(elem) {
    $.facebox($(elem).html());
}