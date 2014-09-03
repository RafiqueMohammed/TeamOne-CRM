    var tech_data={};
    var branch_list={};
    
    var tech_data_count = 0;    

$(function(){

    blockThisUI($(".technician_list"));
    $.getJSON("api/Technicians",function(response){
        if(response.status=="ok"){
            tech_data = response.data;
            if(response.branch_list.empty){
                branch_list={0:"No Branch List Found"};
            }else{
                branch_list=response.branch_list;
            }
            
            var total=1;
            var tech_list_tr ="";
            if(response.status=="ok") {
                delete response.status;
                var i=1;
                $.each(response.data, function(key,type){
                    //console.log(type.first_name+" "+type.last_name+" ");
                    tech_list_tr += "<tr class='tech_row tech_row_"+i+"'><td>"+type.first_name+" "+type.last_name+"</td>\
                    <td>"+type.mobile+"</td><td>"+type.email+"</td>\
                    <td>"+type.address+"</td>\
                    <td>"+type.branch_name+"</td>\
                    <td class='center'><i style='cursor:pointer; font-size:1em' onclick='edit_technician("+key+")' class='clip-pencil '></i>&nbsp;&nbsp;\
                    <i class='clip-user-minus' onclick='remove_technician("+type.tech_id+","+i+")' style='cursor:pointer; font-size:1em'></i></td></tr>";
               i++;
               tech_data_count++;
                });
            } else {
                tech_list_tr = "<tr><td class='alert alert-info center' colspan='7'> <i class='clip-info'></i> " + data.tech_data.result + "</td></tr>";
            }
            $("#tech_details tbody").prepend(tech_list_tr);
        } else {
            $("#tech_details tbody").html("<tr><td colspan='6' class='alert alert-info center'> <i class='clip-info'></i>  - No Technician Added Yet -</td></tr>");
            console.log("failure");
        }
        unblockThisUI($(".technician_list"));
    });

    
    $("#add_technician").on("click", function(){
        $.facebox({ div: "#modal_add_tech" })
            
    $("#facebox .tech_register").on("click ", function(){

        var mobile = $("#facebox input[name='tech_mobile']");
        var firstname = $("#facebox input[name='tech_fname']").val();
        var lastname = $("#facebox input[name='tech_lname']").val();
        var email = $("#facebox input[name='tech_email']").val();
        var branch = $("#facebox select[name='tech_branch']").val();
        var address = $("#facebox textarea[name='tech_address']").val();
        
        var total_req = $("#facebox .tech_req").length;
        var c=0;

        for(var i=0 ; i < total_req ; i++){
            if($("#facebox .tech_req").eq(i).val()=="" || $("#facebox .tech_req").eq(i).val()=="-1"){
                $("#facebox .tech_req").eq(i).parent().removeClass("has-success").addClass("has-error");
                c++;
            } else {
                $("#facebox .tech_req").eq(i).parent().removeClass("has-error");
            }
        }

        if (mobile.val().length != 10) {
            mobile.parent().removeClass("has-success").addClass("has-error");
            mobile.parent().parent().find(".error_span").addClass("text-danger").html("Invalid Mobile Number");
            c++;
        } else {
            mobile.parent().removeClass("has-error");
            mobile.parent().parent().find(".error_span").empty();
        }

        if(c > 0){
            $("#facebox #error").html("Please fill the required fields").removeClass().addClass("alert alert-danger center");
        } else {
            $("#facebox #error").removeClass().empty();

            var mobile = $("#facebox input[name='tech_mobile']").val();
            var query = {firstname:firstname,lastname:lastname,email:email,mobile:mobile,branch:branch,address:address};
            $("#facebox #result").show().html("Please wait...<i class='clip-busy'></i>").addClass("alert alert-info center")
            $.ajax({
                type:'post',
                url:'api/Technicians',
                data:query,
                dataType:'json',
                success: function(data){
                    if(data.status=="ok") {
                        $("#facebox #result").show().html(data.result).removeClass().addClass("alert alert-success center").slideUp(3000);
                        //$("#technician_form")[0].reset();
                        //add_technician_row(data.last_id,query);
                        window.location.replace("Technicians");                        
                    } else {
                        $("#facebox #result").show().html(data.result).removeClass().addClass("alert alert-danger center").slideUp(3000);
                    }
                }
            });
        }
    });
    

    })
        
});

function add_technician_row(tech_id,qry) {

    var a = $(".tech_row").length;
    var total = a + 1;
    var row = "<tr class='tech_row tech_row_"+total+"'><td>"+qry.firstname+" "+qry.lastname+"</td>\
    <td>"+qry.mobile+"</td><td>"+qry.email+"</td><td>"+qry.address+"</td><td>"+qry.branch+"</td>\
    <td class='center'><i style='cursor:pointer; font-size:1em' onclick='edit_technician("+tech_id+")' class='clip-pencil '></i>&nbsp;&nbsp;\
    <i class='clip-user-minus' onclick='remove_technician("+tech_id+","+total+")' style='cursor:pointer; font-size:1em'></i></td></tr>";
    $("#tech_details tbody").prepend(row);    
}

