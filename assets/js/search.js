$(document).ready(function(){
    
    $("#customer_search_button").click(function(){
        var search = $("#customer_search_box").val();
        if(search == ''){
            alert("Enter Mobile Number or Organisation to search");
        }else{
            blockThisUI($(".search-classic"));
$(".search-keyword").html("Search for \""+search+"\"");
            $.ajax({
                type:'get',
                url:'api/Search/'+search,
                dataType:'json',
                success: function(response){
                    if(response.status=="ok"){

                        var opt = "";
                        $.each(response.data, function (key, type) {
                            if(type.account_type=="r"){

                                opt += "<span class='label label-default '>Residential</span> " +
                                    "<h4><a href='CustomerDetails?id="+type.cust_id+"'>"+type.first_name+" "+type.last_name+"</a></h4>" +
                                    "<a href='#'>"+type.location+"</a><br/><p><b>Email : </b>"+type.email+"<br>" +
                                    "<b>Contact :</b>  "+type.mobile+"<br>  </p><hr>";

                            }else{
                                opt += "<span class='label label-warning '>Commercial</span> " +
                                    "<h4><a href='CustomerDetails?id="+type.cust_id+"'>"+type.organisation+"</a></h4>" +
                                    "<a href='#'>"+type.location+"</a><br/><p><b>Contact Person : </b>"+type.first_name+" "+type.last_name+"<br>" +
                                    "<b>Contact :</b>  "+type.mobile+"<br>" +
                                    "<b>Email : </b> "+type.email+"<br>"+
                                    "<b>Alternate Contact :</b>  "+type.alternate_mobile+"<br>  </p><hr>";
                            }
                        });
                           $(".search-result").html(opt);                    
                    }else if(response.status=="no"){
                       opt="<div class='alert alert-danger'>"+response.result+"</div>";
                    }
                    unblockThisUI($(".search-classic"));
                },error:function(response){
                    unblockThisUI($(".search-classic"));
                }
            });
        }
    });
    
})