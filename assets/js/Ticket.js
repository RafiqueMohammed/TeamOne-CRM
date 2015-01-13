
var technician_dropdown;
$(function(){
});

function show_popup(elem,sub){ 
    var content=$("."+elem).find("."+sub).html();
    
    $.facebox(content);
}

function popup_close(id,elem,sub){
    console.log(id+" "+elem+" "+sub);
    var content=$("."+elem).find("."+sub).html();
    
    $.facebox(content);
    
    $("#facebox .ticket_close").on("click", function(){
 
    var input_length = $(".f_req").length;

    var c = 0;
    
    for (var i = 0; i < input_length; i++) {
            if ($('#facebox .f_req').eq(i).val() == "") {
                $('#facebox .f_req').eq(i).parent().removeClass("has-success").addClass("has-error");
                c++;
            } else {
                $('#facebox .f_req').eq(i).parent().removeClass("has-error");

            }
        }
    if(c > 0){
        $("#facebox #error").show().html("Please fill the required field").removeClass().addClass("center alert alert-danger");
    }else{
    $("#facebox #error").remove();
    var id=$("#facebox .id").val();
    var remarks=$("#facebox .remarks").val();
    console.log(id+" "+remarks);
    $("#facebox #result").show().html("Please wait...<i class='clip-busy'></i>").removeClass().addClass("center alert alert-info");
    $.ajax({
        type:'put',
        url:'api/Tickets/'+id+'/Close',
        data:"assign_id="+id+"&remarks="+remarks,
        dataType:'json',
        success: function(response){
            if(response.status=="ok"){
                $("#facebox #result").show().html("Ticket Closed").removeClass().addClass("center alert alert-success");
                $("."+elem).slideUp();
                jQuery(document).trigger('close.facebox');
            }else if(response.status=="no"){
                $("#facebox #result").show().html(response.result).removeClass().addClass("center alert alert-danger");
            }
        }
    });
    }
    });  
}

function tryagain(id,elem,sub){
    var content=$("."+elem).find("."+sub).html();

    var today=new Date;
    today.setDate(today.getDate());
    $.facebox(content);
    $('#facebox .date-picker').datepicker({
        startDate:today,
        autoclose: true
    });

    $("#facebox .reassign_submit").on("click", function(){
        console.log("click");
        var ilength = $("#facebox .re_req").length;

        var c=0;
        for(var i=0; i<ilength ;i++){
            if($("#facebox .re_req").eq(i).val()=="" || $("#facebox .re_req").eq(i).val()=="-1"){
                $("#facebox .re_req").eq(i).parent().removeClass("has-success").addClass("has-error");
                c++;
            } else {
                $("#facebox .re_req").eq(i).parent().removeClass("has-error");
            }
        }
        if(c>0){
            $("#facebox #error").show().html("Please fill the required fields").removeClass().addClass("center alert alert-danger");
        }else{
            $("#facebox #error").remove();
            var date = $("#facebox .date-picker").val();
            var technician = $("#facebox .technician").val().split("|")[0];
            var tech = $("#facebox .technician").val().split("|")[1];
            var remark = $("#facebox .remarks").val();
            var qry = "technician="+technician+"&date="+date+"&remarks="+remark;

            $("#facebox #success").show().html("Please wait...<i class='clip-busy'></i>").removeClass().addClass("center alert alert-info");
            $.ajax({
                type:'put',
                data:qry,
                url:"api/Tickets/"+id+"/Reassign",
                dataType:'json',
                success: function(response){
                    if(response.status=="ok"){
                        $("#facebox #success").show().html(response.result).removeClass().addClass("center alert alert-success");
                        $("."+elem).find(".rename_technician").html(tech);
                        $("."+elem).find(".re_date").html(date);
                        $("."+elem).find(".ticket_remarks").html(remark);
                        $("."+elem).find(".date-picker").attr("value",date);
                        $("."+elem).find(".remarks").text(remark);
                    }else if(response.status=="no"){
                        $("#facebox #success").show().html(response.result).removeClass().addClass("center alert alert-danger");
                    }
                    setTimeout(function(){
                        jQuery(document).trigger('close.facebox');
                    },1000);
                }
            });
        }


    });
}
