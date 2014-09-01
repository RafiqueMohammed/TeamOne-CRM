$(function (){
    $.getJSON("api/Customer/pincode/", function(response){
        if(response.status=='ok') {
            delete response.status;
            var pin="";
            $.each(response.data, function(key, value){
               pin += "<tr><td>"+ value.pincode+"</td></tr>" 
            });
        } else {
            pin = "<tr><td>Not Found</td></tr>"
        }
        $(".pin_row").append(pin);
    });
});