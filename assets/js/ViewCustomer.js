$(function(){
    blockThisUI($(".container .row").eq(1))
   $.getJSON("api/Customers", function(response){
        if(response.status=="ok"){
            var cust_list_row = "";
            $.each(response.data, function(key, val){

                if(val.account_type=="r"){val.account_type="<i class='clip-home-2' style='color:green'></i>&nbsp;&nbsp;&nbsp;Residential",val.organisation="Home"}else{val.account_type="<i class='fa fa-trello' style='color:red'></i>&nbsp;&nbsp;&nbsp;Commercial"}
                cust_list_row += "<tr><td class='center'>"+val.account_type+"</td><td>"+val.organisation+"</td>\
                <td>"+val.first_name+" "+val.last_name+"</td><td>"+val.mobile+"</td><td>"+val.location+"</td><td>"+val.created_on+"</td>\
                <td class='center'><button class='btn-primary btn-sm btn tooltips'  data-placement='right' data-original-title='More Info' onclick='return LoadPage(\"CustomerDetails?id="+val.cust_id+"&ref=ViewCustomers\");' href='CustomerDetails?id="+val.cust_id+"&ref=ViewCustomers'><i class='clip-info-2'></i>&nbsp;&nbsp;View</button></td></tr>"
            });
            $("#all_cust_list tbody").html(cust_list_row);      
        } else if(response.status=="no"){
            $("#all_cust_list tbody").html("<tr><td class='colspan='7 center'><i class='clip-info'></i> No Customer Added Yet</td></tr>");
        }
    unblockThisUI($(".container .row").eq(1))
   }); 
});