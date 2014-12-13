$(function(){
    $("#btn_login").on("click",function(e){
        e.preventDefault();
       var username=$('.username').val();
        var password=$('.password').val();

        if(username==""||password==""){
$(".errorHandler").html("Username / password required").show();
        }else{
            $(".errorHandler").hide();
            $.ajax({url:"api/Login",type:"post",data:{username:username,password:password},dataType:"json",success:function(response){

                if(response.status=="ok"){
                   window.location.href="index.php";
                }else if(response.status=="no"){
                    $(".errorHandler").html(response.result).show();

                }else{
                    $(".errorHandler").html("Unexpected error from server").show();
                }
            }});
        }

    });

});