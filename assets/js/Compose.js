$(function(){

    $(".single_screen1").on("click",function(){
        console.log("loaded");
    $(this).find("h2").animate({padding:"8px"},500);
    $(this).animate({"min-height":"50px"},500);

        $(".single_screen2").slideDown("500");

    });
    $(".multiple_screen1").on("click",function(){
        console.log("loaded");
    $(this).find("h2").animate({padding:"8px"},500);
    $(this).animate({"min-height":"50px"},500);
        $(".multiple_screen2").slideDown("500");

    });
    
    $(".send_single_btn").on("click", function(){
        var required = $(".single_req").length;
        var c=0;

        for(var i=0; i<required; i++){
            if($(".single_req").eq(i).val()==""){
                $(".single_req").eq(i).parent().removeClass("has-success").addClass("has-error");
                c++;
            }else{
                $(".single_req").eq(i).parent().removeClass("has-error");
            }
        }
        if($(".single_mobile_number").val().length!=10){
            $(".single_mobile_number").parent().removeClass("has-success").addClass("has-error");
            c++;
        }else{
            $(".single_mobile_number").parent().removeClass("has-error");
        }
        
        if(c>0){
            
        }else{
            var mo_number=$(".single_mobile_number").val();
            var msg = $(".single_mobile_message").val();
            $(".send_single_btn").val("Please wait...");
            $("#single_screen_result").show().html("Please wait...").removeClass().addClass("alert col-md-6 alert-info");
            $.post("api/Compose/SMS/Single",{to:mo_number,msg:msg},function(response){
                if(response.status=="ok"){
                    $(".single_mobile_number").val("");
                    $(".single_mobile_message").val("");
                    $("#single_screen_result").show().removeClass().addClass("alert col-md-6 alert-success").html("Message sent successfully");
                }else if(response.status=="no"){
                    console.log("message not sent");
                    $("#single_screen_result").show().removeClass().addClass("alert col-md-6 alert-error").html("Error occured while sending message");
                }
                $(".send_single_btn").val("Send");
                setTimeout(function(){
                    $("#single_screen_result").slideUp();
                },500);
            });
        }
    });

    $(".send_multiple_btn").on("click", function(){
        var bulk_msg = $(".bulk_message").val();
        if(bulk_msg==""){
            $(".bulk_message").parent().removeClass("has-success").addClass("has-error");
        }else{
            $(".bulk_message").parent().removeClass("has-error");
            $(".send_multiple_btn").val("Please wait...");
            $("#multiple_screen_result").show().html("Please wait...").removeClass().addClass("alert col-md-6 alert-info");
            $.post("api/Compose/SMS/Multiple",{msg:bulk_msg},function(response){
                if(response.status=="ok"){
                    $(".bulk_message").val("");
                    $("#multiple_screen_result").show().removeClass().addClass("alert col-md-6 alert-success").html("Message sent successfully");
                } else if(response.status=="no"){
                    $("#multiple_screen_result").show().removeClass().addClass("alert col-md-6 alert-error").html("Error occured while sending message");
                }
                $(".send_multiple_btn").val("Send");
                setTimeout(function(){
                    $("#multiple_screen_result").slideUp();
                },500);
            });            
        }
    });
    
    $(".send_single_mail_btn").on("click", function(){
        var required = $(".single_req").length;
        var c=0;

        for(var i=0; i<required; i++){
            if($(".single_req").eq(i).val()==""){
                $(".single_req").eq(i).parent().removeClass("has-success").addClass("has-error");
                c++;
            }else{
                $(".single_req").eq(i).parent().removeClass("has-error");
            }
        }
        var email=$(".single_email").val();
        if(!checkEmail(email)){
            $(".single_email").parent().removeClass("has-success").addClass("has-error");
            c++;
        }else{
            $(".single_email").parent().removeClass("has-error");
        }
               
        if(c>0){
            
        }else{
            var email=$(".single_email").val();
            var msg = $(".single_email_message").val();
            $(".send_single_mail_btn").val("Please wait...");
            $("#single_screen_result").show().html("Please wait...").removeClass().addClass("alert col-md-6 alert-info");
            $.post("api/Compose/Mail/Single",{to:email,msg:msg},function(response){
                if(response.status=="ok"){
                    console.log("message sent");
                    $(".single_email").val("");
                    $(".single_email_message").val("");
                    $("#single_screen_result").show().removeClass().addClass("alert col-md-6 alert-success").html("Message sent successfully");
                }else if(response.status=="no"){
                    console.log("message not sent");
                    $("#single_screen_result").show().removeClass().addClass("alert col-md-6 alert-error").html("Error occured while sending message");
                }
                $(".send_single_mail_btn").val("Send");
                setTimeout(function(){
                    $("#single_screen_result").slideUp();
                },500);
            });
        }
    });
    
    $(".send_multiple_mail_btn").on("click", function(){
        var bulk_mail = $(".bulk_email").val();
        if(bulk_mail==""){
            $(".bulk_email").parent().removeClass("has-success").addClass("has-error");
        }else{
            $(".bulk_email").parent().removeClass("has-error");
            $(".send_multiple_mail_btn").val("Please wait...");
            $("#multiple_screen_result").show().html("Please wait...").removeClass().addClass("alert col-md-6 alert-info");
            $.post("api/Compose/Mail/Multiple",{msg:bulk_mail},function(response){
                if(response.status=="ok"){
                    $(".bulk_email").val("");
                    $("#multiple_screen_result").show().removeClass().addClass("alert col-md-6 alert-success").html("Mail sent successfully");
                } else if(response.status=="no"){
                    $("#multiple_screen_result").show().removeClass().addClass("alert col-md-6 alert-error").html("Error occured while sending mail");
                }
                $(".send_multiple_mail_btn").val("Send");
                setTimeout(function(){
                    $("#multiple_screen_result").slideUp();
                },500);
            }); 
        }
    });

});

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function checkEmail(email)
{
    var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
    if (reg.test(email)){
        return true;
    }else{
        return false;
    }
}