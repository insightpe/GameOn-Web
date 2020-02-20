$(function(){ 
    UiRoleDataEntry.init(); 
});

var UiRoleDataEntry = function() {
    return {
        init: function() {
            $("#btnNewRole").click(UiRoleDataEntry.add);
            $("#btnUpdate").click(UiRoleDataEntry.update);
            $("#change_pass").click(UiRoleDataEntry.change_pass);
        },
        add: function() {
            var data = $("#frmRole").serializeFormJSON();

            $.ajax({
                url: App.baseUrl + "agregar-rol",
                type:'POST',
                dataType: "json",
                data: data,
                success: function(data) {
                    console.log(data);
                  if(!$.isEmptyObject(data.error)){
                    Swal.fire({
                        title: "Error",
                        html: data.error,
                        buttonsStyling: false,
                        confirmButtonClass: "btn btn-success",
                        type: "error"
                    });
                  }else{
                    window.location = data.redirect;
                  }
                }
            });
        },
        update: function(){
            var data = {
              rol_name: $("#rol_name").val(),
              lista_roles:  $("#lista_roles").val(),
              id:  $("#id").val(),
            };

            $.ajax({
                url: App.baseUrl + "actualizar-rol",
                type:'POST',
                dataType: "json",
                data: data,
                success: function(data) {
                    console.log(data);
                  if(!$.isEmptyObject(data.error)){
                    Swal.fire({
                        title: "Error",
                        html: data.error,
                        buttonsStyling: false,
                        confirmButtonClass: "btn btn-success",
                        type: "error"
                    });
                  }else{
                    window.location = data.redirect;
                  }
                }
            });
        },
    }
}();