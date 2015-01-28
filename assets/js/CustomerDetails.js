var ac_data = {}, cust_data = {};
ac_data.problem_type = {};
ac_data.ac_info = {};
var customer_id;
var ac_data_count = 0;
var technician_dropdown;
var uninstalled_ac = {};
var technicians = {};
var possible_linked_account={};
$(document).ready(function () {

    customer_id = $("#customer_id_holder").val();

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
                    $(".edit_firstname").attr("value",data.first_name);
                    $(".edit_lastname").attr("value",data.last_name);
                    $(".display_username").html(data.first_name + " " + data.last_name);
                    $(".edit_mobile1").attr("value",data.mobile);
                    $(".display_mobile1").html(data.mobile);
                    $(".edit_mobile2").attr("value",data.alternate_mobile);
                    $(".display_mobile2").html(data.alternate_mobile);
                    $(".edit_email").attr("value",data.email);
                    $(".display_email").html(data.email);
                    $(".edit_landline").attr("value",data.phone);
                    $(".display_landline").html(data.phone);
                    $(".edit_address").val(data.address);
                    $(".display_address").html(data.address);
                    $(".edit_alternate_contacts").attr("value",data.alternate_contact);
                    $(".display_alternate_contacts").html(data.alternate_contact);
                    $(".edit_pincode").attr("value",data.pincode);
                    $(".display_pincode").html(data.pincode);
                    $(".edit_city").attr("value",data.city);
                    $(".display_city").html(data.city);
                    var land_opt = "";
                    $.each(data.landmark_info, function (key, val) {

                        if (val == data.landmark) {
                            land_opt += "<option value='" + val + "' selected='selected'>" + val + "</option>";
                        } else {
                            land_opt += "<option value='" + val + "'>" + val + "</option>";
                        }

                    });
                    $("#landmark").html(land_opt);
                    $(".display_landmark_info").html(data.landmark);


                    var ac_drop_opt = "";
                    ac_data.ac_info = data.ac_data; //Total Customer's AC details for later use

                    if (data.ac_data.status == "ok") {
                        delete data.ac_data.status;
                        var ac_remarks = "";
                        $.each(data.ac_data, function (key, type) {
                            ac_remarks = "<div class='ac_row_remark_popup' style='display:none'><div style='background:#fff;padding:20px;border-radius:5px'>\
                            <table class='table table-bordered table-striped'><tr><th class='center'><h4 class='center'>Remarks</h4></th></tr>\
                            <tr><td class='center'><span class='acrow_remarks'>"+type.remarks+"</span></td></tr></table></div></div>";
                            
                            ac_drop_opt += "<tr class='num_ac_rows num_ac_rows_" + ac_data_count + "'><td class='center'><span class='acrow_actype'>" + type.ac_type + "</span></td>\
                            <td class='center'><span class='acrow_make'>" + type.make + "</span></td><td class='center'><span class='acrow_ton'>" + type.tonnage + "</span></td>" +
                            "<td><b>Model No. : </b><span class='o_mod'>" + type.odu_model_no + "</span> <br/ > <b>Serial No. : </b><span class='o_ser'>" + type.odu_serial_no + "</span></td>\
                            <td><b>Model No. : </b><span class='i_mod'>" + type.idu_model_no + "</span> <br/ > <b>Serial No. : </b><span class='i_ser'>" + type.idu_serial_no + "</span></td>\
                            <td class='center'><span class='acrow_loc'>" + type.location + "</span></td>" + "<td class='center'><button class='btn btn-purple' onclick='display_remarks(\"ac_row_remark_popup\",\"num_ac_rows_"+ac_data_count+"\")'><i class='fa  fa-comment '></i></button>"+ac_remarks+"</td>\
                            <td><button onclick='edit_ac("+type.ac_id+",\"num_ac_rows_"+ac_data_count+"\")' class='btn btn-warning'><i class='fa fa-edit'></i></button><button onclick='delete_customer_ac(" + type.ac_id + "," + ac_data_count + ")' class='btn btn-danger'><i class='fa fa-trash-o'></i></button></td></tr>";

                            ac_data_count++; //Total number of AC for later use

                        });

                    } else if (data.ac_data.status == "no") {
                        ac_drop_opt = "<tr class='empty_row'><td class='alert alert-info center' colspan='8'> <i class='clip-info'></i> " + data.ac_data.result + "</td></tr>";
                    }

                    $(".customer_product_view").append(ac_drop_opt);

                    $(".edit_location").attr("value",data.location);
                    $(".display_location").html(data.location);
                    $(".communication option[value='" + data.mode_of_contact + "']").attr("selected", "selected");
                    if (data.communication == "m") {
                        $(".display_communication_m").html("Mobile");
                    } else if (data.communication == "e") {
                        $(".display_communication_m").html("Email");
                    } else {
                        $(".display_communication_m").html("Mobile & Email");
                    }
                    $(".display_referred_by").html(data.reference);
                    $(".edit_referred_by").attr("value",data.reference);
                    $(".display_dob").html(data.dob);
                    $(".edit_birth_date").attr("value",data.dob);
                    $(".display_created_on").html(data.date)
                    $(".edit_remarks").val(data.remarks);
                    $(".display_remarks").html(data.remarks);
                    if (data.account_type == "r") {
                        $(".edit_org_type").attr("value","Residential");
                        $(".display_org_type").html("Residential");
                        $("#CustomerDetailsTab").removeClass("tab-bricky").addClass("tab-blue");

                    } else {
                        $(".edit_org_type").attr("value","Commercial");
                        $(".display_org_type").html("Commercial");
                        $("#CustomerDetailsTab").removeClass("tab-blue").addClass("tab-bricky");
                    }
                    $(".edit_org_name").text(data.organisation);
                    $(".display_org_name").html(data.organisation);

                    $.getJSON("api/Manage/Complaints/ProblemType", function (type) {
                        ac_data.problem_type = type;
                    });
                    /** STARTS: POSSIBLE LINKED ACCOUNT ***/var linked_acc_ref=$("#linked_account");
                    blockThisUI(linked_acc_ref);
                    $.ajax({
                        type:'get',
                        url:'api/LinkedAccount/'+customer_id,
                        dataType:'json',
                        success: function(response){
                            if(response.status=="ok"){
                                var output="";

                                $.each(response.data, function (key, type) {
                                    var li="";
                                    li+="<li><a href='javascript:void(0)' class='activity'>";
                                    if(type.account_type=="r"){
                                        li+="<i class='clip-home-2 circle-icon circle-green'></i>";
                                        li+="<span class='desc'>"+type.organisation+" | "+type.first_name+" "+type.last_name+" | "+type.mobile+" | "+type.location+" </span>";

                                    }else{
                                        li+="<i class='fa fa-trello circle-icon circle-bricky'></i>";
                                        li+="<span class='desc'>"+type.organisation+" | "+type.first_name+" "+type.last_name+" | "+type.mobile+" | "+type.location+" </span>";
                                    }
                                    li+="<div class='time'><i class='fa fa-time bigger-110'></i>" +
                                    "<button class='btn btn-primary' onClick='LoadPage(\"CustomerDetails?id="+type.cust_id+"&ref=CustomerDetails?id="+customer_id+"\")'>View</button></div></a></li>";
                                    output+=li;
                                });
                            }else if(response.status=="no"){
                                output="<li class='alert alert-warning'><i class='clip-notification-2'></i> No Matching Account</li>";
                            }
                            linked_acc_ref.html("<ul class='activities'>"+output+"</ul>");
                            unblockThisUI(linked_acc_ref);
                        },error:function(){
                            unblockThisUI(linked_acc_ref);
                        }
                    });

                    /** ENDS: POSSIBLE LINKED ACCOUNT ***/
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
            var dob = $("#edit_get_birth_date").val();
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
                                $.ajax({
            type: 'GET',
            url: 'api/Customer/' + customer_id,
            dataType: 'json',
            success: function (data) {
                cust_data = data;
                if (data.status == 'ok') {
                    $(".edit_firstname").attr("value",data.first_name);
                    $(".edit_lastname").attr("value",data.last_name);
                    $(".display_username").html(data.first_name + " " + data.last_name);
                    $(".edit_mobile1").attr("value",data.mobile);
                    $(".display_mobile1").html(data.mobile);
                    $(".edit_mobile2").attr("value",data.alternate_mobile);
                    $(".display_mobile2").html(data.alternate_mobile);
                    $(".edit_email").attr("value",data.email);
                    $(".display_email").html(data.email);
                    $(".edit_landline").attr("value",data.phone);
                    $(".display_landline").html(data.phone);
                    $(".edit_address").val(data.address);
                    $(".display_address").html(data.address);
                    $(".edit_alternate_contacts").attr("value",data.alternate_contact);
                    $(".display_alternate_contacts").html(data.alternate_contact);
                    $(".edit_pincode").attr("value",data.pincode);
                    $(".display_pincode").html(data.pincode);
                    $(".edit_city").attr("value",data.city);
                    $(".display_city").html(data.city);
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
                                <td>" + type.location + "</td>" + "<td><button class='btn btn-primary btn-sm' onclick='display_remarks(\"" + type.remarks + "\")'><i class='clip-info'></i></button></td>\
                                <td><button class='btn btn-danger btn-sm' onclick='delete_customer_ac(" + type.ac_id + "," + ac_data_count + ")'> <i class='fa fa-trash-o'></i></button></td></tr>";

                            ac_data_count++; //Total number of AC for later use

                        });

                    } else if (data.ac_data.status == "no") {
                        ac_drop_opt = "<tr class='empty_row'><td class='alert alert-info center' colspan='8'> <i class='clip-info'></i> " + data.ac_data.result + "</td></tr>";
                    }

                    $(".customer_product_view").append(ac_drop_opt);

                    $(".edit_location").attr("value",data.location);
                    $(".display_location").html(data.location);
                    $(".communication option[value='" + data.mode_of_contact + "']").attr("selected", "selected");
                    if (data.communication == "m") {
                        $(".display_communication_m").html("Mobile");
                    } else if (data.communication == "e") {
                        $(".display_communication_m").html("Email");
                    } else {
                        $(".display_communication_m").html("Mobile & Email");
                    }
                    $(".display_referred_by").html(data.reference);
                    $(".edit_referred_by").attr("value",data.reference);
                    $("edit_birth_date").attr("value",data.dob);
                    $(".display_dob").html(data.dob);
                    $(".display_created_on").html(data.date)
                    $(".edit_remarks").val(data.remarks);
                    $(".display_remarks").html(data.remarks);
                    if (data.account_type == "r") {
                        $(".edit_org_type").attr("value","Residential");
                        $(".display_org_type").html("Residential");
                        $("#CustomerDetailsTab").removeClass("tab-bricky").addClass("tab-blue");

                    } else {
                        $(".edit_org_type").attr("value","Commercial");
                        $(".display_org_type").html("Commercial");
                        $("#CustomerDetailsTab").removeClass("tab-blue").addClass("tab-bricky");
                    }
                    $(".edit_org_name").attr("value",data.organisation);
                    $(".display_org_name").html(data.organisation);

                    $.getJSON("api/Manage/Complaints/ProblemType", function (type) {
                        ac_data.problem_type = type;
                    });

                } else if (data.status == "no") {
                    $(".container .row").eq(1).html("<div class='alert alert-danger center'>" + data.result + "</div>");
                }
                //unblockThisUI($(".profile"));
            }
        });

                    } else if (data.status == "no") {
                        $("#update_customer_details_output").show().html("" + data.result).removeClass().addClass("alert alert-info center");
                    }
                    setTimeout(function () {
                        $("#update_customer_details_output").slideUp();
                    }, 1000);
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

        var pincode = $('#pincode').val();
        if (pincode.length > 3) {
            $.post("controller/GetPincode.php", {type: "pincode", pincode: pincode}, function (data) {
                $("#pincode_display").html(data).show();
            });
        }
    });


    /** ****** INSTALLATION *********/
    $("#add_installation").on('click', function () {
        var mThis = $(this);
        blockThisUI(mThis);
        var modal_box = $("#installation_modal_box");
        var title = modal_box.find(".modal-title");
        var modal_body = modal_box.find(".modal-body");
        var modal_footer=modal_box.find(".modal-footer");
        var ac_dropdown = "<option value='-1'> -- Select AC -- </option>";

        $.getJSON("api/Customer/" + customer_id + "/Uninstalled", function (response) {
            if (response.status == "ok") {
                uninstalled_ac = response.data;
                if (response.data.length > 0) {

                    $.each(response.data, function (key, val) {
                        ac_dropdown += "<option  value='" + key + "'> " + val.brand_name + " (" + val.location + ")  </option>";
                    });
                    modal_body.find(".select_uninstalled_ac").html(ac_dropdown);
                } else {
                    modal_body.html("<div class='alert alert-danger'>AC Data is corrupt or not retrieved. Please refresh the page</div>");
                    modal_footer.html("");
                }
            } else {
                modal_body.html("<div class='alert alert-danger'>" + response.result + "</div>");
                modal_footer.html("");

            }
            unblockThisUI(mThis);
            $.facebox({div: "#installation_modal_box"});
            $(".date-picker").datepicker({
                autoclose:true
            });
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

        $.facebox({ div: "#complaints_modal_box" });
        //$("#facebox .preffered_date").datepicker({autoclose: true});
        $("#facebox .preffered_date").datepicker({
            autoclose:true
        });
    
    $("#facebox .create_btn").on('click', function () {
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
                        setTimeout(function () {
                            jQuery(document).trigger('close.facebox');
                        }, 1000);
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

    $("#facebox .select_ac").on('change', function () {
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
            elem.find('.display_ac_info_idu_md').html("--N/A--");
            elem.find('.display_ac_info_odu_md').html("--N/A--");
        } else {
            elem.find(".select_ac_id").val(ac_data.ac_info[val].ac_id);
            elem.find('.display_ac_info_type').html(ac_data.ac_info[val].ac_type);
            elem.find('.display_ac_info_make').html(ac_data.ac_info[val].make);
            elem.find('.display_ac_info_place').html(ac_data.ac_info[val].location);
            elem.find('.display_ac_info_tonnage').html(ac_data.ac_info[val].tonnage);
            elem.find('.display_ac_info_idu_sr').html(ac_data.ac_info[val].idu_serial_no);
            elem.find('.display_ac_info_odu_sr').html(ac_data.ac_info[val].odu_serial_no);
            elem.find('.display_ac_info_idu_md').html(ac_data.ac_info[val].idu_model_no);
            elem.find('.display_ac_info_odu_md').html(ac_data.ac_info[val].odu_model_no);           
        }
    });
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
            <td > <select class='form-control mandotory amc_service_type'><option value='-1'> -- Select Type -- </option><option value='s'>Semi-Comprehensive</option><option value='c'>Comprehensive</option><option value='n'>Labour only</option></select>\
            </td>\
            <td><input type='text' class='form-control amc_datepicker mandotory' data-date-format='dd-mm-yyyy' data-date-viewmode='years'></td>\
            <td class='center'><input type='number' class='form-control amc_dry mandotory' placeholder='Dry' size='1'> <br>\
            <input type='number' class='form-control amc_wet mandotory' placeholder='Wet' size='1'></td><td><textarea class='form-control amc_remarks'></textarea>" + del + "\
            </tr>";

            $("#facebox .table_body").html(row);
            $('#facebox .amc_datepicker').each(function () {
                $(this).datepicker({autoclose: true});
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
            <td > <select class='form-control mandotory amc_service_type'><option value='-1'> -- Select Type -- </option><option value='s'>Semi-Comprehensive</option><option value='c'>Comprehensive</option><option value='n'>Labour only</option></select>\
            </td>\
            <td><input type='text' class='form-control amc_datepicker mandotory' data-date-format='dd-mm-yyyy' data-date-viewmode='years'></td>\
            <td class='center'><input type='number' class='form-control amc_dry mandotory' placeholder='Dry' size='1'> <br>\
            <input type='number' class='form-control amc_wet mandotory' placeholder='Wet' size='1'></td><td><textarea class='form-control amc_remarks'></textarea>" + del + "\
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
            <td> <select class='form-control mandotory amc_service_type'><option value='-1'> -- Select Type -- </option><option value='s'>Semi-Comprehensive</option><option value='c'>Comprehensive</option><option value='n'>Labour only</option></select>\
            </td>\
            <td><input type='text' class='form-control amc_datepicker mandotory' data-date-format='dd-mm-yyyy' data-date-viewmode='years'></td>\
            <td class='center '><input type='number' class='form-control amc_dry mandotory' placeholder='Dry' size='1'> <br>\
            <input type='number' class='form-control amc_wet mandotory' placeholder='Wet' size='1'></td><td><textarea class='form-control amc_remarks'></textarea>" + del + "\
            </td></tr>";

            $("#facebox .table_body").append(row);
            /*$("#facebox .preffered_date").datepicker({
                autoclose:true,
                startDate: date
            });*/
            $('#facebox .amc_datepicker').each(function () {
                $(this).datepicker({autoclose: true});
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

                    data += "&row[" + i + "][cust_id]=" + $("#facebox .aaa").eq(i).find(".Customer_id").val();
                    data += "&row[" + i + "][ac_id]=" + $("#facebox .aaa").eq(i).find(".amc_selected_ac").val();
                    data += "&row[" + i + "][select_ac]=" + $("#facebox .aaa").eq(i).find(".amc_select_ac").val();
                    data += "&row[" + i + "][service_type]=" + $("#facebox .aaa").eq(i).find(".amc_service_type").val();
                    data += "&row[" + i + "][dry_service]=" + $("#facebox .aaa").eq(i).find(".amc_dry").val();
                    data += "&row[" + i + "][wet_service]=" + $("#facebox .aaa").eq(i).find(".amc_wet").val();
                    data += "&row[" + i + "][amc_datepicker]=" + $("#facebox .aaa").eq(i).find(".amc_datepicker").val();
                    data += "&row[" + i + "][amc_remarks]=" + $("#facebox .aaa").eq(i).find(".amc_remarks").val();
                }

                $("#facebox #result").show().html("Please wait...<i class='clip-buzy'></i>").removeClass().addClass("alert alert-info center");
                $.ajax({
                    type: 'post',
                    data: data,
                    url: 'api/Customer/' + customer_id + '/AMC',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == "ok") {

                            $("#facebox #result").show().html("Added Successfully").removeClass().addClass("alert alert-success center");
                            setTimeout(function(){
                                    jQuery(document).trigger('close.facebox');
                            },1000);
                        } else if (response.status == "no") {

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
        
        //$("#facebox .preffered_date").datepicker({autoclose: true});
        $("#facebox .preffered_date").datepicker({
            autoclose:true
        });
        
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
                elem.find('.display_ac_info_idu_md').html("--N/A--");
                elem.find('.display_ac_info_odu_md').html("--N/A--");
            } else {
                elem.find(".select_ac_id").val(ac_data.ac_info[val].ac_id);
                elem.find('.display_ac_info .display_ac_info_type').html(ac_data.ac_info[val].ac_type);
                elem.find('.display_ac_info .display_ac_info_make').html(ac_data.ac_info[val].make);
                elem.find('.display_ac_info .display_ac_info_place').html(ac_data.ac_info[val].location);
                elem.find('.display_ac_info .display_ac_info_tonnage').html(ac_data.ac_info[val].tonnage);
                elem.find('.display_ac_info .display_ac_info_idu_sr').html(ac_data.ac_info[val].idu_serial_no);
                elem.find('.display_ac_info .display_ac_info_odu_sr').html(ac_data.ac_info[val].odu_serial_no);
                elem.find('.display_ac_info .display_ac_info_idu_md').html(ac_data.ac_info[val].idu_model_no);
                elem.find('.display_ac_info .display_ac_info_odu_md').html(ac_data.ac_info[val].odu_model_no);
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
                            <tr><th>AC Type</th><td>"+val.actype+"</td></tr>\
                            <tr><th>Make</th><td>" + val.brand_name + "</td></tr>\
                            <tr><th>Location</th><td>"+val.location+"</td></tr>\
                            <tr><th>Tonnage / HP</th><td>"+val.tonnage+"</td></tr>\
                            <tr><th>IDU</th><td>Serial No: "+val.idu_serial_no+"<br /> Model No :"+val.idu_model_no+"</td></tr>\
                            <tr><th>ODU</th><td>Serial No: "+val.odu_serial_no+"<br /> Model No :"+val.odu_model_no+"</td></tr>\
                            <tr><th>Remarks</th><td>"+val.remarks+"</td></tr></table></div></div>";
                            if(val.install_remarks==""){
                                remake_remarks="<b class='text-danger'>No remarks added</b>";
                            }else{
                                remake_remarks=val.install_remarks;
                            }
                    var ac_remarks = "<div class='no-display ac_remark'><div style='background:#fff;padding: 20px;border-radius:5px;width: 400px;'><table class='table table-bordered table-striped'><tr><th class='center'>Remarks</th></tr><tr><td style='text-align:justify'>"+remake_remarks+"</td></tr></table></div></div>";
                    installed_ac += "<tr class='i_row i_row_" + total + "'><td>" + val.brand_name + "&nbsp;("+val.actype+")"+ac_div+"&nbsp;&nbsp;<i onclick='show_ac_popup(\"i_row_" + total + "\");' style='font-size:1.3em' class='clip-popout cursor'></i></td>" +
                        "<td>" + install_type + "</td>" +
                        "<td>" + val.preferred_date + "</td>" +
                        "<td class='center'>" + val.no_of_service + "</td>" +
                        "<td class='center'>"+ac_remarks+"&nbsp;&nbsp;<a onclick='show_ac_remark_popup(\"i_row_" + total + "\");' class='big_icon btn'><i class='clip-bubble-dots-2'></i></a></td>" +
                        "<td class='center'>" + val.created_on + "</td><td  class='center'><span>"+val.assignment_status+"</span> </td>" +
                        "<td><button onclick='ViewAMC(\"install\","+val.install_id+")' class='btn btn-sm btn-info center'><i class='clip-info-2'></i></button> <button onclick='delete_service_type(\"installation\"," + val.install_id + "," + total + ")' class='btn btn-sm btn-danger'><i class='fa fa-trash-o'></i></button></td></tr>";
                    total++;
                });
                $(".installed_product").html(installed_ac);
            } else if (response.status == "no") {
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
                    <tr><th>AC Type</th><td>"+val.actype+"</td></tr>\
                    <tr><th>Make</th><td>" + val.brand_name + "</td></tr>\
                    <tr><th>Location</th><td>"+val.location+"</td></tr>\
                    <tr><th>Tonnage / HP</th><td>"+val.tonnage+"</td></tr>\
                    <tr><th>IDU</th><td>Serial No: "+val.idu_serial_no+"<br /> Model No :"+val.idu_model_no+"</td></tr>\
                    <tr><th>ODU</th><td>Serial No: "+val.odu_serial_no+"<br /> Model No :"+val.odu_model_no+"</td></tr>\
                    <tr><th>Remarks</th><td>"+val.remarks+"</td></tr></table></div></div>";
                    if(val.problem_desc==""){
                        remake_remarks = "<b class='text-danger'>No remarks added</b>";
                    }else{
                        remake_remarks = val.problem_desc;
                    }
                    var ac_remarks = "<div class='no-display ac_remark'><div style='background:#fff;padding: 20px;border-radius:5px;width: 400px;'><table class='table table-bordered table-striped'><tr><th class='center'>Remarks</th></tr><tr><td style='text-align:justify'>"+remake_remarks+"</td></tr></table></div></div>";
                    complaint_ac += "<tr class='c_row c_row_" + total + "'><td>" + val.brand_name+"&nbsp;("+val.actype+")&nbsp;" + ac_div+"&nbsp;&nbsp; <i onclick='show_ac_popup(\"c_row_" + total + "\");' style='font-size:1.3em' class='clip-popout cursor'></i></td>\
                    <td>" + val.ac_problem_type + "</td><td class='center'>" + ac_remarks + "&nbsp;&nbsp;<a onclick='show_ac_remark_popup(\"c_row_" + total + "\");' class='big_icon btn'><i class='clip-bubble-dots-2'></i></a></td>\
                    <td class='center'>" + val.created_on + "</td><td  class='center'><span>"+val.assignment_status+"</span> </td>\
                    <td><button class='btn btn-danger'  onclick='delete_service_type(\"complaints\"," + val.com_id + "," + total + ")'><i class='fa fa-trash-o' ></i></button></td></tr>";
                    total++;
                });
                $(".complaint_product").html(complaint_ac);
            } else if (response.status == "no") {
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

                        
                    
                    if (val.amc_type == "s") {
                        val.amc_type = "Semi-comprehensive"
                    } else if (val.amc_type == "n") {
                        val.amc_type = "Labour only"
                    } else if (val.amc_type == "c") {
                        val.amc_type = "Comprehensive"
                    }
                    var ac_div = "<div class='no-display ac_popup'><div class='' style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                    <tr><th>AC Type</th><td>"+mAC_Info.ac_type+"</td></tr>\
                    <tr><th>Make</th><td>" + mAC_Info.make + "</td></tr>\
                    <tr><th>Location</th><td>"+mAC_Info.location+"</td></tr>\
                    <tr><th>Tonnage / HP</th><td>"+mAC_Info.tonnage+"</td></tr>\
                    <tr><th>IDU</th><td>Serial No: "+mAC_Info.idu_serial_no+"<br /> Model No :"+mAC_Info.idu_model_no+"</td></tr>\
                    <tr><th>ODU</th><td>Serial No: "+mAC_Info.odu_serial_no+"<br /> Model No :"+mAC_Info.odu_model_no+"</td></tr>\
                    <tr><th>Remarks</th><td>"+mAC_Info.remarks+"</td></tr></table></div></div>";
                    if(val.remarks==""){
                        remake_remarks="<b class='text-danger'>No remakrs added</b>";
                    }else{
                        remake_remarks=val.remarks;
                    }
                    var ac_remarks = "<div class='no-display ac_remark'><div style='background:#fff;padding: 20px;border-radius:5px;width: 400px;'><table class='table table-bordered table-striped'><tr><th class='center'>Remarks</th></tr><tr><td style='text-align:justify'>"+remake_remarks+"</td></tr></table></div></div>";                    
                    amc_ac += "<tr class='a_row a_row_" + total + "'><td> "+mAC_Info.make+" ("+mAC_Info.location+")" +ac_div+ " <i onclick='show_ac_popup(\"a_row_" + total + "\");' style='font-size:1.3em' class='clip-popout cursor'></i></td><td>" + val.amc_type + "</td><td>" +
                        "<b>Dry: </b>" + val.dry + "<br /><b>Wet: </b>" + val.wet + "</td><td>" + val.activation + "</td><td>" + val.expiration + "</td><td>"+ac_remarks+"&nbsp;&nbsp; <a onclick='show_ac_remark_popup(\"a_row_" + total + "\");' class='big_icon btn'><i class='clip-bubble-dots-2'></i></td>\
                        <td><button onclick='ViewAMC(\"amc\","+val.amc_id+","+val.wet+","+val.dry+")' class='btn btn-info center'><i class='clip-info-2'> More</i></button></td>\
                        <td><button class='btn btn-danger' onclick='delete_service_type(\"amc\"," + val.amc_id + "," + total + ")'><i class='fa fa-trash-o'></i></button></td></tr>";
                    total++;
                    }
                    }
                });
                $(".amc_product").html(amc_ac);
            } else if (response.status == "no") {
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
                    <tr><th>AC Type</th><td>"+val.actype+"</td></tr>\
                    <tr><th>Make</th><td>" + val.brand_name + "</td></tr>\
                    <tr><th>Location</th><td>"+val.location+"</td></tr>\
                    <tr><th>Tonnage / HP</th><td>"+val.tonnage+"</td></tr>\
                    <tr><th>IDU</th><td>Serial No: "+val.idu_serial_no+"<br /> Model No :"+val.idu_model_no+"</td></tr>\
                    <tr><th>ODU</th><td>Serial No: "+val.odu_serial_no+"<br /> Model No :"+val.odu_model_no+"</td></tr>\
                    <tr><th>Remarks</th><td>"+val.remarks+"</td></tr></table></div></div>";
                    if(val.description==""){
                        remake_remarks="<b class='text-danger'>No remarks added</b>";
                    }else{
                        remake_remarks=val.description;
                    }
                    var ac_remarks = "<div class='no-display ac_remark'><div style='background:#fff;padding: 20px;border-radius:5px;width: 400px;'><table class='table table-bordered table-striped'><tr><th class='center'>Remarks</th></tr><tr><td style='text-align:justify'>"+remake_remarks+"</td></tr></table></div></div>";
                     
                    ots_ac += "<tr class='o_row o_row_" + total + "'><td>"+val.brand_name+"&nbsp;("+ val.actype+")"+ac_div+ "&nbsp;&nbsp;<i onclick='show_ac_popup(\"o_row_" + total + "\");' style='font-size:1.3em' class='clip-popout cursor'></i></td>\
                    <td>" + val.service_type + "</td><td>" + ac_remarks + "&nbsp;&nbsp;<a onclick='show_ac_remark_popup(\"o_row_" + total + "\");' class='big_icon btn'><i class='clip-bubble-dots-2'></i></a></td><td>" + val.created_on + "</td><td><span>"+val.assignment_status+"</span></td>\
                    <td><button class='btn btn-danger' onclick='delete_service_type(\"ots\"," + val.ots_id + "," + total + ")'><i class='fa fa-trash-o'></i></button></td></tr>";
                    total++;
                });
                $(".ots_product").html(ots_ac);
            } else if (response.status == "no") {
                ots_ac = "<tr class='empty_row'><td class='alert alert-info center' colspan='8'> <i class='clip-info'></i> No OTS is added yet</td></tr>";
                $(".ots_product").html(ots_ac);
            }
            unblockThisUI(".panel-body")
        });
    });
    

    $("#tab_services_request").on("click", function(){
    var customer_id;
    var customer_info = {};    
    var technician_dropdown;
    var inst_count = 0;
    var comp_count = 0;
    var amc_count = 0;
    var ots_count = 0;
    
    var ac_info_div = "<div class='no-display ac_popup'>\
                    <div class='' style='background:#fff;padding: 20px;'>\
                    <h2 class='center'> AC Informations</h2>\
                    <table class='table table-bordered table-striped'>\
                    <tr><th>AC Type</th><td>{type}</td></tr>\
                    <tr><th>Make</th><td>{make}</td></tr>\
                    <tr><th>Location</th><td>{location}</td></tr>\
                    <tr><th>Tonnage</th><td>{tonnage}</td></tr>\
                    <tr><th>IDU</th><td>Serial No: {idu_serial_no}<br /> Model No :{idu_model_no}</td></tr>\
                    <tr><th>ODU</th><td>Serial No: {odu_serial_no}<br /> Model No :{odu_model_no}</td></tr>\
                    <tr><th>Remarks</th><td>{remarks}</td></tr></table></div></div>";

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
                            if(val.install_remarks==""){val.install_remarks="<b class='text-danger'>No remarks added"}else{val.install_remarks=val.install_remarks}
                        install_tab_row += "<tr class='i_num_rows i_row_num_c_" + sr_no + "'><td>" + val.make + "&nbsp;(" + val.location + ") <i onclick='view_ac_info(\".ac_popup\")' class='clip-popout cursor' style='font-size:1.3em'></i>" + tmp_ac_div +
                            "</td><td> Installation </td><td>"+val.install_type+"</td>" +
                            "<td>" +  val.install_remarks + "</td><td>" + val.created_on + "</td><td><button onclick='assign_technician(" + sr_no + ",\"installation\"," + v.install_service_id + ",\"" + v.date + "\"," + val.ac_id+")' class='btn btn-primary btn-sm'>Assign</button></td></tr>"
                        notification++;
                        sr_no++;
                        }else{
                            if(v.remarks==""){v.remarks="<b class='text-danger'>No remarks added"}else{v.remarks=v.remarks}
                            install_tab_row += "<tr class='i_num_rows i_row_num_c_" + sr_no + "'><td>" + val.make + "&nbsp;(" + val.location + ") <i onclick='view_ac_info(\".ac_popup\")' class='clip-popout cursor' style='font-size:1.3em'></i>" + tmp_ac_div +
                            "</td><td> Service </td><td>-</td>" +
                            "<td>" + v.remarks + "</td><td>" + v.date + "</td><td><button onclick='assign_technician(" + sr_no + ",\"ins_service\"," + v.install_service_id + ",\"" + v.date + "\"," + val.ac_id+")' class='btn btn-primary btn-sm'>Assign</button></td></tr>";
                        notification++;
                        sr_no++;
                        }
                        inst_count = notification;

                        
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
                comp_count=0;
                } else {
                    delete customer_info.complaints.empty;
                    $.each(customer_info.complaints, function (key, val) {

                        var ac_div = "<div class='no-display ac_popup'><div style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                            <tr><th>AC Type</th><td>" + val.ac_type + "</td></tr>\
                            <tr><th>Make</th><td>" + val.make + "</td></tr>\
                            <tr><th>Location</th><td>" + val.location + "</td></tr>\
                            <tr><th>Tonnage</th><td>" + val.tonnage + "</td></tr>\
                            <tr><th>IDU</th><td>Serial No: " + val.idu_serial_no + "<br /> Model No :" + val.idu_model_no + "</td></tr>\
                            <tr><th>ODU</th><td>Serial No: " + val.odu_serial_no + "<br /> Model No :" + val.odu_model_no + "</td></tr>\
                            <tr><th>Remarks</th><th>" + val.remarks + "</td></tr></table></div></div>";
                        (val.problem_desc=="")?val.problem_desc="<b class='text-danger'>No Remarks added</b>":val.problem_desc=val.problem_desc;
                        complaint_tab_row += "<tr class='c_num_rows c_row_num_c_" + sr_no + "'><td>" + val.make + "&nbsp; (" + val.ac_type + ") <i onclick='view_ac_info(\".ac_popup\")' class='clip-popout cursor' style='font-size:1.3em'></i>" + ac_div + "</td><td>" + val.ac_problem_type + "</td>" +
                            "<td>" + val.problem_desc + "</td><td>" + val.created_on + "</td><td><button onclick='assign_technician(" + sr_no + ",\"complaint\"," + val.com_id + ",\"" + val.preferred_date + "\"," + val.ac_id+")' class='btn btn-primary btn-sm'>Assign</button></td></tr>";
                        notification++;
                        sr_no++;
                        comp_count = notification;
                    });
                }
                if (notification != 0) {
                    $("#Com_count").html(notification);
                }

                $("#at_complaint_table tbody").html(complaint_tab_row);
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

                    $.each(customer_info.amc, function (key, val) {

                        $.each(customer_info.amc[key].service_info, function (k, v) {

                            if (val.amc_type == "s") {
                                val.amc_type = "Semi-Comprehensive"
                            } else if (val.amc_type == "n") {
                                val.amc_type = "Labour only"
                            } else if (val.amc_type == "c") {
                                val.amc_type = "Comprehensive";
                            }

                            var ac_div = "<div class='no-display ac_popup'><div class='' style='background:#fff;padding: 20px;border-radius:5px;'>\
                    <h4 class='center'>AC Information</h4>\
                    <table class='table table-bordered table-striped'>\
                            <tr><th>AC Type</th><td>" + val.ac_type + "</td></tr>\
                            <tr><th>Make</th><td>" + val.make + "</td></tr>\
                            <tr><th>Location</th><td>" + val.location + "</td></tr>\
                            <tr><th>Tonnage</th><td>" + val.tonnage + "</td></tr>\
                            <tr><th>IDU</th><td>Serial No: " + val.idu_serial_no + "<br /> Model No :" + val.idu_model_no + "</td></tr>\
                            <tr><th>ODU</th><td>Serial No: " + val.odu_serial_no + "<br /> Model No :" + val.odu_model_no + "</td></tr>\
                            <tr><th>Remarks</th><td>" + val.remarks + "</td></tr></table></div></div>";

                            amc_tab_row += "<tr class='a_num_rows a_row_num_c_" + sr_no + "'><td>" + val.make + "&nbsp;(" + val.location + ") <i onclick='view_ac_info(\".ac_popup\")' class='clip-popout cursor' style='font-size:1.3em'></i>" + ac_div + "</td><td>" + val.amc_type + "</td><td><b>Dry : </b>" + val.dry + "<br /><b>Wet : </b>" + val.wet + "</td>\
                        <td>" + val.amc_remarks + "</td><td><b>Activation : </b>" + val.activation + "<br /><b>Expiration : " + val.expiration + "</b></td><td>" + v.date + "</td>\
                        <td><button onclick='assign_technician(" + sr_no + ",\"amc\"," + v.amc_service_id + ",\"" + v.date + "\"," + val.ac_id+")' class='btn btn-primary btn-sm'>Assign</button></td></tr>";
                            notification++;
                            sr_no++;
                            amc_count = notification;
                        });
                    });
                }
                if (notification != 0) {
                    $("#AMC_count").html(notification);
                }

                $("#at_amc_table tbody").html(amc_tab_row);


                var ots_tab_row;
                var notification = 0;
                var sr_no = 1;
                if (customer_info.ots.empty) {
                    ots_tab_row = "<tr><td colspan='6' class='alert alert-info center'><i class='clip-info'></i>&nbsp;&nbsp;No OTS Added Yet</td></tr>";
                } else {
                    delete customer_info.ots.empty;
                    var notification = 0;
                    var sr_no = 1

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
                        if(val.description==""){val.description="<b class='text-danger'>No Remarks Added</b>";}else{val.description=val.description;}
                        ots_tab_row += "<tr class='o_num_rows o_row_num_c_" + sr_no + "'><td>" + val.make + "<br />(" + val.ac_type + "," + val.location + ") <i onclick='view_ac_info(\".ac_popup\")' class='clip-popout cursor' style='font-size:1.3em'></i>" + ac_div + "</td><td>" + val.service_type + "</td><td>" + val.description + "</td>" +
                            "<td>" + val.created_on + "</td>" +
                            "<td><button onclick='assign_technician(" + sr_no + ",\"ots\"," + val.ots_id + ",\"" + val.preferred_date + "\"," + val.ac_id+")' class='btn btn-primary btn-sm'>Assign</button></td></tr>";
                        notification++;
                        sr_no++;
                        ots_count = notification;
                    });
                    if (notification != 0) {
                        $("#OTS_count").html(notification);
                    }
                }
                $("#at_ots_table tbody").html(ots_tab_row);

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

                                    $("#facebox #result").html("Added Successfully").removeClass().addClass("alert alert-success center").show();
                                    update_ac_variable();
                                    add_row_in_customer_details(dataval, response.last_id);
                                    setTimeout(function(){
                                    jQuery(document).trigger('close.facebox');
                                },1000);
                                
                                } else if (response.status == "no") {
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

        $(".empty_row").remove();
    }
    var tot_tr = $(".num_ac_rows").length;
    var total = tot_tr + 1;
    var ac_remarks = "<div class='ac_row_remark_popup' style='display:none'><div style='background:#fff;padding:20px;border-radius:5px'>\
                            <table class='table table-bordered table-striped'><tr><th class='center'><h4 class='center'>Remarks</h4></th></tr>\
                            <tr><td class='center'><span class='acrow_remarks'>"+qry.remarks+"</span></td></tr></table></div></div>";
    var new_row = "<tr class='num_ac_rows num_ac_rows_" + total + "'><td class='center'>" + qry.ac_type + "</td>\
    <td class='center'>" + qry.brand + "</td><td class='center'>" + qry.ton + "</td>\
    <td><b>Serial No.</b>" + qry.odu_sr_no + "<br/><b>Model No.</b>" + qry.odu_model_no + "</td>\
    <td>Serial No." + qry.odu_sr_no + "<br/>Model No." + qry.odu_model_no + "</td>\
    <td class='center'>" + qry.location + "</td><td class='center'><button class='btn btn-purple' onclick='display_remarks(\"ac_row_remark_popup\",\"num_ac_rows_"+total+"\")'><i class='fa fa-comment'></i></button>"+ac_remarks+"</td>\
    <td><button onclick='edit_ac("+type.ac_id+",\"num_ac_rows_"+total+"\")' class='btn btn-warning'><i class='fa fa-edit'></i></button><button class='btn btn-danger' onclick='delete_customer_ac(" + id + "," + total + ")'><i class='fa fa-trash-o'></i></button></td></tr>";
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
                    $(".num_ac_rows_" + row_id).slideUp("slow").remove();
                    if($(".customer_product_view tr").length==0){
                        $(".customer_product_view").html("<tr class='empty_row'><td class='alert alert-info center' colspan='8'> <i class='clip-info'></i> No AC Found</td></tr>")
                    }
                    $.getJSON("api/Customer/" + customer_id + "/AC", function (response) {
                        if (response.status == "ok") {

                        } else if (response.status == "no") {

                        }
                    });
                } else if (data.status == "no") {

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
                $("#result_install").show().html("Please wait...").removeClass().addClass("alert alert-info center");
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
                $("#result_complaints").show().html("Please wait...").removeClass().addClass("alert alert-info center");
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
                $("#result_amc").show().html("Please wait...").removeClass().addClass("alert alert-info center");
                $.ajax({
                    type: 'delete',
                    url: 'api/Customer/' + customer_id + '/AMC/' + id,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == "ok") {
                            $(".a_row_" + row_id).slideUp().remove();
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
                $("#result_ots").show().html("Please wait...").removeClass().addClass("alert alert-info center");
                $.ajax({
                    type: 'delete',
                    url: 'api/Customer/' + customer_id + '/OTS/' + id,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == "ok") {
                            $(".o_row_" + row_id).slideUp().remove();
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

function display_remarks(elem,val){
    var htm = $("."+val).find("."+elem).html();
    $.facebox(htm);
}

function ViewAMC(type,id,wet,dry){
    blockThisUI();
    $.getJSON("api/Customer/"+customer_id+"/Service/"+id+"/"+type,function(response){
        var tmp_row="";
        if(response.status=="ok"){

            var total=response.data.length;
            if(type=="amc"){
                $.each(response.data,function(key,val){
                tmp_row += "<tr class='bbb'><td><input type='hidden' class='amc_service_id' value='"+val.amc_service_id+"'>\
                <input type='text' class='amc_assign_required select_date form-control datepicker' value='"+val.date+"' data-date-format='dd-mm-yyyy' data-date-viewmode='years'></td><td><textarea class='give_remarks form-control amc_assign_required'>"+val.remarks+"</textarea></td></tr>";
            });
            }else{
                $.each(response.data,function(key,val){

                    if(val.type=="installation"){

                        tmp_row += "<tr ><th colspan='2'>Installation Date</th></tr><tr class='bbb'><td><input type='hidden' class='amc_service_id' value='"+val.install_service_id+"'>\
                <input type='text' class='amc_assign_required select_date form-control datepicker' value='"+val.date+"' data-date-format='dd-mm-yyyy' data-date-viewmode='years'></td><td><textarea class='give_remarks form-control amc_assign_required'>"+val.remarks+"</textarea></td></tr>";

                    }else{

                        tmp_row += "<tr ><th colspan=2>Service Date</th></tr><tr class='bbb'><td><input type='hidden' class='amc_service_id' value='"+val.install_service_id+"'>\
                <input type='text' class='amc_assign_required select_date form-control datepicker' value='"+val.date+"' data-date-format='dd-mm-yyyy' data-date-viewmode='years'></td><td><textarea class='give_remarks form-control amc_assign_required'>"+val.remarks+"</textarea></td></tr>";

                    }

            });
            }
            $("#service_date_table").html(tmp_row);

        }else if(response.status=="no"){

            for(var i=0;i<wet+dry;i++){
                tmp_row += "<tr class='bbb'><td><input type='text' class='amc_assign_required select_date form-control datepicker' data-date-format='dd-mm-yyyy' data-date-viewmode='years'></td><td><textarea class='give_remarks form-control amc_assign_required'></textarea></td></tr>";
            }
            $("#service_date_table").html(tmp_row);

        }
        $.facebox({ div: "#view_amc_modal" });
    unblockThisUI();
            
            $('#facebox .datepicker').each(function () {
                $(this).datepicker();
                autoclose: true;
            });
    $("#facebox .amc_assign_btn").on("click", function(){

        var c=0;
        var input_length = $("#facebox .amc_assign_required").length;

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

function addInstallation(){

    var elem = $("#facebox .modal-body");
    
        var selected_ac = elem.find(".select_ac_id").val();
        var ins_type = elem.find(".installation_type").val();
        var no_of_service = elem.find(".no_of_service").val();
        var ins_date = elem.find(".installation_date").val();
        var remarks = elem.find(".add_remarks").val();
        var output = elem.find(".display_output");
    output.html("").removeClass("alert alert-success alert-danger alert-info center");
        if (selected_ac != -1) {
            if (ins_type != -1 && no_of_service != "" && no_of_service > 0 && ins_date != "") {

                output.html("Please wait...<i class='clip-busy'></i>").addClass("alert alert-info center");
                $.ajax({
                    url: "api/Customer/" + customer_id + "/Installations",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        ac_id: selected_ac,
                        ins_type: ins_type,
                        no_of_service: no_of_service,
                        ins_date: ins_date,
                        remarks: remarks
                    },
                    success: function (response) {
                        if (response.status == "ok") {
                            output.html("Successfully Added").removeClass("alert-info alert-danger").addClass("alert-success center");
                            setTimeout(function () {
                                jQuery(document).trigger('close.facebox');
                            }, 1000);
                        } else if (response.status == "no") {
                            output.html(response.result + "").addClass("alert alert-danger center");
                        } else {
                            output.html("No Response from the server").addClass("alert alert-danger center");
                        }
                    }
                });
            } else {
                output.html("Required field missing").addClass("alert alert-danger center");
            }

        } else {
            output.html("Select AC for the installation").addClass("alert alert-danger center");

        }


}

function onUninstallACSelect() {

    var val='-1';
    val=$('#facebox .select_uninstalled_ac').val();


    var elem = $("#facebox .modal-body");

    if (val == -1) {
        elem.find(".select_ac_id").val("-1");
        elem.find('.display_ac_info_type').html("--N/A--");
        elem.find('.display_ac_info_make').html("--N/A--");
        elem.find('.display_ac_info_place').html("--N/A--");
        elem.find('.display_ac_info_tonnage').html("--N/A--");
        elem.find('.display_ac_info_idu_sr').html("--N/A--");
        elem.find('.display_ac_info_odu_sr').html("--N/A--");
        elem.find('.display_ac_info_idu_md').html("--N/A--");
        elem.find('.display_ac_info_odu_md').html("--N/A--");
    } else {
        elem.find(".select_ac_id").val(uninstalled_ac[val].ac_id);
        elem.find('.display_ac_info .display_ac_info_type').html(uninstalled_ac[val].actype);
        elem.find('.display_ac_info .display_ac_info_make').html(uninstalled_ac[val].brand_name);
        elem.find('.display_ac_info .display_ac_info_place').html(uninstalled_ac[val].location);
        elem.find('.display_ac_info .display_ac_info_tonnage').html(uninstalled_ac[val].tonnage);
        elem.find('.display_ac_info .display_ac_info_idu_sr').html(uninstalled_ac[val].idu_serial_no);
        elem.find('.display_ac_info .display_ac_info_odu_sr').html(uninstalled_ac[val].odu_serial_no);
        elem.find('.display_ac_info .display_ac_info_idu_md').html(uninstalled_ac[val].idu_model_no);
        elem.find('.display_ac_info .display_ac_info_odu_md').html(uninstalled_ac[val].odu_model_no);
    }

}

function assign_technician(serial, type, id, date,ac_id) {
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
                    var qry = "tech_id=" + assign_t_id + "&assign_date=" + assign_date + "&assign_remarks=" + assign_remarks + "&type=" + type + "&assign_of=" + id + "&cust_id=" + customer_id + "&ac_id=" + ac_id;

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
                                    $(".install_assign").html("<tr><td colspan='6' class='alert alert-info center'><i class='clip-info'></i> No installation assigned</td></tr>")
                                }
                                $("#facebox #result").show().html("Successfully Assigned").removeClass().addClass("alert alert-success center");
                                $("#Ins_count").html(parseInt($("#Ins_count").text()) - 1);
                                setTimeout(function () {
                                    jQuery(document).trigger('close.facebox');
                                }, 1000);
                            }
                            else if (data.status == "no") {
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
                    var qry = "tech_id=" + assign_t_id + "&assign_date=" + assign_date + "&assign_remarks=" + assign_remarks + "&type=" + type + "&assign_of=" + id + "&cust_id=" + customer_id+ "&ac_id=" + ac_id;

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
                    var qry = "tech_id=" + assign_t_id + "&assign_date=" + assign_date + "&assign_remarks=" + assign_remarks + "&type=" + type + "&assign_of=" + id + "&cust_id=" + customer_id+ "&ac_id=" + ac_id;

                    $("#facebox #result").show().html("Please wait...<i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");

                    $.ajax({
                        type: 'post',
                        url: 'api/Assign',
                        data: qry,
                        dataType: 'json',
                        success: function (data) {
                            if (data.status == "ok") {
                                $(".c_row_num_c_" + serial).remove();
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
                    var qry = "tech_id=" + assign_t_id + "&assign_date=" + assign_date + "&assign_remarks=" + assign_remarks + "&type=" + type + "&assign_of=" + id + "&cust_id=" + customer_id+ "&ac_id=" + ac_id;

                    $("#facebox #result").show().html("Please wait...<i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");
                    $.ajax({
                        type: 'post',
                        url: 'api/Assign',
                        data: qry,
                        dataType: 'json',
                        success: function (data) {
                            if (data.status == "ok") {
                                $(".a_row_num_c_" + serial).remove();
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
                    var qry = "tech_id=" + assign_t_id + "&assign_date=" + assign_date + "&assign_remarks=" + assign_remarks + "&type=" + type + "&assign_of=" + id + "&cust_id=" + customer_id+ "&ac_id=" + ac_id;

                    $("#facebox #result").show().html("Please wait...<i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");

                    $.ajax({
                        type: 'post',
                        url: 'api/Assign',
                        data: qry,
                        dataType: 'json',
                        success: function (data) {
                            if (data.status == "ok") {
                                $(".o_row_num_c_" + serial).remove();
                                if ($(".ots_assign tr").length == 0) {
                                    $(".ots_assign").html("<tr><td colspan='6' class='alert alert-info center'><i class='clip-info'></i> No OTS assigned</td></tr>")
                                }
                                $("#facebox #result").show().html("Successfully Assigned").removeClass().addClass("alert alert-success center");
                                $("#OTS_count").html(parseInt($("#OTS_count").text()) - 1);
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
        var c = 0;
        var input_length = $("#facebox .amc_assign_required").length;
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

function edit_ac(id,elem){
    blockThisUI(".panel-body");
    $("#product_result").removeClass().addClass("alert alert-info center").show();
    $.getJSON("api/Manage/AC/"+id+"/"+customer_id,function(response){
        if(response.status=="ok"){
            var acinfo = response.ac_info;
            var brand = response.brand;
            var ton = response.tonnage;
            var loc = response.location;
            var actype = response.ac_type;
            
            var make_drpdwn="";
            var ton_drpdwn="";
            var loc_drpdwn="";
            var actype_drpdwn="";
            if(brand.empty==false){
                delete brand.empty;
                $.each(brand,function(key,val){
                    if(acinfo.make==val.make){
                        make_drpdwn+="<option selected='selected' value='"+val.make_id+"'>"+val.make+"</option>";
                    }else{
                        make_drpdwn+="<option value='"+val.make_id+"|"+val.make+"'>"+val.make+"</option>";
                    }  
                });
            }else{
                make_drpdwn="<option value='-1'>Make not found</option>";
            }
            
            if(ton.empty==false){
                delete ton.empty;
                $.each(ton,function(key,val){
                    if(acinfo.capacity==val.tonnage_id){
                        ton_drpdwn+="<option selected='selected' value='"+val.tonnage_id+"|"+val.tonnage+"'>"+val.tonnage+"</option>";
                    }else{
                        ton_drpdwn+="<option value='"+val.tonnage_id+"|"+val.tonnage+"'>"+val.tonnage+"</option>";
                    }
                });
            }else{
                ton_drpdwn="<option value='-1'>Tonnage not found</option>";
            }
            
            if(loc.empty==false){
                delete loc.empty;
                $.each(loc,function(key,val){                        
                    if(acinfo.location==val.location){
                        loc_drpdwn+="<option selected='selected' value='"+val.ac_location_id+"|"+val.location+"'>"+val.location+"</option>";
                    }else{
                        loc_drpdwn+="<option value='"+val.ac_location_id+"|"+val.location+"'>"+val.location+"</option>";    
                    }
                });
            }else{
                loc_drpdwn="<option value='-1'>Location not found</option>";
            }
            
            if(actype.empty==false){
                delete actype.empty;
                $.each(actype,function(key,val){
                    if(acinfo.ac_type==val.ac_type){
                        actype_drpdwn+="<option selected='selected' value='"+val.ac_type_id+"|"+val.ac_type+"'>"+val.ac_type+"</option>";
                    }else{
                        actype_drpdwn+="<option value='"+val.ac_type_id+"|"+val.ac_type+"'>"+val.ac_type+"</option>";
                    }
                });
            }else{
                actype_drpdwn="<option value='-1'>AC Type not found</option>";
            }
            
            var htm = "<div style='padding:20px;border-radius:5px;background:#fff'>\
                        <h4>Edit Customer AC</h4>\
                        <table class='table table-bordered table-striped'>\
                        <tr><th>AC Type</th><td><select id='edit_actype' class='form-control edit_actype'></select></td></tr>\
                        <tr><th>Make</th><td><select id='edit_make' class='form-control edit_make'></select></td></tr>\
                        <tr><th>Tonnage / HP</th><td><select id='edit_tonnage' class='form-control edit_tonnage'></select></td></tr>\
                        <tr><th>Location</th><td><select id='edit_location' class='form-control edit_location'></select></td></tr>\
                        <tr><th>IDU serial number</th><td><input type='text' id='e_i_ser_n'  class='form-control e_i_ser_n' /></td></tr>\
                        <tr><th>IDU model number</th><td><input type='text'  id='e_i_mod_n' class='form-control e_i_mod_n' /></td></tr>\
                        <tr><th>ODU serial number</th><td><input type='text' id='e_o_ser_n' class='form-control e_o_ser_n' /></td></tr>\
                        <tr><th>ODU model number</th><td><input type='text' id='e_o_mod_n' class='form-control e_o_mod_n' /></td></tr>\
                        <tr><th>Remarks</th><td><textarea id='edit_remarks' class='form-control edit_remarks'></textarea></td></tr>\
                        <tr><th><input type='button' class='btn btn-primary edit_ac_update_btn' onclick='edit_ac_info("+id+",\""+elem+"\")' value='Update'/></th><td><div id='result'></div></td></tr>\
                        </table></div></div>";
                        
            $.facebox(htm);
            $("#facebox #edit_actype").html(actype_drpdwn);
            $("#facebox #edit_make").html(make_drpdwn);
            $("#facebox #edit_tonnage").html(ton_drpdwn);
            $("#facebox #edit_location").html(loc_drpdwn);
            $("#facebox #e_i_ser_n").val(acinfo.idu_serial_no);
            $("#facebox #e_i_mod_n").val(acinfo.idu_model_no);
            $("#facebox #e_o_ser_n").val(acinfo.odu_serial_no);
            $("#facebox #e_o_mod_n").val(acinfo.odu_model_no);
            $("#facebox #edit_remarks").val(acinfo.remarks);
        }else if(response.status=="no"){
            $.facebox("Error in loading AC information. Please delete the AC and ADD it again");
        }
        $("#product_result").hide();
        unblockThisUI(".panel-body");
    });
    
}

function edit_ac_info(id,elem){
    var ac_type = $("#facebox .edit_actype").val().split("|")[0];
    var make = $("#facebox .edit_make").val().split("|")[0];
    var ton = $("#facebox .edit_tonnage").val().split("|")[0];
    var loc = $("#facebox .edit_location").val().split("|")[0];
    var i_serial = $("#facebox .e_i_ser_n").val();
    var i_model = $("#facebox .e_i_mod_n").val();
    var o_serial = $("#facebox .e_o_ser_n").val();
    var o_model = $("#facebox .e_o_mod_n").val();
    var remarks = $("#facebox .edit_remarks").val();
    $("#facebox #result").html("Please wait").removeClass().addClass("alert alert-info center").show();
    $("#facebox .edit_ac_update_btn").val("Please wait...");
    $.ajax({
        type:'put',
        url:'api/Customer/'+customer_id+'/AC/'+id,
        data:{ac_type:ac_type,make:make,ton:ton,loc:loc,i_serial:i_serial,i_model:i_model,o_serial:o_serial,o_model:o_model,remarks:remarks},
        dataType:'json',
        success: function(response){
            console.log(response.status);
            if(response.status=="ok"){
                $("#facebox #result").html(response.result).removeClass().addClass("alert alert-success center").show();
                $("."+elem).find(".acrow_actype").html($("#facebox .edit_actype").val().split("|")[1]);
                $("."+elem).find(".acrow_make").html($("#facebox .edit_make").val().split("|")[1]);
                $("."+elem).find(".acrow_ton").html($("#facebox .edit_tonnage").val().split("|")[1]);
                $("."+elem).find(".o_mod").html(o_model);
                $("."+elem).find(".o_ser").html(o_serial);
                $("."+elem).find(".i_mod").html(i_model);
                $("."+elem).find(".i_ser").html(i_serial);
                $("."+elem).find(".acrow_loc").html($("#facebox .edit_location").val().split("|")[1]);
                $("."+elem).find(".acrow_remarks").html(remarks);
            }else if(response.status=="no"){
                $("#facebox #result").html(response.result).removeClass().addClass("alert alert-danger center").show();
            }
            $("#facebox .edit_ac_update_btn").val("Update");
        }
    });
    
}