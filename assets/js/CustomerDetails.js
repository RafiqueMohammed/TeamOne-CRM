var ac_data = {}, cust_data = {};
ac_data.problem_type = {};
ac_data.ac_info = {};
var customer_id;
var ac_data_count = 0;
var technician_dropdown;

$(document).ready(function () {

    customer_id = $("#customer_id_holder").val();

    $('#dob').datepicker({
        autoclose: true
    });


    if (customer_id == -1) {

        $(".container .row").eq(1).html("<div class='alert alert-danger center'>Missing Required Parameter. Customer ID is not defined.</div>");
    } else {


        blockThisUI($(".profile"));

        $.ajax({
            type: 'GET',
            url: 'api/Customer/' + customer_id,
            dataType: 'json',
            success: function (data) {
                cust_data = data;
                if (data.status == 'ok') {
                    $(".firstname").val(data.first_name);
                    $(".lastname").val(data.last_name);
                    $(".username").html(data.first_name + " " + data.last_name);
                    $(".mobile1").val(data.mobile);
                    $(".mobile1").html(data.mobile);
                    $(".mobile2").val(data.alternate_mobile);
                    $(".mobile2").html(data.alternate_mobile);
                    $(".email").val(data.email);
                    $(".email").html(data.email);
                    $(".landline").val(data.phone);
                    $(".landline").html(data.phone);
                    $(".address").val(data.address);
                    $(".address").html(data.address);
                    $(".alternate_contacts").val(data.alternate_contact);
                    $(".alternate_contacts").html(data.alternate_contact);
                    $(".pincode").val(data.pincode);
                    $(".pincode").html(data.pincode);
                    $(".city").val(data.city);
                    $(".city").html(data.city);
                    var land_opt = "";
                    $.each(data.landmark_info, function (key, val) {

                        if (val == data.landmark) {
                            land_opt += "<option value='" + val + "' selected='selected'>" + val + "</option>";
                        } else {
                            land_opt += "<option value='" + val + "'>" + val + "</option>";
                        }

                    });
                    $("#landmark").html(land_opt);
                    $(".landmark_info").html(data.landmark);


                    var ac_drop_opt = "";

                    ac_data.ac_info = data.ac_data; //Total Customer's AC details for later use

                    if (data.ac_data.status == "ok") {
                        delete data.ac_data.status;
                        $.each(data.ac_data, function (key, type) {
                            
                            ac_drop_opt += "<tr class='num_ac_rows num_ac_rows_" + ac_data_count + "'><td>" + type.ac_type + "</td>\
                            <td>" + type.make + "</td><td>" + type.tonnage + "</td>" +
                                "<td><b>Model No. : </b>" + type.odu_model_no + " <br/ > <b>Serial No. : </b>" + type.odu_serial_no + "</td><td><b>Model No. : </b>" + type.idu_model_no + " <br/ > <b>Serial No. : </b>" + type.idu_serial_no + "</td>\
                                <td>" + type.location + "</td>" + "<td><button class='btn btn-primary btn-sm' onclick='display_remarks(\""+type.remarks+"\")'><i class='clip-info'></i></button></td>\
                                <td><i style='cursor:pointer;color:red' onclick='delete_customer_ac(" + type.ac_id + "," + ac_data_count + ")' class='clip-minus-circle-2'></i></td></tr>";

                            ac_data_count++; //Total number of AC for later use

                        });

                    } else if (data.ac_data.status == "no") {
                        ac_drop_opt = "<tr class='empty_row'><td class='alert alert-info center' colspan='8'> <i class='clip-info'></i> " + data.ac_data.result + "</td></tr>";
                    }

                    $(".customer_product_view").append(ac_drop_opt);

                    $(".location").val(data.location);
                    $(".location").html(data.location);
                    $(".communication option[value='" + data.mode_of_contact + "']").attr("selected", "selected");
                    if (data.communication == "m") {
                        $(".communication_m").html("Mobile");
                    } else if (data.communication == "e") {
                        $(".communication_m").html("Email");
                    } else {
                        $(".communication_m").html("Mobile & Email");
                    }
                    $(".referred_by").html(data.reference);
                    $(".referred_by").val(data.reference);
                    $("input[name='dob']").val(data.dob);
                    $(".dob").html(data.dob);
                    $(".created_on").html(data.date)
                    $(".remarks").val(data.remarks);
                    $(".remarks").html(data.remarks);
                    if (data.account_type == "r") {
                        $(".org_type").val("Residential");
                        $(".org_type").html("Residential");
                        $("#CustomerDetailsTab").removeClass("tab-bricky").addClass("tab-blue");

                    } else {
                        $(".org_type").val("Commercial");
                        $(".org_type").html("Commercial");
                        $("#CustomerDetailsTab").removeClass("tab-blue").addClass("tab-bricky");
                    }
                    $(".org_name").val(data.organisation);
                    $(".org_name").html(data.organisation);

                    $.getJSON("api/Manage/Complaints/ProblemType", function (type) {
                        ac_data.problem_type = type;
                    });

                } else if (data.status == "no") {
                    $(".container .row").eq(1).html("<div class='alert alert-danger center'>" + data.result + "</div>");
                }
                unblockThisUI($(".profile"));
            }
        });

    }

    $("#update_customer_details").click(function () {
        var mThis = $(this);
        var input_length = $(".up_req").length;

        var c = 0;
        for (var i = 0; i < input_length; i++) {
            if ($('.up_req').eq(i).val() == "") {
                $('.up_req').eq(i).parent().removeClass("has-success").addClass("has-error");
                c++;
            } else {
                $('.up_req').eq(i).parent().removeClass("has-error");

            }
        }

        if ($('input[name=mobile1]').val().length != 10) {
            $('input[name=mobile1]').parent().removeClass("has-success").addClass("has-error");
            $('input[name=mobile1]').parent().parent().find(".error_span").addClass("text-danger").html("Invalid Mobile Number");
            c++;
        } else {
            $('input[name=mobile1]').parent().removeClass("has-error");
            $('input[name=mobile1]').parent().parent().find(".error_span").empty();

        }

        if (c > 0) {
            console.log(c);
            $("#error").html("Please fill the required fields").removeClass().addClass("alert alert-danger center");
        } else {
            $("#error").hide();
            /** UPDATE INFO **/
            var fname = $("#firstname").val();
            var lname = $("#lastname").val();
            var email = $("#email").val();
            var address = $("#address").val();
            var pincode = $("#pincode").val();
            var landmark = $("#landmark").val();
            var communication = $("#communication").val();
            var dob = $("#dob").val();
            var landline = $("#landline").val();
            var alt_contacts = $("#alternate_contacts").val();
            var city = $("#city").val();
            var location = $("#location").val();
            var remarks = $("#remarks").val();
            var mobile1 = $("#mobile1").val();
            var mobile2 = $("#mobile2").val();
            var org = $("#org_name").val();
            var update_customer = "update_customer";

            var query = "fname=" + fname + "&lname=" + lname + "&email=" + email + "&address=" + address + "&pincode=" + pincode + "&landmark=" + landmark +
                "&communication=" + communication + "&dob=" + dob + "&landline=" + landline + "&alt_contacts=" + alt_contacts + "&city=" + city +
                "&location=" + location + "&remarks=" + remarks + "&mobile1=" + mobile1 + "&mobile2=" + mobile2 + "&org=" + org +
                "&update_customer=" + update_customer;
            var tmp_load_holder = mThis.html();
            mThis.html("<i class='clip-busy'></i> Saving...");
            $.ajax({
                type: 'put',
                url: 'api/Customer/' + customer_id,
                data: query,
                dataType: 'json',
                success: function (data) {
                    if (data.status == "ok") {
                        $("#update_customer_details_output").show().html("" + data.result).removeClass().addClass("alert alert-success center");
                        
                    } else if (data.status == "no") {
                        $("#update_customer_details_output").show().html("" + data.result).removeClass().addClass("alert alert-info center");
                    }
                    setTimeout(function(){
                        $("#update_customer_details_output").slideUp();
                    },1000);
                    mThis.html(tmp_load_holder);
                }
            });

        }
    });

    $.ajax({
        type: 'get',
        url: 'api/Manage/Customer/Reference',
        dataType: 'json',
        success: function (data) {
            if (data.status == "ok") {
                delete data.status;
                var opt = "";
                $.each(data, function (key, value) {
                    opt += "<option value=" + value.name + ">" + value.name + "</option>";
                });
                $('#referred_by').html(opt);
            } else if (data.status == "no") {

            }
        }
    });


    $("#pincode").keyup(function (e) {
        /* var code = e.keyCode;
         console.log("Key code "+code);*/
        var pincode = $('#pincode').val();
        if (pincode.length > 3) {
            $.post("controller/GetPincode.php", {type: "pincode", pincode: pincode}, function (data) {
                $("#pincode_display").html(data).show();
            });
        }
    });


    /** ****** INSTALLATION *********/
    $("#add_installation").on('click', function () {
        var modal_box = $("#installation_modal_box");
        var title = modal_box.find(".modal-title");
        var modal_body = modal_box.find(".modal-body");
        var ac_dropdown = "<option value='-1'> -- Select AC -- </option>";


        if (ac_data.ac_info != null) {
            if (ac_data_count > 0) {
                console.log(ac_data.ac_info);
                $.each(ac_data.ac_info, function (key, val) {
                    ac_dropdown += "<option value='" + key + "'> " + val.make + " (" + val.location + ")  </option>";
                });

            } else {
                ac_dropdown = "<option value='-1'> - No AC Added Yet - </option>";
            }
            modal_body.find(".select_ac").html(ac_dropdown);
        } else {
            modal_body = "<div class='alert alert-danger'>AC Data is corrupt or not retrieved. Please refresh the page</div>";
        }
        $.facebox({ div: "#installation_modal_box" });
        $(".date-picker").datepicker({autoclose: true});


        $("#facebox .content .select_ac").on('change', function () {
            var val = $(this).val();
            var elem = $(this).parent().parent();
            if (val == -1) {
                elem.find(".select_ac_id").val("-1");
                elem.find('.display_ac_info_type').html("--N/A--");
                elem.find('.display_ac_info_make').html("--N/A--");
                elem.find('.display_ac_info_place').html("--N/A--");
                elem.find('.display_ac_info_tonnage').html("--N/A--");
                elem.find('.display_ac_info_idu_sr').html("--N/A--");
                elem.find('.display_ac_info_odu_sr').html("--N/A--");
            } else {
                elem.find(".select_ac_id").val(ac_data.ac_info[val].ac_id);
                elem.find('.display_ac_info .display_ac_info_type').html(ac_data.ac_info[val].ac_type);
                elem.find('.display_ac_info .display_ac_info_make').html(ac_data.ac_info[val].make);
                elem.find('.display_ac_info .display_ac_info_place').html(ac_data.ac_info[val].location);
                elem.find('.display_ac_info .display_ac_info_tonnage').html(ac_data.ac_info[val].tonnage);
                elem.find('.display_ac_info .display_ac_info_idu_sr').html(ac_data.ac_info[val].idu_serial_no);
                elem.find('.display_ac_info .display_ac_info_odu_sr').html(ac_data.ac_info[val].odu_serial_no);
            }

        });
        $("#facebox .create_btn").on('click', function () {
            var elem = $(this).parent().siblings();
            var selected_ac = elem.find(".select_ac_id").val();
            var ins_type = elem.find(".installation_type").val();
            var no_of_service = elem.find(".no_of_service").val();
            var ins_date = elem.find(".installation_date").val();
            var remarks = elem.find(".add_remarks").val();
            var output = elem.find(".display_output");
            if (selected_ac != -1) {
                if (ins_type != -1 && no_of_service != "" && no_of_service > 0 && ins_date != "") {
                    output.html("Please wait...<i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");
                    $.ajax({url: "api/Customer/" + customer_id + "/Installations",
                        type: "POST",
                        dataType: "JSON",
                        data: {ac_id: selected_ac, ins_type: ins_type, no_of_service: no_of_service, ins_date: ins_date, remarks: remarks},
                        success: function (response) {
                            if (response.status == "ok") {
                                output.html("Successfully Added").removeClass().addClass("alert alert-success center");
                                setTimeout(function(){
                                    jQuery(document).trigger('close.facebox');
                                },1000);
                            } else if (response.status == "no") {
                                output.html(response.result + "").removeClass().addClass("alert alert-danger center");
                            } else {
                                output.html("No Response from the server").removeClass().addClass("alert alert-danger center");
                            }
                        }});
                } else {
                    output.html("Required field missing").removeClass().addClass("alert alert-danger center");
                }

            } else {
                output.html("Select AC for the installation").removeClass().addClass("alert alert-danger center");
                console.log("Required");
            }

        });
    });


    /******** COMPLAINTS ************/

    $("#add_complaints").on('click', function () {

        var modal_box = $("#complaints_modal_box");
        var title = modal_box.find(".modal-title");
        var modal_body = modal_box.find(".modal-body");

        var ac_dropdown = "<option value='-1'> -- Select AC -- </option>";

        if (ac_data.problem_type != null) {
            var problem_dropdown = "<option value='-1'> -- Select Problem -- </option>";
            $.each(ac_data.problem_type.data, function (key, val) {
                problem_dropdown += "<option value='" + val.ac_problem_id + "'> " + val.ac_problem_type + " </option>";

            });
            modal_body.find(".select_problem").html(problem_dropdown);
        }

        if (ac_data.ac_info != null) {
            if (ac_data_count > 0) {
                $.each(ac_data.ac_info, function (key, val) {
                    ac_dropdown += "<option value='" + key + "'> " + val.make + " (" + val.location + ")  </option>";
                });
            } else {
                ac_dropdown = "<option value='-1'> - No AC Added Yet - </option>";
            }

            modal_body.find(".select_ac").html(ac_dropdown);
        } else {
            modal_body = "<div class='alert alert-danger'>AC Data is corrupt or not retrieved. Please refresh the page</div>";
        }


        modal_box.modal("show");
        $(".preffered_date").datepicker({autoclose: true});
    });
    $("#complaints_modal_box .create_btn").on('click', function () {
        var elem = $(this).parent().parent();
        var ac_id = elem.find(".select_ac_id").val();
        var problem_type = elem.find(".select_problem").val();
        var p_date = elem.find(".preffered_date").val();
        var problem_desc = elem.find(".problem_desc").val();
        var output = elem.find(".display_output");

        if (ac_id != -1 && problem_type != -1) {
            output.html("<div class='alert alert-info center'>Adding.. Please Wait..</div>");
            $.ajax({url: "api/Customer/" + customer_id + "/Complaints",
                type: "POST",
                dataType: "JSON",
                data: {ac_id: ac_id, problem_type: problem_type, p_date: p_date, problem_desc: problem_desc},
                success: function (response) {
                    if (response.status == "ok") {
                        output.html("<div class='alert alert-success center'>Successfully Added</div>");
                    } else if (response.status == "no") {
                        output.html("<div class='alert alert-danger center'>" + response.result + "</div>");
                    } else {
                        output.html("<div class='alert alert-danger center'>No Response from the server</div>");
                    }
                }});
        } else {
            output.html("<div class='alert alert-danger'>Required Field Missing</div>");
        }

    });

    $(".select_ac").on('change', function () {
        var val = $(this).val();
        var elem = $(this).parent();
        if (val == -1) {
            elem.find(".select_ac_id").val("-1");
            elem.find('.display_ac_info_type').html("--N/A--");
            elem.find('.display_ac_info_make').html("--N/A--");
            elem.find('.display_ac_info_place').html("--N/A--");
            elem.find('.display_ac_info_tonnage').html("--N/A--");
            elem.find('.display_ac_info_idu_sr').html("--N/A--");
            elem.find('.display_ac_info_odu_sr').html("--N/A--");
        } else {
            elem.find(".select_ac_id").val(ac_data.ac_info[val].ac_id);
            elem.find('.display_ac_info_type').html(ac_data.ac_info[val].ac_type);
            elem.find('.display_ac_info_make').html(ac_data.ac_info[val].make);
            elem.find('.display_ac_info_place').html(ac_data.ac_info[val].location);
            elem.find('.display_ac_info_tonnage').html(ac_data.ac_info[val].tonnage);
            elem.find('.display_ac_info_idu_sr').html(ac_data.ac_info[val].idu_serial_no);
            elem.find('.display_ac_info_odu_sr').html(ac_data.ac_info[val].odu_serial_no);
        }
    });

    /** ****** AMC CONTRACTS *********/

    /** AMC **/

    $("#add_amc").on('click', function () {

        var modal_box = "#amc_modal_box";
        $.facebox({div: modal_box});
        var amc_ac_dropdown = "<option value='-1'> -- Select AC -- </option>";
        if (ac_data.ac_info != null) {
            if(ac_data_count > 0){
            $.each(ac_data.ac_info, function (key, val) {
                amc_ac_dropdown += "<option value='" + key + "'> " + val.make + " (" + val.location + ")  </option>";
            });
            i = $("#facebox .table_body tr").length;
            //i=i+1;
            var del = "<td style='color: brown'><i onclick='remove_amc_row(" + i + ");' class='clip-minus-circle-2'></i></td>";

            var row = "<tr class='aaa row_" + i + "'><td ><select onchange='amc_ac_change(\"row_" + i + "\")' class='form-control mandotory amc_select_ac'>" + amc_ac_dropdown + "</select>\
            <input type='hidden' class='amc_selected_ac' value='-1' /><input type='hidden' class='Customer_id' value='" + customer_id + "' ></td>\
            <td > <table class='table table-bordered'><tr>\
                <td> AC Type : <span class='ac_type'>-N/A-</span> </td>\
                <td> Tonnage / HP :<span class='capacity'>-N/A-</span> </td>\
                </tr><tr><td> <span class='idu_no'>-N/A-</span> </td>\
                <td> <span class='odu_no'>-N/A-</span></td>\
                </tr></table></td>\
            <td > <select class='form-control mandotory amc_service_type'><option value='-1'> -- Select Type -- </option><option value='s'>Semi-Comprehensive</option><option value='c'>Comprehensive</option><option value='n'>Non-Comprehensive</option></select>\
            </td>\
            <td><input type='text' class='form-control amc_datepicker mandotory' data-date-format='dd-mm-yyyy' data-date-viewmode='years'></td>\
            <td class='center'><input type='number' class='form-control amc_dry mandotory' placeholder='Dry' size='1'> <br>\
            <input type='number' class='form-control amc_wet mandotory' placeholder='Wet' size='1'></td>" + del + "\
            </tr>";

            $("#facebox .table_body").html(row);

            $('#facebox .amc_datepicker').each(function () {
                autoclose: true
                $(this).datepicker();
            });                
            }else{
                amc_ac_dropdown += "<option value='-1'> - No AC Added Yet - </option>";
            var row = "<tr class='aaa row_" + i + "'><td ><select onchange='amc_ac_change(\"row_" + i + "\")' class='form-control mandotory amc_select_ac'>" + amc_ac_dropdown + "</select>\
            <input type='hidden' class='amc_selected_ac' value='-1' /><input type='hidden' class='Customer_id' value='" + customer_id + "' ></td>\
            <td > <table class='table table-bordered'><tr>\
                <td> AC Type : <span class='ac_type'>-N/A-</span> </td>\
                <td> Tonnage / HP :<span class='capacity'>-N/A-</span> </td>\
                </tr><tr><td> <span class='idu_no'>-N/A-</span> </td>\
                <td> <span class='odu_no'>-N/A-</span></td>\
                </tr></table></td>\
            <td > <select class='form-control mandotory amc_service_type'><option value='-1'> -- Select Type -- </option><option value='s'>Semi-Comprehensive</option><option value='c'>Comprehensive</option><option value='n'>Non-Comprehensive</option></select>\
            </td>\
            <td><input type='text' class='form-control amc_datepicker mandotory' data-date-format='dd-mm-yyyy' data-date-viewmode='years'></td>\
            <td class='center'><input type='number' class='form-control amc_dry mandotory' placeholder='Dry' size='1'> <br>\
            <input type='number' class='form-control amc_wet mandotory' placeholder='Wet' size='1'></td>" + del + "\
            </tr>";
            
            $("#facebox .table_body").html(row);
            }

        } else {
            $("#facebox .table_body").html("<tr><td colspan='4'><div class='alert alert-danger'>AC Data is corrupt or not retrieved. Please refresh the page</div></td></tr>");
        }

        /** ADD NEW ROW ***/
        var i = 1;
        $(".add_btn").on('click', function () {
            i = $("#facebox .table_body tr").length;
            i = i + 1;
            var del = "<td style='color: brown'><i onclick='remove_amc_row(" + i + ");' class='clip-minus-circle-2'></i></td>";

            var row = "<tr class='aaa row_" + i + "'><td><select onchange='amc_ac_change(\"row_" + i + "\")' class='form-control amc_select_ac mandotory'>" + amc_ac_dropdown + "</select>\
            <input type='hidden' class='amc_selected_ac' value='-1' /><input type='hidden' class='Customer_id' value='" + customer_id + "' ></td>\
             <td> <table class='table table-bordered'><tr>\
                <td> AC Type : <span class='ac_type'>-N/A-</span> </td>\
                <td> Tonnage / HP :<span class='capacity'>-N/A-</span> </td>\
                </tr><tr><td> <span class='idu_no'>-N/A-</span> </td>\
                <td> <span class='odu_no'>-N/A-</span></td>\
                </tr></table></td>\
            <td> <select class='form-control mandotory amc_service_type'><option value='-1'> -- Select Type -- </option><option value='s'>Semi-Comprehensive</option><option value='c'>Comprehensive</option><option value='n'>Non-Comprehensive</option></select>\
            </td>\
            <td><input type='text' class='form-control amc_datepicker mandotory' data-date-format='dd-mm-yyyy' data-date-viewmode='years'></td>\
            <td class='center '><input type='number' class='form-control amc_dry mandotory' placeholder='Dry' size='1'> <br>\
            <input type='number' class='form-control amc_wet mandotory' placeholder='Wet' size='1'></td>" + del + "\
            </tr>";

            $("#facebox .table_body").append(row);
            $('#facebox .amc_datepicker').each(function () {
                autoclose: true
                $(this).datepicker();
            });
        });

        /** CREATE AMC BUTTON ***/

        $("#facebox .create_btn").on('click', function () {

            var input_length = $("#facebox .mandotory").length;
            var err_msg = "";
            
            var c = 0;

            for (var i = 0; i < input_length; i++) {
                if ($('#facebox .mandotory').eq(i).val() == "" || $('#facebox .mandotory').eq(i).val() == "-1") {
                    $('#facebox .mandotory').eq(i).parent().removeClass("has-success").addClass("has-error");
                    c++;
                    err_msg = "Please fill the required fields";
                } else {
                    $('#facebox .mandotory').eq(i).parent().removeClass("has-error");

                }
            }
            if ($.isNumeric($("#facebox .amc_dry").val()) && $.isNumeric($("#facebox .amc_wet").val())) {

            } else {

                err_msg = "Only numbers are allowed for Wet & Dry";
                c++;

            }

            if (c > 0) {
                $("#facebox #error").show().html(err_msg).removeClass().addClass("alert alert-danger center")
            } else {
                $("#facebox #error").remove();
                var rows = $("#facebox .aaa").length;
                var data = "";

                for (var i = 0; i < rows; i++) {
                    console.log("AC :" + $("#facebox .table_body tr").eq(i).find(".amc_selected_ac").val());
                    data += "&row[" + i + "][cust_id]=" + $("#facebox .table_body tr").eq(i).find(".Customer_id").val();
                    data += "&row[" + i + "][ac_id]=" + $("#facebox .table_body tr").eq(i).find(".amc_selected_ac").val();
                    data += "&row[" + i + "][select_ac]=" + $("#facebox .table_body tr").eq(i).find(".amc_select_ac").val();
                    data += "&row[" + i + "][service_type]=" + $("#facebox .table_body tr").eq(i).find(".amc_service_type").val();
                    data += "&row[" + i + "][dry_service]=" + $("#facebox .table_body tr").eq(i).find(".amc_dry").val();
                    data += "&row[" + i + "][wet_service]=" + $("#facebox .table_body tr").eq(i).find(".amc_wet").val();
                    data += "&row[" + i + "][amc_datepicker]=" + $("#facebox .table_body tr").eq(i).find(".amc_datepicker").val();
                }
                console.log(data);
                $("#facebox #result").show().html("Please wait...<i class='clip-buzy'></i>").removeClass().addClass("alert alert-info center");
                $.ajax({
                    type: 'post',
                    data: data,
                    url: 'api/Customer/' + customer_id + '/AMC',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == "ok") {
                            console.log("success");
                            $("#facebox #result").show().html("Added Successfully").removeClass().addClass("alert alert-success center");
                            setTimeout(function(){
                                    jQuery(document).trigger('close.facebox');
                            },1000);
                        } else if (response.status == "no") {
                            console.log("error");
                            $("#facebox #result").show().html(data.result).removeClass().addClass("alert alert-danger center");
                        }
                    }
                });
            }
        });
    });


    /** END: AMC**/


    /** ****** ONE TIME SERVICE *********/

    $("#add_ots").on('click', function () {

        var modal_box = $("#ots_modal_box");
        var title = modal_box.find(".modal-title");
        var modal_body = modal_box.find(".modal-body");

        var ac_dropdown = "<option value='-1'> -- Select AC -- </option>";

        if (ac_data.ac_info != null) {
            if (ac_data_count > 0) {
                $.each(ac_data.ac_info, function (key, val) {
                    ac_dropdown += "<option value='" + key + "'> " + val.make + " (" + val.location + ")  </option>";
                });
            } else {
                ac_dropdown = "<option value='-1'> - No AC Added Yet - </option>";
            }
            modal_body.find(".select_ac").html(ac_dropdown);
        } else {
            modal_body = "<div class='alert alert-danger'>AC Data is corrupt or not retrieved. Please refresh the page</div>";
        }


        $.facebox({div: "#ots_modal_box"});
        
        $("#facebox .preffered_date").datepicker({autoclose: true});
        
        $("#facebox .content .select_ac").on('change', function () {

            var val = $(this).val();
            console.log(val);
            var elem = $(this).parent().parent();
            if (val == -1) {
                elem.find(".select_ac_id").val("-1");
                elem.find('.display_ac_info_type').html("--N/A--");
                elem.find('.display_ac_info_make').html("--N/A--");
                elem.find('.display_ac_info_place').html("--N/A--");
                elem.find('.display_ac_info_tonnage').html("--N/A--");
                elem.find('.display_ac_info_idu_sr').html("--N/A--");
                elem.find('.display_ac_info_odu_sr').html("--N/A--");
            } else {
                elem.find(".select_ac_id").val(ac_data.ac_info[val].ac_id);
                elem.find('.display_ac_info .display_ac_info_type').html(ac_data.ac_info[val].ac_type);
                elem.find('.display_ac_info .display_ac_info_make').html(ac_data.ac_info[val].make);
                elem.find('.display_ac_info .display_ac_info_place').html(ac_data.ac_info[val].location);
                elem.find('.display_ac_info .display_ac_info_tonnage').html(ac_data.ac_info[val].tonnage);
                elem.find('.display_ac_info .display_ac_info_idu_sr').html(ac_data.ac_info[val].idu_serial_no);
                elem.find('.display_ac_info .display_ac_info_odu_sr').html(ac_data.ac_info[val].odu_serial_no);
            }

        });

        $("#facebox .create_btn").on('click', function () {
            var elem = $(this).parent().siblings();
            var selected_ac = elem.find(".select_ac_id").val();
            var service_type = elem.find(".service_type").val();
            var p_date = elem.find(".preffered_date").val();
            var desc = elem.find(".desc").val();
            var output = elem.find(".display_output div");
            if (selected_ac != -1) {
                if (service_type != -1) {
                    output.html("Please wait...<i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");

                    $.ajax({url: "api/Customer/" + customer_id + "/OTS",
                        type: "POST",
                        dataType: "JSON",
                        data: {ac_id: selected_ac, service_type: service_type,p_date: p_date, desc: desc},
                        success: function (response) {
                            if (response.status == "ok") {
                                output.html("Successfully Added").removeClass().addClass("alert alert-success center");
                                setTimeout(function(){
                                    jQuery(document).trigger('close.facebox');
                                },1000);
                            } else if (response.status == "no") {
                                output.html(response.result + "").removeClass().addClass("alert alert-danger center");
                            } else {
                                output.html("No Response from the server").removeClass().addClass("alert alert-danger center");
                            }
                        }});
                } else {
                    output.html("Select Service Type").removeClass().addClass("alert alert-danger center");
                }

            } else {
                output.html("Select AC for the installation").removeClass().addClass("alert alert-danger center");
            }

        });
    });


    /** *********** MANAGE TAB CLICK *************/

    $("#tab_installation").on("click", function () {
        blockThisUI(".panel-body");
        $.getJSON("api/Customer/" + customer_id + "/Installations", function (response) {
            if (response.status == "ok") {
                var installed_ac = "";
                var install_type = "";
                var total = 1;
                $.each(response.data, function (key, val) {
                    
                    if (val.install_type == "s") {
                        install_type = "Standard";
                    } else if (val.install_type == "n") {
                        install_type = "Non Standard";
                    } else {
                        install_type = "Free";
                    }
                    var ac_div = "<div class='no-display ac_popup'><div class='' style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                            <tr><td>AC Type</td><td>"+val.actype+"</td></tr>\
                            <tr><td>Make</td><td>" + val.brand_name + "</td></tr>\
                            <tr><td>Location</td><td>"+val.location+"</td></tr>\
                            <tr><td>Tonnage / HP</td><td>"+val.tonnage+"</td></tr>\
                            <tr><td>IDU</td><td>Serial No: "+val.idu_serial_no+"<br /> Model No :"+val.idu_model_no+"</td></tr>\
                            <tr><td>ODU</td><td>Serial No: "+val.odu_serial_no+"<br /> Model No :"+val.odu_model_no+"</td></tr>\
                            <tr><td colspan='2'>"+val.remarks+"</td></tr></table></div></div>";
                            if(val.install_remarks==""){
                                remake_remarks="<b>No remarks added</b>";
                            }else{
                                remake_remarks=val.install_remarks;
                            }
                    var ac_remarks = "<div class='no-display ac_remark'><div class='modal-head' style='background:#fff;padding: 20px;border-radius:5px;'><h4 class='center'>Remarks</h4><div class='modal-body'><p>"+remake_remarks+"</p></div></div></div>";
                    installed_ac += "<tr class='i_row i_row_" + total + "'><td>" + val.brand_name + "&nbsp;("+val.actype+")"+ac_div+"&nbsp;&nbsp;<i onclick='show_ac_popup(\"i_row_" + total + "\");' style='font-size:1.3em' class='fa fa-eye cursor'></i></td>" +
                        "<td>" + install_type + "</td>" +
                        "<td>" + val.preferred_date + "</td>" +
                        "<td>" + val.no_of_service + "</td>" +
                        "<td>"+ac_remarks+"&nbsp;&nbsp;<a onclick='show_ac_remark_popup(\"i_row_" + total + "\");' class='big_icon btn'><i class='clip-bubble-dots-2'></i></a></td>" +
                        "<td>" + val.created_on + "</td><td><button onclick='ViewAMC(\"install\","+val.install_id+")' class='btn btn-info center'><i class='clip-info-2'> More</i></button></td>" +
                        "<td><i class='clip-minus-circle-2' onclick='delete_service_type(\"installation\"," + val.install_id + "," + total + ")' style='cursor:pointer;color:red'></i></td></tr>";
                    total++;
                });
                $(".installed_product").html(installed_ac);
            } else if (response.status == "no") {
                console.log("No installation is added yet");
                installed_ac = "<tr class='empty_row'><td class='alert alert-info center' colspan='7'> <i class='clip-info'></i> No installation is added yet</td></tr>";
                $(".installed_product").html(installed_ac);
            }
            unblockThisUI(".panel-body");
        });
    });
    

    $("#tab_complaints").on("click", function () {
        blockThisUI(".panel-body");
        $.getJSON("api/Customer/" + customer_id + "/Complaints", function (response) {
            if (response.status == "ok") {
                var complaint_ac = "";
                var total = 1;
                $.each(response.data, function (key, val) {
                    var ac_div = "<div class='no-display ac_popup'><div class='' style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                    <tr><td>AC Type</td><td>"+val.actype+"</td></tr>\
                    <tr><td>Make</td><td>" + val.brand_name + "</td></tr>\
                    <tr><td>Location</td><td>"+val.location+"</td></tr>\
                    <tr><td>Tonnage / HP</td><td>"+val.tonnage+"</td></tr>\
                    <tr><td>IDU</td><td>Serial No: "+val.idu_serial_no+"<br /> Model No :"+val.idu_model_no+"</td></tr>\
                    <tr><td>ODU</td><td>Serial No: "+val.odu_serial_no+"<br /> Model No :"+val.odu_model_no+"</td></tr>\
                    <tr><td colspan='2'>"+val.remarks+"</td></tr></table></div></div>";
                    if(val.problem_desc==""){
                        remake_remarks = "<b>No remarks added</b>";
                    }else{
                        remake_remarks = val.problem_desc;
                    }
                    var ac_remarks = "<div class='no-display ac_remark'><div class='modal-head' style='background:#fff;padding: 20px;border-radius:5px;'><h4 class='center'>Remarks</h4><div class='modal-body'><p>"+remake_remarks+"</p></div></div></div>";
                    complaint_ac += "<tr class='c_row c_row_" + total + "'><td>" + val.brand_name+"&nbsp;("+val.actype+")&nbsp;" + ac_div+"&nbsp;&nbsp; <i onclick='show_ac_popup(\"c_row_" + total + "\");' style='font-size:1.3em' class='fa fa-eye cursor'></i></td>\
                    <td>" + val.ac_problem_type + "</td><td>" + ac_remarks + "&nbsp;&nbsp;<a onclick='show_ac_remark_popup(\"c_row_" + total + "\");' class='big_icon btn'><i class='clip-bubble-dots-2'></i></a></td><td>" + val.created_on + "</td>\
                        <td><i class='clip-minus-circle-2' onclick='delete_service_type(\"complaints\"," + val.com_id + "," + total + ")' style='cursor:pointer;color:red'></i></td></tr>";
                    total++;
                });
                $(".complaint_product").html(complaint_ac);
            } else if (response.status == "no") {
                console.log("No Complaints is added yet");
                complaint_ac = "<tr class='empty_row'><td class='alert alert-info center' colspan='8'> <i class='clip-info'></i> No Complaints is added yet</td></tr>";
                $(".complaint_product").html(complaint_ac);
            }
            unblockThisUI(".panel-body");
        });
    });

    $("#tab_amc").on("click", function () {
        blockThisUI(".panel-body");
        $.getJSON("api/Customer/" + customer_id + "/AMC", function (response) {
            if (response.status == "ok") {
                var amc_ac = "";
                var total = 1;
                $.each(response.data, function (key, val) {
                    for (var i = 0; i < ac_data_count; i++) {
                        if (ac_data.ac_info[i].ac_id == val.ac_id) {
                            mAC_Info = ac_data.ac_info[i];
                            console.log(mAC_Info);
                        
                    
                    if (val.amc_type == "s") {
                        val.amc_type = "Semi-comprehensive"
                    } else if (val.amc_type == "n") {
                        val.amc_type = "Non-comprehensive"
                    } else if (val.amc_type == "c") {
                        val.amc_type = "Comprehensive"
                    }
                    var ac_div = "<div class='no-display ac_popup'><div class='' style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                    <tr><td>AC Type</td><td>"+mAC_Info.ac_type+"</td></tr>\
                    <tr><td>Make</td><td>" + mAC_Info.make + "</td></tr>\
                    <tr><td>Location</td><td>"+mAC_Info.location+"</td></tr>\
                    <tr><td>Tonnage / HP</td><td>"+mAC_Info.tonnage+"</td></tr>\
                    <tr><td>IDU</td><td>Serial No: "+mAC_Info.idu_serial_no+"<br /> Model No :"+mAC_Info.idu_model_no+"</td></tr>\
                    <tr><td>ODU</td><td>Serial No: "+mAC_Info.odu_serial_no+"<br /> Model No :"+mAC_Info.odu_model_no+"</td></tr>\
                    <tr><td colspan='2'>"+mAC_Info.remarks+"</td></tr></table></div></div>";
                    if(val.remarks==""){
                        remake_remarks="<b>No remakrs added</b>";
                    }else{
                        remake_remarks=val.remarks;
                    }
                    var ac_remarks = "<div class='no-display ac_remark'><div class='modal-head' style='background:#fff;padding: 20px;border-radius:5px;'><h4 class='center'>Remarks</h4><div class='modal-body'><p>"+remake_remarks+"</p></div></div></div>";                    
                    amc_ac += "<tr class='a_row a_row_" + total + "'><td> "+mAC_Info.make+" ("+mAC_Info.location+")" +ac_div+ " <i onclick='show_ac_popup(\"a_row_" + total + "\");' style='font-size:1.3em' class='fa fa-eye cursor'></i></td><td>" + val.amc_type + "</td><td>" +
                        "<b>Dry: </b>" + val.dry + "<br /><b>Wet: </b>" + val.wet + "</td><td>" + val.activation + "</td><td>" + val.expiration + "</td><td>"+ac_remarks+"&nbsp;&nbsp; <a onclick='show_ac_remark_popup(\"a_row_" + total + "\");' class='big_icon btn'><i class='clip-bubble-dots-2'></i></td>\
                        <td><button onclick='ViewAMC(\"amc\","+val.amc_id+","+val.wet+","+val.dry+")' class='btn btn-info center'><i class='clip-info-2'> More</i></button></td>\
                        <td><i class='clip-minus-circle-2' onclick='delete_service_type(\"amc\"," + val.amc_id + "," + total + ")' style='cursor:pointer;color:red'></i></td></tr>";
                    total++;
                    }
                    }
                });
                $(".amc_product").html(amc_ac);
            } else if (response.status == "no") {
                console.log("No AMC is added yet");
                amc_ac = "<tr class='empty_row'><td class='alert alert-info center' colspan='7'> <i class='clip-info'></i> No AMC is added yet</td></tr>";
                $(".amc_product").html(amc_ac);
            }
            unblockThisUI(".panel-body");
        });
    });

    $("#tab_ots").on("click", function () {
        blockThisUI(".panel-body");
        $.getJSON("api/Customer/" + customer_id + "/OTS", function (response) {
            if (response.status == "ok") {
                var ots_ac = "";
                var total = 1;
                $.each(response.data, function (key, val) {
                    var ac_div = "<div class='no-display ac_popup'><div class='' style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                    <tr><td>AC Type</td><td>"+val.actype+"</td></tr>\
                    <tr><td>Make</td><td>" + val.brand_name + "</td></tr>\
                    <tr><td>Location</td><td>"+val.location+"</td></tr>\
                    <tr><td>Tonnage / HP</td><td>"+val.tonnage+"</td></tr>\
                    <tr><td>IDU</td><td>Serial No: "+val.idu_serial_no+"<br /> Model No :"+val.idu_model_no+"</td></tr>\
                    <tr><td>ODU</td><td>Serial No: "+val.odu_serial_no+"<br /> Model No :"+val.odu_model_no+"</td></tr>\
                    <tr><td colspan='2'>"+val.remarks+"</td></tr></table></div></div>";
                    if(val.description==""){
                        remake_remarks="<b>No remarks added</b>";
                    }else{
                        remake_remarks=val.description;
                    }
                    var ac_remarks = "<div class='no-display ac_remark'><div class='modal-head' style='background:#fff;padding: 20px;border-radius:5px;'><h4 class='center'>Remarks</h4><div class='modal-body'><p>"+remake_remarks+"</p></div></div></div>";
                     
                    ots_ac += "<tr class='o_row o_row_" + total + "'><td>"+val.brand_name+"&nbsp;("+ val.actype+")"+ac_div+ "&nbsp;&nbsp;<i onclick='show_ac_popup(\"o_row_" + total + "\");' style='font-size:1.3em' class='fa fa-eye cursor'></i></td>\
                    <td>" + val.service_type + "</td><td>" + ac_remarks + "&nbsp;&nbsp;<a onclick='show_ac_remark_popup(\"o_row_" + total + "\");' class='big_icon btn'><i class='clip-bubble-dots-2'></i></a></td><td>" + val.created_on + "</td>\
                    <td><i class='clip-minus-circle-2' onclick='delete_service_type(\"ots\"," + val.ots_id + "," + total + ")' style='cursor:pointer;color:red'></i></td></tr>";
                    total++;
                });
                $(".ots_product").html(ots_ac);
            } else if (response.status == "no") {
                console.log("No OTS Found");
                ots_ac = "<tr class='empty_row'><td class='alert alert-info center' colspan='8'> <i class='clip-info'></i> No OTS is added yet</td></tr>";
                $(".ots_product").html(ots_ac);
            }
            unblockThisUI(".panel-body")
        });
    });

    
     $.getJSON("api/Technicians", function (tech) {
        if (tech.status == "ok") {
            technicians = tech.data;
          $.each(technicians, function (key, value) {
                technician_dropdown += "<option value='" + value.tech_id + "'>" + value.first_name + " " + value.last_name + "</option>";
            });
        } else {
            technician_dropdown = "<option value='-1'>No Technician available</option>";
        }
    });
    
    
    

});

