$(function(){
    /*blockThisUI($(".container .row").eq(1))
   $.getJSON("api/Customers", function(response){
        if(response.status=="ok"){
            var cust_list_row = "";
            $.each(response.data, function(key, val){

                if(val.account_type=="r"){val.account_type="<i class='clip-home-2' style='color:green'></i>&nbsp;&nbsp;&nbsp;Residential",val.organisation="Home"}else{val.account_type="<i class='fa fa-trello' style='color:red'></i>&nbsp;&nbsp;&nbsp;Commercial"}
                cust_list_row += "<tr class='cust_row cust_row_"+val.cust_id+"'><td class='center'>"+val.account_type+"</td><td>"+val.organisation+"</td>\
                <td>"+val.first_name+" "+val.last_name+"</td><td>"+val.mobile+"</td><td>"+val.location+"</td><td>"+val.created_on+"</td>\
                <td class='center'><button class='btn-primary btn-sm btn tooltips'  data-placement='right' data-original-title='More Info' onclick='return LoadPage(\"CustomerDetails?id="+val.cust_id+"&ref=ViewCustomers\");' href='CustomerDetails?id="+val.cust_id+"&ref=ViewCustomers'><i class='clip-info-2'></i></button>\
                <button class='btn-danger btn-sm btn tooltips'  data-placement='right' data-original-title='Delete' onclick='remove_customer("+val.cust_id+")'><i class='fa fa-trash-o'></i></button></td></tr>"
            });
            $("#all_cust_list tbody").html(cust_list_row);      
        } else if(response.status=="no"){
            $("#all_cust_list tbody").html("<tr><td colspan='7' class='center alert alert-info'><i class='clip-info'></i> No Customer Added Yet</td></tr>");
        }
    unblockThisUI($(".container .row").eq(1))
   }); */
});

function remove_customer(elem){
    var ans = confirm("Are you sure to delete these customer?");
    if(ans){
        $("#customer_result").html("Please Wait... <i class='clip-busy'></i>").removeClass().addClass("alert alert-info center").show();
        $.ajax({
            type:'delete',
            url:'api/Customer/'+elem,
            dataType:'json',
            success: function(response){
                if(response.status=="ok"){
                    $("#customer_result").html("<i class='fa fa-check'></i> "+response.result).removeClass().addClass("alert alert-success center").show();
                    $(".cust_row_"+elem).slideUp().remove();
                }else if(response.status=="no"){
                    $("#customer_result").html("<i class='fa-exclamation-triangle fa'></i> "+response.result).removeClass().addClass("alert alert-danger center").show();
                }
                setTimeout(function(){
                    $("#customer_result").slideUp();
                },2500);
            }
        });
    }
}