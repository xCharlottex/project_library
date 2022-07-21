

const button = document.querySelector(".buttonN");

button.addEventListener('click', function (){

    const body = document.querySelector(".js-body");

    if(body.classList.contains("nightjs")){
        body.classList.remove("nightjs")
    } else {
        body.classList.add("nightjs");
    }

});


