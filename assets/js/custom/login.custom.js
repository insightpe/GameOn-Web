$(function(){ 
    UiLogin.init(); 
});

var UiLogin = function() {
    return {
        init: function() {
            $("#lnkLogin").click(UiLogin.login);
        },

        login: function(){
            var data = {
                user_email: $("#user_email").val(),
                user_pass:  $("#user_pass").val(),
            };

            $.ajax({
                url: App.baseUrl + "signin",
                type:'POST',
                dataType: "json",
                data: data,
                success: function(data) {
                  console.log("login");
                  if(!$.isEmptyObject(data.error)){
                    Swal.fire({
                        title: "Advertencia",
                        html: data.error,
                        buttonsStyling: false,
                        confirmButtonClass: "btn btn-success",
                        type: "warning"
                    });
                  }else{
                    window.location = data.redirect;
                  }
                }
            });
        }
    }
}();