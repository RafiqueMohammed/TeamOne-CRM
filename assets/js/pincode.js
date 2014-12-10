$(function (){
 
      $("#pincode").select2();
    $("#pincode").on("change", function(){
        
        var p = $("#pincode").val();
        if(p==""||p=="-1"){
            
        }
        else{
            $("#hidden_pincode").val(p)
            $("#show_my_output").show().html("Please wait... <i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");
        $.getJSON("api/Manage/pin/"+p,function(response){
            if(response.status=="ok"){
                console.log("success")
                var pincode_tr = "";
                var total="1";
                $.each(response.data,function(key,val){
                    pincode_tr += "<tr class='p_row p_row_"+total+"'><td>"+val.pincode+"</td><td>"+val.locality_name+"</td>\
                    <td><i style='cursor:pointer;color:red' class='clip-minus-circle-2' onclick='remove_pincode("+total+","+val.locality_id+")'></td></tr>";
                    total++;
                });
                
            }else if(response.status=="no"){
                console.log("error")
                pincode_tr="<tr class='empty'><td colspan='3' class='alert alert-info center'><i class='clip-info'></i> No Landmark Added for this pincode</td></tr>"
            }
            $("#pincode_table tbody").html(pincode_tr);
            $("#show_my_output").slideUp();
        });
        }
        });
        
        $("#add_pincode").on("click", function(){
            var landmark = $("#new_landmark").val();
            var pin = $("#hidden_pincode").val();
            if(pin=="" || landmark==""){
                $("#show_my_output").show().html("Please fill the required").removeClass().addClass("alert alert-danger center");
                console.log("missing")
            }else{
                $("#show_my_output").show().html("Please wait... <i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");
            $.ajax({
                type:'post',
                url:'api/Manage/pin',
                data:"pincode="+pin+"&landmark="+landmark,
                dataType:'json',
                success: function(response){
                    if(response.status=="ok"){
                        console.log("success")
                        if($(".empty").length==1){
                            $(".empty").remove();
                        }
                        var total = $(".p_row").length;
                        total=total+1;
                        $("#pincode_table tbody").prepend("<tr class='p_row p_row_"+total+"'><td>"+pin+"</td><td>"+landmark+"</td>\
                        <td><i style='cursor:pointer;color:red' class='clip-minus-circle-2' onclick='remove_pincode("+total+","+response.result+")'></td></tr>");
                        $("#show_my_output").show().html("Landmark Added Successfully").removeClass().addClass("alert alert-success center");
                    }else if(response.status=="no"){
                        console.log("error")
                        $("#show_my_output").show().html(data.result).removeClass().addClass("alert alert-danger center");
                    }setTimeout(function(){
                    $("#show_my_output").slideUp();
                    },1000);
                }
            })
            }
        });
        
    
});

function remove_pincode(row_id,id){
    var ans=confirm("Are you sure...??")
    if(ans){
        $("#show_my_output").show().html("Please wait... <i class='clip-busy'></i>").removeClass().addClass("alert alert-info center");
        $.ajax({
            type:'delete',
            url:'api/Manage/pin/'+id,
            dataType:'json',
            success: function(response){
                if(response.status=="ok"){
                    console.log("success");
                    $("#show_my_output").show().html("Landmark Deleted").removeClass().addClass("alert alert-success center");
                    $(".p_row_"+row_id).remove();
                    if($(".p_row").length==0){
                        $("#pincode_table tbody").html("<tr class='empty'><td colspan='3' class='alert alert-info center'> <i class='clip-info'></i> No Landmark Added For This Pincode</td></tr>")
                    }
                }else if(response.status=="no"){
                    console.log("error")
                    $("#show_my_output").show().html(data.result).removeClass().addClass("alert alert-danger center");
                }setTimeout(function(){
                    $("#show_my_output").slideUp();
                },1000);
            }
        });
    }
}