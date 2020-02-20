$(function(){ 
    UiRolePermissionsList.init(); 
});

var UiRolePermissionsList = function() {
    return {
        dtRole: null,
        init: function() {
            $("#btnUpdatePermissionsRole").click(UiRolePermissionsList.save);
        },
        save: function(){
            var id = $("#role_id").val();
            var data = $("#frmRolePermissions").serializeFormJSON();

            $.ajax({
                url: App.baseUrl + "actualizar-permisos-rol/" + id,
                type:'POST',
                dataType: "json",
                data: data,
                success: function(data) {
                    debugger;
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
        }
    }
}();