$(function () {
    $(".close").on("click", function () {
        console.log("clickckckc");
    });
    $.ajaxSetup({
        headers: { 'Authorization': "Mohammed Rafique" }
    });


    $('#QuickSearch').click(function () {
        var str = $("#QuickSearchInput").val();
        if (str.length > 0 && str != "") {
            var link="Search?keyword=" + str;
            LoadPage(link);
        }
    });


    $('.date-picker').datepicker({
        autoclose: true
    });

    $('.datepicker').datepicker({
        autoclose: true
    });

    $(".main-navigation-menu li").on('click', function () {
        $(".main-navigation-menu").find(".active").removeClass("active");
        $(this).addClass("active");
    });


});


function init_registration_form() {

    $("#customer_ac_form").trigger('reset');
    $("#RegistrationForm").trigger('reset');
    showCustomerACProduct(false);

}

function setPageHeader(title, subtitle) {
    var c = "<h1>";
    if (title != "") {
        c += title;
    }

    if (subtitle != "") {
        c += "<small>" + subtitle + "</small>";
    }
    c += "</h1>";
    $('.page-header').html(c);
}
function unblockThisUI(element) {
    var main = $("#main-content");
    var container = $(element);

    if (element == null || element == "") {
        container = main;
    }
    container.unblock();

}
function blockThisUI(element) {
    var main = $("#main-content");
    var container = $(element);

    if (element == null || element == "") {
        container = main;
    }
    container.block({
        overlayCSS: {
            backgroundColor: '#fff'
        },
        message: '<img src="assets/images/loading.gif" /> Just a moment...',
        css: {
            border: 'none',
            color: '#333',
            background: 'none'
        }
    });
}
function LoadPage(name) {
    var main = $("#main-content");
    var match=name.indexOf('?');
    console.log("match "+match);
    if (match>=0){
        console.log("I am inside match "+match);
        blockThisUI(main);
        var qry = name.split("?");
        main.find(".container").eq(0).load("view/" + qry[0] + ".php?" + qry[1],function () {
            unblockThisUI(main);
            var stateObj = {"state": "changed"}
            window.history.pushState(stateObj, name, name);
        }).slideDown();

    } else {
        blockThisUI(main);
        main.find(".container").eq(0).load("view/" + name + ".php",function () {
            unblockThisUI(main);
            var stateObj = {"state": "changed"}
            window.history.pushState(stateObj, name, name);
        }).slideDown();
    }

    return false;
}

function LoadPage(name,class_name) {

    var main = $("#main-content");
    var match=name.indexOf('?');
    console.log("match "+match);
    if (match>=0){
        console.log("I am inside match "+match);
        blockThisUI(main);
        var qry = name.split("?");
        main.find(".container").eq(0).load("view/" + qry[0] + ".php?" + qry[1],function () {
            unblockThisUI(main);
            var stateObj = {"state": "changed"}
            window.history.pushState(stateObj, name, name);
        }).slideDown();

    } else {
        blockThisUI(main);
        main.find(".container").eq(0).load("view/" + name + ".php",function () {
            unblockThisUI(main);
            var stateObj = {"state": "changed"}
            window.history.pushState(stateObj, name, name);
        }).slideDown();
    }
$('.class_name')
    return false;
}


function remove_amc_row(row_id){
    var t=$("#facebox .table_body .row_"+row_id).parent().find("tr").length;
    console.log(t);
    if(t!=1){
        $("#facebox .table_body .row_"+row_id).slideUp("slow").remove();
    }else{
       alert("You cannot close minimum row");
    }

}

