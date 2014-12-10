$(function (){

	    $("#add_brand").click(function () {
        var brand_input = $("input[name=make]");
        var brand_name = brand_input.val();
        
        var list_length = $(".make_list").length;
        var total = list_length + 1;
        
        var mthis = $(this);
        var tmp_val = mthis.val();

        mthis.val("Adding...");
        brand_input.attr("disabled", "disabled");

        var rand = Math.floor(Math.random() * 16) + 1;

        $.ajax({
            type: 'post',
            url: 'api/Manage/AC/Make',
            data: {brand_name: brand_name},
            dataType: 'json',
            success: function (data) {
                if (data.status == 'ok') {
                    brand_input.val("").css("border", "");
                    $('.brand_err').empty();
                    if ($('.brand_list').find(".not_found")) {
                        $('.brand_list .not_found').slideUp("slow").remove();
                    }
                    $('.brand_list').prepend("<li class='list-group-item make_list make_list_"+total+"'>" + brand_name + "<span style='cursor:pointer' onclick='delete_brand(\"make\","+data.last_id+",\".make_list_"+total+"\")'  class='badge badge-danger'>X</span></li>");
                } else {
                    brand_input.css("border", "1px solid red");
                    $('.brand_err').html(data.result);
                }
                mthis.val(tmp_val);
                brand_input.removeAttr("disabled");
            }
        });

    });

    $("#add_ton").click(function () {

        var ton_input = $("input[name=tonnage]");
        var ton_name = ton_input.val();

        var mthis = $(this);
        var tmp_val = mthis.val();
        
        var list_length = $(".ton_list").length;
        var total = list_length + 1;        

        mthis.val("Adding...");
        ton_input.attr("disabled", "disabled");

        var rand = Math.floor(Math.random() * 16) + 1;

        $.ajax({
            type: 'post',
            url: 'api/Manage/AC/Tonnage',
            data: {tonnage: ton_name},
            dataType: 'json',
            success: function (data) {
                if (data.status == 'ok') {
                    console.log(data.last_id);
                    ton_input.val("").css("border", "");
                    $('.tonnage_err').empty();

                    if ($('.tonnage_list').find(".not_found")) {
                        $('.brand_list .not_found').slideUp("slow").remove();
                    }
                    $('.tonnage_list').prepend("<li class='list-group-item ton_list ton_list_"+total+"'>" + ton_name + "<span style='cursor:pointer' onclick='delete_brand(\"ton\","+data.last_id+",\".ton_list_"+total+"\")'  class='badge badge-danger'>X</span></li>");
                } else {
                    ton_input.css("border", "1px solid red");
                    $('.tonnage_err').html(data.result);
                }
                mthis.val(tmp_val);
                ton_input.removeAttr("disabled");
            }
        });

    });

    $("#add_location").click(function () {

        var location_input = $("input[name=location]");
        var location_name = location_input.val();

        var mthis = $(this);
        var tmp_val = mthis.val();
        
        var list_length = $(".loc_list").length;
        var total = list_length + 1;          

        mthis.val("Adding...");
        location_input.attr("disabled", "disabled");

        var rand = Math.floor(Math.random() * 16) + 1;

        $.ajax({
            type: 'post',
            url: 'api/Manage/AC/location',
            data: {location: location_name},
            dataType: 'json',
            success: function (data) {
                if (data.status == 'ok') {
                    location_input.val("").css("border", "");
                    $('.location_err').empty();

                    if ($('.location_list').find(".not_found")) {
                        $('.brand_list .not_found').slideUp("slow").remove();
                    }
                    $('.location_list').prepend("<li class='list-group-item loc_list loc_list_"+total+"'>" + location_name + "<span style='cursor:pointer' onclick='delete_brand(\"location\","+data.last_id+",\".loc_list_"+total+"\")'  class='badge badge-danger'>X</span></li>");
                } else {
                    location_input.css("border", "1px solid red");
                    $('.location_err').html(data.result);
                }
                mthis.val(tmp_val);
                location_input.removeAttr("disabled");
            }
        });

    });
    
    $("#add_reference").click(function () {

        var reference_input = $("input[name=reference]");
        var reference_name = reference_input.val();

        var mthis = $(this);
        var tmp_val = mthis.val();

        var list_length = $(".ref_list").length;
        var total = list_length + 1;  

        mthis.val("Adding...");
        reference_input.attr("disabled", "disabled");

        $.ajax({
            type: 'post',
            url: 'api/Manage/Customer/Reference',
            data: {reference: reference_name},
            dataType: 'json',
            success: function (data) {
                if (data.status == 'ok') {
                    reference_input.val("").css("border", "");
                    $('.location_err').empty();

                    if ($('.reference_list').find(".not_found")) {
                        $('.brand_list .not_found').slideUp("slow").remove();
                    }
                    $('.reference_list').prepend("<li class='list-group-item ref_list ref_list_"+total+"'>" + reference_name + "<span style='cursor:pointer' onclick='delete_brand(\"reference\","+data.last_id+",\".ref_list_"+total+"\")'  class='badge badge-danger'>X</span></li>");
                } else {
                    reference_input.css("border", "1px solid red");
                    $('.reference').html(data.result);
                }
                mthis.val(tmp_val);
                reference_input.removeAttr("disabled");
            }
        });

    });
    
    $("#add_ac_type").click(function(){
        
        var ac_type_input = $("input[name=ac_type]");
        var ac_type_name = ac_type_input.val();
        
        var mthis = $(this);
        var tmp_val = mthis.val();

        var list_length = $(".actype_list").length;
        var total = list_length + 1;
        
        mthis.val("Adding...");
        ac_type_input.attr("disabled", "disabled");
        
        $.ajax({
            type:'post',
            url: 'api/Manage/AC/Type',
            data: {ac_type: ac_type_name},
            dataType: 'json',
            success: function(data) {
                if(data.status == 'ok') {
                    ac_type_input.val("").css("border", "");
                    $('.ac_type_err').empty();
                    
                    if($(".actype_list").find(".not_found")) {
                        $('.brand_list .not_found').slideUp("slow").remove();
                    }
                    $('.ac_type_list').prepend("<li class='list-group-item actype_list actype_list_"+total+"'>" + ac_type_name + "<span style='cursor:pointer' onclick='delete_brand(\"ac_type\","+data.last_id+",\".actype_list_"+total+"\")'  class='badge badge-danger'>X</span></li>");
                } else {
                    ac_type_input.css("border", "1px solid red");
                    $(".ac_type").html(data.result);
                }
                mthis.val(tmp_val);
                ac_type_input.removeAttr("disabled");
            }
        });
    });
    
    $("#add_problem").click(function(){
        
        var problem_type_input = $("input[name=problem_type]");
        var problem_type_name = problem_type_input.val();
        
        var mthis = $(this);
        var tmp_val = mthis.val();

        var list_length = $(".problem_type").length;
        var total = list_length + 1;
        
        mthis.val("Adding...");
        problem_type_input.attr("disabled", "disabled");
                
        $.ajax({
            type:'post',
            url: 'api/Manage/Complaints/ProblemType',            
            data: {problem_type: problem_type_name},
            dataType: 'json',
            success: function(data) {
                if(data.status == 'ok') {
                    problem_type_input.val("").css("border", "");
                    $('.problem_type_err').empty();
                    
                    if($(".problem_type").find(".not_found")) {
                        $('.brand_list .not_found').slideUp("slow").remove();
                    }
                    $('.problem_type_list').prepend("<li class='list-group-item problem_type problem_type_list_"+total+"'>" + problem_type_name + "<span style='cursor:pointer' onclick='delete_brand(\"problem_type\","+data.last_id+",\".problem_type_list_"+total+"\")'  class='badge badge-danger'>X</span></li>");
                } else {
                    problem_type_input.css("border", "1px solid red");
                    $(".problem_type_list").html(data.result);
                }
                mthis.val(tmp_val);
                problem_type_input.removeAttr("disabled");
            }
        });                
    });
    
    $("#add_branch").on("click", function(){
        
        var branch_input = $("input[name=branch]");
        var branch_name = branch_input.val();
        
        var mthis = $(this);
        var tmp_val = mthis.val();

        var list_length = $(".branch").length;
        var total = list_length + 1;
        
        mthis.val("Adding...");
        branch_input.attr("disabled", "disabled");
        
        $.ajax({
            type:'post',
            url:'api/Manage/Branch',
            data:{branch : branch_name},
            dataType:'json',
            success: function(data){
                if(data.status=="ok"){
                    console.log("success");
                    branch_input.val("").css("border", "");
                    $('.branch_err').empty();
                    
                    if($(".branch").find(".not_found")) {
                        $('.brand_list .not_found').slideUp("slow").remove();
                    }
                    $('.branch_list').prepend("<li class='list-group-item branch branch_list_"+total+"'>" + branch_name + "<span style='cursor:pointer' onclick='delete_brand(\"branch\","+data.last_id+",\".branch_list_"+total+"\")'  class='badge badge-danger'>X</span></li>");
                }else if(data.status=="no"){
                    console.log("error");
                }
                mthis.val(tmp_val);
            }
        });     
           
    });

});

