function deleteUser(login) {
    if (confirm("Voulez-vous effacer "+login+" ?")) {
        lib.ajax({
            url:"index.php?c=users&a=delete",
            type:'POST',
            data:{"login":login},
            success(response) {
                location.reload();
            },
            error:function(response,status) {
                alert(lib.formatError(response,status));
            }
        })
    }
}