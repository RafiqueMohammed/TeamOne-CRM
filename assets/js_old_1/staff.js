var staff_data={};
var branch_list={};

var staff_data_count = 0;

$(function(){
    blockThisUI($('.staff_list'));
        $.getJSON("api/Staff",function(response){
            if(response.status=="ok") {
                staff_data = response.data;
                if(response.branch_list.empty){
                    branch_list={0:"No Branch List Found"};
                }else{
                    branch_list=response.branch_list;
                }                
                var total=1;
                var tech_list_tr ="";
                    delete response.status;
                    var i=1;
                    $.each(response.data, function(key,type){
                        //console.log(type.first_name+" "+type.last_name+" ");
                        tech_list_tr += "<tr class='staff_row staff_row_"+i+"'><td>"+type.first_name+" "+type.last_name+"</td>\
                        <td>"+type.mobile+"</td><td>"+type.email+"</td>\
                        <td>"+type.address+"</td>\
                        <td>"+type.branch_name+"</td>\
                        <td class='center'><i style='cursor:pointer; font-size:1em' onclick='edit_staff("+key+")' class='clip-pencil '></i>&nbsp;&nbsp;\
                        <i class='clip-user-minus' onclick='remove_staff("+type.staff_id+","+i+")' style='cursor:pointer; font-size:1em'></i></td></tr>";
                   i++;
                   staff_data_count++;
                    });
                    $("#staff_details tbody").prepend(tech_list_tr);
            } else if(response.status=="no"){
                tech_list_tr = "<tr><td class='alert alert-info center' colspan='7'> <i class='clip-info'></i> " + response.result + "</td></tr>";
            $("#staff_details tbody").prepend(tech_list_tr);
            }
            unblockThisUI($('.staff_list'));

        });
        
        $("#add_staff").on("click", function(){
            
        $.facebox({ div: "#modal_add_staff" })

        
    $("#facebox #staff_register").on("click", function(){

        var fname = $("#facebox input[name='fname']").val();
        var lname = $("#facebox input[name='lname']").val();
        var mobile = $("#facebox input[name='mobile']");
        var email = $("#facebox input[name='email']").val();
        var address = $("#facebox textarea[name='address']").val();
        var branch = $("#facebox select[name='staff_branch']").val().split("|");   
             
        var total_req = $("#facebox .staff_req").length;
        console.log(total_req);
        
        var c = 0;
        for(var i=0; i< total_req; i++){
        if($("#facebox .staff_req").eq(i).val()=="" || $("#facebox .staff_req").eq(i).val()==-1){
            $("#facebox .staff_req").eq(i).parent().removeClass("has-success").addClass("has-error");
            c++;
        }else{
            $("#facebox .staff_req").eq(i).parent().removeClass("has-error");
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
        
        if(c > 0) {
            console.log(c);
            $("#facebox #error").html("Please fill the required fields").removeClass().addClass("alert alert-danger center");
        } else {
            $("#facebox #error").remove();
            var mobile = $("#facebox input[name='mobile']").val();
            var query = {staff:"staff",fname:fname,lname:lname,mobile:mobile,email:email,address:address,branch:branch[1]};
            var qry = "fname="+fname+"&lname="+lname+"&mobile="+mobile+"&email="+email+"&address="+address+"&branch="+branch[0];
            
            $("#facebox #result").show().html("Please wait... <i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");
            $.ajax({
                type:'post',
                url:'api/Staff',
                data:qry,
                dataType:'json',
                success: function(data){
                    if(data.status=="ok"){
                        console.log("succes");
                        $("#facebox #result").show().html(data.result).removeClass().addClass("alert alert-success center").fadeOut(3000);
                        window.location.replace("Staff");
                        //add_staff_row(data.last_id,query);
                    } else if(data.status=="no") {
                        console.log("failure");
                        $("#facebox #result").show().html(data.result).removeClass().addClass("alert alert-danger center").fadeOut(3000);
                    }
                }
            });
        }
    });
        });    
});

function add_staff_row(staff_id,qry){
    
    var row_lenght=$(".staff_row").length;
    var i=row_lenght+1;
    var row = "<tr class='staff_row staff_row_"+i+"'><td>"+qry.fname+" "+qry.lname+"</td>\
    <td>"+qry.mobile+"</td><td>"+qry.email+"</td><td>"+qry.address+"</td><td>"+qry.branch+"</td>\
    <td class='center'><i style='cursor:pointer; font-size:1em' onclick='edit_staff()' class='clip-pencil '></i>&nbsp;&nbsp;\
    <i class='clip-user-minus' onclick='remove_staff()' style='cursor:pointer; font-size:1em'></i></td></tr>";
    $("#staff_details").prepend(row);
}

function remove_staff(staff_id,row_id) {
    var answer=confirm("Are you sure..?");
    if(answer){
    $("#staff_response_result").show().html("Please wait...").removeClass().addClass("alert alert-info center");
    $.ajax({
        type:'DELETE',
        url:'api/Staff/'+staff_id,
        success: function(data){
            if(data.status=="ok"){
                $(".staff_row_"+row_id).slideUp().remove();
                $("#staff_response_result").show().html("Deleted Successfully").removeClass().addClass("alert alert-success center");
                if($(".staff_row_c tr").length==0){
                    $(".staff_row_c").html("<tr><td class='alert alert-info center' colspan='6'><i class='clip-info'></i>  No Staff Found</td></tr>");
                }
            } else if(data.status=="no") {
                $("#staff_response_result").show().html(data.result).removeClass().addClass("alert alert-danger center");
            }
            setTimeout(function(){
            $("#staff_response_result") .slideUp();
        },1000);
        }
    });
    }  
}

function edit_staff(staff_id) {
  
$.facebox({ div: "#modal_edit_staff" });  

delete branch_list.empty;
var branch_list_opt="";
$.each(branch_list, function(key, val){
    if(staff_data[staff_id].branch_name=val.branch_name){
    branch_list_opt+="<option value='"+val.branch_id+"'>"+val.branch_name+"</option>";
    } 
});

        $('#facebox .edit_s_fname').val(staff_data[staff_id].first_name);
        $('#facebox .edit_s_lname').val(staff_data[staff_id].last_name);
        $('#facebox .edit_s_mobile').val(staff_data[staff_id].mobile);
        $('#facebox .edit_s_email').val(staff_data[staff_id].email);
        $('#facebox .edit_s_address').val(staff_data[staff_id].address);
        $('#facebox .edit_s_branch').html(branch_list_opt);
        $("#facebox .edit_s_branch option[value='" + staff_data[staff_id].branch_id + "']").attr("selected", "selected");
        $('#facebox .edit_s_id').val(staff_data[staff_id].staff_id);         

    
    $("#facebox #staff_update").on("click",function() {
        var fname = $("#facebox #up_staff_fname").val();
        var lname = $("#facebox #up_staff_lname").val();
        var mobile = $("#facebox #up_staff_mobile");
        var email = $("#facebox #up_staff_email").val();
        var address = $("#facebox #up_staff_address").val();
        var branch = $("#facebox #up_staff_branch").val();
        var id = $("#facebox #up_staff_id").val();

        var total_req = $("#facebox .req_s").length;
        var c=0;

        for(var i=0 ; i < total_req ; i++){
            if($("#facebox .req_s").eq(i).val()=="" || $("#facebox .req_s").eq(i).val()=="-1"){
                $("#facebox .req_s").eq(i).parent().removeClass("has-success").addClass("has-error");
                c++;
            } else {
                $("#facebox .req_s").eq(i).parent().removeClass("has-error");
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
            $("#facebox #error").show().html("Please fill the required details").removeClass().addClass("alert alert-danger center");
        }else{
            $("#facebox #error").remove();
            var mobile = $("#facebox #up_staff_mobile").val();
        var query = "firstname="+fname+"&lastname="+lname+"&mobile="+mobile+"&email="+email+"&address="+address+"&branch="+branch;
        $("#facebox #result").show().html("Please Wait...<i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");
            $.ajax({
                type:"put",
                data:query,
                dataType:'json',
                url:'api/Staff/'+id,
                success: function(data) {
                    if(data.status=="ok"){
                        $("#facebox #result").show().html("Updated Successfully").removeClass().addClass("alert alert-success center").slideUp(3000);
                        window.location.replace("Staff");                        
                    } else if(data.status=="no"){
                        $("#facebox #result").show().html(data.result).removeClass().addClass("alert alert-danger center").slideUp(3000)
                    }
                }
            });
        }
    });
        

          
 }
 
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}