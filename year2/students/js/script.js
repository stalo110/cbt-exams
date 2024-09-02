$(document).ready(function(){
$(".addstudent").click(function(e){
    e.preventDefault();
    $(".addModel").css("display","flex");
});
$(".closeadd").each(function(){
$(this).click(function(){
$(".updateModel").hide();
});
});

$(".closeadd").each(function(){
    $(this).click(function(){
    $(".addModel").hide();
    });
    });

    $(".update-link").click(function(){
        var id = $(this).attr("rel");

            var update_url = "students.php?update="+ id +" ";

            $(".update_delete_link").attr("href", update_url);
        $(".updateModel").css("display","flex");
    })
});