function fill_locality(Value) {
    $('#pincode').val(Value);
    $('#pincode_display').hide();
    var pin = $("#pincode").val();
    $('.landmark').html("<option value='-1'> Please wait.. </option>");
    $.ajax({
        type: "GET",
        url: "api/Manage/pincode/" + pin,
        dataType: "JSON",
        success: function (data) {
            if (data.status == "ok") {
                delete data.status;
                var opt = "";
                $.each(data, function (key, loc) {
                    opt += "<option value=" + loc.locality + ">" + loc.locality + "</option>";
                });
                $('.landmark').html(opt);
            } else if (data.status == "no") {
                $('.landmark').html("<option value='-1'>- Not Available -</option>");
            }
        }
    });

}

function add_new_ac() {
    blockThisUI(".panel-body")
    $.ajax({
        type: 'get',
        url: 'api/Manage',
        success: function (response) {
            if (response.status == "ok") {
                delete response.status;
                var brand_empty = response.brand.empty;
                var ton_empty = response.tonnage.empty;
                var location_empty = response.location.empty;
                var ac_type_empty = response.ac_type.empty;

                if (brand_empty) {

                } else {
                    delete response.brand.empty;
                    var brand_tmp_opt = "<option value='-1'>--SELECT--</option>";
                    $.each(response.brand, function (key, value) {
                        brand_tmp_opt += "<option value=" + value.make_id + "|" + value.make + ">" + value.make + "</option>"
                    });

                }

                if (ton_empty) {

                } else {
                    delete response.tonnage.empty;
                    var ton_tmp_opt = "<option value='-1'>--SELECT--</option>";
                    $.each(response.tonnage, function (key, value) {
                        ton_tmp_opt += "<option value=" + value.tonnage_id + "|" + value.tonnage + ">" + value.tonnage + "</option>"
                    });

                }

                if (location_empty) {

                } else {
                    delete response.location.empty;
                    var loc_tmp_opt = "<option value='-1'>--SELECT--</option>";
                    $.each(response.location, function (key, value) {
                        loc_tmp_opt += "<option value=" + value.ac_location_id + "|" + value.location + ">" + value.location + "</option>"
                    });
                }

                if (ac_type_empty) {

                } else {
                    delete response.ac_type.empty;
                    var type_tmp_opt = "<option value='-1'>--SELECT--</option>";
                    $.each(response.ac_type, function (key, value) {
                        type_tmp_opt += "<option value=" + value.ac_type_id + "|" + value.ac_type + ">" + value.ac_type + "</option>"
                    });

                }

                var htm1 = "<select class='form-control imp add_cust_ac_ac_type' name='product_type'>" + type_tmp_opt + "</select>"
                var htm2 = "<select class='form-control imp add_cust_ac_brand_name' name='brand_name'>" + brand_tmp_opt + "</select>";
                var htm3 = "<select name='capacity' class='form-control imp add_cust_ac_ton_capacity'>" + ton_tmp_opt + "</select>";
                var htm4 = "<select class='form-control imp add_cust_ac_location' name='location'>" + loc_tmp_opt + "</select>";
                $(".cust_details_ac_type").html(htm1);
                $(".cust_details_make").html(htm2);
                $(".cust_details_tonnage").html(htm3);
                $(".cust_details_location").html(htm4);
                unblockThisUI(".panel-body")

                $.facebox({ div: "#Customer_details_add_ac"});
                
                $("#facebox .add_cust_ac_ac_type").on("change", function(){
                    var val = $(this).val();
                    if(val.split("|")[0]==5){
                        console.log("jdfjkdf")
                        $("#facebox .add_ac_table tr:first").after("<tr class='empty'><th>Sub AC Type</th><td><select class='form-control imp add_cust_ac_sub_ac_type' name='product_type'>" + type_tmp_opt + "</select></td></tr>");
                    }else{
                        $("#facebox .add_ac_table").find(".empty").remove();
                    }
                });

                $("#facebox #face_add_ac").on("click", function () {
                    var mThis = $(this);
                    var ac_type = $("#facebox .add_cust_ac_ac_type").val().split("|"); //1|Split               
                    var brand = $("#facebox .add_cust_ac_brand_name").val().split("|");
                    var ton = $("#facebox .add_cust_ac_ton_capacity").val().split("|");
                    var location = $("#facebox .add_cust_ac_location").val().split("|");
                    var idu_sr_no = $("#facebox .add_cust_ac_idu_sr_no").val();
                    var idu_model_no = $("#facebox .add_cust_ac_idu_model_no").val();
                    var odu_sr_no = $("#facebox .add_cust_ac_odu_sr_no").val();
                    var odu_model_no = $("#facebox .add_cust_ac_odu_model_no").val();
                    var remarks = $("#facebox .add_cust_ac_remarks").val();
                    var dataval = {ac_type: ac_type[1], brand: brand[1], ton: ton[1], location: location[1], idu_sr_no: idu_sr_no,
                        idu_model_no: idu_model_no, odu_sr_no: odu_sr_no, odu_model_no: odu_model_no, remarks: remarks}
                    var rows = 1;
                    var output = $("#facebox #error");
                    var qry = "";

                    for (var i = 0; i < rows; i++) {
                        qry += "&row[" + i + "][ac_type]=" + ac_type[0];
                        qry += "&row[" + i + "][make]=" + brand[0];
                        qry += "&row[" + i + "][ton]=" + ton[0];
                        qry += "&row[" + i + "][idu_model_no]=" + idu_model_no;
                        qry += "&row[" + i + "][idu_serial_no]=" + idu_sr_no;
                        qry += "&row[" + i + "][odu_model_no]=" + odu_model_no;
                        qry += "&row[" + i + "][odu_serial_no]=" + odu_sr_no;
                        qry += "&row[" + i + "][location]=" + location[0];
                        qry += "&row[" + i + "][remarks]=" + remarks;
                    }

                    var imp_fields = $("#facebox .imp").length;
                    var c = 0;
                    for (var i = 0; i < imp_fields; i++) {
                        if ($('#facebox .imp').eq(i).val() == "" || $('#facebox .imp').eq(i).val() == -1) {
                            $('#facebox .imp').eq(i).parent().removeClass("has-success").addClass("has-error");
                            c++;
                        } else {
                            $('#facebox .imp').eq(i).parent().removeClass("has-error");
                        }
                    }
                    if (c > 0) {
                        output.html("Please fill the required fields").removeClass().addClass("result_msg alert alert-danger center");
                    } else {
                        output.hide();
                        var tmp_load_holder = mThis.html();
                        mThis.html("<i class='clip-busy'></i> Adding...");
                        
                        $.ajax({
                            type: 'post',
                            url: 'api/Customer/' + customer_id + '/AC',
                            data: qry,
                            dataType: 'json',
                            success: function (response) {
                                if (response.status == "ok") {
                                    console.log("success");
                                    $("#facebox #result").html("Added Successfully").removeClass().addClass("alert alert-success center").show();
                                    update_ac_variable();
                                    add_row_in_customer_details(dataval, response.last_id);
                                    setTimeout(function(){
                                    jQuery(document).trigger('close.facebox');
                                },1000);
                                
                                } else if (response.status == "no") {
                                    console.log("error")
                                    $("#facebox #result").html(response.result).removeClass().addClass("alert alert-danger center").show();
                                }
                                output.hide();
                                mThis.html(tmp_load_holder);
                            }
                        });
                    }
                });
            }
        }
    });
}

