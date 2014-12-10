var technicians=null;
$(function(){
   blockThisUI($(".container .row").eq(1));
   $.getJSON('api/Assign/Customer',function(response){
    if(response.status=="ok"){
        var row="";
        $.each(response.data,function(key,value){
            if(value.account_type=="r"){value.account_type="<i class='clip-home-2' style='color:green'></i>&nbsp;&nbsp;Residential" , value.organisation="Home" }else{value.account_type="<i class='fa fa-trello' style='color:red'></i>&nbsp;&nbsp;Commercial"}
            row += "<tr><td>"+value.account_type+"</td><td>"+value.organisation+"</td><td>"+value.first_name+" "+value.last_name+"</td>\
            <td>"+value.mobile+"</td><td>"+value.location+"</td><td><button class='btn btn-primary btn-sm' onclick='return LoadPage(\"AssignTechnician?id="+value.cust_id+"\");' href='AssignTechnician?id="+value.cust_id+"'>View&nbsp;&nbsp;<i class='fa fa-arrow-circle-right'></i></button></td></tr>"
        });
        $("#customer_list_for_technician_assignment tbody").prepend(row);
    }else if(response.status=="no"){
        console.log("error");
        $("#customer_list_for_technician_assignment tbody").html("<tr><td colspan='6' class='alert alert-info center'><i class='clip-info'></i>&nbsp;&nbsp;&nbsp;No Services to be Assigned to customer</td></tr>");
    }
       unblockThisUI($(".container .row").eq(1));
   });
    
});