$(function(){ 
    UiPermissionDataEntry.init(); 
});

var UiPermissionDataEntry = function() {
    return {
        init: function() {
            $("#btnNewPermission").click(UiPermissionDataEntry.add);
            $("#btnUpdate").click(UiPermissionDataEntry.update);
            $("#change_pass").click(UiPermissionDataEntry.change_pass);
        },
        add: function() {
            var data = $("#frmPermission").serializeFormJSON();

            $.ajax({
                url: App.baseUrl + "agregar-permiso",
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
            var data = $("#frmPermission").serializeFormJSON();

            $.ajax({
                url: App.baseUrl + "actualizar-permiso",
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