function add_row_in_customer_details(qry, id) {
    if ($(".customer_product_view tr").hasClass("empty_row")) {
        console.log("yes");
        $(".empty_row").remove();
    }
    var tot_tr = $(".num_ac_rows").length;
    var total = tot_tr + 1;
    console.log(tot_tr + " " + total);
    var new_row = "<tr class='num_ac_rows num_ac_rows_" + total + "'><td>" + qry.ac_type + "</td><td>" + qry.brand + "</td><td>" + qry.ton + "</td><td><b>Serial No.</b>" + qry.odu_sr_no + "<br/><b>Model No.</b>" + qry.odu_model_no + "</td><td>Serial No." + qry.odu_sr_no + "<br/>Model No." + qry.odu_model_no + "</td><td>" + qry.location + "</td><td><button class='btn btn-primary btn-sm' onclick='display_remarks(\""+qry.remarks+"\")'><i class='clip-info'></i></button></td><td><i style='cursor:pointer;color:red' onclick='delete_customer_ac(" + id + "," + total + ")' class='clip-minus-circle-2'></i></td></tr>";
    $(".customer_product_view").prepend(new_row);
}

function delete_customer_ac(cust_ac_id, row_id) {
    var ans = confirm("Are you sure");
    if (ans) {
        $("#ac_info_res").show().html("Please wait... <i class='clip-busy'></i>").removeClass().addClass("alert alert-info center")
        $.ajax({
            type: 'DELETE',
            url: 'api/Customer/' + customer_id + '/AC/' + cust_ac_id,
            dataType: 'json',
            success: function (data) {
                if (data.status == "ok") {
                    $("#ac_info_res").show().html("Successfully Deleted").removeClass().addClass("alert alert-success center");
                    setTimeout(function(){
                        $("#ac_info_res").slideUp();
                    },1000);
                    if($(".customer_product_view tr").length==1){
                        $(".customer_product_view").html("<tr class='empty_row'><td class='alert alert-info center' colspan='8'> <i class='clip-info'></i> No AC Found</td></tr>")
                    }
                    $(".num_ac_rows_" + row_id).slideUp("slow");
                    $.getJSON("api/Customer/" + customer_id + "/AC", function (response) {
                        if (response.status == "ok") {
                            console.log("data updated");
                        } else if (response.status == "no") {
                            console.log("error");
                        }
                    });
                } else if (data.status == "no") {
                    console.log("error");
                    $("#ac_info_res").show().html(data.result).removeClass().addClass("alert alert-danger center")
                }
            }
        });
    }

}

