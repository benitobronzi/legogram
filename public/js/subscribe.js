const subscribebox=document.getElementsByClassName("subscribebox")[0];
const error2=document.querySelector(".subscribebox .error");

document.getElementById("subscribe").addEventListener('click',function(event) {
    error.innerHTML="";
    subscribebox.setAttribute("class","subscribebox visible");
    event.preventDefault();
});

document.getElementById("subscribe2").addEventListener('click',function(event) {
    error.innerHTML="";
    subscribebox.setAttribute("class","subscribebox visible");
    event.preventDefault();
});

subscribebox.querySelector("input[value='S'inscrire']").addEventListener('click',function(event) {
    event.preventDefault();
    lib.ajax({
        url:"index.php?c=auth&a=login",
        type:'POST',
        data:subscribebox.querySelector("form"),
        success(response) {
            location.reload();
        },
        error:lib.ajaxError(error)
    })

});

subscribebox.querySelector("input[value=x]").addEventListener('click',function(event) {
    subscribebox.setAttribute("class","subscribebox");
    event.preventDefault();
});

