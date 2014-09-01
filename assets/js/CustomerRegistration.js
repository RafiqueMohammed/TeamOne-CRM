$(document).ready(function () {

    $("#registration_dob").datepicker({
        autoclose: true
    });

    $('#registration_submit').on('click', function (e) {
        e.preventDefault();
        
        var type = $("input[name=acc_type]:checked").val();
        var org_name = $("textarea[name=org_name]").val();
        var fname = $("input[name=firstname]").val();
        var lname = $("input[name=lastname]").val();
        var mobile1 = $("input[name=mobile1]");
        var mobile2 = $("input[name=mobile2]").val();
        var email = $("input[name=email]").val();
        var landline = $("input[name=landline]").val();
        var address = $("textarea[name=address]").val();
        var alt_contact = $("textarea[name=alternate_contact]").val();
        var pincode = $("input[name=pincode]").val();
        var city = $("input[name=city]").val();
        var landmark = $("select[name=landmark]").val();
        var location = $("input[name=location]").val();
        var communication_type = $("input[name=communication_type]").val();
        var referred_by = $("select[name=referred]").val();
        var reffered_other = $("input[name=referred_other]").val();
        var dob = $("input[name=dob]").val();
        var remarks = $("textarea[name=remarks]").val();
        var registration = "registration";
        var input_length = $(".req").length;

        var c = 0;

        if(type=="c"){

            $("textarea[name=org_name]").addClass("req");
        }else{
            $("textarea[name=org_name]").removeClass("req");
            $("textarea[name=org_name]").parent().removeClass("has-error");
        }

        for (var i = 0; i < input_length; i++) {
            if ($('.req').eq(i).val() == "" || $('.req').eq(i).val() == "-1") {
                $('.req').eq(i).parent().removeClass("has-success").addClass("has-error");
                c++;
            } else {
                $('.req').eq(i).parent().removeClass("has-error");

            }
        }
        if (mobile1.val().length != 10) {
            mobile1.parent().removeClass("has-success").addClass("has-error");
            mobile1.parent().parent().find(".error_span").addClass("text-danger").html("Invalid Mobile Number");
            c++;
        } else {
            mobile1.parent().removeClass("has-error");
            mobile1.parent().parent().find(".error_span").empty();

        }

        if (c > 0) {
           $("#validation_error").html("please fill the required fields").removeClass().addClass("alert alert-danger");
        } else {

            $("#validation_error").hide();
            /* SEND INFO*/
            mobile1 = $("input[name=mobile1]").val();

            var query = 'acc_type=' + type + '&org_name=' + org_name + '&firstname=' + fname + '&lastname=' + lname + '&mobile1=' + mobile1 + '&mobile2=' + mobile2 + '&email=' + email + '&landline=' + landline +
                '&address=' + address + '&alternate_contact=' + alt_contact + '&pincode=' + pincode + '&city=' + city + '&landmark=' + landmark + '&location=' + location + '&communication_type=' + communication_type + '&referred_by=' + referred_by + '&reffered_other=' + reffered_other + '&dob=' + dob + '&remarks=' + remarks + '&registration=' + registration;
            $('#registration_submit').html("<i class='clip-busy'></i>  Please wait..");
            $.ajax({
                type: 'post',
                url: 'api/Customer',
                data: query,
                dataType: 'JSON',
                success: function (data) {
                    var modal_box = $("#registration_modal_box");
                    var title = modal_box.find(".modal-title");
                    var modal_body = modal_box.find(".modal-body");
                    if (data.status == "ok") {


                        title.html("Account Created Successfully").removeClass("text-error").addClass("text-success");
                        modal_body.html("<div><span class='pull-left'>Would you like to add AC next? </span>\
                            <span class='pull-right'><button data-dismiss='modal' class='btn btn-primary' onclick='showCustomerACProduct(true);' type='button'>Yes</button>\
                            &nbsp; <button data-dismiss='modal' class='btn btn-default' onclick='LoadPage(\"CustomerRegistration\");'  type='button'>No</button></span></div><div class='clearfix'></div>");

                        var cust_id = data.customer_id;
                        if (cust_id != null || cust_id !== "") {
                            $(".step-2").find("#customer_new_id").val(cust_id);
                        }


                    } else if (data.status == "no") {
                        title.html("Unable to create account").removeClass("text-success").addClass("text-error");
                        modal_body.html("<div><span class='pull-left'>" + data.result + " </span><span class='pull-right'>\
                            &nbsp; <button data-dismiss='modal' class='btn btn-default' type='button'>Close</button></span></div>\
                            <div class='clearfix'></div>");
                    }
                    $('#registration_submit').html("<i class='clip-plus-circle-2'></i>  Create Account");
                    modal_box.modal("show");
                }

            });

        }
    });

    $("#customer_ac_details_submit").click(function () {
        
        var input_length = $(".ac_req").length;
        console.log(input_length);
        var c = 0;
        for (var i = 0; i < input_length; i++) {
            if ($('.ac_req').eq(i).val() == "" || $('.ac_req').eq(i).val() == "-1") {
                $('.ac_req').eq(i).parent().removeClass("has-success").addClass("has-error");
                c++;
            } else {
                $('.ac_req').eq(i).parent().removeClass("has-error");

            }
        }
        
        if( c > 0){
            console.log(c);
            $("#error_result").html("Please fill the required fields").removeClass().addClass("alert alert-danger").show();
        }else{
            $("#error_result").hide();
        

        var rows = $(".customer_ac_row").length;

        var qry = "", make = "", ton = "", model_no = "", idu_no = "", odu_no = "", location = "", remarks = "";

        for (var i = 0; i < rows; i++) {
            qry += "&row[" + i + "][ac_type]=" + $(".customer_ac_row").eq(i).find(".ac_type").val();
            qry += "&row[" + i + "][make]=" + $(".customer_ac_row").eq(i).find(".brand_name").val();
            qry += "&row[" + i + "][ton]=" + $(".customer_ac_row").eq(i).find(".ton_capacity").val();
            //qry += "&row[" + i + "][model_no]=" + $(".customer_ac_row").eq(i).find(".model_no").val();
            qry += "&row[" + i + "][idu_model_no]=" + $(".customer_ac_row").eq(i).find(".idu_model_no").val();
            qry += "&row[" + i + "][idu_serial_no]=" + $(".customer_ac_row").eq(i).find(".idu_serial_no").val();
            qry += "&row[" + i + "][odu_model_no]=" + $(".customer_ac_row").eq(i).find(".odu_model_no").val();
            qry += "&row[" + i + "][odu_serial_no]=" + $(".customer_ac_row").eq(i).find(".odu_serial_no").val();
            qry += "&row[" + i + "][location]=" + $(".customer_ac_row").eq(i).find(".location").val();
            qry += "&row[" + i + "][remarks]=" + $(".customer_ac_row").eq(i).find(".remarks").val();

        }


        var cust_id = $(".step-2").find("#customer_new_id").val();
        if (cust_id != -1 || cust_id != "") {


            var modal_box = $("#registration_modal_box");
            var title = modal_box.find(".modal-title");
            var modal_body = modal_box.find(".modal-body");
            $("#customer_ac_details_submit").attr("value", "Please Wait..");
            $.ajax({
                    type: 'post',
                    url: 'api/Customer/' + cust_id + '/AC',
                    data: qry,
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.status == "ok") {
                            title.html("Success").removeClass("text-error").addClass("text-success");
                            modal_body.html("<div><span class='pull-left'> What would you like to do next? </span><span class='pull-right'>\
                            &nbsp; <button data-dismiss='modal' onclick='LoadPage(\"CustomerRegistration\");' class='btn btn-primary' type='button'>Add Customer</button>\
                                &nbsp; <button data-dismiss='modal' onclick='LoadPage(\"CustomerDetails?id="+cust_id+"\");' class='btn btn-info' type='button'>View Info</button>\
                       </span></div>   <div class='clearfix'></div>");


                        } else if (data.status == "no") {
                            title.html("Error occured while adding").removeClass("text-success").addClass("text-error");
                            modal_body.html("<div><span class='pull-left'>" + data.result + " </span><span class='pull-right'>\
                            &nbsp; <button data-dismiss='modal' class='btn btn-default' type='button'>Close</button></span></div>\
                            <div class='clearfix'></div>");
                        }

                        modal_box.modal("show");
                        $("#customer_ac_details_submit").attr("value", "Submit");
                    }
                });
                
        } else {
            alert("Customer ID is not defined. Please reload the page");
            console.log("Customer ID not found");
            $("#customer_ac_details_submit").attr("value", "Submit");
        }
        }
    });


    $("#registration_pincode").keyup(function () {
        var pincode = $('#registration_pincode').val();
        if (pincode.length > 3) {
            $.post("controller/GetPincode.php", {type: "pincode", pincode: pincode}, function (data) {
                $("#pincode_display").html(data).show();
            });
        }
    });

    $("#registration_referred").on('change', function () {
        var value = $(this).val();
        if (value == "exist_cust" || value == "other") {
            //console.log("SHOW:"+value);
            $("#registration_referred_other").show().addClass("req");
        } else {
            //console.log("HIDE:"+value);
            $("#registration_referred_other").hide().removeClass("req");
        }

    });
    
    
});