function delete_service_type(type, id, row_id) {
    switch (type) {
        case 'installation':

            var ans = confirm("Are you sure");
            if (ans) {
                $.ajax({
                    type: 'delete',
                    url: 'api/Customer/' + customer_id + '/Installations/' + id,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == "ok") {
                            $(".i_row_" + row_id).slideUp().remove();
                            $("#result_install").show().html("Deleted Successfully").removeClass().addClass("alert alert-success center");
                            if ($(".installed_product tr").length == 0) {
                                var row = "<tr class='empty_row'><td class='alert alert-info center' colspan='8'> <i class='clip-info'></i> No Installation is added yet</td></tr>";

                                $(".installed_product").html(row);
                            }
                        } else if (data.status == "no") {
                            $("#result_install").show().html(data.result).removeClass().addClass("alert alert-danger center");
                        }
                        setTimeout(function(){
                            $("#result_install").slideUp();
                        },1000);
                    }
                });
            }

            break;

        case 'complaints':

            var ans = confirm("Are you sure");
            if (ans) {
                $.ajax({
                    type: 'delete',
                    url: 'api/Customer/' + customer_id + '/Complaints/' + id,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == "ok") {
                            $(".c_row_" + row_id).slideUp().remove();
                            $("#result_complaints").show().html("Deleted Successfully").removeClass().addClass("alert alert-success center");
                            if ($(".complaint_product tr").length == 0) {
                                var row = "<tr class='empty_row'><td class='alert alert-info center' colspan='8'> <i class='clip-info'></i> No Complaints is added yet</td></tr>";
                                $(".complaint_product").html(row);
                            }
                        } else if (data.status == "no") {
                            $("#result_complaints").show().html(data.result).removeClass().addClass("alert alert-danger center");
                        }setTimeout(function(){
                            $("#result_complaints").slideUp();
                        },1000);
                    }
                });
            }

            break;

        case 'amc':

            var ans = confirm("Are you sure");
            if (ans) {
                $.ajax({
                    type: 'delete',
                    url: 'api/Customer/' + customer_id + '/AMC/' + id,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == "ok") {
                            $(".a_row_" + row_id).slideUp();
                            $("#result_amc").show().html("Deleted Successfully").removeClass().addClass("alert alert-success center");
                            if ($(".amc_product tr").length == 0) {
                                var row = "<tr class='empty_row'><td class='alert alert-info center' colspan='7'> <i class='clip-info'></i> No AMC is added yet</td></tr>";
                                $(".amc_product").html(row);
                            }
                        } else if (data.status == "no") {
                            $("#result_amc").show().html(data.result).removeClass().addClass("alert alert-danger center");
                        }setTimeout(function(){
                            $("#result_amc").slideUp();  
                        },1000);
                    }
                });
            }

            break;

        case 'ots':

            var ans = confirm("Are you sure");
            if (ans) {
                $.ajax({
                    type: 'delete',
                    url: 'api/Customer/' + customer_id + '/OTS/' + id,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == "ok") {
                            $(".o_row_" + row_id).slideUp();
                            $("#result_ots").show().html("deleted successfully").removeClass().addClass("alert alert-success center");
                            if ($(".ots_product tr").length == 0) {
                                var row = "<tr class='empty_row'><td class='alert alert-info center' colspan='8'> <i class='clip-info'></i> No OTS is added yet</td></tr>";
                                $(".ots_product").html(row);
                            }
                        } else if (data.status == "no") {
                            $("#result_ots").show().html(data.result).removeClass().addClass("alert alert-danger center");
                        }
                        setTimeout(function(){
                            $("#result_ots").slideUp();
                        },1000);
                    }
                    
                });
            }

            break;
    }
}

