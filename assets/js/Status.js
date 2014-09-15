$(function(){
   console.log("welcome to status page");
   $.getJSON("api/Status/Customers",function(response){
        if(response.status=="ok"){
            $.each(response.data, function(key,val){
                
            });
        }else if(response.status=="no"){
            
        }
   });
    
});