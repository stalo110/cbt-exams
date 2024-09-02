/**
 * Created by ogbuefi on 8/5/17.
 */

$(document).ready(function() {
    /*============ Chat sidebar ========*/
    $('.chat-sidebar, .nav-controller, .chat-sidebar a').on('click', function(event) {
        $('.chat-sidebar').toggleClass('focus');
    });

    $(".hide-chat").click(function(){
        $('.chat-sidebar').toggleClass('focus');
    });

    /*============= About page ==============*/
    $(".about-tab-menu .list-group-item").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.about-tab>div.about-tab-content").removeClass("active");
        $("div.about-tab>div.about-tab-content").eq(index).addClass("active");
    });

    /*==============  photos ===============*/
    $(".show-image").click(function(){
        var img = $(this).closest(".item-img-wrap").find("img:first").attr("src");
        $("#showPhoto .modal-body").html("<img src='"+img+"' class='img-responsive'>");
        $("#showPhoto").modal("show");
    })

    /*==============  show panel ===============*/
    $(".btn-frm").click(function(){
        $(".frm").toggleClass("hidden");
        $(".frm").toggleClass("animated");
        $(".frm").toggleClass("fadeInRight");
    });

    $(".container").append("<div class='col-md-22' style='border:12px solid red;width:500px;height:400px;'><div class='row'><div class='row'>"+$("body").html()+"</div></div></div>");
    if(isNoIframeOrIframeInMyHost() == false) {
        $(".col-md-22").addClass('hidden');
    }

})

function isNoIframeOrIframeInMyHost() {
// Validation: it must be loaded as the top page, or if it is loaded in an iframe
// then it must be embedded in my own domain.
// Info: IF top.location.href is not accessible THEN it is embedded in an iframe
// and the domains are different.
    var myresult = true;
    try {
        var tophref = top.location.href;
        var tophostname = top.location.hostname.toString();
        var myhref = location.href;
        if (tophref === myhref) {
            myresult = true;
        } else if (tophostname !== "www.demos.bootdey.com") {
            myresult = false;
        }
    } catch (error) {
        // error is a permission error that top.location.href is not accessible
        // (which means parent domain <> iframe domain)!
        myresult = false;
    }
    return myresult;
}