function delete_brand(type,id,parent){
    switch(type){
        case 'ton':
            var result = confirm("Are you sure?");
            if (result == true) {

                $.ajax({
                    type: "DELETE",
                    url: "api/Manage/AC/Tonnage/"+id,
                    dataType:"JSON",
                    success: function (data) {
                        if (data.status == "ok") {
                            console.log("success");
                            $(parent).slideUp("slow");
                        } else {
                            console.log("failure");
                        }
                    }
                });


            }
            break;
        case 'location':
            var result = confirm("Are you sure?");
            if (result == true) {
                $.ajax({
                    type: "DELETE",
                    url: "api/Manage/AC/location/"+id,
                    dataType:"JSON",
                    success: function (data) {
                        if (data.status == "ok") {
                            console.log("success");
                            $(parent).slideUp("slow");
                        } else {
                            console.log("failure");
                        }
                    }
                });

            }
            ;
            break;
        case 'make':
            var result = confirm("Are you sure?");
            if (result == true) {
                $.ajax({
                    type: "DELETE",
                    url: "api/Manage/AC/Make/"+id,
                    dataType:"JSON",
                    success: function (data) {
                        if (data.status == "ok") {
                            console.log("success");
                            $(parent).slideUp("slow");
                        } else {
                            console.log("failure");
                        }
                    }
                });


            }
            break;
         case 'reference':
         console.log(parent);
            var result = confirm("Are you sure?");
            if (result == true) {
                $.ajax({
                    type: "DELETE",
                    url: "api/Manage/Customer/Reference/"+id,
                    dataType:"JSON",
                    success: function (data) {
                        if (data.status == "ok") {
                            console.log("success");
                            $(parent).slideUp("slow");
                        } else {
                            console.log("failure");
                        }
                    }
                });


            }
            break;
         case 'ac_type':
            var result = confirm("Are you sure?");
            if (result == true) {
                $.ajax({
                    type: "DELETE",
                    url: "api/Manage/AC/Type/"+id,
                    dataType:"JSON",
                    success: function (data) {
                        if (data.status == "ok") {
                            console.log("success");
                            $(parent).slideUp("slow");
                        } else {
                            console.log("failure");
                        }
                    }
                });


            }
            break;            
         case 'problem_type':
            var result = confirm("Are you sure?");
            if (result == true) {
                $.ajax({
                    type: "DELETE",
                    url: "api/Manage/Complaints/ProblemType/"+id,
                    dataType:"JSON",
                    success: function (data) {
                        if (data.status == "ok") {
                            console.log("success");
                            $(parent).slideUp("slow");
                        } else {
                            console.log("failure");
                        }
                    }
                });


            }
            break; 
         case 'branch':
            var result = confirm("Are you sure?");
            if (result == true) {
                $.ajax({
                    type: "DELETE",
                    url: "api/Manage/Branch/"+id,
                    dataType:"JSON",
                    success: function (data) {
                        if (data.status == "ok") {
                            console.log("success");
                            $(parent).slideUp("slow");
                        } else {
                            console.log("failure");
                        }
                    }
                });


            }
            break;    
    }

}