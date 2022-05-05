document.getElementById("newPassword").addEventListener("click", function(event) {

    event.preventDefault();

    const form=document.getElementById("newPasswordForm");

    const error=form.querySelector(".error");

    lib.ajax({
        url:"index.php?c=profile&a=newPassword",
        type:'POST',
        data:form,
        success(response) {
            alert("Le mot de passe a bien été changé.");
            const elements=form.querySelectorAll("input[type=password]");
            for(let i=0; i<elements.length; i++) {
                elements[i].value="";
            }
            error.innerText=response;
        },
        error:lib.ajaxError(error)
    })
});

document.getElementById("newName").addEventListener("click", function(event) {

    event.preventDefault();

    const form=document.getElementById("newNameForm");

    const error=form.querySelector(".error");

    lib.ajax({
        url:"index.php?c=profile&a=newName",
        type:'POST',
        data:form,
        success(response) {
            alert("Votre nom a bien été changé.");
            location.reload();
        },
        error:lib.ajaxError(error)
    });

});