function amc_ac_change(elem) {
    var mThis = $('#facebox .' + elem + ' .amc_select_ac');
    var val = mThis.val().split("|")[0];
    var elem = mThis.parent().parent();

    if (val == -1) {
        mThis.parent().find(".amc_selected_ac").val(-1);
        elem.find(".ac_type").html("--N/A--");
        elem.find(".capacity").html("-- No Information --");
        elem.find(".idu_no").html("-- No Information --");
        elem.find(".odu_no").html("-- No Information --");
    } else {
        mThis.parent().find(".amc_selected_ac").val(ac_data.ac_info[val].ac_id);
        elem.find(".ac_type").html(ac_data.ac_info[val].ac_type);
        elem.find(".capacity").html(ac_data.ac_info[val].tonnage);
        elem.find(".idu_no").html("<b>IDU Serial No:</b>" + ac_data.ac_info[val].idu_serial_no + " <br /> <b>IDU Model No:</b> " + ac_data.ac_info[val].idu_model_no);
        elem.find(".odu_no").html("<b>ODU Serial No:</b>" + ac_data.ac_info[val].odu_serial_no + " <br /> <b>ODU Model No:</b> " + ac_data.ac_info[val].odu_model_no);
    }

}

function update_ac_variable(){
        $.getJSON("api/Customer/" + customer_id, function (response) {
        if (response.status == "ok") {
            delete response.ac_data.status;
            ac_data.ac_info = response.ac_data;
          
            var e=$.map(response.ac_data,function(ej){return ej});
          ac_data_count=e.length
            
        } else if (response.status == "no") {
            alert("Error Updating information. Reloading please wait..");
            window.location.replace("CustomerDetails?id=" + customer_id);
        }
    });    
}

