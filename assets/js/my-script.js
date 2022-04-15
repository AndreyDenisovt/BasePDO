
$(document).ready(function(){
    console.log("js");

    $(".new-project-btn").on("click",function () {
        $(".new-project-form").slideToggle();
    })

    $(".btns-options").on({
        "mouseenter": function(){
            $(".btn-delete-row").eq($(this).data("rowid")).show("slow");
        },
        "mouseleave": function (){
            $(".btn-delete-row").eq($(this).data("rowid")).hide("fast");
            $(".confirm-btn-delete-row").eq($(this).data("rowid")).hide("fast");
        }    
    });

    $(".btn-delete-row").on("click",function(){       
        $(".confirm-btn-delete-row").eq($(this).data("rowid")).show("slow");
    });
});