function remove_technician(tech_id,elem) {
    var answer = confirm("Are you sure you want to delete this technician ?");
    if(answer){
    $("#tech_response_result").show().html("Please Wait...").removeClass().addClass("alert alert-info center");
    $.ajax({
        type:'delete',
        url:'api/Technicians/'+tech_id,
        dataType:'json',
        success: function(data) {
            if(data.status=="ok") {
                $(".tech_row_"+elem).slideUp("slow").remove();
                $("#tech_response_result").show().html("Deleted Successfully").removeClass().addClass("alert alert-success center");
                if($(".tech_row_c tr").length==0){
                    $(".tech_row_c").html("<tr><td class='alert alert-info center' colspan='6'><i class='clip-info'></i>  No Technician Found</td></tr>");
                }
            } else if(data.status=="no") {
                    $("#tech_response_result").show().html(data.result).removeClass().addClass("alert alert-danger center");
            }
            setTimeout(function(){
                $("#tech_response_result") .slideUp();
            },1000);
        }
    });        
    }

}

function edit_technician(tech_id) {

$.facebox({ div: "#modal_edit_tech" });  

delete branch_list.empty;
var branch_list_opt="";
$.each(branch_list, function(key, val){
    if(tech_data[tech_id].branch_name=val.branch_name){
    branch_list_opt+="<option value='"+val.branch_id+"'>"+val.branch_name+"</option>";
    } 
});

        $('#facebox .display_tech_fname').val(tech_data[tech_id].first_name);
        $('#facebox .display_tech_lname').val(tech_data[tech_id].last_name);
        $('#facebox .display_tech_mobile').val(tech_data[tech_id].mobile);
        $('#facebox .display_tech_email').val(tech_data[tech_id].email);
        $('#facebox .display_tech_address').val(tech_data[tech_id].address);
        $('#facebox .display_tech_branch').html(branch_list_opt);
        $("#facebox .display_tech_branch option[value='" + tech_data[tech_id].branch_id + "']").attr("selected", "selected");
        $('#facebox .display_tech_id').val(tech_data[tech_id].tech_id);         

    
    $("#facebox .tech_update_btn").on("click",function() {
        var fname = $("#facebox #fname_edit").val();
        var lname = $("#facebox #lname_edit").val();
        var mobile = $("#facebox #mobile_edit");
        var email = $("#facebox #email_edit").val();
        var address = $("#facebox #address_edit").val();
        var branch = $("#facebox #branch_edit").val();
        var id = $("#facebox #id_edit").val();
        
        var total_req = $("#facebox .req_t").length;
        var c=0;

        for(var i=0 ; i < total_req ; i++){
            if($("#facebox .req_t").eq(i).val()=="" || $("#facebox .req_t").eq(i).val()=="-1"){
                $("#facebox .req_t").eq(i).parent().removeClass("has-success").addClass("has-error");
                c++;
            } else {
                $("#facebox .req_t").eq(i).parent().removeClass("has-error");
            }
        }
        
        if (mobile.val().length != 10) {
            mobile.parent().removeClass("has-success").addClass("has-error");
            mobile.parent().parent().find(".error_span").addClass("text-danger").html("Invalid Mobile Number");
            c++;
        } else {
            mobile.parent().removeClass("has-error");
            mobile.parent().parent().find(".error_span").empty();
        }        
                
        if(c > 0){
            $("#facebox #error").html("Please fill the required fields").removeClass().addClass("alert alert-danger center");
        }else{
            $("#facebox #error").remove();
        mobile = $("#facebox #mobile_edit").val();
        var query = "firstname="+fname+"&lastname="+lname+"&mobile="+mobile+"&email="+email+"&address="+address+"&branch="+branch;
        $("#facebox #result").show().html("Please wait...<i class='clip-busy'></i>").addClass("alert alert-info center")
            $.ajax({
                type:"put",
                data:query,
                dataType:'json',
                url:'api/Technicians/'+id,
                success: function(data) {
                    if(data.status=="ok"){
                        console.log("success");
                        $("#facebox #result").show().html(data.result).addClass("alert alert-success center")
                        window.location.replace("Technicians"); 
                    } else if(data.status=="no"){
                        console.log("error");
                        $("#facebox #result").show().html(data.result).addClass("alert alert-danger center")
                    }
                }
            });
        } 

    });
        

          
 }

function reset_form(form_id) {
 
    $(form_id)[0].reset();
 }

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}