function display_remarks(val){
        if(val==""){
            val="<b>No Remark available</b>"
        }else{
            val=val;
        }
     $.facebox("<div style='background-color:white;'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button><h5 class='modal-title'>Remarks</h5></div><div class='modal-body'><p>"+val+"</p></div></div>");
}

function ViewAMC(type,id,wet,dry){
    blockThisUI();
    $.getJSON("api/Customer/"+customer_id+"/Service/"+id+"/"+type,function(response){
        if(response.status=="ok"){
            console.log("Service dates found")
            var tmp_row="";
            var total=response.data.length
            console.log(response.data.length);
            if(type=="amc"){
                $.each(response.data,function(key,val){
                tmp_row += "<tr class='bbb'><td><input type='hidden' class='amc_service_id' value='"+val.amc_service_id+"'>\
                <input type='text' class='amc_assign_required select_date form-control datepicker' value='"+val.date+"' data-date-format='dd-mm-yyyy' data-date-viewmode='years'></td><td><textarea class='give_remarks form-control amc_assign_required'>"+val.remarks+"</textarea></td></tr>";
            });
            }else{
                $.each(response.data,function(key,val){
                tmp_row += "<tr class='bbb'><td><input type='hidden' class='amc_service_id' value='"+val.install_service_id+"'>\
                <input type='text' class='amc_assign_required select_date form-control datepicker' value='"+val.date+"' data-date-format='dd-mm-yyyy' data-date-viewmode='years'></td><td><textarea class='give_remarks form-control amc_assign_required'>"+val.remarks+"</textarea></td></tr>";
            });
            }
            $("#service_date_table").html(tmp_row);
            $(".modal-footer").html("<button id='amc_assign_btn' class='btn btn-primary amc_assign_btn'>Submit</button>");
            $.facebox({ div: "#view_amc_modal" });
            
        }else if(response.status=="no"){
            console.log("No Service dates found")
            for(var i=0;i<wet+dry;i++){
                tmp_row += "<tr class='bbb'><td><input type='text' class='amc_assign_required select_date form-control datepicker' data-date-format='dd-mm-yyyy' data-date-viewmode='years'></td><td><textarea class='give_remarks form-control amc_assign_required'></textarea></td></tr>";
            }
            $("#service_date_table").html(tmp_row);
            $(".modal-footer").html("<button id='amc_assign_btn' class='btn btn-primary amc_assign_btn'>Submit</button>");
            $.facebox({ div: "#view_amc_modal" });
        }
    unblockThisUI();
            
            $('#facebox .datepicker').each(function () {
                $(this).datepicker();
                autoclose: true;
            });
    $("#facebox .amc_assign_btn").on("click", function(){
        console.log("click");
        var c=0;
        var input_length = $("#facebox .amc_assign_required").length;
        //console.log(input_length);
        for(var i=0; i<input_length; i++){
            if($("#facebox .amc_assign_required").eq(i).val()=="" || $("#facebox .amc_assign_required").eq(i).val()==-1){
                $("#facebox .amc_assign_required").eq(i).parent().removeClass("has-success").addClass("has-error");
                c++;
            }else{
                $("#facebox .amc_assign_required").eq(i).parent().removeClass("has-error");
            }
        }
        if(c > 0){
            $("#facebox #error").html("Please fill the required details").removeClass().addClass("alert alert-danger");
        }else{
            $("#facebox #error").remove();
        var data = "";
        var asd = $("#facebox .bbb").length;
        console.log(asd);
        
        for(var i = 0; i < asd ; i++){
            data += "&row[" + i + "][date]=" + $("#facebox .select_date").eq(i).val();
            data += "&row[" + i + "][remarks]=" + $("#facebox .give_remarks").eq(i).val();
            data += "&row[" + i + "][service_id]=" + $("#facebox .amc_service_id").eq(i).val();         
        }
        $("#facebox #result").show().html("Please wait...<i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");
        if(type=="install"){
            address = "api/Customer/"+customer_id+"/Installation/Service";
        }else{
            address = "api/Customer/"+customer_id+"/AMC_Service";
        }
        $.ajax({
            type:'PUT',
            url:address,
            data:data,
            dataType:'json',
            success: function(response){
                if(response.status=="ok"){
                    console.log(response.result);
                    $("#facebox #result").show().html(response.result).removeClass().addClass("alert alert-success center");
                    setTimeout(function(){
                        jQuery(document).trigger('close.facebox');  
                    },1000)
                }else if(response.status=="no"){
                    $("#facebox #result").show().html(response.result).removeClass().addClass("alert alert-danger center"); 
                }
            }
        });
        }
    });
   }); 
       
}

function show_ac_popup(elem){
    var content=$("."+elem).find(".ac_popup").html();
    
    $.facebox(content);
}
function show_ac_remark_popup(elem){
    var content=$("."+elem).find(".ac_remark").html();
    
    $.facebox(content);
}