
$(document).ready(function(){
    console.log("js");

    $(".new-project-btn").on("click",function () {
        $(".new-project-form").slideToggle();
    })

<<<<<<< HEAD
new_project_btn.addEventListener("click",function() { // TODO: убрать класс "active" в верстке формы 
=======
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
>>>>>>> origin/001-w

});