function fire_check(){
    console.log("i checked");
}

function add_customer_ac_row() {

    var row_no = $("#customer_ac_body tr").length;
    if (row_no == 0) {
        row_no = 1;
    } else {
        row_no++;
    }

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
                        brand_tmp_opt += "<option value=" + value.make_id + ">" + value.make + "</option>"
                    });

                }

                if (ton_empty) {

                } else {
                    delete response.tonnage.empty;
                    var ton_tmp_opt = "<option value='-1'>--SELECT--</option>";
                    $.each(response.tonnage, function (key, value) {
                        ton_tmp_opt += "<option value=" + value.tonnage_id + ">" + value.tonnage + "</option>"
                    });

                }

                if (location_empty) {

                } else {
                    delete response.location.empty;
                    var loc_tmp_opt = "<option value='-1'>--SELECT--</option>";
                    $.each(response.location, function (key, value) {
                        loc_tmp_opt += "<option value=" + value.ac_location_id + ">" + value.location + "</option>"
                    });

                }

                if (ac_type_empty) {

                } else {
                    delete response.ac_type.empty;
                    var type_tmp_opt = "<option value='-1'>--SELECT--</option>";
                    $.each(response.ac_type, function (key, value) {
                        type_tmp_opt += "<option value=" + value.ac_type_id + ">" + value.ac_type + "</option>"
                    });

                }

                var html_row = "<tr id='customer_ac_row_" + row_no + "' class='customer_ac_row'>\
                 <td><select class='form-control ac_req ac_type' name='product_type' class='product_type'>" + type_tmp_opt +"</select></td> \
                 <td><select class='form-control ac_req brand_name' name='brand_name'>" + brand_tmp_opt + "</select>   </td>\
                 <td><select name='capacity' class='form-control ac_req ton_capacity'>" + ton_tmp_opt + "</select>   </td>\
                 <td><b><small>IDU Model No</small></b><br><input type='text' name='idu_no' placeholder='IDU Model Number' class='idu_model_no'><br/>\
                 <b><small>IDU Serial No</small></b><br><input type='text' name='idu_no' placeholder='IDU Serial Number' class='idu_serial_no'></td>\
                 <td><b><small>ODU Model No</small></b><br><input type='text' placeholder='ODU Model Number' name='odu_no' class='odu_model_no'><br/>\
                 <b><small>ODU Serial No</small></b><br><input type='text' name='odu_no' placeholder='ODU Serial Number' class='odu_serial_no'></td>\
                 <td><select class='form-control ac_req location' name='location'>" + loc_tmp_opt + "</select></td>\
                 <td><textarea name='remarks' class='form-control remarks'></textarea></td>\
                 <td><span style='cursor:pointer' onclick='delete_cust_ac_row(\"#customer_ac_row_"+row_no+"\")'  class='badge badge-danger'><i class='fa fa-minus'></i></span></td></tr>";

                $("#customer_ac_body").append(html_row);

            }
        }
    });
 }

function showCustomerACProduct(show) {
    if (show) {
        $(".step-1").slideUp("slow");
        setTimeout(function () {
            add_customer_ac_row();
            $('.step-2').slideDown("slow");
        }, 500);
    } else {
        $(".step-2").slideUp("slow");
        setTimeout(function () {
            $('.step-1').slideDown("slow");
        }, 500);
    }
}


function fill_locality(Value) {
    $('#registration_pincode').val(Value);
    $('#pincode_display').hide();
    var pin = $("#registration_pincode").val();
    $('#registration_landmark').html("<option value='-1'> Please wait.. </option>");
    $.ajax({
        type: "GET",
        url: "api/Manage/pincode/" + pin,
        dataType: "JSON",
        success: function (data) {
            if (data.status == "ok") {
                delete data.status;
                var opt = "";
                $.each(data, function (key, loc) {
                    opt += "<option value='" + loc.locality + "'>" + loc.locality + "</option>";
                });
                $('#registration_landmark').html(opt);
            } else if (data.status == "no") {
                $('#registration_landmark').html("<option value='-1'>- Not Available -</option>");
            }
        }
    });

}

function delete_cust_ac_row(parent) {
    //console.log(parent);
    $(parent).slideUp("slow").remove();
}