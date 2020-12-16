function login(){
    $.ajax({
        type: "POST",
        url: 'login.php',
        data: {login: $('#login').val(), password: $('#password').val()},
        success: (response) => {
            if(response == 'true'){
                window.location.replace("client.php");
            }
            else{
                window.location.replace("login.php");
            }
        },
    });
}

function expand(i) {
    if($('#fact'+i).is(":hidden")){
        $('#fact'+i).show();
    }
    else{
        $('#fact'+i).hide();
    }
}

function facture(){
    $.ajax({
        type: "POST",
        url: 'facturation.php',
        data: { produit: $('#produit-liste').val(), client: $('#client-liste').val(), date: $('#date').val(),nom: $('#nom').val(), detail: $('#detail').val(), prix: $('#prix').val() },
        success: (response) => {
            window.location.replace("facturation.php");
        },
    });
}