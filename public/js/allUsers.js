function deleteUser(login) {
    // faire un appel ajax au backend pour demander l'effacement 
    lib.ajax({
        url:"index.php?c=users&a=deleteUser",
        type:'POST',
        data:{"login":login},
        success:function() {
            location.reload();
        },
        error:function(response,status) {
            alert(response);
        }
    })
}