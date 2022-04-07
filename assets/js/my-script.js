
const new_project_btn = document.querySelector(".new-project-btn");
const new_project_form = document.querySelector("form.new-project-form");


new_project_btn.addEventListener("click",function() { // TODO: убрать класс "active" в верстке формы 

    if(!new_project_btn.classList.contains("active")){
        new_project_btn.classList.add("active");
        new_project_form.classList.add("active");    
    }else{
        new_project_btn.classList.remove("active");
        new_project_form.classList.remove("active");
    }
    
});

console.log("js");