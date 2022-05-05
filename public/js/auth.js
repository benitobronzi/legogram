const loginbox=document.getElementsByClassName("loginbox")[0];
const error=document.querySelector(".loginbox .error");

document.getElementById("login").addEventListener('click',function(event) {
    error.innerHTML="";
    loginbox.setAttribute("class","loginbox visible");
    event.preventDefault();
});

loginbox.querySelector("input[value='Se connecter']").addEventListener('click',function(event) {
    event.preventDefault();
    lib.ajax({
        url:"index.php?c=auth&a=login",
        type:'POST',
        data:loginbox.querySelector("form"),
        success(response) {
            location.reload();
        },
        error:lib.ajaxError(error)
    })

});

loginbox.querySelector("input[value=x]").addEventListener('click',function(event) {
    loginbox.setAttribute("class","loginbox");
    event.preventDefault();
});

